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
            // 'to_hour',
            array(
                'attribute'=>'hours_off',
                'format' => 'raw',
                'filter'=>false,
                'contentOptions' => array('style' => 'text-align: right;'),
                'footerOptions'=> array('style' => 'text-align: right;'),
                'footer' => ''
            ),
            array(
                'header'=>'Reason',
                'attribute'=>'reasonApplication.name',
            ),

        ],
    ]); ?>

</div>