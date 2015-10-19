<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use dosamigos\datetimepicker\DateTimePicker;
use dosamigos\datepicker\DatePicker;

use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DateRangePicker;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter'=>true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            array(
                'attribute'=>'from_date',
                'contentOptions' => array('style' => 'width: 200px;'),
            ),
            array(
                'attribute'=>'to_date',
                'contentOptions' => array('style' => 'width: 200px;'),
            ),
            'from_hour',
            'to_hour',
            array(
                'attribute'=>'hours_off',
                'format' => 'raw',
                'filter'=>false,
                'contentOptions' => array('style' => 'text-align: right;'),
                'footerOptions'=> array('style' => 'text-align: right;'),
                'footer' => $total
            ),
            array(
                'header'=>'Reason',
                'attribute'=>'reasonApplication.name',
            ),
            // 'content:ntext',
            // 'deleted:boolean',
            // 'date_create',
            // 'date_update',
            // 'type',
//            [
//                'class' => 'yii\grid\ActionColumn',
//                'template'=>'{view}',
//                'buttons'=>[
//                    'update' => function ($url, $model) {
//                            if(($model->hrm_readed || $model->manager_readed) && !Yii::$app->user->can('admin'))
//                                return '<span class="glyphicon glyphicon-pencil"></span>';
//                            else
//                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
//                                    'title' => Yii::t('yii', 'Update'),
//                                ]);
//
//                        },
//                ]
//            ],
        ],
    ]); ?>

</div>
