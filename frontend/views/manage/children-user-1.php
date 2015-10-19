<ul>

    <?php
    $checked = $parent_checked==0?"":"checked";
    foreach($dataProvider->models as $model){
        echo '<li><i class="glyphicon glyphicon-plus"></i> <input '.$checked.' type="checkbox" value="'.$model->id.'" /> <a id="'.$model->code.'" class="node plus" href="#">'.$model->first_name." ".$model->last_name.'</a></li>';
    }?>
</ul>