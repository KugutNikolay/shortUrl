<?php

use app\models\ShortUrl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ShortUrl */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="short-url-form">
    <div class="col-sm-offset-3 col-sm-6">
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'max_visits')->textInput() ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'expire')
                        ->dropDownList(array_combine(range(1, ShortUrl::MAX_EXPIRE), range(1, ShortUrl::MAX_EXPIRE))) ?>
                </div>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Shorten URL'), ['class' => 'btn btn-lg btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
