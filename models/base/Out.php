<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\query\OutQuery;

/**
 * This is the base-model class for table "out".
 *
 * @property integer $id
 * @property integer $type_out_id
 * @property string $name
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property \app\models\TypeOut $typeOut
 */
abstract class Out extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'out';
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
            [['type_out_id'], 'required'],
            [['type_out_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['type_out_id'], 'exist', 'skipOnError' => true, 'targetClass' => TypeOut::className(), 'targetAttribute' => ['type_out_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type_out_id' => 'Type Out ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \app\models\query\TypeOutQuery
     */
    public function getTypeOut()
    {
        return $this->hasOne(\app\models\TypeOut::className(), ['id' => 'type_out_id'])->inverseOf('outs');
    }

    /**
     * @inheritdoc
     * @return OutQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OutQuery(get_called_class());
    }
}
