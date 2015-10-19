<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\UserInfo;
use frontend\models\SignupForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'user_id')->label(false)->hiddenInput() ?>
    <?php if(Yii::$app->controller->action->id == "create"){ ?>
    <div class="panel panel-default">
        <div class="panel-heading">Login Information</div>
        <div class="panel-body">
            <?= $form->field($modelSignUp, 'username') ?>
            <?= $form->field($modelSignUp, 'password')->passwordInput() ?>
        </div>
    </div>
    <?php }?>


    <div class="panel panel-default">
        <div class="panel-heading">Personal Information</div>
        <div class="panel-body">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => 1000]) ?>

            <?= $form->field($model, 'last_name')->textInput(['maxlength' => 1000]) ?>

            <?= $form->field($model, 'full_name')->textInput(['maxlength' => 1000]) ?>

            <?= $form->field($model, 'phone')->textInput(['maxlength' => 100]) ?>

            <?= $form->field($modelSignUp, 'email')->textInput(['maxlength' => 500]) ?>

            <?php
            if(Yii::$app->user->can("admin") || Yii::$app->user->can("hrm")){
                echo $form->field($model, 'position')->textInput(['maxlength' => 2000]);
                if($model->isNewRecord){
                    echo $form->field($model, 'manager')->dropDownList(ArrayHelper::map($model->find()->rightJoin('auth_assignment','user_info.user_id = auth_assignment.user_id')->where(array('item_name'=>'director'))->orWhere(array('item_name'=>'manager'))->all(),'user_id','full_name'),array('prompt' => '--Select a manager--'))->label('Manager');
                }else{
                    $position = \common\models\AuthAssignment::find()->where(['user_id'=>$model->user_id])->one();
                    //Neu la staff thi hien thi list manager.
                    if($position !== null && $position->item_name === "staff")
                        echo $form->field($model, 'manager')->dropDownList(ArrayHelper::map($model->find()->rightJoin('auth_assignment','user_info.user_id = auth_assignment.user_id')->where(array('item_name'=>'manager'))->all(),'user_id','full_name'),array('prompt' => '--Select a manager--'))->label('Manager');
                    if($position !== null && $position->item_name === "manager" || $position->item_name === "hrm")
                        echo $form->field($model, 'manager')->dropDownList(ArrayHelper::map($model->find()->rightJoin('auth_assignment','user_info.user_id = auth_assignment.user_id')->where(array('item_name'=>'director'))->all(),'user_id','full_name'),array('prompt' => '--Select a director--'))->label('Director');
                    //Neu la manager thi hien thi director.
                }
            }
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
