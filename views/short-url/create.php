<?php

/* @var $this yii\web\View */
/* @var $model app\models\ShortUrl */

$this->title = Yii::t('app', 'Short Url');
?>
<div class="short-url-create">
    <h2 class="text-center">
        <?= Yii::t('app','Paste the URL to be shortened'); ?>
    </h2>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
