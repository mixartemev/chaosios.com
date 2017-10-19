<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\TypeIn]].
 *
 * @see \app\models\TypeIn
 */
class TypeInQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\TypeIn[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\TypeIn|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
