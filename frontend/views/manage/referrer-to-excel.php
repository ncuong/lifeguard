<?php
$date = date('Y-m-d-H-i-s');
\yii\grid\ExcelGrid::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'extension' => 'xlsx',
    'filename' => 'report'.$date,
    'properties' =>[
        'creator'=>'viet-binh',
        'title' =>'title',
        'subject'=>'',
        'category'=>'',
        'keywords'=>'',
        'manager'=>''
    ],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'Name',
            'attribute' => 'first_name',
            'value' => function ($model) {
                    return $model->first_name . " " . $model->last_name;
                }
        ],
        'code',
        'referrer',
        'mobile',
        [
            'attribute' => 'state',
            'filter' => \frontend\controllers\Common::$states,
            'value' => function ($model) {
                    if (array_key_exists($model->state, \frontend\controllers\Common::$states))
                        return \frontend\controllers\Common::$states[$model->state];
                    else
                        return $model->state;
                }
        ],
        'zip',
        'city',
        'email',
        [
            'attribute' => 'graduate_high_school',
            'label' => 'Graduate',
            'value' => 'graduate_high_school',
        ],
        [
            'attribute' => 'sex',
            'contentOptions' => [
                'style' => 'text-align:center'
            ],
            'value' => function ($model) {
                    return $model->sex == 1 ? 'Male' : 'Female';
                }
        ],
        [
            'attribute' => 'status',
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
                }
        ],
        [
            'attribute' => 'graduate_high_school',
            'label' => 'Graduate',
            'value' => function($model){ return Yii::$app->formatter->asDate($model->created_at);},
        ],
    ]
]);














