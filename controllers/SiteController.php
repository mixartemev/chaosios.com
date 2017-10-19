<?php

namespace app\controllers;

use app\models\form\EmailConfirmForm;
use app\models\form\PasswordResetRequestForm;
use app\models\form\ResetPasswordForm;
use app\models\form\SignupForm;
use app\models\form\UploadForm;
use Imagine\Image\Box;
use moonland\phpexcel\Excel;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\httpclient\Client;
use yii\imagine\Image;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\form\LoginForm;
use app\models\form\ContactForm;
use yii\web\UploadedFile;


class SiteController extends Controller
{
	public $excel;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],

        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

	public function readExcel($fileName){
		$data = Excel::import(Yii::getAlias('@runtime/').$fileName/*, $config*/); // $config is an optional
		$query_array = [];
		if($data){
			foreach($data[0] as $d){
				$query_array[$d['VALUE']] = $d['NAME'];
			}
		}
		//print_r($query_array);
		return $this->redirect(['pics', 'query' => base64_encode(serialize($query_array))]);
	}

	/**
	 * @param string $query
	 * @return string
	 */
    public function actionPics($query='')
    {
        $results = [];
		$model = new UploadForm();
		if ($photos = Yii::$app->request->post('photo')) {
			$web = Yii::getAlias('@webroot/');
			foreach($photos as $query => $photo_query){
				foreach($photo_query as $k => $photo){
					$img = Image::getImagine()->open($photo);
					$img->strip(); // облегчили фотку от мусора
					$original_size = $img->getSize();
					$w = $original_size->getWidth();
					$h = $original_size->getHeight();
					$ar = $w/$h;
					$img->resize(new Box(800,round(800/$ar)));
					$img->save($web.'photos/'.$query.'_'.($k+1).'.png');
				}
			}
			self::zipDir($web.'photos', $web.'photos.zip');
			Yii::$app->response->redirect('/photos.zip');
		}
		elseif(Yii::$app->request->post('UploadForm')){
			$model->excel = UploadedFile::getInstance($model, 'excel');
			if($model->upload()){
				$this->readExcel($model->excel->name);
			}
			Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Your profile updated success'));
		}
		elseif (@$query /*= Yii::$app->request->post('query')*/) {
			$client = new Client();

			$queries = unserialize(base64_decode($query)); //is_array($query_string)? $query_string: explode(',', $query_string);

			foreach($queries as $value => $name) {
				$response = $client->createRequest()
					->setMethod('get')
					->setUrl('https://www.googleapis.com/customsearch/v1')
					->setData([
						'cx' => '013190748820172743486:w0tsoxhfu38',
						'key' => 'AIzaSyAlrYrhabVpgaBNC9y8KJB0umMqgJYyS2c',
						'q' => trim($name),
						'searchType' => 'image',
						'fields' => 'items(image(width),link)',
					])
					->send();
				if ($response->isOk) {
					$results[$value] = $response->data;
				}
			}
		}

        return $this->render('pics', ['model' => $model, 'results' => $results, 'photos' => @$photos]);
    }

	/**
	 * Add files and sub-directories in a folder to zip file.
	 * @param string $folder
	 * @param /ZipArchive $zipFile
	 * @param int $exclusiveLength Number of text to be exclusived from the file path.
	 */
	private static function folderToZip($folder, &$zipFile, $exclusiveLength) {
		$handle = opendir($folder);
		while (false !== $f = readdir($handle)) {
			if ($f != '.' && $f != '..') {
				$filePath = "$folder/$f";
				// Remove prefix from file path before add to zip.
				$localPath = substr($filePath, $exclusiveLength);
				if (is_file($filePath)) {
					$zipFile->addFile($filePath, $localPath);
				} elseif (is_dir($filePath)) {
					// Add sub-directory.
					$zipFile->addEmptyDir($localPath);
					self::folderToZip($filePath, $zipFile, $exclusiveLength);
				}
			}
		}
		closedir($handle);
	}

	/**
	 * Zip a folder (include itself).
	 * Usage:
	 *   HZip::zipDir('/path/to/sourceDir', '/path/to/out.zip');
	 *
	 * @param string $sourcePath Path of directory to be zip.
	 * @param string $outZipPath Path of output zip file.
	 */
	public static function zipDir($sourcePath, $outZipPath)
	{
		$pathInfo = pathInfo($sourcePath);
		$parentPath = $pathInfo['dirname'];
		$dirName = $pathInfo['basename'];

		$z = new \ZipArchive();
		$z->open($outZipPath, \ZIPARCHIVE::CREATE);
		$z->addEmptyDir($dirName);
		self::folderToZip($sourcePath, $z, strlen("$parentPath/"));
		$z->close();
	}

	/**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for emailConfirmLink'));
                return $this->goHome();
            } else
                Yii::$app->session->setFlash('error', Yii::t('app', 'We are unable to register you'));
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionEmailConfirm($token)
    {
        try {
            $model = new EmailConfirmForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->confirmEmail()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Email confirm success'));
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Email confirm error'));
        }

        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for resetLink'));

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'We are unable to reset password for this email'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'New password was saved'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
}
