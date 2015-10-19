<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Date off of '. $user->first_name ;
?>
<div class="user-date-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?php
        if(Yii::$app->user->can('hrm'))
            echo Html::a('Create date off for '. $user->first_name, ['create-for-staff','id'=>$user->user_id], ['class' => 'btn btn-success'])
        ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user.full_name',
                'value' => 'user.full_name'
            ],
            'year',
            'entitlement',
            'balance',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => false,
                'buttons'=>[
                    'delete' => function ($url, $model) {
                            if(!Yii::$app->user->can('hrm'))
                                return '<span class="glyphicon glyphicon-trash"></span>';
                            else
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('yii', 'Create'),
                                ]);

                        },
                    'update' => function ($url, $model) {
                            if(!Yii::$app->user->can('hrm'))
                                return '<span class="glyphicon glyphicon-pencil"></span>';
                            else
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('yii', 'Update'),
                                ]);

                        },
                ]

            ],
        ],
    ]); ?>

</div>
