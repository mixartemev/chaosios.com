<?php

/* @var $this yii\web\View */
/* @var array $results from controller */
/* @var array $photos */
/* @var UploadForm $model */

use app\models\form\UploadForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Pics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-pics">
    <?= Html::beginForm('','get'); ?>
    <?= Html::label('Введи названия через ","', 'query') ?>
    <?= Html::textInput('query',null, ['autofocus' => true]) ?>
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'pics-button']) ?>
    <?= Html::endForm(); ?>
    <div>
    <?php

    if(@$model){
        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
        <?= $form->field($model, 'excel')->fileInput(['label' => 'Или загрузи excel']) ?>
        <button>Submit</button>
        <?php ActiveForm::end();
    }

    if(@$results){
        echo Html::beginForm();
        foreach($results as $query => $result){
            echo Html::tag('h2',$query);
            echo '<div class="row">';
            if(isset($result['items'])) {
                foreach ($result['items'] as $key => $item) {
                    ?>
                    <?= Html::checkbox("photo[$query][]", null, [
                        'value' => $item['link'],
                        'label' => HTML::a( $item['image']['width'], $item['link'], ['target' => '_blank'] )
                            . HTML::img($item['link'], ['style' => 'width:100%']),
                        'labelOptions' => ['style' => 'float:left; width:10%']
                    ]) ?>
                    <div class="">
                    </div>
                <?php }
            }
            echo '</div>';
        }
        echo Html::submitButton();
        echo Html::endForm();
    }
    /** @var array $photos */
    elseif(@$photos) {
        echo Html::tag('h2', 'Фотки успешно загружены');
        print_r($photos);
    }
    ?>
    </div>
</div>
