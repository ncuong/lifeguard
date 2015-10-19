<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = 'Update User: ' . ' ' . $model->first_name;
?>
<div class="panel-default panel">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>




    <?= $this->render('user_form', [
        'model' => $model,
    ]) ?>


</div>