<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::$app->params['typeApplication'][$model->type];
//$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">

        <div class="application-form">

            <?php $form = ActiveForm::begin(); ?>
            <?= $form->errorSummary($model); ?>
            <?php //echo $form->field($model, 'type')->dropDownList(Yii::$app->params['typeApplication']) ?>

            <?= $form->field($model, 'reason',['options'=>['class'=>'form-inline']])->dropDownList(ArrayHelper::map($reason, 'id', 'name'), array('prompt' => '--Select a reason--', 'style' => 'width:300px;'))->label('Reason',['style'=>'margin-right:10px']) ?>
            <?= $form->field($model, 'hours_off',['options'=>['class'=>'form-inline']])->textInput(['style' => 'width:200px;'])->label('Hours',['style'=>'margin-right:20px']) ?>
            <div class="form-inline">
            <?=
            $form->field($model, 'from_date')->widget(
                DatePicker::className(), [
                // inline too, not bad
                'inline' => false,
                // modify template for custom rendering
                'template' => '{addon}{input}',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ],
                'options' => [
                    'style' => 'width:300px;',
                ]
            ])->label('Date',['style'=>'margin-right:30px']);?>
            </div>
            <?php
            //    echo $form->field($model, 'from_date')->widget(DateRangePicker::className(), [
            //        'attributeTo' => 'to_date',
            //        'form' => $form, // best for correct client validation
            //        'language' => 'en',
            //        'size' => 'ms',
            //        'clientOptions' => [
            //            'minView' => 0,
            //            'autoclose' => true,
            //            'daysOfWeekDisabled'=>'0,6',
            //            'format' => 'dd MM yyyy'
            //        ]
            //    ]);
            ?>
            <?= $form->field($model, 'content')->textarea(['rows' => 10,'style'=>'width:80%;']) ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>