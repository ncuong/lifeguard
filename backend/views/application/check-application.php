<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */

$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['application/application-of-room', 'id' => Yii::$app->user->id]];
$this->params['breadcrumbs'][] = $model->reasonApplication->name;
?>
<div class="application-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        //'action' => ['application/checked-application','id'=>$model->id],
    ]); ?>

    <div class="panel panel-default">
        <div class="panel-heading">Leave Application</div>
        <div class="panel-body">
            <?= $form->errorSummary($model); ?>
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'user.full_name',
                    [
                        'attribute'=>'reasonApplication.name',
                        'label'=>'Reason'
                    ],
                    'from_date:date',
                    'to_date:date',
                    'from_hour',
                    'to_hour',
                    'hours_off',
                    'content:html',
                    'date_create',
                ],
            ]) ?>

            <?php
            if (Yii::$app->user->can("manager") || Yii::$app->user->can('admin')) {

                echo $form->field($model, 'manager_ok')->radioList(array(1 => 'Accept ', 0 => ' Refuse'), [
                    'item' => function ($index, $label, $name, $checked, $value) {
                            //$disabled = true; // replace with whatever check you use for each item
                            //$checked = false;
                            //if($value == 0){
                            //    $checked = true;
                            //}
                            return Html::radio($name, $checked, [
                                'value' => $value,
                                'label' => Html::encode($label),
                                //   'checked' => $checked,
                            ]);
                        },
                ]);

            }

            if ((Yii::$app->user->can("hrm") && $model->reasonApplication->type_id == -11) || Yii::$app->user->can('admin')) {

                echo $form->field($model, 'hrm_ok')->radioList(array(1 => 'Accept ', 0 => ' Refuse'), [
                    'item' => function ($index, $label, $name, $checked, $value) {
                            //$disabled = true; // replace with whatever check you use for each item
                            //$checked = false;
                            //if($value == 0){
                            //    $checked = true;
                            //}
                            return Html::radio($name, $checked, [
                                'value' => $value,
                                'label' => Html::encode($label),
                                //   'checked' => $checked,
                            ]);
                        },
                ]);
            }

            ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
