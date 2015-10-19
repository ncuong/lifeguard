<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UserInfo */

$this->title = 'Create Staff';
$this->params['breadcrumbs'][] = ['label' => 'List of Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">
        <div class="user-info-create">

            <h1><?= Html::encode($this->title) ?></h1>

            <?=
            $this->render('_form', [
                'model' => $model,
                'modelSignUp' => $modelSignUp,
            ]) ?>

        </div>
    </div>
</div>