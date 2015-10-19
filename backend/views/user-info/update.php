<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserInfo */

$this->title = 'Update User Info: ' . ' ' . $model->full_name;
if (!Yii::$app->user->can('hrm')) {
    $this->params['breadcrumbs'][] = 'Update';
} else {
    $this->params['breadcrumbs'][] = ['label' => 'List of staff', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'id' => $model->user_id]];
    $this->params['breadcrumbs'][] = 'Update';
}

?>

<div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">
        <div class="user-info-update">

            <h1><?= Html::encode($this->title) ?></h1>

            <?=
            $this->render('_form', [
                'model' => $model,
                'modelSignUp' => $modelSignUp,
            ]) ?>

        </div>
    </div>
</div>