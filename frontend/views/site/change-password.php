<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/**
 * Created by PhpStorm.
 * User: VIETBINH
 * Date: 9/26/15
 * Time: 8:15 AM
 */

?>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <?php $form = ActiveForm::begin(['id' => 'change-password-form', 'layout' => 'horizontal', 'requiredCssClass' => 'required']); ?>
        <div class="panel panel-default">
            <div class="panel-heading">Change Password <span class="extra-title muted"></span></div>
            <div class="panel-body">
                <?php echo $form->field($model, "currentPassword")->passwordInput(); ?>
                <?php echo $form->field($model, "newPassword")->passwordInput(); ?>
                <?php echo $form->field($model, "confirmNewRepeat")->passwordInput() ?>
            </div>
            <div class="panel-footer" style="text-align: right">
                <?= Html::submitButton('Change Password', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
