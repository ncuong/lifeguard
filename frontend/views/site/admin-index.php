

<script>
    $(document).ready(function(){
        var myJsArrayUser = <?= json_encode($list_user); ?>;
        var myJsArrayUserStatus = <?= json_encode($array_user_status); ?>;

        Morris.Area({
            element: 'morris-area-chart',
            data: myJsArrayUser,
            xkey: 'created_at_date',
            ykeys: ['count_date'],
            labels: ['User'],
            pointSize: 2,
            hideHover: 'auto',
            resize: true
        });

        Morris.Donut({
            element: 'morris-donut-chart',
            data: myJsArrayUserStatus,
            resize: true
        });

    })
</script>

<?php $this->registerJsFile('@web/js/admin/raphael-min.js',['depends'=>[\yii\web\JqueryAsset::className()]]);?>

<?php $this->registerJsFile('@web/js/admin/morris.min.js',['depends'=>[\yii\web\JqueryAsset::className()]]);?>

<?php //$this->registerJsFile('@web/js/admin/morris-data.js',['depends'=>[\yii\web\JqueryAsset::className()]]);?>



<div class="row">
    <div class="col-lg-12">
        <h1 style="margin:0 0 20px;">Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$count_user ?></div>
                        <div>&nbsp;</div>
                    </div>
                </div>
            </div>
            <a href="<?=\yii\helpers\Url::to("manage/referrer");?>">
                <div class="panel-footer">
                    <span class="pull-left">List View</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-envelope fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$count_email ?></div>
                        <div><?=\yii\helpers\Html::a("New Email",["manage/create-email"],["style"=>"color:#FFF"]) ?></div>
                    </div>
                </div>
            </div>
            <a href="<?=\yii\helpers\Url::to("manage/email")?>">
                <div class="panel-footer">
                    <span class="pull-left">List Email</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
<!--    <div class="col-lg-3 col-md-6">-->
<!--        <div class="panel panel-yellow">-->
<!--            <div class="panel-heading">-->
<!--                <div class="row">-->
<!--                    <div class="col-xs-3">-->
<!--                        <i class="fa fa-shopping-cart fa-5x"></i>-->
<!--                    </div>-->
<!--                    <div class="col-xs-9 text-right">-->
<!--                        <div class="huge">124</div>-->
<!--                        <div>New Orders!</div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <a href="#">-->
<!--                <div class="panel-footer">-->
<!--                    <span class="pull-left">View Details</span>-->
<!--                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>-->
<!--                    <div class="clearfix"></div>-->
<!--                </div>-->
<!--            </a>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col-lg-3 col-md-6">-->
<!--        <div class="panel panel-red">-->
<!--            <div class="panel-heading">-->
<!--                <div class="row">-->
<!--                    <div class="col-xs-3">-->
<!--                        <i class="fa fa-support fa-5x"></i>-->
<!--                    </div>-->
<!--                    <div class="col-xs-9 text-right">-->
<!--                        <div class="huge">13</div>-->
<!--                        <div>Support Tickets!</div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <a href="#">-->
<!--                <div class="panel-footer">-->
<!--                    <span class="pull-left">View Details</span>-->
<!--                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>-->
<!--                    <div class="clearfix"></div>-->
<!--                </div>-->
<!--            </a>-->
<!--        </div>-->
<!--    </div>-->
</div>
<!-- /.row -->
<div class="row">
<div class="col-lg-8">
<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> User Registry Statistics
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <div id="morris-area-chart"></div>
    </div>
    <!-- /.panel-body -->
</div>
<!-- /.panel -->
</div>
<!-- /.col-lg-8 -->
<div class="col-lg-4">

    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-bar-chart-o fa-fw"></i> Donut Chart Status Users
        </div>
        <div class="panel-body">
            <div id="morris-donut-chart"></div>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->

</div>
<!-- /.col-lg-4 -->
</div>
<!-- /.row -->