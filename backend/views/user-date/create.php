<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UserDate */

$this->title = 'Create User Date';
$this->params['breadcrumbs'][] = ['label' => 'User Dates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    </div>
</div>
