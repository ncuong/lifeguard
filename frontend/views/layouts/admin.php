<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->registerJsFile('@web/js/editable/shieldui-lite-all.min.js',['depends'=>[\yii\web\JqueryAsset::className()]]);?>
    <?php $this->registerJsFile('@web/js/bootstrap-tagsinput.min.js')?>
    <?php $this->registerJsFile('@web/js/resizetable/jquery.resizableColumns.min.js');?>
    <?php $this->registerJsFile('@web/js/resizetable/store.min.js');?>
    <?php $this->registerJsFile('@web/js/jquery-ui.min.js');?>

    <?php $this->registerCssFile('@web/css/font-awesome/css/font-awesome.min.css'); ?>
    <?php $this->registerCssFile('@web/css/resizetable/jquery.resizableColumns.css'); ?>
    <?php $this->registerCssFile('@web/css/bootstrap-tagsinput.css') ?>
    <?php $this->registerCssFile('@web/css/jquery-ui.css') ?>
    <?php $this->head() ?>

    <!-- MetisMenu CSS -->
    <?php $this->registerCssFile('@web/css/admin/metisMenu.min.css',['depends'=>[\yii\bootstrap\BootstrapAsset::className()]]) ?>

    <!-- Timeline CSS -->
    <?php $this->registerCssFile('@web/css/admin/timeline.css',['depends'=>[\yii\bootstrap\BootstrapAsset::className()]]) ?>

    <!-- Custom CSS -->
    <?php $this->registerCssFile('@web/css/admin/sb-admin-2.css',['depends'=>[\yii\bootstrap\BootstrapAsset::className()]]) ?>

    <!-- Morris Charts CSS -->
    <?php $this->registerCssFile('@web/css/admin/morris.css',['depends'=>[\yii\bootstrap\BootstrapAsset::className()]]) ?>

    <!-- Bootstrap Core JavaScript -->
    <!-- Metis Menu Plugin JavaScript -->
    <?php $this->registerJsFile('@web/js/admin/metisMenu.min.js',['depends'=>[\yii\web\JqueryAsset::className()]]);?>

    <!-- Custom Theme JavaScript -->
    <?php $this->registerJsFile('@web/js/admin/sb-admin-2.js',['depends'=>[\yii\web\JqueryAsset::className()]]);?>


</head>
<body>
    <?php $this->beginBody() ?>
    <div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?=Yii::$app->homeUrl?>">Lifeguard</a>
    </div>
    <!-- /.navbar-header -->

    <?php echo $this->render('nav-top')?>
    <!-- /.navbar-top-links -->
    <?php echo $this->render('slide-bar') ?>


    </nav>

    <div id="page-wrapper" style="padding-bottom: 20px;">
        <div class="row">
            <div class="col-lg-12" style="min-height: 20px;">

            </div>
        </div>

        <?= $content ?>
    </div>
    <!-- /#page-wrapper -->

    </div>


    <?php $this->endBody() ?>

    <script>
        $(document).ready(function(){

//            $("table").resizableColumns({
//                store: window.store
//            });

            //$( "th" ).resizable();
            function fix_active_menu()
            {
                i = $("#side-menu .active").length;
                if( i >1){

                    $(".li-home a").removeClass('active');
                }
            }

            fix_active_menu();
        })
    </script>
</body>
</html>
<?php $this->endPage() ?>
