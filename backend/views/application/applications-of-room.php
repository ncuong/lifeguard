<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Applications';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function ($model, $key, $index, $grid) {
                    if (Yii::$app->user->can('manager')) {
                        if ($model->manager_readed == 1 && $model->manager_ok == 1) {
                            return ['class' => 'success'];
                        } else if ($model->manager_readed == 1 && $model->manager_ok == -1)
                            return ['class' => 'warning'];
                        else if ($model->manager_readed == -1) {
                            return ['class' => 'no-read'];
                        } else
                            return ['class' => 'danger'];
                    }

                    if (Yii::$app->user->can('hrm')) {
                        if ($model->hrm_readed == 1 && $model->hrm_ok == 1) {
                            return ['class' => 'success'];
                        } else if ($model->hrm_readed == 1 && $model->hrm_ok == -1)
                            return ['class' => 'warning'];
                        else if ($model->hrm_readed == -1) {
                            return ['class' => 'no-read'];
                        } else
                            return ['class' => 'danger'];
                    }

                    if (Yii::$app->user->can('hrm') && $model->hrm_readed == -1) {
                        return ['class' => 'no-read'];
                    }
                },

            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'full_name',
                    'value' => 'user.full_name'
                ],
                array(
                    'attribute' => 'from_date',
                    'filter' => DatePicker::widget([
                            'model' => $dataProvider,
                            'name' => 'from_date',
                            'value' => Yii::$app->request->get('from_date'),
                            'attribute' => 'from_date',
                            'size' => 'ms',
                            'template' => '{addon}{input}',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]),
                    'value' => function ($model) {
                            return Yii::$app->formatter->asDate($model->from_date);
                        },
                    'contentOptions' => array('style' => 'width: 170px;'),
                ),
                array(
                    'attribute' => 'to_date',
                    'filter' => DatePicker::widget([
                            'model' => $dataProvider,
                            'name' => 'to_date',
                            'value' => Yii::$app->request->get('to_date'),
                            'attribute' => 'to_date',
                            'size' => 'ms',
                            'template' => '{addon}{input}',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]),
                    'value' => function ($model) {
                            return Yii::$app->formatter->asDate($model->from_date);
                        },
                    'contentOptions' => array('style' => 'width: 170px;'),
                ),
                'from_hour',
                'to_hour',
                array(
                    'attribute' => 'hours_off',
                    'filter' => false
                ),
                [
                    'attribute' => 'reason',
                    'filter' => ArrayHelper::map(\backend\models\ReasonApplication::find()->all(), 'id', 'name'),
                    'value' => 'reasonApplication.name'
                ],
                // 'content:ntext',
                // 'deleted:boolean',
                // 'date_create',
                // 'date_update',
                [
                    'attribute' => 'manager_ok',
                    'format' => 'raw',
                    'filter' => array(
                        '1' => 'Accept',
                        '0' => 'Refuse',
                        '-1' => 'Waiting'
                    ),
                    'value' => function ($model) {

                            if ($model->manager_ok == 1)
                                $status = '<span style="color: #008000; font-size: 12px;"> Accept</span>';
                            else if ($model->manager_ok == 0)
                                $status = '<span style="color: #008000; font-size: 12px;"> Refuse</span>';
                            else
                                $status = '<span style="color: #cccccc; font-size: 12px;"> Waiting</span>';
                            //return Html::checkbox("manager_ok[]",false,array('disabled'=>true)).$status;
                            return $status;
                        },
                ],

                [
                    'attribute' => 'hrm_ok',
                    'format' => 'raw',
                    'filter' => array(
                        '1' => 'Accept',
                        '0' => 'Refuse',
                        '-1' => 'Waiting'
                    ),
                    'value' => function ($model) {

                            if ($model->hrm_ok == 1)
                                $status = '<span style="color: #008000; font-size: 12px;"> Accept</span>';
                            else if ($model->hrm_ok == 0)
                                $status = '<span style="color: #008000; font-size: 12px;"> Refuse</span>';
                            else
                                $status = '<span style="color: #cccccc; font-size: 12px;"> Waiting</span>';
                            //return Html::checkbox("manager_ok[]",false,array('disabled'=>true)).$status;
                            return $status;
                        },
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                                    ['application/check-application', 'id' => $model->id]);
                            },
                    ]
                ],
            ],
        ]);
        ?>
    </div>
</div>