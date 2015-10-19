<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
//use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;

$this->title = 'Vacation Report' ;

?>
    <h1 style="text-align: center">Vacation Report </h1>
    <h4 style="text-align: center"><?=$str_date;?></h4>
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
                'value' => 'full_name',
                'header'=>"Full Name"
            ],
            [
                'header'=>'Sick leave<br> with<br> document',
                'format' => 'raw',
                'value'=>function($model){
                        if($model->nghi_phep2 === null)
                            return "";
                        else
                            $model->nghi_phep2;
                    }
            ],
            [
                'header'=>'Sick leave<br> without<br>documents',
                'format' => 'raw',
                'value'=>function($model){
                        if($model->nghi_phep3 === null)
                            return "";
                        else
                            return $model->nghi_phep3;
                    }
            ],
            [
                'header'=>'Maternity leave',
                'format' => 'raw',
                'value'=>function($model){
                        if($model->nghi_phep4 === null)
                            return "";
                        else
                            return $model->nghi_phep4;
                    }
            ],
            [
                'header'=>'Unpaid leave',
                'format' => 'raw',
                'value'=>function($model){
                        if($model->nghi_phep5 === null)
                            return "";
                        else
                            return $model->nghi_phep5;
                    }
            ],
            [
                'header'=>'Wedding leave',
                'format' => 'raw',
                'value'=>function($model){
                        if($model->nghi_phep6 === null)
                            return "";
                        else
                            return $model->nghi_phep6;
                    }
            ],
            [
                'header'=>'Break contract',
                'format' => 'raw',
                'value'=>function($model){
                        if($model->nghi_phep7 === null)
                            return "";
                        else
                            return $model->nghi_phep7;
                    }
            ],
            [
                'header'=>'Bereavement<br>leave<br>(parents)',
                'format' => 'raw',
                'value'=>function($model){
                        if($model->nghi_phep8 === null)
                            return "";
                        else
                            return $model->nghi_phep8;
                    }
            ],
            [
                'header'=>'Bereavement<br>leave<br>(grandparents)',
                'format' => 'raw',
                'value'=>function($model){
                        if($model->nghi_phep9 === null)
                            return "";
                        else
                            return $model->nghi_phep9;
                    }
            ],
            [
                'header'=>'Other',
                'format' => 'raw',
                'value'=>function($model){
                        if($model->nghi_phep10 === null)
                            return "";
                        else
                            return $model->nghi_phep10;
                    }
            ],
            [
                'header'=>'Annual leave',
                'format' => 'raw',
                'value'=>function($model){
                        if($model->nghi_phep13 === null)
                            return "";
                        else
                            return $model->nghi_phep13;
                    }
            ],
        ],
    ]); ?>
<div style="text-align: right"><a href="javascript:;" onclick="return window.print();">Print</a></div>
