<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login row">
    <div class="col-lg-6 col-lg-offset-3 col-sm-6" style="border: 1px solid #ccc; border-radius: 5px; padding: 10px">
        <div class="row" style="text-align: center">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>Please fill out the following fields to login:</p>
        </div>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'layout' => 'horizontal', 'requiredCssClass' => 'required']); ?>
        <?= $form->field($model, 'email',['template'=>'{label}<div class="col-sm-10 col-sm-offset-1">{input}{error}</div>{hint}'])->textInput(['placeholder'=>'Email*'])->label(false) ?>
        <?= $form->field($model, 'password',['template'=>'{label}<div class="col-sm-10 col-sm-offset-1">{input}{error}</div>{hint}'])->passwordInput(['placeholder'=>'Password*'])->label(false) ?>
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
        <div class="row" style="text-align: center">
            <div style="color:#999;margin:0 0 10px 0">
                If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
            </div>
            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
