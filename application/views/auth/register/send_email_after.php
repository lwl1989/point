
    <div class="row" style="text-align:center;color:#32465D;font-weight:bolder;font-size:30px;margin-top:120px;">
        恭喜完成注册	&nbsp;<img alt="" src="/static/public/images/right.png" style="margin-top:-7px;">
    </div>
        <div class="row" style="text-align:center;color:#a2a2a2;font-weight:bolder;margin-top:40px;">
            HI，欢迎来到学霸银行，在您发布内容之前，你需要激活你的邮箱
            <span style="color:#32465D;"><a href="javascript:void(0);"
                                            onclick=""><?php echo($email);?></a></span>
        </div>
        <div class="row" style="text-align:center;color:#a2a2a2;font-weight:bolder;margin-top:40px;">
            <span>如果没有收到，请点击</a><a style="color:#32465D;" href="javascript:void(0);" onclick="send_email_register('<?php echo($email);?>',this)">重新发送</a></span>
        </div>

        <div class="row" style="text-align:center;border-bottom:solid 1px #ccc;margin-top:40px;margin-bottom:100px;">
        </div>
        <script>
            function send_email_register(email,obj){
                $.ajax({
                    url:'/auth/register/send_email_again',
                    type:'post',
                    data:{email:email},
                    dataType:'json',
                    success:function(data){
                        if(data.status){
                            alert('重新发送成功，请登录邮箱');
                            obj.attr("disabled","disabled");
                        }
                    }
                });
            }
        </script>