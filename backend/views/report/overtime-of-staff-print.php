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
<h1 style="text-align: center">Overtime Report </h1>
<h4 style="text-align: center"><?=$str_date;?></h4>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'full_name',
            'value' => 'full_name',
            'header'=>"Full Name"
        ],
        [
            'header'=>'Overtime (h)',
            'format' => 'raw',
            'value'=>function($model){
                    if($model->nghi_phep12 === null)
                        return "";
                    else
                        return '<span onclick="getListApplicationOvertimeDetail('.$model->user_id.',12);" class="user'.$model->user_id.'-12">'.$model->nghi_phep12.'</span>';
                }
        ],
        [
            'header'=>'OT Compensation (h)',
            'format' => 'raw',
            'value'=>function($model){
                    if($model->nghi_phep11 === null)
                        return "";
                    else
                        return $model->nghi_phep11;
                }
        ],
        [
            'header'=>'OT by Cash',
            'format' => 'raw',
            'value'=>function($model){
                    if($model->nghi_phep14 === null)
                        return "";
                    else
                        return $model->nghi_phep14;
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



<div style="text-align: right"><a href="javascript:;" onclick="return window.print();">Print</a></div>

<script type="application/javascript">

    function getListApplicationOvertimeDetail(user_id,reason_id){
        var cl = '.user'+user_id+"-"+reason_id;
        var request = $.ajax({
            url: "<?php echo \yii\helpers\Url::to(['report/overtime-of-staff-detail']) ?>",
            type: "POST",
            data: { user_id : user_id, reason_id: reason_id, from_date: $("#reportstaff-from_date").val(), to_date: $("#reportstaff-to_date").val(), view:2 },
            dataType: "html"
        });

        request.done(function( msg ) {
            $(cl).parent().append(msg);
        });


        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }
</script>