<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>学霸银行 - <?php echo $head_title?></title>
    <link href="/static/public/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="/static/public/css/buttons.css">
    <link rel="stylesheet" href="/static/public/css/style.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/static/lib/jquery-2.1.3.min.js"></script>
    <script src="/static/lib/jquery.validate.min.js"></script>
    <script src="/static/lib/jquery.form.min.js"></script>
    <script src="/static/lib/jquery.json.min.js"></script>
    <script src="/static/lib/company_base.js"></script>
    <script src="/static/public/js/transition.js"></script>
    <script src="/static/public/js/dropdown.js"></script>
    <script src="/static/public/js/collapse.js"></script>
    <script src="/static/public/js/carousel.js"></script>

</head>
<body>
<div class="container">
    <div class="row">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">切换导航</span><span class="icon-bar"></span><span
                            class="icon-bar"></span><span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"style="margin-left:0px;">
                        <img src="/static/public/images/logo.png" style="margin-top:0px;padding:0px 0px;"/>
                    </a>
                </div>
                <div class="collapse navbar-collapse"
                     id="bs-example-navbar-collapse-1">
                    <div class="login_before">
                        <?php if($logined):?>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown" id="dropdown-toggle"><a class="dropdown-toggle" href="javascript:void(0)">
                                    <?php echo $user['username']; ?><strong class="caret"></strong></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/company/account">商家中心</a> </li>
                                        <li><a href="/auth/logout">退出</a></li>
                                    </ul>
                                </li>
                            </ul>
                        <?php else: ?>
                            <div class="nav navbar-nav navbar-right" style="margin-top:10px;margin-left:0px;">
                                <a class="btn btn-default theme-login" href="javascript:void(0)">登录</a>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </nav>
        <?php echo $layout_content;?>

</body>
<script type="text/javascript">
    $(function(){
        $('.theme-login').click(function(){
            $('.theme-popover-mask').fadeIn(500);
            $('.theme-popover').slideDown(200);
        });
        $('.theme-poptit .close').click(function(){
            $('.theme-popover-mask').fadeOut(500);
            $('.theme-popover').slideUp(200);
        });
        $('.comment').click(function(){

            $('.theme-popover-mask').fadeIn(500);
            $('#myModal').slideDown(200);
        });
        $('#myModal .close').click(function(){
            $('.theme-popover-mask').fadeOut(500);
            $('#myModal').slideUp(200);
        });

        $('#register_index').click(function(){
            var account=$('#inputEmail').val();
            var password = $('#password_email').val();
            var re_password = $('#re_password').val();
            $.ajax({
                url:'/auth/register/do_register',
                type:'post',
                data:{email:account,password:password,re_password:re_password},
                dataType:'json',
                success:function(json){
                    if(json.status==true){
                        alert('注册成功');
                        window.location.href="/auth/register/send_email_after";
                    }else{
                        alert('注册失败');
                    }
                }
            })
        });
    });
</script>
</html>
<div class="theme-popover">
    <div class="theme-poptit" style=";height:40px;">
        <a href="javascript:void(0);" title="关闭" class="close" style="margin-right:7px;margin-top:7px;">×</a>
    </div>
    <div class="theme-popbod dform">
        <form class="form-horizontal" role="form">
            <div class="form-group" style="margin-top:0px;">
                <label for="account" class="ztsdl control-label">用户名</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="account" name="account" placeholder="请输入你的用户名">
                </div>
            </div>
            <div class="form-group " style="margin-top:0px;">
                <label for="password" class="ztsdl control-label">密码</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" id="password" name="password" placeholder="请输入你的密码">
                </div>
            </div>
            <div class="show_error"></div>
            <input class="btn btn-primary"
                   type="button" name="submit"
                   id="login_header"
                   style="background:#32465D; color: white; padding: 6px 15px;margin-left:auto;"
                   value=" 登 录 " />
        </form>
    </div>
</div>