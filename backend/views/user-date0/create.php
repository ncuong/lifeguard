<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UserDate */

$this->title = 'Create User Date';
$this->params['breadcrumbs'][] = ['label' => 'User Dates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-date-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
