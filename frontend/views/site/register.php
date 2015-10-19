<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Registration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" >
    <div id="form-registration" class=" col-lg-offset-3 col-sm-offset-2 col-lg-6 col-sm-7" style="border: 1px solid #ccc; border-radius: 5px; padding: 10px">

        <div class="row" style="text-align: center; margin-bottom: 10px">

            <h1 class="registration"><?= Html::encode($this->title) ?></h1>

<!--            <p>Please fill out the following fields to register: (* = required field)</p>-->
        </div>

        <?php $form = ActiveForm::begin(['id' => 'form-signup', 'layout' => 'horizontal', 'requiredCssClass' => 'required']); ?>

        <?php //= $form->field($model, 'referrer', ['template' => '{label}<div class="col-lg-2">{input}{error}</div>{hint}'])->hint("Ma code gioi thieu",['class'=>'col-lg-5 help-block']) ?>
        <?php //= $form->field($model, 'username', ['template' => '{label}<div class="col-lg-4">{input}{error}</div>{hint}'])->hint("Chao ca nha",['class'=>'col-lg-5 help-block']) ?>
        <?php //= $form->field($model, 'password',['template' => '{label}<div class="col-lg-4">{input}{error}</div>{hint}'])->passwordInput()->hint("Mat khau ne",['class'=>'col-lg-5 help-block']) ?>
        <?php //= $form->field($model, 'email',['template' => '{label}<div class="col-sm-4">{input}{error}</div>{hint}'])->hint("Your email",['class'=>'col-lg-5 help-block']) ?>
        <!---->
        <?php //= $form->field($model, 'full_name', ['template' => '{label}<div class="col-lg-4">{input}{error}</div>{hint}'])->hint("Ma code gioi thieu",['class'=>'col-lg-5 help-block']) ?>
        <?php //= $form->field($model, 'address', ['template' => '{label}<div class="col-lg-4">{input}{error}</div>{hint}'])->textarea(['rows' => 3, 'style' => 'width:100%;'])->hint("Ma code gioi thieu",['class'=>'col-lg-5 help-block']) ?>
        <?php //= $form->field($model, 'city', ['template' => '{label}<div class="col-lg-4">{input}{error}</div>{hint}'])->hint("Ma code gioi thieu",['class'=>'col-lg-5 help-block']) ?>
        <?php //= $form->field($model, 'state', ['template' => '{label}<div class="col-lg-4">{input}{error}</div>{hint}'])->hint("Ma code gioi thieu",['class'=>'col-lg-5 help-block']) ?>
        <?php //= $form->field($model, 'zip', ['template' => '{label}<div class="col-lg-4">{input}{error}</div>{hint}'])->hint("Ma code gioi thieu",['class'=>'col-lg-5 help-block']) ?>

            <?= $form->field($model, 'referrer', ['template' => '{hint}<div class="col-sm-5 referrer-input">{input}{error}</div>'])->textInput(['placeholder'=>'Referrer Code','disabled'=>$isDisableReferrer])->label(false)->hint("Please enter the Referrer Code if you were given one",['class'=>'referrer-hint']); ?>

        <div class="row">
        <?= $form->field($model, 'first_name', ['template' => '{label}<div>{input}{error}</div>{hint}','options'=>['class'=>'col-sm-6']])->textInput(['placeholder'=>'First name*'])->label(false); ?>
        <?= $form->field($model, 'last_name', ['template' => '{label}<div>{input}{error}</div>{hint}','options'=>['class'=>'col-sm-6']])->textInput(['placeholder'=>'Last name*'])->label(false);?>
        </div>

        <div class="row">
        <?= $form->field($model, 'email', ['template' => '{label}<div>{input}{error}</div>{hint}','options'=>['class'=>'col-sm-12']])->textInput(['placeholder'=>'Email*'])->label(false) ?>
        </div>

        <?= $form->field($model, 'password', ['template' => '{label}<div class="col-sm-12">{input}{error}</div>{hint}'])->passwordInput(['placeholder'=>'Password*'])->label(false); ?>

        <div class="row">
            <?php echo $form->field($model, 'mobile', ['horizontalCssClasses'=>['wrapper' => 'col-sm-12','offset'=>null],'options'=>['class'=>'col-sm-6']])->widget(MaskedInput::className(), ['mask' => '(999) 999-9999','options'=>['class'=>'form-control','placeholder'=>"Mobile"]])->label(false); ?>
            <?= $form->field($model, 'sex',['options'=>['class'=>'col-sm-6'], 'horizontalCssClasses'=>['wrapper' => 'col-sm-12','offset'=>null]])->inline()->radioList(array(1=>'Male ',0=>' Female'),['class'=>'col-sm-12'])->label(false);?>
        </div>

        <?= $form->field($model, 'city', ['template' => '{label}<div class="col-sm-12">{input}{error}</div>{hint}'])->textInput(['placeholder'=>'City'])->label(false) ?>

        <div class="row">
        <?= $form->field($model, 'state', ['template' => '{label}<div class="state-input">{input}{error}</div>{hint}','options'=>['class'=>'col-sm-6']])->dropDownList($states)->label(false) ?>
        <?= $form->field($model, 'zip', ['template' => '{label}<div class="col-sm-12">{input}{error}</div>{hint}','options'=>['class'=>'col-sm-6']])->widget(MaskedInput::className(), ['mask' => '9', 'clientOptions' => ['repeat' => 5, 'greedy' => false],'options'=>['class'=>'form-control','placeholder'=>"Zip"]])->label(false) ?>
        </div>

        <div> What year did you graduate High School?</div>
        <?php

        echo $form->field($model, 'graduate_high_school',['template' => '{label}<div class="col-sm-6">{input}{error}</div>{hint}','options'=>['class'=>'form-group']])->dropDownList(\frontend\controllers\Common::graduate_years())->label(false);


        ?>

        <div style="text-align: center">
            <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#signupform-state").change(function () {
            if($(this).val() == "0") $(this).addClass("empty");
            else $(this).removeClass("empty")
        });
        $("#signupform-state").change();
    })
</script>