<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Short Urls');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="short-url-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Short Url'), ['/'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'url:url',
            [
                'attribute' => 'short_code',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->isActiveCode() ? Html::a($model->short_code, ['redirect', 'code' => $model->short_code]) : $model->short_code;
                }
            ],
            'expire',
            'max_visits',
            'total_visits'
        ],
    ]); ?>


</div>
