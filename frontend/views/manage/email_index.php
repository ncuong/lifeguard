<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TbEmailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Emails';
?>
<div class="row panel panel-default ">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="col-lg-12 col-sm-12 tb-email-index">
        <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

        <p style="text-align: right; margin: 10px 0 0 0">
            <?= Html::a('Send Email', ['create-email'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php
        $grid = GridView::begin([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pager' => ['options' => ['class' => 'pagination','style'=>'margin:0px;']],
            'layout'=>"{summary}\n{items}",
            'rowOptions' => function ($model, $key, $index, $grid) {
                    if ($model->status == 0) {
                        return ['class' => 'danger'];
                    }
//            else
//                return ['class' => 'success'];
                },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'email_to',
                    'value' => function ($model) {
                            return str_replace(",", ", ", $model->email_to);
                        },
                    'contentOptions' => array('width' => '10%'),
                    'headerOptions' => array("style" => "width:50%;")
                ],
                'email_from:text',
                'email_subject:text',
                [
                    'attribute' => 'status',
                    'filter' => [0 => 'Error', 1 => 'Sent'],
                    'value' => function ($model) {
                            return $model->status == 0 ? "Error" : "Sent";
                        }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}{delete}',
                    'contentOptions' => array('width' => '100', 'class' => 'btn-action'),
                    'buttons' => [
                        'view' => function ($url, $model) {
                                $url = \yii\helpers\Url::to(['manage/email-view', 'id' => $model->id], true);
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                                    $url);
                            },
                        'delete' => function ($url, $model) {
                                $url = \yii\helpers\Url::to(['manage/delete-email', 'id' => $model->id], true);
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('yii', 'Create'),
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this email "' . $model->email_subject . '"?',
                                        'method' => 'post',
                                    ],
                                ]);

                            },
                        'update' => function ($url, $model) {
                                $url = \yii\helpers\Url::to(['manage/update-email', 'id' => $model->id], true);
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('yii', 'Update'),
                                ]);

                            },
                    ]
                ],
            ],
        ]); ?>

        <?php $grid->end(); ?>
        <div class="row" style="margin-top: 20px;">
            <div class="col-lg-12 panel-footer" style="text-align: right">
                <?php echo $grid->renderPager(); ?>
            </div>
        </div>

    </div>
</div>