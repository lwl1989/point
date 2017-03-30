<div class="row" style="margin-top:100px;">
    <?php require($views_path . 'public/company_left.php');?>
<div class="col-md-9">
    <div class="col-md-12 rightTitle yj">修改密码</div>
    <div class="col-md-9">
        <form class="form-horizontal" role="form" style="margin-top: 60px;" name="change_password" id="change_password" action="<?php echo site_url('company/account/do_change_password')?>" method="post">
            <div class="col-md-8 col-md-offset-2">
                <div class="form-group">
                    <label for="oldpassword">旧密码：</label> <input
                        class="form-control" placeholder="旧密码" id="password" name="password"
                        type="password" />
                </div>
                <div class="form-group">
                    <label for="newpassword">新密码：</label><input class="form-control"
                                                                placeholder="新密码" id="new_password" type="password"
                        name="new_password"/>
                </div>
                <div class="form-group">
                    <label for="confirmpassword">确认密码：</label><input
                        class="form-control" placeholder="确认密码" id="re_password" name="re_password"
                        type="password" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-8" style="text-align: center;">
                    <div class="show_err hide"></div>
                    <button class="btn btn-default"
                            style="padding-left: 40px; padding-right: 40px; background: #32465D; color: white;margin-top:30px;"
                            type="submit">保存</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>

<script type="text/javascript">
    $().ready(function() {
        $("#change_password").validate({
            rules: {
                //password: "password",
                password: {
                    required: true,
                    minlength: 5
                },
                repassword: {
                    required: true,
                    minlength: 5
                },
                newpassword: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                //account: "请输入账户",
                password: {
                    required: "请输入密码",
                    minlength: jQuery.format("密码不能小于{0}个字 符")
                },
                newpassword: {
                    required: "请输入新密码",
                    minlength: jQuery.format("密码不能小于{0}个字 符")
                },
                repassword: {
                    required: "请输入确认密码",
                    minlength: jQuery.format("密码不能小于{0}个字 符")
                }

                },
            submitHandler: function(form) {
                jQuery(form).ajaxSubmit({
                    dataType:"json",
                    success:function(json){
                        if(json.status==true){
                            alert('已经修改密码成功，请重新登录');
                            window.location.href='<?php echo site_url('auth/logout')?>';
                        }else{
                            $('.show_error').removeClass('hide');
                            $('.show_error').html('修改密码失败');
                            $('.show_error').fadeOut(2000);
                        }
                    }
                });

            }
        });

    });
</script>
