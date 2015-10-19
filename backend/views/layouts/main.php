<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
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
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'VIETBINH',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
            ];
            //menu danh cho administrator
            if(Yii::$app->user->can('admin')){
                $menuItems[] = [
                    'label' => 'User',
                    'url' => ['user/index'],
                    'items' => [
                        ['label' => 'Permission', 'url' => ['/admin/permission']],
                        ['label' => 'Route', 'url' => ['/admin/route']],
                        ['label' => 'Role', 'url' => ['/admin/role']],
                        ['label' => 'Assignment', 'url' => ['/admin/assignment']],
                        ['label' => 'Menu', 'url' => ['/admin/menu']],
                    ]];
            }

            //menu danh cho nguoi quan ly nhan su
            if(Yii::$app->user->can('hrm')){
                $hrmNeedToReed = \backend\models\Application::find()->where(['hrm_readed'=>-1,'manager_ok'=>1])->count();
                $menuItems[] = [
                    'label' => 'Human Resource Management <span class="badge">'.$hrmNeedToReed.'</span>',
                    'items'=>[
                        ['label' => 'Assignment', 'url' => ['/admin/assignment']],
                        ['label' => 'Staff List', 'url' => ['/user-info/index']],
                        ['label' => 'Quota', 'url' => ['/user-date/index']],
                        ['label' => 'Leave/OT Application Request', 'url' => ['/application/application-of-room','id'=>Yii::$app->user->id]],
                        ['label' => 'Vacation Report', 'url' => ['/report/vacation-of-staff']],
                        ['label' => 'Overtime Report', 'url' => ['/report/overtime-of-staff']],
                    ]
                ];


            }

            //menu danh cho truong phong
            if(Yii::$app->user->can('manager')){
                $managerNeedToRead = \backend\models\Application::find()->joinWith('user')->where(['manager_readed'=>-1,'manager'=>Yii::$app->user->id])->count();
                $menuItems[] = [
                    'label' => 'Manager <span class="badge">'.$managerNeedToRead.'</span>',
                    'items'=>[
                        ['label' => 'Staff List', 'url' => ['/user-info/index']],
                        ['label' => 'Leave/OT Application Request', 'url' => ['/application/application-of-room','id'=>Yii::$app->user->id]],
                    ]
                ];
            }
            //menu danh cho nhan vien
            if(Yii::$app->user->can('staff')){
                $menuItems[] = [
                    'label' => 'Form',
                    //'url' => ['/application/index'],
                    'items'=>[
                        ['label' => 'Leave Application', 'url' => ['/application/application-of-type', 'id' => 0]],
                        ['label' => 'OT Compensation', 'url' => ['/application/application-of-type','id'=>-1]],
                        ['label' => 'Overtime', 'url' => ['/application/application-of-type', 'id'=>1]],
                        ['label' => 'OT by cash request', 'url' => ['/application/application-of-type', 'id'=>-11,'user_id'=>Yii::$app->user->id]],
                    ]
                ];

                $menuItems[] = [
                    'label' => 'Report',
                    'items'=>[
                        ['label' => 'Leave Application', 'url' => ['/application/index']],
                        ['label' => 'Leave and OT Summary', 'url' => ['/report/leave-and-overtime']],
                    ]
                ];
            }

            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'items'=>[
                        ['label' => 'Change Password', 'url' => ['/site/change-password']],
//                        ['label' => 'Personal Information', 'url' => Yii::$app->urlManager->createUrl(array('userinfo/show-information-user', 'id' => Yii::$app->user->id))],
                        ['label' => 'Log out', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
                    ],
                    'label' => 'Hello ' . Yii::$app->user->identity->username . '!',
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav  navbar-right'],
                'items' => $menuItems,
                'encodeLabels'=>false,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; Superkids <?= date('Y') ?></p>
        <p class="pull-right">Powered by <a href="http://www.hvl.com.vn/" rel="external">HVL</a></p>
        </div>
    </footer>
    <div id="loading">Loading .... </div>
    <?php $this->endBody() ?>
<!--Code waiting load ajax-->

    <script>
        $(document).ready(function () {
            $("#loading").hide();
            $(document).ajaxStart(function () {
                $("#loading").show();
            }).ajaxStop(function () {
                $("#loading").hide();
                });
        });
    </script>
<!-- End code waiting load ajax-->
</body>
</html>
<?php $this->endPage() ?>
