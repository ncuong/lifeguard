<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use frontend\widgets\MaskedInput;

/**
 * Created by PhpStorm.
 * User: VIETBINH
 * Date: 9/26/15
 * Time: 8:13 AM
 */
?>

<?php $form = ActiveForm::begin(); ?>

    <div class="container">
        <div class="row">

            <div
                class="col-xs-12 col-sm-12 col-md-6 col-lg-8 col-lg-offset-2 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo $model->first_name; ?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 " align="center">
                                <!--                            <img alt="User Pic"-->
                                <!--                                 src="http://babyinfoforyou.com/wp-content/uploads/2014/10/avatar-300x300.png"-->
                                <!--                                 class="img-circle img-responsive">-->
                            </div>

                            <div class=" col-md-12 col-lg-12 ">
                                <table class="table table-user-information">
                                    <tbody>
                                    <tr>
                                        <td>Code:</td>
                                        <td><?php echo $form->field($model, "code")->textInput(['readonly' => true])->label(false); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Referrer Code:</td>
                                        <td><?php echo $form->field($model, "referrer")->label(false); ?></td>
                                    </tr>
                                    <tr>
                                        <td>First Name:</td>
                                        <td><?php echo $form->field($model, "first_name")->label(false); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Last Name:</td>
                                        <td><?php echo $form->field($model, "last_name")->label(false); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td><?php echo $form->field($model, "email")->textInput(['readonly' => true])->label(false); ?></td>
                                    </tr>

                                    <tr>
                                        <td>Sex:</td>
                                        <td><?=$form->field($model, 'sex')->inline()->radioList(array(1=>'Male ',0=>' Female'))->label(false);?></td>
                                    </tr>
                                    <tr>
                                        <td>Graduated From <br> High School</td>
                                        <td>
                                            <?php
                                            $years = array();
                                            for($i = 1940; $i<= 2000; $i++)
                                                $years[$i] = $i;

                                            echo $form->field($model, 'graduate_high_school')->dropDownList($years)->label(false);


                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Phone</td>
                                        <td><?php
                                            echo $form->field($model, 'mobile')->widget(MaskedInput::className(), ['mask' => '(999) 999-9999'])->label(false);
                                            ?></td>

                                    </tr>


                                    <tr>
                                        <td>City</td>
                                        <td><?php echo $form->field($model, "city")->label(false); ?></td>
                                    </tr>
                                    <tr>
                                        <td>State:</td>
                                        <td><?php echo $form->field($model, "state")->dropDownList(\frontend\controllers\Common::$states)->label(false); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Zip:</td>
                                        <td><?php echo $form->field($model, "zip")->widget(MaskedInput::className(),['mask'=>'9','clientOptions' => ['repeat' => 5, 'greedy' => false]])->label(false); ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer" style="text-align: right">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>