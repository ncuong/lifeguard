<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TbEmail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tb-email-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email_to')->textInput(['maxlength' => 3000]) ?>

    <?= $form->field($model, 'email_from')->textInput(['maxlength' => 3000]) ?>

    <?= $form->field($model, 'email_subject')->textInput(['maxlength' => 10000]) ?>

    <?= $form->field($model, 'email_message')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
