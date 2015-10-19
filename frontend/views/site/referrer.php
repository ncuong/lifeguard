<?php
use yii\grid\GridView;
/**
 * Created by PhpStorm.
 * User: VIETBINH
 * Date: 9/26/15
 * Time: 8:12 AM
 */

?>
<div class="row">
    <div class="col-lg-offset-2 col-lg-8">
        <div class="input-group">

            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
        <button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search"></i> </button>
      </span>
        </div><!-- /input-group -->
    </div><!-- /.col-lg-6 -->

</div><!-- /.row -->
<div class="row">
    <div class="col-lg-10 col-lg-offset-1" style="text-align: center; margin: 10px 0px;">

    </div>
</div>

<div class="row" style="margin-top: 10px">
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php
                if($referrer !== null){
                    echo "Referrer by ". $referrer->first_name;
                }else{
                    echo "Referrer";
                }?>

            </div>
            <div class="panel-body">
                <?php
                if($referrer !== null){ ?>
                <dl class="dl-horizontal box-info-referrer">
                    <dt>Code </dt>
                    <dd><?php echo $referrer->code ?></dd>
                    <dt>Name </dt>
                    <dd><?php echo $referrer->first_name ?></dd>
                    <dt>Email </dt>
                    <dd><?php echo $referrer->email ?></dd>
                    <dt>Mobile</dt>
                    <dd><?php echo $referrer->mobile ?></dd>
                </dl>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-lg-8 panel panel-default">
        <div style="margin: 10px 0px;">
            <h2 style="font-size: 20px; font-weight: bold;">Invite Your Friends to Lifeguard: </h2>
            <?php
                $url = \yii\helpers\Url::to(["site/register","referrer_code"=>$user->code],true);
                //echo \yii\helpers\Html::a($url,$url,['style'=>'font-size:16px;color:blue']);
            ?>
            <div class="invite"><?php echo $url; ?></div>
        </div>

            <!-- Default panel contents -->
            <div class="panel-heading">Lifeguard</div>

            <!-- Table -->


        <?= GridView::widget([
            'dataProvider' => $iRefer,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'header'=>'Name',
                    'value'=>function($model){ return $model->first_name." ".$model->last_name;}
                ],
                [
                    'attribute' => 'email',
                    'value' => 'email',
                    'enableSorting'=>false
                ],
            ],
        ]); ?>
    </div>
</div>