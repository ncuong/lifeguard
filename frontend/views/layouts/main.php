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

    <script>
        $(document).ready(function(){

//            $("table").resizableColumns({
//                store: window.store
//            });

            //$( "th" ).resizable();


        })
    </script>

<!--    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />-->
<!--    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />-->
<!---->
<!--    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>-->
<!--    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>-->
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Lifeguard',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
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

        <div class="container">
        <?php
//        echo Breadcrumbs::widget([
//            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
//        ])
        ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; Lifeguard <?= date('Y') ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
