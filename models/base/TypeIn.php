<?php

namespace app\models\base;

use Yii;
use app\models\query\TypeInQuery;

/**
 * This is the base-model class for table "type_in".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $slug
 *
 * @property \app\models\In[] $ins
 * @property \app\models\TypeIn $parent
 * @property \app\models\TypeIn[] $typeIns
 */
abstract class TypeIn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_in';
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
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => TypeIn::className(), 'targetAttribute' => ['parent_id' => 'id']]
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
     * @return \app\models\query\InQuery
     */
    public function getIns()
    {
        return $this->hasMany(\app\models\In::className(), ['type_in_id' => 'id'])->inverseOf('typeIn');
    }

    /**
     * @return \app\models\query\TypeInQuery
     */
    public function getParent()
    {
        return $this->hasOne(\app\models\TypeIn::className(), ['id' => 'parent_id'])->inverseOf('typeIns');
    }

    /**
     * @return \app\models\query\TypeInQuery
     */
    public function getTypeIns()
    {
        return $this->hasMany(\app\models\TypeIn::className(), ['parent_id' => 'id'])->inverseOf('parent');
    }

    /**
     * @inheritdoc
     * @return TypeInQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TypeInQuery(get_called_class());
    }
}
