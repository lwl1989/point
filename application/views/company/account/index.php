<div class="row" style="margin-top:100px;">
    <?php require($views_path . 'public/company_left.php');?>
    <div class="col-md-9">
        <div class="colmdbtl rightTitle yj" style="right:40px;left:40px;">商家中心</div>
        <div class="col-md-9">
            <form class="form-horizontal" role="form" style="margin-top:60px;" name="update_user" id="update_user"
                  method="post" action="<?php echo site_url('user/account/do_update_info');?>">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="inputNickname">昵称：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="" id="inputNickname" name="nickname" type="text" value="<?php echo $user['nickname'];?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="school">所在学校：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="" id="school" type="text" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="contact-way">详细地址：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="" id="contact-way" type="text" name="address" value="<?php echo $user['address'];?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="contact-way">手机：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="" id="contact-way" type="text"  name="mobile" value="<?php echo $user['mobile'];?>" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8" style="text-align:center;">
                        <div class="show_error hide"></div>
                        <button class="btn btn-default" style="padding-left:40px;padding-right:40px;background:#32465D;color:white;" type="submit">保存</button>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>
<script src="<?php echo base_url()?>static/public/js/tab.js"></script>
<script type="text/javascript">
    $().ready(function() {
        $("#update_user").validate({
            submitHandler: function(form) {
                jQuery(form).ajaxSubmit({
                    dataType:"json",
                    success:function(json){
                        if(json.status==true){
                            window.location.href='<?php site_url('user/account')?>';
                        }else{
                            $('.show_error').removeClass('hide');
                            $('.show_error').html('修改个人信息失败');
                            $('.show_error').fadeOut(2000);
                        }
                    }
                });
            }
        });
    });
</script>