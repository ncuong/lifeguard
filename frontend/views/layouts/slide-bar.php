<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
<!--            <li class="sidebar-search">-->
<!--                <div class="input-group custom-search-form">-->
<!--                    <input type="text" class="form-control" placeholder="Search...">-->
<!--                                <span class="input-group-btn">-->
<!--                                <button class="btn btn-default" type="button">-->
<!--                                    <i class="fa fa-search"></i>-->
<!--                                </button>-->
<!--                            </span>-->
<!--                </div>-->
<!--            </li>-->
            <li class="li-home">
                <a href="<?=\yii\helpers\Url::base(true)?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="<?=\yii\helpers\Url::to(['manage/report-one'])?>"><i class="fa fa-file-text fa-fw"></i> Report</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-envelope fa-fw"></i> Email<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">

                    <li>
                        <a href="<?=\yii\helpers\Url::to(['manage/create-email']); ?>">Sent Email</a>
                    </li>
                    <li>
                        <a href="<?=\yii\helpers\Url::to(['manage/email'])?>">List Email</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>


            <li>
                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Referrer<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?=\yii\helpers\Url::to(['manage/referrer'])?>">List View</a>
                    </li>
                    <li>
                        <a href="<?=\yii\helpers\Url::to(['manage/tree-view']); ?>">Tree View</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->