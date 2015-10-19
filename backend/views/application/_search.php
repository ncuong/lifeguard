<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ApplicationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'from_date') ?>

    <?= $form->field($model, 'to_date') ?>

    <?= $form->field($model, 'from_hour') ?>

    <?php // echo $form->field($model, 'to_hour') ?>

    <?php // echo $form->field($model, 'hours_off') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'deleted')->checkbox() ?>

    <?php // echo $form->field($model, 'date_create') ?>

    <?php // echo $form->field($model, 'date_update') ?>

    <?php // echo $form->field($model, 'manager_ok')->checkbox() ?>

    <?php // echo $form->field($model, 'hrm_ok')->checkbox() ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'reason') ?>

    <?php // echo $form->field($model, 'manager_id_ok') ?>

    <?php // echo $form->field($model, 'hrm_id_ok') ?>

    <?php // echo $form->field($model, 'calculate_date_off')->checkbox() ?>

    <?php // echo $form->field($model, 'manager_readed')->checkbox() ?>

    <?php // echo $form->field($model, 'hrm_readed')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>