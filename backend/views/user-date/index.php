<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Date off of Staff';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">
        <p>
            <?= Html::a('Create date off for staff', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'full_name',
                    'value' => 'user.full_name'
                ],
                'year',
                'entitlement',
                [
                    'attribute'=>'balance',
                    'filter'=>false,
                    'format'=>'raw',
                    'value'=>function($model){
                            if($model->balance === null)
                                return $model->entitlement;
                            else
                                return $model->balance;
                        }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template'=>'{update}{delete}'
                ],
            ],
        ]); ?>

    </div>
</div>
