<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-16
 * Time: 下午2:10
 */
?>

<div style="width: 100%; height: 100%; clear: both;margin-top: 200px;" id="div_to_place">
    <?php foreach ($file_info as $file): ?>
    <div>
        <input type="checkbox" id="checks" checked="checked" />
        <input type="hidden" value="<?php echo($file['id'])?>" id="file_id"/>
        <p><?php //echo($file['title']);?></p>
        <input type="text" value="<?php echo($file['file_num']);?>" id="file_num"/>
    </div>
    <?php endforeach; ?>
    <select name="company_id">
        <option value="0">请选择公司</option>
        <?php foreach ($company as $v): ?>
        <option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
        <?php endforeach; ?>
    </select>
    <input type="radio" value="1" name="side_checked"><input type="radio" value="2" name="side_checked">
    <textarea id="remarks"></textarea>
</div>


<input type="button" value="我要下单" id="do_place"/>
<script>
    seajs.use(["jquery","json",,"bootstrap"],function(jquery,json){

        $("#do_place").click(
            function(){
                var num =$("#div_to_place").children("div").length;
                var i=0;
                var myArray=new Array();
                for(;i<num;i++){

                    var check_ = $("#div_to_place div").eq(i).find("#checks").is(':checked');
                    if(check_){
                        var file_num =  $("#div_to_place div").eq(i).find("#file_num").val();
                        var file_id = $("#div_to_place div").eq(i).find("#file_id").val();
                        myArray[i] = { file_id:file_id,file_num:file_num }
                    }
                }
                var postData = $.toJSON(myArray);
                var company_id  = $('#company_id').val();
                var side = $('input[name="side_checked"]:checked').val();
                var remarks = $('#remarks').val();
                $.ajax({
                    'url':'<?php echo site_url('public/file/do_place')?>',
                    'dataType':'json',
                    'data':{file_info:postData,company_id:company_id,side:side,remarks:remarks},
                    'type':'post',
                    'success':function(data){
                        //var back =$.evalJSON(data).state;
                        alert(data.state);
                    }
                });
            }
        );



	});
    function obj2string(o) {
        var r = [];
        if (typeof o == "string") {
            return "\""
                + o.replace(/([\'\"\\])/g, "\\$1").replace(/(\n)/g, "\\n")
                .replace(/(\r)/g, "\\r").replace(/(\t)/g, "\\t")
                + "\"";
        }
        if (typeof o == "object") {
            if (!o.sort) {
                for ( var i in o) {
                    r.push(i + ":" + obj2string(o[i]));
                }
                if (!!document.all
                    && !/^\n?function\s*toString\(\)\s*\{\n?\s*\[native code\]\n?\s*\}\n?\s*$/
                    .test(o.toString)) {
                    r.push("toString:" + o.toString.toString());
                }
                r = "{" + r.join() + "}";
            } else {
                for (var i = 0; i < o.length; i++) {
                    r.push(obj2string(o[i]))
                }
                r = "[" + r.join() + "]";
            }
            return r;
        }
        return o.toString();
    }

</script>