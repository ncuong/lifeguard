<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Application */

$this->title = Yii::$app->params['typeApplication'][$model->type];
//$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?=$this->title?></div>
    <div class="panel-body">
        <div class="application-create">
            <?= $this->render('_form', [
                'model' => $model,
                'reason'=>$reason
            ]) ?>
        </div>
    </div>
</div>
