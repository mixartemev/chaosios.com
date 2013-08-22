<?php
class SiteController extends Controller{
	public $layout='column1';

	public function actions(){
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFF8800,
			),
			// рендерим static pages: 'protected/views/site/pages'
			// url as 'index.php?r=site/page&view=FileName'
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	// дебаг
	public function actionError(){
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	// Вызов контакт-формы
	public function actionContact(){
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	//Вход по данным из бд
	public function actionLogin(){
		if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
			throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");

		$model=new LoginForm;

		// если вход аяксовый
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// если данные юзера приняли
		if(isset($_POST['LoginForm'])){
			$model->attributes=$_POST['LoginForm'];
			// проверяем их, и если ок, то 304 на previous page
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		$this->render('login',array('model'=>$model));
	}

	//Досвидания
	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionRegistration(){
        $form = new User();
        // Проверяем являеться ли пользователь гостем,если он уже зарегистрирован - форму он не увидит.
        if (!Yii::app()->user->isGuest){
			throw new CException('Вы уже зарегистрированны!');
        }else{
            // Если $_POST['User'] не пустой массив - значит была отправлена форма, занчит надо заполнить $form этими данными и провести валидацию.
			//Если валидация пройдет успешно - пользователь будет зарегистрирован, не успешно - покажем ошибку на экран
            if (!empty($_POST['User'])){                
				// Заполняем $form данными которые пришли с формы
				$form->attributes = $_POST['User'];
                
                // Запоминаем данные которые пользователь ввёл в капче
                // $form->verifyCode = $_POST['User']['verifyCode'];
                
                    // В validate мы передаем название сценария
					if($form->validate('registration')) {
                        // Если валидация прошла успешно - проверяем свободен ли указанный логин
							if ($form->model()->count("name = :login", array(':login' => $form->name))) {
								// Указанный логин уже занят. Создаем ошибку и передаем в форму
                                $form->addError('login','Логин уже занят');
                                $this->render("registration", array('form' => $form));
                             } else {
                                // Выводим страницу ОК
                                $form->save();
                                $this->render("registration_ok");
                            }
					}else{
                        // Если валидация не ок - выводим форму с ошибкой
                        $this->render("registration", array('form' => $form));
                    }
			}else{
			// Если $_POST['User'] пустой массив, значит юзер просто вошел на страницу регистрации - просто показываем форму.
                $this->render("registration", array('form' => $form));
            }
        }
    }
	
	public function actionIndex($tabl=null){
		if(!$tabl)$tabl='Domain';
		$model=new $tabl('search');
		$model->unsetAttributes();  // clear any default values
		//$model->attributes=array('id'=>'>1');
		$this->render('index',array('model'=>$model));
	}
}