<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <div class="row" style="text-align: center">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Please choose your new password:</p>
    </div>
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form','options'=>['class'=>'form-inline']]); ?>
            <?= $form->field($model, 'password',['options'=>['class'=>'form-group col-lg-8 col-lg-offset-2'],'inputOptions'=>['class'=>'form-control','style'=>'width:100%'],'template' => '<div class="col-lg-3">{label}</div><div class="col-lg-9">{input}{error}</div>{hint}'])->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
