<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $head_title?> 学霸银行</title>
    <meta charset="UTF-8">

    <meta name="keywords" content="学霸银行"/>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <link rel="shortcut icon" href="<?php echo base_url() ?>static/img/favicon.ico">

    <?php
    //样式加载
    if ($css_load) {
        echo load_css_files($css_load);
    }
    ?>
    <link href="/static/public/css/menu.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/static/lib/jquery-2.1.3.min.js"></script>
    <script src="/static/lib/jquery.form.min.js"></script>
    <script src="/static/lib/jquery.json.min.js"></script>
    <script src="/static/lib/jquery.validate.min.js"></script>
    <script src="/static/lib/base.js"></script>
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
                <div class="navbar-header" style="height: 61px;">
                    <button class="navbar-toggle" type="button" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">切换导航</span><span class="icon-bar"></span><span
                            class="icon-bar"></span><span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">
                        <img src="/static/public/images/logo.png"/>
                    </a>
                </div>
                <?php if($logined){ ?>
                <div class="collapse navbar-collapse"
                     id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown" id="dropdown-toggle"><a class="dropdown-toggle" href="javascript:void(0)"
                                ><?php echo $user['nickname']?$user['nickname']:$user['username']; ?><strong class="caret"></strong></a>
                            <ul class="dropdown-menu">
                                <li><a href="/user/account">个人中心</a> </li>
                                <li><a href="/auth/logout">退出</a></li>
                            </ul>
                        </li>
                        <li><a class="btn btn-primary btn-sm" href="/upload"
                               style="background:#32465D;color:white;padding:6px 15px;margin-top:10px;">上传文档</a></li>
                    </ul>

                    <form class="navbar-form navbar-right" role="search" action="/search" method="post" id="search_form" style="margin-top:10px;">
                        <div class="form-group">
                            <input class="form-control" type="text" id="keyword" style="width: 300px;"/>
                        </div>
                        <button class="btn btn-default" type="button" id="search_button">搜索</button>
                    </form>
                </div>
            </div>
            <?php }else{ ?>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <div class="login_before">
                        <div class="nav navbar-nav navbar-right" style="margin-left:20px;margin-top:14px;">
                            <a class="btn btn-default" href="<?php echo site_url('auth/register')?>">注册</a>
                        </div>
                        <div class="nav navbar-nav navbar-right" style="margin-left:20px;margin-top:14px;">
                            <a class="btn btn-default theme-login" href="javascript:void();">登录</a>
                        </div>
                    </div>
                    <form class="navbar-form navbar-right" role="search" action="/search" method="post" id="search_form" style="height: 61px; line-height: 61px;margin:0;padding: 0;">
                            <input class="form-control" type="text" id="keyword" style="width: 300px;"/>
                        <button class="btn btn-default" type="button" id="search_button">搜索</button>
                    </form>
                </div>
            </div>
    <?php }?>
        </nav>
    </div>
<?php echo $layout_content;?>
<!-- content ends -->

</div>

<?php require_once($views_path . "public/foot.php"); ?>
<script type="text/javascript">
    $(function(){
        $('.theme-login').click(function(){
            $('.theme-popover-mask').fadeIn(500);
            $('.theme-popover').slideDown(200);
        })
        $('.theme-poptit .close').click(function(){
            $('.theme-popover-mask').fadeOut(500);
            $('.theme-popover').slideUp(200);
        })
        $('.comment').click(function(){

            $('.theme-popover-mask').fadeIn(500);
            $('#myModal').slideDown(200);
        })
        $('#myModal .close').click(function(){
            $('.theme-popover-mask').fadeOut(500);
            $('#myModal').slideUp(200);
        })
        $('#login_header').click(function(){
            var account=$('#account').val();
            var password = $('#password').val();
            $.ajax({
                url:'/auth/login/do_login',
                type:'post',
                data:{account:account,password:password},
                dataType:'json',
                success:function(json){
                    if(json.status==true){
                       // window.local.href=json.data.url;
                        $('#bs-example-navbar-collapse-1 .login_before').html('');
                        str =' <ul class="nav navbar-nav navbar-right">'+
                        '<li class="dropdown" id="dropdown-toggle"><a class="dropdown-toggle" href="<?php echo site_url('user/account')?>" >'+json.msg+'<strong class="caret"></strong></a>'+
                        '<ul class="dropdown-menu">'+
                        '<li><a href="<?php echo site_url('auth/logout')?>">退出</a></li>'+
                        '</ul></li> <li><a class="btn btn-primary btn-sm" href="/upload" style="background:#32465D;color:white;padding:6px 15px;margin-top:10px;">上传文档</a></li> </ul>';
                        $('#bs-example-navbar-collapse-1 .login_before').html(str);
                        $('.theme-popover-mask').fadeOut(500);
                        $('#myModal').slideUp(200);
                        $('.theme-popover-mask').fadeOut(500);
                        $('.theme-popover').slideUp(200);
                    }else{
                        $('.show_error').removeClass('hide');
                        $('.show_error').html(json.msg);
                        $('.show_error').fadeOut(3000);
                    }
                }
            })
        });
    });
</script>
<div class="theme-popover">
    <div class="theme-poptit" style="height:40px;">
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
            <!-- <div class="form-group">
                 <label class="ztsdl control-label" for="inputVerificationCode">验证码</label>
                 <div class="col-sm-4">
                     <input class="form-control" placeholder="请输入验证码" id="inputVerificationCode" type="text" />
                     <span class="glyphicon  form-control-feedback"></span>
                 </div>
                 <div class="col-sm-4">
                     <a>获取验证码</a>
                 </div>
             </div>-->
            <input class="btn btn-primary"
                   type="button" name="submit"
                   id="login_header"
                   style="background:#32465D; color: white; padding: 6px 15px;margin-left:auto;"
                   value=" 登 录 " />
        </form>
    </div>
</div>
</body>
</html>