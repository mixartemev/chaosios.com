<?php

/**
 * This is the model class for table "hoster_account".
 *
 * The followings are the available columns in table 'hoster_account':
 * @property integer $id
 * @property string $name
 * @property integer $hoster
 * @property integer $owner
 * @property string $login
 * @property string $password
 *
 * The followings are the available model relations:
 * @property Domain[] $domains
 * @property Hoster $hoster0
 * @property Owner $owner0
 */
class HosterAccount extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HosterAccount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hoster_account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, hoster, owner, login, password', 'required'),
			array('hoster, owner', 'numerical', 'integerOnly'=>true),
			array('name, login', 'length', 'max'=>63),
			array('password', 'length', 'max'=>127),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, hoster, owner, login, password', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'domains' => array(self::HAS_MANY, 'Domain', 'hoster_account'),
			'hoster0' => array(self::BELONGS_TO, 'Hoster', 'hoster'),
			'owner0' => array(self::BELONGS_TO, 'Owner', 'owner'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'hoster' => 'Hoster',
			'owner' => 'Owner',
			'login' => 'Login',
			'password' => 'Password',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('hoster',$this->hoster);
		$criteria->compare('owner',$this->owner);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}