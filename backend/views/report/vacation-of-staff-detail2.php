<?php
/**
 * Created by PhpStorm.
 * User: VIETBINH
 * Date: 3/5/15
 * Time: 1:50 PM
 */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
?>
<div class="application-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter'=>false,
        'summary'=>'',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            array(
                'attribute'=>'from_date',
                'enableSorting'=>false,
                'value' => function ($model) {
                        return Yii::$app->formatter->asDate($model->from_date)."-".$model->from_hour;
                    },
                //'contentOptions' => array('style' => 'width: 200px;'),
            ),
            array(
                'attribute'=>'to_date',
                'enableSorting'=>false,
                'value' => function ($model) {
                        return Yii::$app->formatter->asDate($model->to_date)."-".$model->to_hour;
                    },
                //'contentOptions' => array('style' => 'width: 200px;'),
            ),
            // 'to_hour',
            array(
                'attribute'=>'hours_off',
                'enableSorting'=>false,
                'format' => 'raw',
                'filter'=>false,
                'contentOptions' => array('style' => 'text-align: right;'),
                'footerOptions'=> array('style' => 'text-align: right;'),
                'footer' => ''
            ),

        ],
    ]); ?>

</div>