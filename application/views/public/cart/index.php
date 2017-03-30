<script src="<?php echo base_url() ?>static/lib/sea.js"></script>
<div class="row" style="margin-top:100px;">
<?php require($views_path . 'public/user_leftmenu.php');?>
<div class="col-md-9">
    <div class="col-md-12 rightTitle yj">我的订单</div>
    <div class="rightContent"style="margin-top:70px;">
        <div class="row"style="margin-top:15px;">
            <div class="col-md-2 text-right"style="margin-top:5px;">复印店：</div>
            <div class="col-md-8"style="left:-15px;">
                <select name="company_id" class="form-control">
                    <option value="0">请选择打印店</option>
                    <?php foreach ($company as $v): ?>
                        <option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <?php foreach ($file_info as $file): ?>
            <div class="row" style="margin-top:10px;">
                <div class="col-md-2 text-right">文件名：</div>
                <div class="zt1"style="margin-top:5px;"><?php echo $file['title'];?></div>

            </div>
        <div class="print_size hide" style="margin-top:10px;" id="print_<?php echo $file['id'];?>">
            <input type="hidden" id="file_id" name="file_id" value="<?php echo $file['id'];?>" />
            <div class="row size" style="margin-top:10px;">
                <div class="col-md-2 text-right"style="margin-top:5px;">打印规格：</div>
                <div class="zt1">
                    <select class="form-control" name="size">
                    <?php foreach($charge_default as $key=>$val): ?>
                        <option value="<?php echo $key;?>"><?php echo $key;?></option>
                    <?php endforeach ?>
                    </select>
                </div>
                <div class="col-md-2 text-right" style="margin-top:5px;">单双面：</div>
                    <div class="zt1">
                        <select class="form-control" name="side_checked">
                            <option value="one">单面打印</option>
                            <option value="two">双面打印</option>
                        </select>
                    </div>
            </div>
            <div class="row" style="margin-top:10px;">
                <div class="col-md-2 text-right" style="margin-top:5px;">打印数量：</div>
                <div class="zt1">
                    <input type="text" value="<?php echo($file['file_num']?$file['file_num']:1);?>" id="file_num" name="file_num" class="form-control" />
                </div>
            </div>
            <div class="row" style="margin-top:10px;">
                <div class="col-md-2 text-right" style="margin-top:5px;">总页数：</div>
                <div class="zt1">
                    <input type="text" class="form-control" id="page" name="page" value="<?php echo($file['page']);?>" readonly="readonly">
                </div>
                <div class="col-md-2 text-right" style="margin-top:5px;">金额：</div>
                <div class="zt1">
                    <input type="text" class="form-control" id="price" value="" ><span class="sales"></span>
                </div>
            </div>
        </div>

        <?php endforeach; ?>
        <div class="row" style="margin-top:10px;">
            <div class="col-md-2 text-right" style="margin-top:5px;">备注：</div>
            <div class="col-md-5" style="left:-15px;">
                <input type="text" class="form-control" id="remarks">
            </div>
        </div>
        <div class="row" style="margin-top:20px;">
            <div class="col-md-2" style="margin-left:300px;">
                <button class="btn btn-block btn-primary" type="button" id="do_place">
                    提交打印
                </button>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    function get_price(obj,company_id,size,side,num){
        $.ajax({
            url:'/api/company/get_price/'+company_id+'/'+size+'/'+side+'/'+num,
            type:'get',
            dataType:'json',
            success:function(json){
                if(json.status==true){
                    $(obj).find('#price').val(json.data.total+"元");

                    /*
                     折扣率也从这返回了
                     */
                }
            }
        });
    }
        $("select[name=company_id]").change(function(){
            var company_id = $("select[name=company_id]").val();
            if(company_id){
                $(".print_size").removeClass('hide');
                var nums =$(".rightContent").children(".print_size").length;
                var i=0;
                for(;i<nums;i++){
                    var id =  '#'+$(".rightContent .print_size").eq(i).attr('id');
                    var size = $(id).find('select[name=size]').val();
                    var num = $(id).find('#file_num').val();
                    var side =  $(id).find('select[name=side_checked]').val();
                    get_price(id,company_id,size,side,num);
                    $('.print_size size').addClass('hide');
                    $('.print_size .company_'+company_id).removeClass('hide');
                }
            }else
            if(company_id){
                $(".print_size").addClass('hide');
            }
        });
        $("select[name=side_checked]").change(function(){
            var side = $(this).val();
            var company_id = $("select[name=company_id]").val();
            var id = '#'+$(this).parent().parent().parent().attr('id');
            var size = $(id).find('select[name=size]').val();
            var num = $(id).find('#file_num').val();
            get_price(id,company_id,size,side,num);
        });
        $("select[name=size]").change(function(){
            var obj = this;
            var id = '#'+$(this).parent().parent().parent().attr('id');
            var size = $(this).val();
            var company_id = $("select[name=company_id]").val();
            var side =  $(id).find('select[name=side_checked]').val();
            var num =  $(id).find('#file_num').val();
            get_price(id,company_id,size,side,num);
        });
        $('input[name=file_num]').focusout(function(){
            var id = '#'+$(this).parent().parent().parent().attr('id');
            var num = $(this).val();
            var company_id = $("select[name=company_id]").val();
            var side =  $(id).find('select[name=side_checked]').val();
            var size =  $(id).find('select[name=size]').val();
            get_price(id,company_id,size,side,num);
        });
        $("#do_place").click(
            function(){
                var nums =$(".rightContent").children(".print_size").length;

                var i=0;
                var myArray=new Array();
                for(;i<nums;i++){

                    //var check_ = $("#div_to_place div").eq(i).find("#checks").is(':checked');
                    //if(check_){
                        var size = $(".rightContent .print_size").eq(i).find('select[name=size]').val();
                        var side = $(".rightContent .print_size").eq(i).find('select[name=side_checked]').val();
                        var file_num =  $(".rightContent .print_size").eq(i).find("#file_num").val();
                        var file_id = $(".rightContent .print_size").eq(i).find("#file_id").val();
                        var price = $(".rightContent .print_size").eq(i).find("#price").val();
                        var sale = $(".rightContent .print_size").eq(i).find("#sales").val();
                        var page = $(".rightContent .print_size").eq(i).find("#page").val();
                       // var is_color =  $("#div_to_place div").eq(i).find('.select_company input[name=is_color]:checked').val();
                        var is_color = 0;
                        if(!is_color){
                            is_color=0;
                        }
                        myArray[i] = { file_id:file_id,file_num:file_num,size:size,side:side,is_color:is_color,price:price,sale:sale,page:page}
                   // }
                }
                var postData = $.toJSON(myArray);
                var company_id = $("select[name=company_id]").val();
                var remarks = $('#remarks').val();
                $.ajax({
                    'url':'<?php echo site_url('public/cart/do_place')?>',
                    'dataType':'json',
                    'data':{file_info:postData,company_id:company_id,remarks:remarks},
                    'type':'post',
                    'success':function(data){
                        alert(data.state);
                    }
                });
            }
        );
</script>