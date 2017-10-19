<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\query\UserQuery;

/**
 * This is the base-model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property string $password_hash
 * @property string $email
 * @property string $auth_key
 * @property string $confirm_token
 * @property integer $phone
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $aliasModel
 */
abstract class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'email', 'auth_key'], 'required'],
            [['phone', 'status'], 'integer'],
            [['username', 'name', 'password_hash', 'email'], 'string', 'max' => 255],
            [['auth_key', 'confirm_token'], 'string', 'max' => 43],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['confirm_token'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'name' => Yii::t('app', 'Name'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'email' => Yii::t('app', 'Email'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'confirm_token' => Yii::t('app', 'Confirm Token'),
            'phone' => Yii::t('app', 'Phone'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
