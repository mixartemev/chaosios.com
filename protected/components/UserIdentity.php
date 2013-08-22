<?php
//User controller
class UserIdentity extends CUserIdentity{
	private $_id;
	//авторизация
	public function authenticate(){
		//из бд в array record
		$record=User::model()->findByAttributes(array('name'=>$this->name));
		if($record===null)//пустое имя
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($record->password!==$this->password)//не тот пароль
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else{//ок
			$this->_id=$record->id;
			$this->setState('title', $record->title);
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
	public function getId(){
		return $this->_id;
	}
}