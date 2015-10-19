<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ReasonApplication */

$this->title = 'Create Reason Application';
$this->params['breadcrumbs'][] = ['label' => 'Reason Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reason-application-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
