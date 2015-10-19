<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TbEmail */

$this->title = 'Create Tb Email';
$this->params['breadcrumbs'][] = ['label' => 'Tb Emails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-email-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
