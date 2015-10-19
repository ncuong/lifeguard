<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Application */

$this->title = Yii::$app->params['typeApplication'][$model->type];
//$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
    <div class="panel-heading">Personal Information</div>
    <div class="panel-body">
        <div class="application-create">

            <h1><?= Html::encode($this->title) ?></h1>

            <?= $this->render('_form', [
                'model' => $model,
                'notify' => $notify,
                'type_notify' => $type_notify,
                'reason'=>$reason
            ]) ?>

        </div>
    </div>
</div>
