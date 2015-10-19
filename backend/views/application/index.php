<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use dosamigos\datetimepicker\DateTimePicker;
use dosamigos\datepicker\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DateRangePicker;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leave Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            [
//                'attribute' => 'user.full_name',
//                'value' => 'user.full_name'
//            ],
            array(
                'attribute'=>'from_date',
                'filter' => DatePicker::widget([
                        'model' => $dataProvider,
                        'name'=>'from_date',
                        'value' =>Yii::$app->request->get('from_date'),
                        'attribute' => 'from_date',
                        'size' => 'ms',
                        'template' => '{addon}{input}',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]),
                'value'=>function($model){
                        return Yii::$app->formatter->asDate($model->from_date);
                    },
                'contentOptions' => array('style' => 'width: 170px;'),
            ),
            array(
                'attribute'=>'to_date',
                'filter' => DatePicker::widget([
                        'model' => $dataProvider,
                        'name'=>'to_date',
                        'value' =>Yii::$app->request->get('to_date'),
                        'attribute' => 'to_date',
                        'size' => 'ms',
                        'template' => '{addon}{input}',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]),
                'value'=>function($model){
                        return Yii::$app->formatter->asDate($model->to_date);
                    },
                'contentOptions' => array('style' => 'width: 170px;'),
            ),
            array(
                'attribute'=>'from_hour',
                'contentOptions' => array('style' => 'width: 70px;')
            ),
            array(
                'attribute'=>'to_hour',
                'contentOptions' => array('style' => 'width: 70px;')
            ),
            array(
                'attribute'=>'hours_off',
                'filter'=>false
            ),
            //'title',
            // 'content:ntext',
            // 'deleted:boolean',
            // 'date_create',
            // 'date_update',
            [
                'attribute'=>'reason',
                'filter'=> ArrayHelper::map(\backend\models\ReasonApplication::find()->all(),'id','name'),
                'value'=>'reasonApplication.name'
            ],
            [
                'attribute'=>'manager_ok',
                'filter'=>array(
                    '1'=>'Accept',
                    '0'=>'Refuse',
                    '-1'=>'Waiting'
                ),
                'format' => 'raw',
                'value' => function ($model) {
                        if($model->manager_ok == 1)
                            $status = '<span style="color: #008000; font-size: 12px;"> Accept</span>';
                        else if($model->manager_ok == 0)
                            $status = '<span style="color: #008000; font-size: 12px;"> Refuse</span>';
                        else
                            $status = '<span style="color: #cccccc; font-size: 12px;"> Waiting</span>';
                        return $status;
                    },
            ],
            [
                'attribute'=>'hrm_ok',
                'filter'=>array(
                    '1'=>'Accept',
                    '0'=>'Refuse',
                    '-1'=>'Waiting'
                ),
                'format' => 'raw',
                'value' => function ($model) {
                    if($model->hrm_ok == 1)
                        $status = '<span style="color: #008000; font-size: 12px;"> Accept</span>';
                    else if($model->hrm_ok == 0)
                        $status = '<span style="color: #ff0000; font-size: 12px;"> Refuse</span>';
                    else
                        $status = '<span style="color: #cccccc; font-size: 12px;"> Waiting</span>';
                    return $status;
                },
            ],
            // 'type',
            [
                'class' => 'yii\grid\ActionColumn',
                //'template'=>'{view}{create}',
                'buttons'=>[
                    'view' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>' ,
                            $url,
                            [
                                'onclick'=>"
                                getApplication(".$model->id.");
                                return false;",
                            ]);
                    },
                    'delete' => function ($url, $model) {
                        if(($model->hrm_readed == 1 || $model->manager_readed == 1) && !Yii::$app->user->can('admin'))
                            return '<span class="glyphicon glyphicon-trash"></span>';
                        else
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('yii', 'Create'),
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this application "'.$model->title.'"?',
                                    'method' => 'post',
                                ],
                            ]);

                    },
                    'update' => function ($url, $model) {
                        if(($model->hrm_readed == 1 || $model->manager_readed == 1) && !Yii::$app->user->can('admin'))
                            return '<span class="glyphicon glyphicon-pencil"></span>';
                        else
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('yii', 'Update'),
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
    'header' => '<h2>Application</h2>',
    'id'=>'modal-application',
    'size'=>'modal-lg',

]);

echo '<div id="content-application"></div>';

Modal::end();
?>
<script type="application/javascript">
    function getApplication(id){
        $('#modal-application').modal('toggle');

        var request = $.ajax({
            url: "<?php echo \yii\helpers\Url::to(['application/view-ajax']) ?>",
            type: "POST",
            data: { id : id },
            dataType: "html"
        });

        request.done(function( msg ) {
            $( "#content-application" ).html( msg );
        });


        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }
</script>
