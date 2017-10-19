<?php

/* @var $this yii\web\View */
/* @var $user app\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/email-confirm', 'token' => $user->confirm_token]);
?>

<?= Yii::t('app', 'Hello {username}', ['username' => $user->username]); ?>

<?= Yii::t('app', 'Follow to conform email') ?>

<?= $confirmLink ?>

<?= Yii::t('app', 'Ignore if do not register') ?>