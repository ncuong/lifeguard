<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */

?>
<div class="application-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'from_date',
            'to_date',
            'hours_off',
            'title',
            'content:html',
            'date_create',
        ],
    ]) ?>

</div>
