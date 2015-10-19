<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

$this->title = 'Quota' ;
$this->params['breadcrumbs'][] = "Report";
?>
<div class="panel panel-default">
    <div class="panel-heading"><?=$this->title?></div>
    <div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user.full_name',
                'value' => 'user.full_name'
            ],
            [
                'attribute'=>'year',
                'filter'=>false,
                'format' => 'raw',
                'value'=>function($model){
                        return Html::a($model->year ,
                            ['application/leave-user','year'=>$model->year],
                            [
                                'onclick'=>"
                                getListApplicationLeave(".$model->year.");
                                return false;",
                        ]);
                },
            ],
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
        ],
    ]); ?>

    </div>
</div>
<?php
Modal::begin([
    'header' => '<h2>Applications</h2>',
    'id'=>'modal-leave',
    'size'=>'modal-lg',

]);

echo '<div id="content-leaves"></div>';

Modal::end();
?>
<script type="application/javascript">
    function getListApplicationLeave(year){
        $('#modal-leave').modal('toggle');

        var request = $.ajax({
            url: "<?php echo \yii\helpers\Url::to(['application/leave-user']) ?>",
            type: "POST",
            data: { year : year },
            dataType: "html"
        });

        request.done(function( msg ) {
            $(".modal-header >h2").html("Applications : "+year);
            $( "#content-leaves" ).html( msg );
        });


        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }
</script>


<div class="panel panel-default">
    <div class="panel-heading">Overtime</div>
    <div class="panel-body">
        <?= GridView::widget([
    'dataProvider' => $dataUserTimeOver,
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
//        'attribute'=>'hours_off',
//        'title',
        // 'content:ntext',
        // 'deleted:boolean',
        // 'date_create',
        // 'date_update',
        [
            'header'=>'Overtime(h)',
            'value'=>function($model){
                if($model->reasonApplication->type_id == 1){
                    return $model->hours_off;
                }else
                    return "";
            },
            'contentOptions' => array('style' => 'text-align: right;'),
            'footerOptions'=> array('style' => 'text-align: right;'),
            'footer' => $totalTimeOverWork
        ],
        [
            'header'=>'OT Compensation(h)',
            'value'=>function($model){
                    if($model->reasonApplication->type_id == -1){
                        return $model->hours_off;
                    }else
                        return "";
                },
            'contentOptions' => array('style' => 'text-align: right;'),
            'footerOptions'=> array('style' => 'text-align: right;'),
            'footer' => $totalTimeLeaveOfTimeOver
        ],
        [
            'header'=>'OT by Cash(h)',
            'value'=>function($model){
                    if($model->reasonApplication->type_id == -11){
                        return $model->hours_off;
                    }else
                        return "";
                },
            'contentOptions' => array('style' => 'text-align: right;'),
            'footerOptions'=> array('style' => 'text-align: right;'),
            'footer' => $totalTimeMoney
        ],
        [
            'header'=>'Time Remaining(h)',
            'value'=>function($model){return '';},
            'contentOptions' => array('style' => 'text-align: right;'),
            'footerOptions'=> array('style' => 'text-align: right;'),
            'footer' => $totalRemainTime
        ],

    ],
]); ?>
    </div>
</div>
