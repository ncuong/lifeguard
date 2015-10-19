<?php
    use yii\helpers\Html;
    use frontend\models\User;
    $level1 = $dataProvider1->models;
?>

<div class="row panel panel-default" style="margin-top: 10px">
    <!-- Default panel contents -->
    <div class="panel-heading">Lifeguard</div>

    <div class="col-lg-12 ">


        <p><?php echo $root->first_name ?></p>
        <ul class="tree">
            <?php foreach( $level1 as $user1){
                $u = new User();

                $str_ul = $u->getUserReferrer($user1->code);
                if($str_ul == "NULL"){
                ?>
                    <li><i class="glyphicon glyphicon-minus"></i>

                        <input type="checkbox" value="<?=$user1->id?>" /> <a id="<?=$user1->code;?>" class="node node_null minus" href="#"><?php echo $user1->first_name." ".$user1->last_name; ?></a>

                    </li>
            <?php }else{ ?>

                    <li><i class="glyphicon glyphicon-minus"></i>

                        <input type="checkbox" value="<?=$user1->id?>_O" /> <a id="<?=$user1->code;?>" class="node minus" href="#"><?php echo $user1->first_name." ".$user1->last_name; ?></a>
                        <ul>
                        <?php

                            $checked = $str_ul['parent_checked']==0?"":"checked";
                            $dataProvider = $str_ul['dataProvider'];

                            foreach($dataProvider->models as $model){
                                echo '<li><i class="glyphicon glyphicon-plus"></i> <input '.$checked.' type="checkbox" value="'.$model->id.'" /> <a id="'.$model->code.'" class="node plus" href="#">'.$model->first_name." ".$model->last_name.'</a></li>';
                            }
                        ?>
                        </ul>
                    </li>

            <?php }}?>
        </ul>

        <div class="row">

            <div class=" col-lg-6" style="padding: 5px 0px 20px 30px;" id="group-action">
                <?php echo Html::img('@web/img/arrow_ltr.png', ['style' => 'padding-left:22px;']) ?>
                <?php //echo Html::a("Delete", ['manage/delete-users']).'/' ?>
                <?php //echo Html::a("Active", ['manage/active-users']).'/' ?>
                <?php //echo Html::a("Inactive", ['manage/inactive-users']) ?>
                <?php //echo Html::a("Lock", ['manage/lock-users']).'/' ?>
                <?php echo Html::a("Send mail", ['manage/tree-create-email']) ?>
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

<script type="application/javascript">
    $(document).ready(function(){

        $(document).on("change", "input[type='checkbox']",function() {
            isParentChecked = this.checked;
            $(this).parent().find('input[type=checkbox]').each(function () {
                // some staff
                this.checked = isParentChecked;
            });
        });

        $(document).on("click", ".node",function() {
            code = $(this).attr("id");
            if($(this).hasClass("node_null")){
                alert("Don't have children");
                return false;
            }
            if ($(this).hasClass("minus")) {
                $(this).parent().children("ul").hide();
                $(this).removeClass('minus');
                $(this).addClass("plus");

                $(this).parent().children("i").removeClass('glyphicon-minus');
                $(this).parent().children("i").addClass("glyphicon-plus");

            } else {

                $(this).removeClass('plus');
                $(this).addClass("minus");

                $(this).parent().children("i").removeClass('glyphicon-plus');
                $(this).parent().children("i").addClass("glyphicon-minus");

                if($(this).parent().children("ul").length<=0)
                    getChildrenUser(code,this);

                $(this).parent().children("ul").show();
            }
        })


        function getChildrenUser(code,_this){

            //Kiem tra parent co checked ko. de thiet lau cho children
            if($(_this).prev().is(":checked")){
                isChecked = 1;
            }else{
                isChecked = 0;
            }

            var request = $.ajax({
                url: "<?php echo \yii\helpers\Url::to(['manage/get-users']) ?>",
                type: "POST",
                data: { code : code , parent_checked: isChecked},
                dataType: "html"
            });

            request.done(function( msg ) {
                if(msg == "NULL"){
                    alert("Don't have children");
                    $(_this).addClass("node_null");
                }else{
                    id = $(_this).prev().attr("value");
                    $(_this).prev().attr("value",id+"_O");
                    $(_this).after(msg);
                }
            });

            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });
        }
    })
</script>


<script>
    $(document).ready(function(){


        function updateUrl(param,value){
            /*
             * queryParameters -> handles the query string parameters
             * queryString -> the query string without the fist '?' character
             * re -> the regular expression
             * m -> holds the string matching the regular expression
             */
            var queryParameters = {}, queryString = location.search.substring(1),
                re = /([^&=]+)=([^&]*)/g, m;

            // Creates a map with the query string parameters
            while (m = re.exec(queryString)) {
                queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
            }

            // Add new parameters or update existing ones
            //queryParameters['per'] = 'new parameter';
            queryParameters[param] = value;

            /*
             * Replace the query portion of the URL.
             * jQuery.param() -> create a serialized representation of an array or
             *     object, suitable for use in a URL query string or Ajax request.
             */
            location.search = $.param(queryParameters); // Causes page to reload


            //  _url = $(location).attr('href');

            // similar behavior as an HTTP redirect
            // window.location.replace("http://stackoverflow.com");

            // similar behavior as clicking on a link
            //window.location.href = "http://stackoverflow.com";
            //alert();
        }

        $(".page-size").change(function(){
            updateUrl('per-page',$(this).val());
//            queryParameters['per-page'] = $(this).val();

        })

        function GetStringId()
        {
            strId = "";
            $(".tree input[type='checkbox']:checked").each(function(){
                strId += $(this).val()+","
            });

            return strId;
        }
        //Cai nay dung de tao lai duong dan cho cac hanh dong delete, active, sendmail
        $(document).on("click", "#group-action a",function() {

            var i = $(".tree input[type='checkbox']:checked").length;
            if(i == 0){
                alert("Please make the choice record(s)!");
                return false;
            }

            strId = GetStringId();
            strId = strId.substring(0,strId.length - 1);
            var url = $(this).attr('href');
            $(this).attr('href',url+"?ids="+strId);
        })

        //Cai nay dung de an hien column tren gridview
        $(".option-show-column input").click(function(){
            col = $(this).attr("name");
            var index = $("tbody tr td").index($("."+col));
            if($(this).is(":checked")){
                $("thead tr").children().eq(index).show();
                $("tr.filters").children().eq(index).show();
                $("."+col).show();
            }else{
                $("thead tr").children().eq(index).hide();
                $("tr.filters").children().eq(index).hide();
                $("."+col).hide();
            }
        })

    })
</script>