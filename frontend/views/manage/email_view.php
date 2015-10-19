<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TbEmail */

$this->title = "Detail Email";
?>
<div class="row panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="col-lg-12 col-sm-12 tb-email-index">



    <p style="padding: 10px 0px 0px; text-align: right">
        <?= Html::a('Update', ['manage/update-email', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['manage/delete-email', 'id' => $model->id], [
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
            'id',
            [
                'attribute'=>'email_to',
                'value'=>str_replace(",",", ",$model->email_to)
            ],
            'email_from',
            'email_subject',
            'email_message:ntext',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    </div>
</div>
