<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\UserInfo */

$this->title = $model->first_name;


?>

<?php
if (Yii::$app->user->can('staff')) {
    $this->params['breadcrumbs'][] = $this->title;
    echo '<h1>Personal Information:' . Html::encode($this->title) . '</h1>';
    echo '<p>';
    echo Html::a('Update', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']);
    echo '</p>';
} else {
    $this->params['breadcrumbs'][] = ['label' => 'List of Staff', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    echo '<h1>Information staff:' . Html::encode($this->title) . '</h1>';
    echo '<p>';
    echo Html::a('Update', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']);
    echo Html::a('Delete', ['delete', 'id' => $model->user_id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]);
    echo '</p>';
}
?>
<div class="panel panel-default">
    <div class="panel-heading">View: <?= Html::encode($this->title) ?></div>
    <div class="panel-body">
        <div class="user-info-view">


            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'user_id',
                    'first_name',
                    'last_name',
                    'full_name',
                    'phone',
                    'email:email',
                    'position',
                    'manager',
                ],
            ]) ?>

        </div>
    </div>
</div>