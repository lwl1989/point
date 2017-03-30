<!DOCTYPE html>
<html lang="en">
<head>
    <!--
        Charisma v1.0.0

        Copyright 2012 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
    -->
    <meta charset="utf-8">
    <title>欢迎您登录学霸网管理平台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
    <meta name="author" content="Muhammad Usman">

    <!-- The styles -->
    <link id="bs-css" base-url="<?php echo $static;?>" href="<?php echo $static;?>css/bootstrap-cerulean.css" rel="stylesheet">
    <style type="text/css">
        body {
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }
    </style>
    <link href="<?php echo $static;?>css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php echo $static;?>css/charisma-app.css" rel="stylesheet">
    <link href="<?php echo $static;?>css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
    <link href='<?php echo $static;?>css/fullcalendar.css' rel='stylesheet'>
    <link href='<?php echo $static;?>css/fullcalendar.print.css' rel='stylesheet'  media='print'>
    <link href='<?php echo $static;?>css/chosen.css' rel='stylesheet'>
    <link href='<?php echo $static;?>css/uniform.default.css' rel='stylesheet'>
    <link href='<?php echo $static;?>css/colorbox.css' rel='stylesheet'>
    <link href='<?php echo $static;?>css/jquery.cleditor.css' rel='stylesheet'>
    <link href='<?php echo $static;?>css/jquery.noty.css' rel='stylesheet'>
    <link href='<?php echo $static;?>css/noty_theme_default.css' rel='stylesheet'>
    <link href='<?php echo $static;?>css/elfinder.min.css' rel='stylesheet'>
    <link href='<?php echo $static;?>css/elfinder.theme.css' rel='stylesheet'>
    <link href='<?php echo $static;?>css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='<?php echo $static;?>css/opa-icons.css' rel='stylesheet'>
    <link href='<?php echo $static;?>css/uploadify.css' rel='stylesheet'>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="<?php echo $static;?>img/favicon.ico">

</head>

<body>
<div class="container-fluid">
    <div class="row-fluid">

        <div class="row-fluid">
            <div class="span12 center login-header">
                <h2>欢迎您登录学霸银行管理平台</h2>
            </div><!--/span-->
        </div><!--/row-->

        <div class="row-fluid">
            <div class="well span5 center login-box">
                <div id="loginMsg" class="alert alert-info">
                    请输入邮箱和密码登录.
                </div>
                <form id="loginForm" class="form-horizontal" action="<?php echo site_url('m-site/login/do_login')?>" method="post"
                    onsubmit="return false;">
                    <fieldset>
                        <div class="input-prepend" title="邮箱" data-rel="tooltip">
                            <span class="add-on"><i class="icon-user"></i></span><input autofocus class="input-large span10" name="email" id="email" type="text" value="" />
                        </div>
                        <div class="clearfix"></div>

                        <div class="input-prepend" title="密码" data-rel="tooltip">
                            <span class="add-on"><i class="icon-lock"></i></span><input class="input-large span10" name="password" id="password" type="password" value="" />
                        </div>
                        <div class="clearfix"></div>

                        <p class="center span5">
                            <button type="submit" id="loginSubmit" class="btn btn-primary">登录</button>
                        </p>
                    </fieldset>
                </form>
            </div><!--/span-->
        </div><!--/row-->
    </div><!--/fluid-row-->

</div><!--/.fluid-container-->

<!-- external javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<!-- jQuery -->
<script src="<?php echo $static;?>js/jquery-1.7.2.min.js"></script>
<!-- jQuery UI -->
<script src="<?php echo $static;?>js/jquery-ui-1.8.21.custom.min.js"></script>
<!-- transition / effect library -->
<script src="<?php echo $static;?>js/bootstrap-transition.js"></script>
<!-- alert enhancer library -->
<script src="<?php echo $static;?>js/bootstrap-alert.js"></script>
<!-- modal / dialog library -->
<script src="<?php echo $static;?>js/bootstrap-modal.js"></script>
<!-- custom dropdown library -->
<script src="<?php echo $static;?>js/bootstrap-dropdown.js"></script>
<!-- scrolspy library -->
<script src="<?php echo $static;?>js/bootstrap-scrollspy.js"></script>
<!-- library for creating tabs -->
<script src="<?php echo $static;?>js/bootstrap-tab.js"></script>
<!-- library for advanced tooltip -->
<script src="<?php echo $static;?>js/bootstrap-tooltip.js"></script>
<!-- popover effect library -->
<script src="<?php echo $static;?>js/bootstrap-popover.js"></script>
<!-- button enhancer library -->
<script src="<?php echo $static;?>js/bootstrap-button.js"></script>
<!-- accordion library (optional, not used in demo) -->
<script src="<?php echo $static;?>js/bootstrap-collapse.js"></script>
<!-- carousel slideshow library (optional, not used in demo) -->
<script src="<?php echo $static;?>js/bootstrap-carousel.js"></script>
<!-- autocomplete library -->
<script src="<?php echo $static;?>js/bootstrap-typeahead.js"></script>
<!-- tour library -->
<script src="<?php echo $static;?>js/bootstrap-tour.js"></script>
<!-- library for cookie management -->
<script src="<?php echo $static;?>js/jquery.cookie.js"></script>
<!-- calander plugin -->
<script src='<?php echo $static;?>js/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='<?php echo $static;?>js/jquery.dataTables.min.js'></script>

<!-- chart libraries start -->
<script src="<?php echo $static;?>js/excanvas.js"></script>
<script src="<?php echo $static;?>js/jquery.flot.min.js"></script>
<script src="<?php echo $static;?>js/jquery.flot.pie.min.js"></script>
<script src="<?php echo $static;?>js/jquery.flot.stack.js"></script>
<script src="<?php echo $static;?>js/jquery.flot.resize.min.js"></script>
<!-- chart libraries end -->

<!-- select or dropdown enhancer -->
<script src="<?php echo $static;?>js/jquery.chosen.min.js"></script>
<!-- checkbox, radio, and file input styler -->
<script src="<?php echo $static;?>js/jquery.uniform.min.js"></script>
<!-- plugin for gallery image view -->
<script src="<?php echo $static;?>js/jquery.colorbox.min.js"></script>
<!-- rich text editor library -->
<script src="<?php echo $static;?>js/jquery.cleditor.min.js"></script>
<!-- notification plugin -->
<script src="<?php echo $static;?>js/jquery.noty.js"></script>
<!-- file manager library -->
<script src="<?php echo $static;?>js/jquery.elfinder.min.js"></script>
<!-- star rating plugin -->
<script src="<?php echo $static;?>js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="<?php echo $static;?>js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="<?php echo $static;?>js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="<?php echo $static;?>js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="<?php echo $static;?>js/jquery.history.js"></script>
<script src="<?php echo $static;?>js/jquery.form.min.js"></script>
<!-- application script for Charisma demo -->
<script src="<?php echo $static;?>js/charisma.js"></script>


</body>
</html>

<script type="text/javascript">
    $(document).ready(function() {
        $('#loginSubmit').click(function() {
            var btn = $(this);
            btn.prop('disabled', true)

            var email = $.trim($('#email').val());
            var password = $.trim($('#password').val());

            if (email == '') {
                $('#loginMsg').attr('class', 'alert alert-error');
                $('#loginMsg').html('请输入邮箱');
                btn.prop('disabled', false);
                return false;
            }
            if (password == '') {
                $('#loginMsg').attr('class', 'alert alert-error');
                $('#loginMsg').html('请输入密码');
                btn.prop('disabled', false);
                return false;
            }

            var options = {
                dataType: 'json',
                success: function(response) {
                    if(response.status) {

                        btn.val("登录成功")
                        window.location = '<?php echo site_url('m-site');?>';

                    } else {
                        var msg = response.msg;
                        var errorMsg;

                        if (msg.email) {
                            errorMsg = msg.email;

                        }

                        if (msg.password) {
                            errorMsg = msg.password;

                        }
                        if (msg.login) {
                            errorMsg = msg.login;
                        }

                        if (typeof response.msg == 'string') {
                            errorMsg = response.msg;
                        }

                        $('#loginMsg').attr('class', 'alert alert-error');
                        $('#loginMsg').html(errorMsg);
                    }
                    btn.prop('disabled', false);
                }
            };
            $('#loginForm').ajaxSubmit( options );
            return false;
        });
    });
</script>
