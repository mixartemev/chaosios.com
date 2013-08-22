<?php
/**
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property HosterAccount[] $hosterAccounts
 * @property RegistarAccount[] $registarAccounts
 */
class User extends CActiveRecord{
	public $passwd2;//для верификации пароля при регистрации
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	public function tableName(){
		return 'user';
	}
	public function rules(){
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>63),
			array('id, name', 'safe', 'on'=>'search'),
		);
	}
	public function relations(){
		return array(
			'hosterAccounts' => array(self::HAS_MANY, 'HosterAccount', 'user'),
			'registarAccounts' => array(self::HAS_MANY, 'RegistarAccount', 'user'),
		);
	}
	public function search(){
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}