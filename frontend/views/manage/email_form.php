<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TbEmail */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="panel-body">
    <div class="tb-email-update col-lg-12 col-sm-12">
        <div class="tb-email-form  ">
            <?= $form->field($model, 'email_from')->textInput(['maxlength' => 3000]) ?>
            <?= $form->field($model, 'email_to')->textInput(['maxlength' => 3000])->textInput(['data-role'=>'tagsinput','size'=>'100em']) ?>
            <?= $form->field($model, 'email_subject')->textInput(['maxlength' => 10000]) ?>

            <?= $form->field($model, 'email_message')->textarea(['rows' => 6])->hint("You can insert {first_name}, {last_name}, {email}, {referrer}, {code}, {phone}, {state}, {city}, {zip} into the email for everyone in database.") ?>
        </div>
    </div>
</div>


    <div class="panel-footer" style="text-align: right;padding-right: 30px;">
        <?= Html::submitButton($model->isNewRecord ? 'Send' : 'Resend', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>