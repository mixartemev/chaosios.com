<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\TypeOut $model
*/

$this->title = Yii::t('app', 'TypeOut') . $model->title . ', ' . 'Edit';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'TypeOuts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud type-out-update">

    <h1>
        <?= Yii::t('app', 'TypeOut') ?>
        <small>
                        <?= $model->title ?>        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> ' . 'View', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
