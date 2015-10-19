<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TbEmail */

$this->title = 'Send Email';
$this->params['breadcrumbs'][] = ['label' => 'Tb Emails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row panel panel-default ">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>

        <?= $this->render('email_form', [
            'model' => $model,
        ]) ?>


</div>