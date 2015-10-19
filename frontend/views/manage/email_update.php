<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TbEmail */

$this->title = 'Update Email: ' . ' ' . $model->email_subject;
?>
<div class="row panel-default panel">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>

        <?=
        $this->render('email_form', [
            'model' => $model,
        ]) ?>



</div>
