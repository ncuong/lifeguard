<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserDateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Dates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-date-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Date', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'year',
            'entitlement',
            'balance',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
