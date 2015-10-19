<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
//use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;

$this->title = 'Days annual leave of employees' ;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">

    <div class="application-form form-inline">
        <?php $form = ActiveForm::begin(); ?>
        <?php
        echo $form->field($model, 'from_date')->widget(DateRangePicker::className(), [
            'attributeTo' => 'to_date',
            'form' => $form, // best for correct client validation
            'language' => 'en',
            'size' => 'ms',
            'clientOptions' => [
                'minView' => 0,
                'autoclose' => true,
                'daysOfWeekDisabled'=>'0,6',
                'format' => 'yyyy-mm-dd'
            ]
        ])->label('Date');
        echo Html::submitButton('Search', ['class' =>'btn btn-primary','style'=>'margin-bottom:10px;']);
        ?>
        <a id="print" href="<?=Yii::$app->urlManager->createUrl(['report/overtime-of-staff','param'=>'print','from_date'=>$model->from_date,'to_date'=>$model->to_date])?>" target="_blank"><span style="font-size:30px;vertical-align: top;margin: 0px 0px 0px 30px;" class="glyphicon glyphicon-print"></span></a>
        <?php ActiveForm::end(); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'full_name',
                'value' => 'full_name'
            ],
            [
                'header'=>'Overtime (h)',
                'format' => 'raw',
                'value'=>function($model){
                        if($model->nghi_phep12 === null)
                            return "";
                        else
                            return Html::a($model->nghi_phep12 ,
                                ['report/vacation-of-staff-detail'],
                                [
                                    'onclick'=>"
                                    getListApplicationOvertimeDetail(".$model->user_id.",12,'".$model->full_name."');
                                    return false;",
                                    'class'=>"user".$model->user_id."-12",
                                ]);
                    }
            ],
            [
                'header'=>'OT Compensation (h)',
                'format' => 'raw',
                'value'=>function($model){
                        if($model->nghi_phep11 === null)
                            return "";
                        else
                            return Html::a($model->nghi_phep11 ,
                                ['report/vacation-of-staff-detail'],
                                [
                                    'onclick'=>"
                                    getListApplicationOvertimeDetail(".$model->user_id.",11,'".$model->full_name."');
                                    return false;",
                                ]);
                    }
            ],
            [
                'header'=>'OT by Cash',
                'format' => 'raw',
                'value'=>function($model){
                        if($model->nghi_phep14 === null)
                            return "";
                        else
                            return Html::a($model->nghi_phep14 ,
                                ['report/vacation-of-staff-detail'],
                                [
                                    'onclick'=>"
                                    getListApplicationOvertimeDetail(".$model->user_id.",14,'".$model->full_name."');
                                    return false;",
                                ]);
                    }
            ],
            [
                'header'=>'Time remaining (h)',
                'format' => 'raw',
                'value'=>function($model){
                        return $model->nghi_phep12 - $model->nghi_phep11 - $model->nghi_phep14;
                    }
            ],

//            [
//                'class' => 'yii\grid\ActionColumn',
//                'template'=>'{forward}',
//                'buttons'=>[
//                    'forward' => function($url, $model){
//                            return Html::a('<span class="glyphicon glyphicon-minus-sign"></span>' ,
//                                ['application/application-of-type','id'=>-11,'user_id'=>$model->user_id],
//                                [
////                                    'onclick'=>"
////                                        getApplication(".$model->id.");
////                                        return false;",
//                                ]);
//                        },
//
//                ]
//            ],

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

    function getListApplicationOvertimeDetail(user_id,reason_id,user_name){
        var cl = '.user'+user_id+"-"+reason_id;

        var request = $.ajax({
            url: "<?php echo \yii\helpers\Url::to(['report/overtime-of-staff-detail']) ?>",
            type: "POST",
            data: { user_id : user_id, reason_id: reason_id, from_date: $("#reportstaff-from_date").val(), to_date: $("#reportstaff-to_date").val(), view: 1 },
            dataType: "html"
        });

        request.done(function( msg ) {
            $('#modal-leave').modal('toggle');
            $(".modal-header >h2").html("Applications : "+user_name);
            $( "#content-leaves" ).html( msg );
        });


        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }
</script>