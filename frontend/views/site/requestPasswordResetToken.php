<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <div class="row " style="text-align: center">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out your email. A link to reset password will be sent there.</p>
    </div>
    <div class="row" style="text-align: center">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form', 'options'=>['class'=>'form-inline']]); ?>
                <?= $form->field($model, 'email',['options'=>['class'=>'form-group col-lg-6 col-lg-offset-2'],'inputOptions'=>['class'=>'form-control','style'=>'width:100%'],'template' => '<div class="col-lg-3">{label}</div><div class="col-lg-9">{input}{error}</div>{hint}']) ?>
                <div class="form-group col-lg-3" style="text-align:left">
                    <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
    </div>

</div>
