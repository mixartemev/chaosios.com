<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\query\InQuery;

/**
 * This is the base-model class for table "in".
 *
 * @property integer $id
 * @property integer $type_in_id
 * @property string $name
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property \app\models\TypeIn $typeIn
 */
abstract class In extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'in';
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
            [['type_in_id'], 'required'],
            [['type_in_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['type_in_id'], 'exist', 'skipOnError' => true, 'targetClass' => TypeIn::className(), 'targetAttribute' => ['type_in_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type_in_id' => 'Type In ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \app\models\query\TypeInQuery
     */
    public function getTypeIn()
    {
        return $this->hasOne(\app\models\TypeIn::className(), ['id' => 'type_in_id'])->inverseOf('ins');
    }

    /**
     * @inheritdoc
     * @return InQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InQuery(get_called_class());
    }
}
