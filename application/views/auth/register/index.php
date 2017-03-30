<div class="row title">
    <div class="col-md-2">注册</div>
</div>
<div class="row" style="margin-top:90px;margin-bottom:40px;">
    <div class="col-sm-2 col-sm-offset-4" ><a class="btn btn-block btn-primary" href="javascript:void(0);" id="mobile">手机注册</a></div>
    <div class="col-sm-2" ><a class="btn btn-block btn-default" href="javascript:void(0);" id="email">邮箱注册</a></div>
</div>
<div class="col-md-12 email_register hide">
    <form class="form-horizontal" role="form" action="<?php echo site_url('auth/register/do_register/email')?>" method="post" id="email_register">
        <div class="form-group  has-feedback">
            <label class="col-sm-2 col-sm-offset-2 control-label" for="inputEmail">登陆邮箱：</label>
            <div class="col-sm-4">
                <input class="form-control" placeholder="" id="inputEmail" name="email" type="text" />

            </div>
        </div>
        <div class="form-group  has-feedback">
            <label class="col-sm-2 col-sm-offset-2 control-label" for="inputPassword3">密码：</label>
            <div class="col-sm-4">
                <input class="form-control" placeholder="" type="password" name="password_email" id="password_email" />


            </div>
        </div>
        <div class="form-group  has-feedback">
            <label class="col-sm-2 col-sm-offset-2 control-label" for="inputPassword3">确认密码：</label>
            <div class="col-sm-4">
                <input class="form-control" placeholder=""  type="password" name="re_password_email" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-2">
                <button class="btn btn-block btn-primary" type="submit">提交</button>
            </div>
        </div>
    </form>
</div>
<div class="col-md-12 mobile_register">
    <form class="form-horizontal" role="form" action="<?php echo site_url('auth/register/do_register/mobile')?>" method="post" id="mobile_register">
        <div class="form-group has-feedback ">
            <label class="col-sm-2 col-sm-offset-2 control-label" for="inputPhone">手机号：</label>
            <div class="col-sm-4">
                <input class="form-control" placeholder="" id="inputPhone" type="text" name="mobile" />
            </div>
        </div>
        <div class="form-group has-feedback ">
            <label class="col-sm-2 col-sm-offset-2 control-label" for="inputVerificationCode">验证码：</label>
            <div class="col-sm-2">
                <input class="form-control" placeholder="" id="inputVerificationCode" type="text" name="verify_code" />
            </div>
            <div class="col-sm-2">
                <a class="btn btn-block btn-primary" href="#">免费获取验证码</a>
            </div>
        </div>
        <div class="form-group  has-feedback">
            <label class="col-sm-2 col-sm-offset-2 control-label" for="inputPassword3">密码：</label>
            <div class="col-sm-4">
                <input class="form-control" placeholder=""  type="password" name="passowrd_mobile" id="passowrd_mobile" />
            </div>
        </div>
        <div class="form-group  has-feedback">
            <label class="col-sm-2 col-sm-offset-2 control-label" for="inputPassword3">确认密码：</label>
            <div class="col-sm-4">
                <input class="form-control" placeholder="" type="password" name="re_password" />
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-2">
                <button class="btn btn-block btn-primary" type="submit">提交</button>
            </div>
        </div>

    </form>

</div>
<div class="row show_error hide">
</div>
<script>
    $('#email').click(function(){
        $(this).removeClass('btn-default');
        $(this).addClass('btn-primary');
        $('#mobile').addClass('btn-default');
        $('#mobile').removeClass('btn-primary');
        $('.email_register').removeClass('hide');
        $('.mobile_register').addClass('hide');
    });
   $('#mobile').click(function(){
       $(this).removeClass('btn-default');
       $(this).addClass('btn-primary');
       $('#email').addClass('btn-default');
       $('#email').removeClass('btn-primary');
       $('.mobile_register').removeClass('hide');
       $('.email_register').addClass('hide');
   });
</script>
<script type="text/javascript">
    $().ready(function() {
        $("#mobile_register").validate({
            rules: {

                mobile: {
                    required: true,
                    number:true
                },
                verify_code: {
                    required: true,
                    number:true
                },
                passowrd_mobile: {
                    required: true,
                    minlength: 5
                },
                re_password: {
                    required: true,
                    equalTo: "#passowrd_mobile"
                }
            },
            messages: {
                //account: "请输入账户",
                passowrd_mobile: {
                    required: "请输入密码",
                    minlength: jQuery.format("密码不能小于{0}个字 符")
                },
                mobile: {
                    required: "请输入手机号",
                    number: "请输入正确的值"
                },
                verify_code: {
                    required: "请输入验证码",
                    minlength:"请输入正确的值"
                },
                re_password: {
                    required: "请输入密码",
                    minlength: jQuery.format("密码不能小于{0}个字 符")
                }

            },
            submitHandler: function(form) {
                jQuery(form).ajaxSubmit({
                    dataType:"json",
                    success:function(json){
                        if(json.status==true){
                            alert('注册成功');
                            window.location.href='/user/account';
                        }else{
                            $('.show_error').removeClass('hide');
                            $('.show_error').html(json.msg);
                            $('.show_error').fadeOut(2000);
                        }
                    }
                });

            }
        });
        $("#email_register").validate({
            rules: {
                password_email: {
                    required: true,
                    minlength: 5
                },
                email: {
                    required: true,
                    email:true
                },
                re_password_email: {
                    required: true,
                    equalTo: "#password_email"
                }
            },
            messages: {
                //account: "请输入账户",
                password_email: {
                    required: "请输入密码",
                    minlength: jQuery.format("密码不能小于{0}个字 符")
                },
                email: {
                    required: "请输入邮箱",
                    email: "请输入正确的邮箱格式"
                },
                re_password_email:{
                    required: "请输入确认密码",
                    equalTo: "两次输入密码不一致不一致"
                }

            },
            submitHandler: function(form) {
                jQuery(form).ajaxSubmit({
                    dataType:"json",
                    success:function(json){
                        if(json.status=='10408'){
                         //   alert('注册成功');
                            window.location.href='/auth/register/send_email_after';
                        }else{
                            $('.show_error').removeClass('hide');
                            $('.show_error').html('注册失败');
                            $('.show_error').fadeOut(2000);
                        }
                    }
                });

            }
        });
    });
</script>

