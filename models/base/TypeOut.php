<?php

namespace app\models\base;

use Yii;
use app\models\query\TypeOutQuery;

/**
 * This is the base-model class for table "type_out".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $slug
 *
 * @property \app\models\Out[] $outs
 * @property \app\models\TypeOut $parent
 * @property \app\models\TypeOut[] $typeOuts
 */
abstract class TypeOut extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_out';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'required'],
            [['parent_id'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => TypeOut::className(), 'targetAttribute' => ['parent_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => 'Parent ID',
            'title' => 'Title',
            'slug' => 'Slug',
        ];
    }

    /**
     * @return \app\models\query\OutQuery
     */
    public function getOuts()
    {
        return $this->hasMany(\app\models\Out::className(), ['type_out_id' => 'id'])->inverseOf('typeOut');
    }

    /**
     * @return \app\models\query\TypeOutQuery
     */
    public function getParent()
    {
        return $this->hasOne(\app\models\TypeOut::className(), ['id' => 'parent_id'])->inverseOf('typeOuts');
    }

    /**
     * @return \app\models\query\TypeOutQuery
     */
    public function getTypeOuts()
    {
        return $this->hasMany(\app\models\TypeOut::className(), ['parent_id' => 'id'])->inverseOf('parent');
    }

    /**
     * @inheritdoc
     * @return TypeOutQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TypeOutQuery(get_called_class());
    }
}
