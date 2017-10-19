<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Out */
?>
<div class="out-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type_out_id',
            'name',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
