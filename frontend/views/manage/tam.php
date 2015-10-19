<div>
    <p><?php echo $root->first_name ?></p>
    <ul class="tree">
        <?php foreach( $level1 as $user1){ ?>
        <li> <input type="checkbox" /> <a href="#"><?php echo $user1->first_name." ".$user1->last_name; ?></a>
            <ul>

                <?php
                    foreach($level2 as $user2){
                        if($user2->referrer == $user1->code){
                            echo '<li> <input type="checkbox" /> <a href="#">'.$user2->first_name." ".$user2->last_name.'</a></li>';
                        }
                }?>
            </ul>
        </li>
        <?php } ?>
    </ul>
</div>

<table id="tree-view" class="table table-striped table-bordered">
    <?php foreach($level1 as $user1){ ?>
    <tr>
        <td><i id="<?=$user1->code?>" class="glyphicon glyphicon-minus"></i></td>
        <td><input class="<?=$user1->code?>" type="checkbox"></td>
        <td><?=$user1->first_name.$user1->last_name?></td>
        <td><?=$user1->code?></td>
        <td><?=$user1->referrer?></td>
        <td><?=$user1->mobile?></td>
        <td><?=$user1->state?></td>
        <td><?=$user1->zip?></td>
        <td><?=$user1->city?></td>
        <td><?=$user1->email?></td>
        <td><?=$user1->status?></td>
    </tr>
        <?php
        $isOpen = false;
        foreach($level2 as $user2){
            if($user2->referrer == $user1->code){

        ?>
        <?php if(!$isOpen){
                    $isOpen = true;?>
        <tr class="<?=$user1->code ?>">
            <td colspan="11">
                <table class="table table-striped table-bordered">
        <?php }?>
                    <tr>
                        <td><i class="glyphicon glyphicon-plus"></i></td>
                        <td><input type="checkbox"></td>
                        <td><?=$user2->first_name.$user2->last_name?></td>
                        <td><?=$user2->code?></td>
                        <td><?=$user2->referrer?></td>
                        <td><?=$user2->mobile?></td>
                        <td><?=$user2->state?></td>
                        <td><?=$user2->zip?></td>
                        <td><?=$user2->city?></td>
                        <td><?=$user2->email?></td>
                        <td><?=$user2->status?></td>
                    </tr>
        <?php }}
            if($isOpen){ $isOpen = false;
        ?>
                </table>
            </td>
        </tr>
    <?php }?>

    <?php }?>
</table>
















table#tb-referrer {
table-layout: fixed;
width: 100%;
/*height:50px;*/
/**margin-left: -100px;*//*ie7*/
}
#tb-referrer td, #tb-referrer th:first-child {
/*vertical-align: top;*/
/*border-top: 1px solid #ccc;*/
/*padding:10px;*/
/*width:100px;*/
}
#tb-referrer th:last-child,#tb-referrer td:last-child {
position:absolute;
/**position: relative; *//*ie7*/
right:0;
width:100px;
border-bottom: 0px !important;
height: 100px;
}
.outer {position:relative}
.inner {
overflow-x:scroll;
overflow-y:visible;
/*width:400px;*/
margin-right:100px;
}
#tb-referrer thead th:last-child{
top: 0;
border-top: 1px solid #cccccc !important;
padding-top: 2px !important;
}
.fix-box{
border: 1px solid #FFFFFF;
border-top: 1px solid #ccc;
width: 100px;
height: 58px;
position: absolute;
right: 0;
bottom: -20;
}















<div class="row panel panel-default" style="margin-top: 10px">
    <!-- Default panel contents -->
    <div class="panel-heading">Lifeguard</div>

    <div class="col-lg-12 ">

        <div class="option-show-column">
            <a style="display: block;text-align: right" data-toggle="collapse" href="#collapseExample"
               aria-expanded="false" aria-controls="collapseExample">
                Option show/hide columns
            </a>

            <div class="collapse" id="collapseExample">
                <div class="well row">
                    <?php echo Html::checkbox("col-name", true); ?><span>Name</span>
                    <?php echo Html::checkbox("col-code", true); ?><span>Code</span>
                    <?php echo Html::checkbox("col-referrer", true); ?><span>Referrer</span>
                    <?php echo Html::checkbox("col-mobile", true); ?><span>Mobile</span>
                    <?php echo Html::checkbox("col-state", true); ?><span>State</span>
                    <?php echo Html::checkbox("col-zip", true); ?><span>Zip</span>
                    <?php echo Html::checkbox("col-city", true); ?><span>City</span>
                    <?php echo Html::checkbox("col-email", true); ?><span>Email</span>
                    <?php echo Html::checkbox("col-graduate", true); ?><span>Graduate</span>
                    <?php echo Html::checkbox("col-sex", true); ?><span>Sex</span>
                    <?php echo Html::checkbox("col-status", true); ?><span>Status</span>
                    <?php echo Html::checkbox("col-created", true); ?><span>Created</span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <!--        <div class="outer">-->
        <!--            <div class="inner">-->
        <div class="grid-view">
            <table id="tree-view" class="table table-striped table-bordered">
                <tr>
                    <th>#</th>
                    <th><input type="checkbox" class="select-on-check-all" name="selection_all" value="1"></th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Referrer</th>
                    <th>Mobile</th>
                    <th>State</th>
                    <th>Zip</th>
                    <th>City</th>
                    <th>Email</th>
                    <th>Sex</th>
                    <th><select class="form-control page-size" name="pageSize" style="width:70px; padding:0px;">
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="70">70</option>
                            <option value="100">100</option>
                        </select></th>
                </tr>
                <?php foreach ($level1 as $user1) { ?>
                    <tr>
                        <td><i id="<?= $user1->code ?>" class="glyphicon glyphicon-minus"></i></td>
                        <td><input class="<?= $user1->code ?>" type="checkbox"></td>
                        <td><?= $user1->first_name ." ".$user1->last_name ?></td>
                        <td><?= $user1->code ?></td>
                        <td><?= $user1->referrer ?></td>
                        <td><?= $user1->mobile ?></td>
                        <td><?= $user1->state ?></td>
                        <td><?= $user1->zip ?></td>
                        <td><?= $user1->city ?></td>
                        <td><?= $user1->email ?></td>
                        <td><?= $user1->sex ?></td>
                        <td class="btn-action" width="70">
                            <?php

                            $url = \yii\helpers\Url::to(['manage/delete-user','id'=>$user1->id],true);
                            echo Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('yii', 'Delete'),
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this application "'.$user1->first_name.'"?',
                                    'method' => 'post',
                                ],
                            ]);

                            $url = \yii\helpers\Url::to(['manage/update-user','id'=>$user1->id],true);
                            echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('yii', 'Update'),
                            ]);

                            ?>
                        </td>
                    </tr>
                    <?php
                    $isOpen = false;
                    foreach ($level2 as $user2) {
                        if ($user2->referrer == $user1->code) {

                            ?>
                            <?php if (!$isOpen) {
                                $isOpen = true;?>
                                <tr class="<?= $user1->code ?>">
                                <td colspan="12">
                                <table class="table table-striped table-bordered">
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Referrer</th>
                                    <th>Mobile</th>
                                    <th>State</th>
                                    <th>Zip</th>
                                    <th>City</th>
                                    <th>Email</th>

                                    <th></th>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><i class="glyphicon glyphicon-plus"></i></td>
                                <td><input type="checkbox"></td>
                                <td><?= $user2->first_name ." ". $user2->last_name ?></td>
                                <td><?= $user2->code ?></td>
                                <td><?= $user2->referrer ?></td>
                                <td><?= $user2->mobile ?></td>
                                <td><?= $user2->state ?></td>
                                <td><?= $user2->zip ?></td>
                                <td><?= $user2->city ?></td>
                                <td><?= $user2->email ?></td>
                                <td><?php

                                    $url = \yii\helpers\Url::to(['manage/delete-user','id'=>$user2->id],true);
                                    echo Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => Yii::t('yii', 'Delete'),
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this application "'.$user2->first_name.'"?',
                                            'method' => 'post',
                                        ],
                                    ]);

                                    $url = \yii\helpers\Url::to(['manage/update-user','id'=>$user2->id],true);
                                    echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('yii', 'Update'),
                                    ]);

                                    ?></td>
                            </tr>
                        <?php
                        }
                    }
                    if ($isOpen) {
                        $isOpen = false;
                        ?>
                        </table>
                        </td>
                        </tr>
                    <?php } ?>

                <?php } ?>
            </table>
        </div>
        <!--            </div>-->
        <!--            <div class="fix-box"></div>-->
        <!--        </div>-->


        <div class="row">

            <div class=" col-lg-6" style="padding: 5px 0px 20px 30px;" id="group-action">
                <?php echo Html::img('@web/img/arrow_ltr.png', ['style' => 'padding-left:22px;']) ?>
                <?php echo Html::a("Delete", ['manage/delete-users']) ?>/
                <?php echo Html::a("Active", ['manage/active-users']) ?>/
                <?php //echo Html::a("Inactive", ['manage/inactive-users']) ?>
                <?php echo Html::a("Lock", ['manage/lock-users']) ?>/
                <?php echo Html::a("Send mail", ['manage/create-email']) ?>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12 panel-footer" style="text-align: right">
                <?php echo \yii\widgets\LinkPager::widget([
                    'pagination' => $dataProvider1->pagination,
                ]);  ?>
            </div>
        </div>
    </div>
</div>