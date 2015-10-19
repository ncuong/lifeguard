<?php
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: VIETBINH
 * Date: 9/26/15
 * Time: 8:12 AM
 */

?>

<?php
static $status = array();
$status[\common\models\User::STATUS_ACTIVE] = "Active";
$status[\common\models\User::STATUS_WAITING] = "Inactive";
$status[\common\models\User::STATUS_LOCK] = "Lock";
?>

<?php
$grid = GridView::begin([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'pager' => ['options' => ['class' => 'pagination','style'=>'margin:0px;']],
    'layout'=>"{summary}\n{items}",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => '<span style="padding: 0 70px;">Name</span>',
            'encodeLabel'=>false,
            'attribute' => 'first_name',
            'value' => function ($model) {
                    return $model->first_name . " " . $model->last_name;
                }
        ],
        [
            'attribute'=>'code',
            'label'=>'<span style="padding: 0px 30px;">Code</span>',
            'encodeLabel'=>false
        ],
        [
            'attribute'=>'referrer',
            'label'=>'<span style="padding: 0px 30px;">Referrer</span>',
            'encodeLabel'=>false
        ],
        [
            'attribute'=>'mobile',
            'label'=>'<span style="padding:0px 50px;">mobile</span>',
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
                }
        ],
        [
            'attribute'=>'zip',
            'label'=>'<span style="padding: 0px 40px;">Zip</span>',
            'encodeLabel'=>false
        ],
        [
            'attribute'=>'city',
            'label'=>'<span style="padding:0px 50px;">City</span>',
            'encodeLabel'=>false,
            'contentOptions'=>array('class'=>'col-city'),
        ],
        'email',
        [
            'attribute' => 'graduate_high_school',
            'label' => 'Graduate',
            'value' => 'graduate_high_school',
        ],
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
                'style' => 'text-align:center'
            ],
            'value' => function ($model) {
                    return $model->sex == 1 ? '<i class="fa fa-male fa-2x"></i>' : '<i class="fa fa-female fa-2x"></i>';
                }
        ],
        [
            'attribute' => 'status',
            'label'=>'<span style="padding: 0px 30px;">Status</span>',
            'encodeLabel'=>false,
            'filter' => $status,
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
            'attribute'=>'created_at',
            'format'=>'date',
            'label'=>'Created'

        ],
//        [
//            'class' => 'yii\grid\ActionColumn',
//            'template' => '',
//            'header' =>
//        ],
    ],
]);



//echo $grid->renderItems();

?>

<div class="row panel panel-default" >
    <!-- Default panel contents -->
    <div class="panel-heading">Report</div>

    <div class="col-lg-12 ">
        <?php $form = ActiveForm::begin(['method'=>'get']); ?>
        <div class="row">
            <div class="report-one-form form-inline col-lg-8">

                <?php
                echo $form->field($searchModel, 'from_date')->widget(\dosamigos\datepicker\DateRangePicker::className(), [
                    'attributeTo' => 'to_date',
                    'form' => $form, // best for correct client validation
                    'language' => 'en',
                    'size' => 'ms',
                    'clientOptions' => [
                        'minView' => 0,
                        'autoclose' => true,
                        //'daysOfWeekDisabled'=>'0,6',
                        'format' => 'dd/mm/yyyy'
                    ]
                ])->label('Date');
                echo Html::submitButton('Find', ['class' =>'btn btn-primary btn-find','style'=>'margin-bottom:10px;']);
                ?>
                <a id="export-excel" href="#"><span style="font-size:35px;vertical-align: top;margin: 2px 0px 0px 30px;" class="fa fa-file-excel-o"></span></a>
            </div>

            <div class="col-lg-4 " style="margin-top: 10px;">
                <div class="row">
                    <div class="col-sm-8" style="text-align: right">

                    </div>
                    <div class="col-sm-4">
                        <?php echo Html::dropDownList('pageSize',Yii::$app->request->get('per-page'), array(20 => 20,30=>30, 50 => 50, 70=>70, 100 => 100), array(
                            'class' => "form-control page-size",'style'=>'')) ?>
                    </div>

                </div>


            </div>


        </div>
        <?php ActiveForm::end(); ?>
        <!-- Table -->
        <?php $grid->end(); ?>
        <div class="row panel-footer" style="margin-top: 20px;">

            <div class="col-lg-12" style="text-align: right">
                <?php echo $grid->renderPager(); ?>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $(".page-size").change(function(){

            /*
             * queryParameters -> handles the query string parameters
             * queryString -> the query string without the fist '?' character
             * re -> the regular expression
             * m -> holds the string matching the regular expression
             */
            var queryParameters = {}, queryString = location.search.substring(1),
                re = /([^&=]+)=([^&]*)/g, m;

            // Creates a map with the query string parameters
            while (m = re.exec(queryString)) {
                queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
            }

            // Add new parameters or update existing ones
            //queryParameters['per'] = 'new parameter';
            queryParameters['per-page'] = $(this).val();

            /*
             * Replace the query portion of the URL.
             * jQuery.param() -> create a serialized representation of an array or
             *     object, suitable for use in a URL query string or Ajax request.
             */
            location.search = $.param(queryParameters); // Causes page to reload


            //  _url = $(location).attr('href');

            // similar behavior as an HTTP redirect
            // window.location.replace("http://stackoverflow.com");

            // similar behavior as clicking on a link
            //window.location.href = "http://stackoverflow.com";
            //alert();
        })

        function GetStringId()
        {
            strId = "";
            $("table>tbody input[type='checkbox']:checked").each(function(){
                strId += $(this).val()+","
            });

            return strId;
        }

        $("#group-action a").click(function(){

            var i = $("table>tbody input[type='checkbox']:checked").length;
            if(i == 0){
                alert("Chưa có dòng nào được chọn!");
                return false;
            }

            strId = GetStringId();
            strId = strId.substring(0,strId.length - 1);
            var url = $(this).attr('href');
            $(this).attr('href',url+"?ids="+strId);
        })

        $("#export-excel").click(function(){
            _url = $(location).attr('href').toString();
            str = _url.replace("report-one","report-to-excel");
            $(this).attr('href',str);
        })

    })
</script>