<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;
use dosamigos\datetimepicker\DateTimePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="application-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model); ?>
    <?= $form->field($model, 'reason', ['options' => ['class' => 'form-inline']])->dropDownList(ArrayHelper::map($reason, 'id', 'name'), array('prompt' => '--Select a reason--', 'style' => 'width:414px;margin-left:20px;')) ?>
    <?= $form->field($model, 'hours_off', ['options' => ['class' => 'form-inline']])->textInput(['style' => 'width:200px;margin-left:30px;']) ?>


    <?php
    // code nay giu lai de lam vi du cho range date.
    echo $form->field($model, 'from_date', ['options' => ['class' => 'form-inline']])->widget(DateRangePicker::className(), [
        'attributeTo' => 'to_date',
        'form' => $form, // best for correct client validation
        'language' => 'en',
        'size' => 'ms',
        'clientOptions' => [
            'minView' => 0,
            'autoclose' => true,
            'daysOfWeekDisabled' => false,
            'format' => 'dd/mm/yyyy'
        ],
        'options' => [


        ]
    ]);
    //
    ?>



    <?php
    //= $form->field($model, 'from_date')->widget(DateTimePicker::className(), [
    //        //'language' => 'en',
    //        'size' => 'ms',
    //        'template' => '{input}{reset}',
    //        'pickButtonIcon' => 'glyphicon glyphicon-time',
    //        'inline' => false,
    //        'clientOptions' => [
    //            'startView' => 2,
    //            //'daysOfWeekDisabled'=>'0,6',
    //            'minView' => 1,
    //            'maxView' => 3,
    //            'startDate' => date('Y-m-d'),
    //            'dateFormat' => 'yy-mm-dd',
    //            'autoclose' => true,
    //            //'linkFormat' => 'HH:ii P', // if inline = true
    //            'format' => 'yyyy-mm-dd (hh:00)', // if inline = false
    //            'todayBtn' => true
    //        ],
    //        'options'=>[
    //            'style'=>'width:200px;margin-left:35px;',
    //
    //        ]
    //    ])->label('From',['style'=>'vertical-align:bottom']);
    ?>


    <?php
    $arrHours[] = '';
    for ($i = 7; $i <= 22; $i++) {
        $arrHours[$i . ':' . '00'] = $i . ':' . '00';
        $arrHours[$i . ':' . '30'] = $i . ':' . '30';
    }
    ?>
    <div class="form-inline" style="margin-top: 25px;">
        <?= $form->field($model, 'from_hour')->dropDownList($arrHours, ['style' => 'width:195px;border-radius:4px 0 0 4px;']) ?>
        <?= $form->field($model, 'to_hour')->dropDownList($arrHours, ['style' => 'width:195px;margin-left:-4px;border-radius:0 4px 4px 0;'])->label("To", ['style' => 'background-color:#EEEEEE;border-top:1px solid #ccc; border-bottom:1px solid #ccc;padding:6px 5px;margin-left:-4px;']) ?>
        <label style="font-size: 13px; font-style: italic">(If less than 7 hours, please specify from what time to what
            time)</label>
    </div>
    <?= $form->field($model, 'content')->textarea(['rows' => 10, 'style' => 'width:80%;']) ?>
    <?php
    //Code nay giu lai de lam vi du cho dieu kien trong option yii
    //        if(Yii::$app->user->can("hrm") || Yii::$app->user->can('admin')){
    //            echo $form->field($model, 'hrm_ok')->radioList(array(1=>'Agree ',0=>' Disagree'),[
    //                'item' => function ($index, $label, $name, $checked, $value) {
    //                        //$disabled = true; // replace with whatever check you use for each item
    //
    //                        if($value === null){
    //                            $checked = true;
    //                        }
    //                        return Html::radio($name, $checked, [
    //                            'value' => $value,
    //                            'label' => Html::encode($label),
    //                            'checked' => $checked,
    //                        ]);
    //                    },
    //            ]);
    //        }
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>