<?php

/**
 * This is the model class for table "domain".
 *
 * The followings are the available columns in table 'domain':
 * @property integer $id
 * @property string $name
 * @property integer $registar_account
 * @property integer $hoster_account
 * @property string $expire
 *
 * The followings are the available model relations:
 * @property Database[] $databases
 * @property RegistarAccount $registarAccount
 * @property HosterAccount $hosterAccount
 * @property Email[] $emails
 * @property Ftp[] $ftps
 */
class Domain extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Domain the static model class
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
		return 'domain';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, expire', 'required'),
			array('registar_account, hoster_account', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>63),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, registar_account, hoster_account, expire', 'safe', 'on'=>'search'),
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
			'databases' => array(self::HAS_MANY, 'Database', 'domain'),
			'registarAccount' => array(self::BELONGS_TO, 'RegistarAccount', 'registar_account'),
			'hosterAccount' => array(self::BELONGS_TO, 'HosterAccount', 'hoster_account'),
			'emails' => array(self::HAS_MANY, 'Email', 'domain'),
			'ftps' => array(self::HAS_MANY, 'Ftp', 'domain'),
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
			'registar_account' => 'Registar Account',
			'hoster_account' => 'Hoster Account',
			'expire' => 'Expire',
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
		$criteria->compare('registarAccount',$this->registarAccount->login);
		$criteria->compare('hoster_account',$this->hoster_account);
		$criteria->compare('expire',$this->expire,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}