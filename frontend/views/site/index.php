
<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'Lifeguard';
?>
<!--<div class="page-home">-->
<!--    <h1>Lifeguard</h1>-->
<!--</div>-->

<div class="row">
    <div class="col-lg-8 col-sm-8 col-lg-offset-2 col-sm-offset-2" style="text-align: center">
       <?php echo Html::img("@web/img/logo.png",array('style'=>"width: 60%")) ?>
        <div style="text-align: center; margin: 10px 0px;">
            <?= Html::a('Join Us', ['register'], ['class' => 'btn btn-primary btn-join-us']) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-sm-12">
        <div class="innerText">
            <p>The Lifeguard Alliance is a nonprofit, nonpartisan organization whose mission is to raise awareness of important social issues crucial to the survival of a thriving American civilization.
                Our goal is to bring together a cohesive movement focused on uniting concerned citizens around the values that have proven to be core to the foundation of flourishing societies throughout history.</p>

            <p><span>The Lifeguard Alliance is a new type of vehicle for providing research-based information for individual citizens to become aware of the pressing social issues from all sides of the debate, not just what’s purported through the mainstream media and educational system.</span></p>

            <p><span>We educate our members with the knowledge and confidence necessary to impact change from a grass roots level in their local communities, state legislatures and federal elections.</span></p>

            <p><span>We do not believe that the entire countries decisions and futures should be decided on a "LEFT VERSUS RIGHT" decisions but RIGHT VERSUS WRONG !</span></p>

            <p><span>It is a fact that the Media and the Education System in America has a Liberal bias and the only thing that we can do when we do not agree with the direction that the country is going is to VOTE, we must VOTE in all elections and help elect those whos thoughts and visions align with ours.</span></p>
        </div>
    </div>
</div>