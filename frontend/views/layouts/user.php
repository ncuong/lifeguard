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
    <?php $this->registerJsFile('@web/js/jquery-ui.min.js');?>

    <?php $this->registerCssFile('@web/css/font-awesome/css/font-awesome.min.css'); ?>
    <?php $this->registerCssFile('@web/css/bootstrap-tagsinput.css') ?>
    <?php $this->registerCssFile('@web/css/jquery-ui.css') ?>


    <?php $this->registerJsFile('@web/js/user/grayscale.js',['depends'=>[\yii\web\JqueryAsset::className()]]);?>
    <?php $this->registerJsFile('@web/js/user/jquery.easing.min.js',['depends'=>[\yii\web\JqueryAsset::className()]]);?>


    <!-- Custom CSS -->
    <?php $this->registerCssFile('@web/css/user/grayscale.css',['depends'=>[\yii\bootstrap\BootstrapAsset::className()]]) ?>

    <!-- Custom Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">


    <?php $this->head() ?>

    <script>
        $(document).ready(function(){

//            $("table").resizableColumns({
//                store: window.store
//            });

            //$( "th" ).resizable();


        })
    </script>


</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <?php $this->beginBody() ?>
    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">

            <!-- Collect the nav links, forms, and other content for toggling -->

            <?php
            NavBar::begin([
                'brandLabel' => 'Lifeguard',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-header',
                ],
            ]);
            //            $menuItems = [
            //                ['label' => 'Home', 'url' => ['/site/index']],
            //            ];
            if (Yii::$app->user->isGuest) {
                $controller = Yii::$app->controller;
                $default_controller = Yii::$app->defaultRoute;
                $isHome = (($controller->id === $default_controller) && ($controller->action->id === $controller->defaultAction)) ? true : false;

                if(!$isHome)
                    $menuItems[] = ['label' => 'Register', 'url' => ['/site/register'],'linkOptions' => ['class' => 'btn btn-primary btn-login']];
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login'],'linkOptions' => ['class' => 'btn btn-primary btn-login']];
//                $menuItems[] = ['label' => 'Forgot Password', 'url' => ['/site/request-password-reset']];
            } else {
                if(Yii::$app->user->can('admin')){
                    $menuItems[] =['label'=>'Report','url' => ['/manage/report-one']];
//                    $menuItems[] = ['label'=>'Email', 'url'=>['/manage/email']];
//                    $menuItems[] =['label'=>'Referrer','url' => ['/manage/referrer']];



                    $menuItems[] = [
                        'label' => 'Email',
                        //'url' => ['/application/index'],
                        'items'=>[
                            ['label' => 'List View', 'url' => ['/manage/referrer']],
                            ['label' => 'Tree View', 'url' => ['/manage/tree-view']],
                            ['label' => 'Sent Box', 'url' => ['/manage/email']],
//                            ['label' => 'OT by cash request', 'url' => ['/application/application-of-type', 'id'=>-11,'user_id'=>Yii::$app->user->id]],
                        ]
                    ];


                }
                if(!Yii::$app->user->can('admin')){
                    $menuItems[] =['label'=>'Referrer','url' => ['/site/referrer']];
                }
                $menuItems[] =['label'=>'Profile','url' => ['/site/profile']];
                $menuItems[] =['label'=>'Change Password','url' => ['/site/change-password']];
                $menuItems[] = [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right fix-menu'],
                'items' => $menuItems,
            ]);
            NavBar::end();
            ?>
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Header -->
    <header class="intro">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="brand-heading">Grayscale</h1>
                        <p class="intro-text">A free, responsive, one page Bootstrap theme.<br>Created by Start Bootstrap.</p>
                        <a href="#about" class="btn btn-circle page-scroll">
                            <i class="fa fa-angle-double-down animated"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>About Grayscale</h2>
                <p>Grayscale is a free Bootstrap 3 theme created by Start Bootstrap. It can be yours right now, simply download the template on <a href="http://startbootstrap.com/template-overviews/grayscale/">the preview page</a>. The theme is open source, and you can use it for any purpose, personal or commercial.</p>
                <p>This theme features stock photos by <a href="http://gratisography.com/">Gratisography</a> along with a custom Google Maps skin courtesy of <a href="http://snazzymaps.com/">Snazzy Maps</a>.</p>
                <p>Grayscale includes full HTML, CSS, and custom JavaScript files along with LESS files for easy customization.</p>
            </div>
        </div>
    </section>

    <!-- Download Section -->
    <section id="download" class="content-section text-center">
        <div class="download-section">
            <div class="container">
                <div class="col-lg-8 col-lg-offset-2">
                    <h2>Download Grayscale</h2>
                    <p>You can download Grayscale for free on the preview page at Start Bootstrap.</p>
                    <a href="http://startbootstrap.com/template-overviews/grayscale/" class="btn btn-default btn-lg">Visit Download Page</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>Contact Start Bootstrap</h2>
                <p>Feel free to email us to provide some feedback on our templates, give us suggestions for new templates and themes, or to just say hello!</p>
                <p><a href="mailto:feedback@startbootstrap.com">feedback@startbootstrap.com</a>
                </p>
                <ul class="list-inline banner-social-buttons">
                    <li>
                        <a href="https://twitter.com/SBootstrap" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>
                    </li>
                    <li>
                        <a href="https://github.com/IronSummitMedia/startbootstrap" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>
                    </li>
                    <li>
                        <a href="https://plus.google.com/+Startbootstrap/posts" class="btn btn-default btn-lg"><i class="fa fa-google-plus fa-fw"></i> <span class="network-name">Google+</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <div id="map"></div>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>Copyright &copy; Your Website 2014</p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
