<?php
/**
 * Created by PhpStorm.
 * User: mix
 * Date: 04.09.16
 * Time: 14:28
 */

namespace app\models\form;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
	/**
	 * @var UploadedFile
	 */
	public $excel;

	public function rules()
	{
		return [
			[['excel'], 'file', 'skipOnEmpty' => false],
		];
	}

	public function upload()
	{
		if ($this->validate()) {
			if(!$this->excel->saveAs(Yii::getAlias('@runtime/') . $this->excel->baseName . '.' . $this->excel->extension) ){
				var_dump(Yii::getAlias('@runtime/') . $this->excel->baseName . '.' . $this->excel->extension);
			}
			return true;
		} else {
			return false;
		}
	}
}