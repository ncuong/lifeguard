<?php
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
//    'layout'=>"{summary}\n{items}",
    'layout'=>"{items}",
    'options'=>['class'=>'gridview-newclass'],
    'tableOptions'=>['style'=>'width:auto;','id'=>'tb-referrer',"class"=>"table table-striped table-bordered"],
//    'headerRowOptions'=>['alala'=>'jajaj'],
//    'sorter'=>["aaa"=>"aaa"],
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'contentOptions' =>['width'=>50]
        ],
        ['class' => 'yii\grid\CheckboxColumn'],
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
            'attribute'=>'code',
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
        [
            'attribute' => 'graduate_high_school',
            'label' => 'Graduate',
            'value' => 'graduate_high_school',
            'contentOptions'=>array('class'=>'col-graduate'),
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
            'contentOptions'=>array('class'=>'col-created'),

        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}{delete}',
            'contentOptions'=>array('width'=>'100','class'=>'btn-action'),
            'header' => Html::dropDownList('pageSize',Yii::$app->request->get('per-page'), array(20 => 20,30=>30, 50 => 50, 70=>70, 100 => 100), array(
                    'class' => "form-control page-size",'style'=>'width:70px; padding:0px;')),
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

<div class="row panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Lifeguard</div>

    <div class="col-lg-12 ">
        <div style="margin: 10px 0px;">
            <h2 style="font-size: 20px; font-weight: bold;">Invite Your Friends to Lifeguard: </h2>
            <?php
            $url = \yii\helpers\Url::to(["site/register","referrer_code"=>$user->code],true);
            ?>
            <div class="invite"><?php echo $url; ?></div>
        </div>

        <div class="option-show-column">
            <?php echo $grid->renderSummary(); ?>

            <a style="display: block;text-align: right" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Option show/hide columns
            </a>
            <div class="collapse" id="collapseExample">
                <div class="well row">
                    <?php echo Html::checkbox("col-name",true);?><span>Name</span>
                    <?php echo Html::checkbox("col-code",true);?><span>Code</span>
                    <?php echo Html::checkbox("col-referrer",true);?><span>Referrer</span>
                    <?php echo Html::checkbox("col-mobile",true);?><span>Mobile</span>
                    <?php echo Html::checkbox("col-state",true);?><span>State</span>
                    <?php echo Html::checkbox("col-zip",true);?><span>Zip</span>
                    <?php echo Html::checkbox("col-city",true);?><span>City</span>
                    <?php echo Html::checkbox("col-email",true);?><span>Email</span>
                    <?php echo Html::checkbox("col-graduate",true);?><span>Graduate</span>
                    <?php echo Html::checkbox("col-sex",true);?><span>Sex</span>
                    <?php echo Html::checkbox("col-status",true);?><span>Status</span>
                    <?php echo Html::checkbox("col-created",true);?><span>Created</span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="outer">
            <div class="inner">
                <?php $grid->end(); ?>
            </div>
            <div class="fix-box"></div>
        </div>

        <div class="row">

            <div class=" col-lg-6" style="padding: 5px 0px 20px 30px;" id="group-action">
                <?php echo Html::img('@web/img/arrow_ltr.png', ['style' => 'padding-left:22px;']) ?>
                <?php echo Html::a("Delete", ['manage/delete-users']) ?>/
                <?php echo Html::a("Active", ['manage/active-users']) ?>/
                <?php //echo Html::a("Inactive", ['manage/inactive-users']) ?>
                <?php echo Html::a("Lock", ['manage/lock-users']) ?>/
                <?php echo Html::a("Send mail",['manage/create-email'])?>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12 panel-footer" style="text-align: right">
                <?php echo $grid->renderPager(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){


        function updateUrl(param,value){
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
            queryParameters[param] = value;

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
        }

        $(".page-size").change(function(){
            updateUrl('per-page',$(this).val());
//            queryParameters['per-page'] = $(this).val();

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
                alert("Please make the choice record(s)!");
                return false;
            }

            strId = GetStringId();
            strId = strId.substring(0,strId.length - 1);
            var url = $(this).attr('href');
            $(this).attr('href',url+"?ids="+strId);
        })

        //Doan script tao scroll theo chieu cao cua div
//        $(function() {
//            var window_height = $(window).height(),
//            content_height = window_height - 200;
//
//            $('.grid-view').height(content_height);
//        });
//
//        $( window ).resize(function() {
//            var window_height = $(window).height(),
//                content_height = window_height - 200;
//            $('.grid-view').height(content_height);
//        });

        $(".option-show-column input").click(function(){
            col = $(this).attr("name");
            var index = $("tbody tr td").index($("."+col));
            if($(this).is(":checked")){
                $("thead tr").children().eq(index).show();
                $("tr.filters").children().eq(index).show();
                $("."+col).show();
            }else{
                $("thead tr").children().eq(index).hide();
                $("tr.filters").children().eq(index).hide();
                $("."+col).hide();
            }
        })

    })
</script>