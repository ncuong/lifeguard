<?php
use yii\grid\GridView;
use yii\helpers\Html;
?>

<?php
static $status = array();

$status[\common\models\User::STATUS_ACTIVE] = "Active";
$status[\common\models\User::STATUS_WAITING] = "Inactive";
$status[\common\models\User::STATUS_LOCK] = "Lock";
?>
<tr class="<?=$code?>">
    <td colspan="16" style="border: 0;border-width: 0;padding-right: 0px;">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,

            'pager' => ['options' => ['class' => 'pagination','style'=>'margin:0px;']],
//    'layout'=>"{summary}\n{items}",
            'layout'=>"{items}",
            'options'=>['class'=>'gridview-newclass'],
            'tableOptions'=>['width'=>'auto',"class"=>"table table-striped table-bordered","style"=>"border-right:0px;"],
//    'headerRowOptions'=>['alala'=>'jajaj'],
//    'sorter'=>["aaa"=>"aaa"],
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'contentOptions' =>['width'=>50]
                ],
                [
                    'format'=>'raw',
                    'value'=>function($model){return '<i id="'.$model->code.'" class="glyphicon glyphicon-plus"></i>';}
                ],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'header'=>'',
                    'checkboxOptions'=>function($model){return ['class'=>$model->code,'value'=>$model->id];}
                ],
//                [
//                    'format'=>'raw',
//                    'value'=>function($model){return Html::input('checkbox');}
//                ],
                [
                    'label' => '<span style="padding: 0 70px;">Name</span>',
                    'encodeLabel'=>false,
                    'attribute' => 'first_name',
                    'value' => function ($model) {
                            return $model->first_name . " " . $model->last_name;
                        },
                    'contentOptions'=>array('class'=>'col-name'),
//            'headerOptions'=>array()
                ],
                [
                    'attribute'=>'id',
                    'label'=>'<span style="padding: 0px 30px;">Code</span>',
                    'encodeLabel'=>false,
                    'contentOptions'=>array('class'=>'col-code'),
                ],
                [
                    'attribute'=>'referrer',
                    'label'=>'<span style="padding: 0px 30px;">Referrer</span>',
                    'encodeLabel'=>false,
                    'contentOptions'=>array('class'=>'col-referrer'),
                ],
                [
                    'attribute'=>'mobile',
                    'label'=>'<span style="padding:0px 40px;">mobile</span>',
                    'encodeLabel'=>false,
                    'contentOptions'=>array('class'=>'col-mobile'),
                ],
                [
                    'attribute' => 'state',
                    'label'=>'<span style="padding:0 80px;">State</span>',
                    'encodeLabel'=>false,
                    'filter' => \frontend\controllers\Common::$states,
                    'value' => function ($model) {
                            if (array_key_exists($model->state, \frontend\controllers\Common::$states))
                                return \frontend\controllers\Common::$states[$model->state];
                            else
                                return $model->state;
                        },
                    'contentOptions'=>array('class'=>'col-state'),
                ],
                [
                    'attribute'=>'zip',
                    'label'=>'<span style="padding: 0px 40px;">Zip</span>',
                    'encodeLabel'=>false,
                    'contentOptions'=>array('class'=>'col-zip'),
                ],
                [
                    'attribute'=>'city',
                    'label'=>'<span style="padding:0px 50px;">City</span>',
                    'encodeLabel'=>false,
                    'contentOptions'=>array('class'=>'col-city'),
                ],
                [
                    'attribute'=>'email',
                    'contentOptions'=>array('class'=>'col-email'),
                ],
//                [
//                    'attribute' => 'graduate_high_school',
//                    'label' => 'Graduate',
//                    'value' => 'graduate_high_school',
//                    'contentOptions'=>array('class'=>'col-graduate'),
//                ],
                [
                    'attribute' => 'sex',
                    'label'=>'<span style="padding: 40px;">Sex</span>',
                    'encodeLabel'=>false,
                    'format' => 'raw',
                    'filter' => array(
                        '1' => 'Male',
                        '0' => 'Female',
                    ),
                    'contentOptions' => [
                        'style' => 'text-align:center',
                        'class'=>'col-sex'
                    ],
                    'value' => function ($model) {
                            return $model->sex == 1 ? '<i class="fa fa-male fa-2x"></i>' : '<i class="fa fa-female fa-2x"></i>';
                        }
                ],
                [
                    'attribute' => 'status',
                    'filter' => $status,
                    'label'=>'<span style="padding: 0px 30px;">Status</span>',
                    'encodeLabel'=>false,
                    'value' => function ($model) {
                            $str = "";
                            switch ($model->status) {
                                case 0:
                                    $str = "Deleted";
                                    break;
                                case 5:
                                    $str = "Inactive";
                                    break;
                                case 10:
                                    $str = "Active";
                                    break;
                                case -10:
                                    $str = "Lock";
                                    break;
                            }
                            return $str;
                        },
                    'contentOptions'=>array('class'=>'col-status'),
                ],
                [
                    'attribute'=>'created_at',
                    'format'=>'date',
                    'label'=>'Created',
                    'contentOptions'=>array('class'=>'col-created',"style"=>"border-right:0;"),
                    'headerOptions'=>array('style'=>'border-right:0px;'),
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}{delete}',
                    'contentOptions'=>array('width'=>'100','class'=>'btn-action'),
                    'headerOptions'=>array('style'=>'margin-top:-10px;'),
                    'buttons'=>[
                        'delete' => function ($url, $model) {
                                $url = \yii\helpers\Url::to(['manage/delete-user','id'=>$model->id],true);
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this application "'.$model->first_name.'"?',
                                        'method' => 'post',
                                    ],
                                ]);

                            },
                        'update' => function ($url, $model) {
                                $url = \yii\helpers\Url::to(['manage/update-user','id'=>$model->id],true);
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('yii', 'Update'),
                                ]);

                            },
                    ]
                ],
            ],
        ]);
        ?>
    </td>
    <td style="width: 0;height: 0;border: 0;border-width: 0"></td>
</tr>