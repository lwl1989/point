<?php if($activate): ?>
        <div class="row" style="text-align:center;color:#32465D;font-weight:bolder;font-size:30px;margin-top:120px;">
            恭喜激活邮箱成功	&nbsp;<img alt="" src="/static/public/images/right.png" style="margin-top:-7px;">
        </div>
        <div class="row" style="text-align:center;color:#a2a2a2;font-weight:bolder;margin-top:40px;">
            HI，欢迎<?php echo $email;?>来到学霸银行!2秒后进入个人中心
            <span style="color:#32465D;"><a href="javascript:void(0);" onclick=""><?php echo($email);?></a></span>
        </div>
        <script>
            $(function() {
                setTimeout("window.location.href = '/user/account'",2000);
            });
        </script>
<?php else: ?>
        <div class="row" style="text-align:center;color:#a2a2a2;font-weight:bolder;margin-top:40px;">
            <span>错误的链接<?php if(@$email): ?>，或者<a style="color:#32465D;" href="javascript:void(0);" onclick="send_email_register('<?php echo($email);?>',this)">
                        重新发送</a><?php else: ?><a href="/" >，2秒后自动返回首页</a> <?php endif;?></span>
        </div>
        <script>
        $(function() {
            setTimeout("window.location.href = '/'",2000);
        });
        </script>
<?php endif; ?>
