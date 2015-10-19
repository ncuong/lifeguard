<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\UserInfo;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\UserDate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-date-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
        echo $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(UserInfo::find()->all(),'user_id','full_name'),array('prompt' => '--Select a employee--'));
    ?>

    <?= $form->field($model, 'year')->dropDownList(array_combine(range(date('Y'),date('Y') + 10),range(date('Y'),date('Y') + 10))) ?>

    <?= $form->field($model, 'entitlement')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
