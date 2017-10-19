<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "TypeOutController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class TypeOutController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\TypeOut';
}
