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
        ?>

        <?= Html::submitButton('Search', ['class' =>'btn btn-primary','style'=>'margin-bottom:10px;']) ?>
        <a id="print" href="<?=Yii::$app->urlManager->createUrl(['report/vacation-of-staff','param'=>'print','from_date'=>$model->from_date,'to_date'=>$model->to_date])?>" target="_blank"><span style="font-size:30px;vertical-align: top;margin: 0px 0px 0px 30px;" class="glyphicon glyphicon-print"></span></a>
        <?php ActiveForm::end(); ?>
        </div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'headerRowOptions'=>[
                'style'=>'font-size:13px;',
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'full_name',
                    'value' => 'full_name'
                ],
                [
                    'header'=>'Sick leave<br> with<br> document',
                    'format' => 'raw',
                    'value'=>function($model){
                            if($model->nghi_phep2 === null)
                                return "";
                            else
                                return Html::a($model->nghi_phep2 ,
                                    ['report/vacation-of-staff-detail'],
                                    [
                                        'onclick'=>"
                                        getListApplicationDetail(".$model->user_id.",2,'".$model->full_name."');
                                        return false;",
                                    ]);
                        }
                ],
                [
                    'header'=>'Sick leave<br> without<br>documents',
                    'format' => 'raw',
                    'value'=>function($model){
                            if($model->nghi_phep3 === null)
                                return "";
                            else
                                return Html::a($model->nghi_phep3 ,
                                    ['report/vacation-of-staff-detail'],
                                    [
                                        'onclick'=>"
                                        getListApplicationDetail(".$model->user_id.",3,'".$model->full_name."');
                                        return false;",
                                    ]);
                        }
                ],
                [
                    'header'=>'Maternity leave',
                    'format' => 'raw',
                    'value'=>function($model){
                            if($model->nghi_phep4 === null)
                                return "";
                            else
                                return Html::a($model->nghi_phep4 ,
                                    ['report/vacation-of-staff-detail'],
                                    [
                                        'onclick'=>"
                                        getListApplicationDetail(".$model->user_id.",4,'".$model->full_name."');
                                        return false;",
                                    ]);
                        }
                ],
                [
                    'header'=>'Unpaid leave',
                    'format' => 'raw',
                    'value'=>function($model){
                            if($model->nghi_phep5 === null)
                                return "";
                            else
                                return Html::a($model->nghi_phep5 ,
                                    ['report/vacation-of-staff-detail'],
                                    [
                                        'onclick'=>"
                                        getListApplicationDetail(".$model->user_id.",5,'".$model->full_name."');
                                        return false;",
                                    ]);
                        }
                ],
                [
                    'header'=>'Wedding leave',
                    'format' => 'raw',
                    'value'=>function($model){
                            if($model->nghi_phep6 === null)
                                return "";
                            else
                                return Html::a($model->nghi_phep6 ,
                                    ['report/vacation-of-staff-detail'],
                                    [
                                        'onclick'=>"
                                        getListApplicationDetail(".$model->user_id.",6,'".$model->full_name."');
                                        return false;",
                                    ]);
                        }
                ],
                [
                    'header'=>'Break contract',
                    'format' => 'raw',
                    'value'=>function($model){
                            if($model->nghi_phep7 === null)
                                return "";
                            else
                                return Html::a($model->nghi_phep7 ,
                                    ['report/vacation-of-staff-detail'],
                                    [
                                        'onclick'=>"
                                        getListApplicationDetail(".$model->user_id.",7 ,'".$model->full_name."');
                                        return false;",
                                    ]);
                        }
                ],
                [
                    'header'=>'Bereavement<br>leave<br>(parents)',
                    'format' => 'raw',
                    'value'=>function($model){
                            if($model->nghi_phep8 === null)
                                return "";
                            else
                                return Html::a($model->nghi_phep8 ,
                                    ['report/vacation-of-staff-detail'],
                                    [
                                        'onclick'=>"
                                        getListApplicationDetail(".$model->user_id.",8 ,'".$model->full_name."');
                                        return false;",
                                    ]);
                        }
                ],
                [
                    'header'=>'Bereavement<br>leave<br>(grandparents)',
                    'format' => 'raw',
                    'value'=>function($model){
                            if($model->nghi_phep9 === null)
                                return "";
                            else
                                return Html::a($model->nghi_phep9 ,
                                    ['report/vacation-of-staff-detail'],
                                    [
                                        'onclick'=>"
                                        getListApplicationDetail(".$model->user_id.",9 ,'".$model->full_name."');
                                        return false;",
                                    ]);
                        }
                ],
                [
                    'header'=>'Other',
                    'format' => 'raw',
                    'value'=>function($model){
                            if($model->nghi_phep10 === null)
                                return "";
                            else
                                return Html::a($model->nghi_phep10 ,
                                    ['report/vacation-of-staff-detail'],
                                    [
                                        'onclick'=>"
                                        getListApplicationDetail(".$model->user_id.",10 ,'".$model->full_name."');
                                        return false;",
                                    ]);
                        }
                ],
                [
                    'header'=>'Annual leave',
                    'format' => 'raw',
                    'value'=>function($model){
                            if($model->nghi_phep13 === null)
                                return "";
                            else
                                return Html::a($model->nghi_phep13 ,
                                    ['report/vacation-of-staff-detail'],
                                    [
                                        'onclick'=>"
                                        getListApplicationDetail(".$model->user_id.",13 ,'".$model->full_name."');
                                        return false;",
                                    ]);
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

    function print_press()
    {
        alert($("#reportstaff-from_date").val());
        var a_href = $('#print').attr('href');
        alert
        //$("#print").attr("href", "http://www.google.com/")
    }

    function getListApplicationDetail(user_id,reason_id,user_name){
        var request = $.ajax({
            url: "<?php echo \yii\helpers\Url::to(['report/vacation-of-staff-detail']) ?>",
            type: "POST",
            data: { user_id : user_id, reason_id: reason_id, from_date: $("#reportstaff-from_date").val(), to_date: $("#reportstaff-to_date").val() },
            dataType: "html"
        });

        request.done(function( msg ) {
            $('#modal-leave').modal('toggle');
            $(".modal-header >h2").html("Applications : "+user_name+"(From: "+$("#reportstaff-from_date").val()+" To: "+$("#reportstaff-to_date").val()+")");
            $( "#content-leaves" ).html( msg );
        });


        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }
</script>