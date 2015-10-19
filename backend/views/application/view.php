<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">View Application</div>
    <div class="panel-body">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if($model->manager_readed != 1 || $model->hrm_readed != 1)
            echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'user_id',
            'from_date:date',
            'to_date:date',
            'from_hour',
            'to_hour',
            'hours_off',
            //'title',
            'content:html',
            'date_create',
            //'date_update',
            //'manager_ok:boolean',
            //'hrm_ok:boolean',
            //'type',
        ],
    ]) ?>

    </div>
</div>
