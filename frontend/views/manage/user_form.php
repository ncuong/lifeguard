<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>

<div class="panel-body">
    <div class="col-sm-12 col-lg-12">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <?= $form->field($model, 'code')->textInput(['maxlength' => 100]) ?>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <?= $form->field($model, 'referrer')->textInput(['maxlength' => 5]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 100]) ?>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 100]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <?= $form->field($model, 'graduate_high_school')->dropDownList(\frontend\controllers\Common::graduate_years()) ?>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <?= $form->field($model, 'sex')->inline()->radioList(array(1=>'Male ',0=>' Female'),['class'=>'col-sm-12']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <?= $form->field($model, 'city')->textInput(['maxlength' => 1000]) ?>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <?= $form->field($model, 'state')->dropDownList(\frontend\controllers\Common::$states) ?>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <?= $form->field($model, 'zip')->textInput(['maxlength' => 500]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <?= $form->field($model, 'mobile')->textInput(['maxlength' => 100]) ?>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <?= $form->field($model, 'status')->dropDownList(\frontend\controllers\Common::status()) ?>
                </div>
            </div>
    </div>
</div>
<div class="panel-footer" style="text-align: right; padding-right: 30px;">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>



<?php ActiveForm::end(); ?>