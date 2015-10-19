<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\UserInfo;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of staff';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">
        <p>
            <?php
            if(Yii::$app->user->can('hrm'))
                echo Html::a('Create staff', ['create'], ['class' => 'btn btn-success'])
            ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'first_name',
                    'format'=>'raw',
                    'value'=>function($model){
                            return Html::a($model->first_name,['userdate/index'], [
                                'title' => Yii::t('yii', 'Close'),
                                'onclick'=>"
                                getListDateOff(".$model->user_id.");
                                return false;",
                            ]);
                        }
                ],
//                'last_name',
                'full_name',
                'phone',
                'email:email',
                'position',
                [
                    'attribute' => 'userinfo.full_name',
                    'label' => 'Manager',
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'buttons'=>[
                        'delete' => function ($url, $model) {
                                if(!Yii::$app->user->can('hrm'))
                                    return '<span class="glyphicon glyphicon-trash"></span>';
                                else
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => Yii::t('yii', 'Create'),
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this application "'.$model->full_name.'"?',
                                            'method' => 'post',
                                        ],
                                    ]);

                            },
                    ]

                ],
            ],
        ]); ?>

    </div>
</div>
<?php
Modal::begin([
    'id'=>'modal-dates',
    'size'=>'modal-lg',

]);

echo '<div id="content-dates"></div>';

Modal::end();
?>
<script type="application/javascript">
    function getListDateOff(idOfStaff){
        var request = $.ajax({
            url: "<?php echo \yii\helpers\Url::to(['user-date/list-date-off']) ?>",
            type: "POST",
            data: { idOfStaff : idOfStaff },
            dataType: "html"
        });

        request.done(function( msg ) {
            $( "#content-dates" ).html( msg );
            $('#modal-dates').modal('toggle');
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }
</script>
