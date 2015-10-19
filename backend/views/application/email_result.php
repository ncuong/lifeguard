<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
?>
<table border="0">
    <tr>
        <td colspan="2">
            Dear <?= $model->user->full_name?>
        </td>
    </tr>
    <tr>
        <td style="width: 100px;">From</td>
        <td style="width: 500px;"><?=$user_manager->full_name;?></td>
    </tr>
    <tr>
        <td>Reason</td>
        <td><?=$model->reasonApplication->name;?></td>
    </tr>
    <tr>
        <td>From date</td>
        <td><?=Yii::$app->formatter->asDate($model->from_date);?></td>
    </tr>
    <tr>
        <td>To date</td>
        <td><?=Yii::$app->formatter->asDate($model->to_date)?></td>
    </tr>
    <tr>
        <td>From hour</td>
        <td><?=$model->from_hour;?></td>
    </tr>
    <tr>
        <td>To hour</td>
        <td><?=$model->to_hour?></td>
    </tr>
    <tr>
        <td>Hours off</td>
        <td><?=$model->hours_off?></td>
    </tr>
    <tr>
        <td>Content</td>
        <td><?=$model->content?></td>
    </tr>
    <tr>
        <td>Please click me!</td>
        <td><?=$link?></td>
    </tr>
</table>