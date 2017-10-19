<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
?>
<div class="user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'name',
            'password_hash',
            'email:email',
            'auth_key',
            'confirm_token',
            'phone',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
