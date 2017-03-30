<hr>

<footer>
    <p class="pull-left">&copy; <a href="#" target="_blank"></a> 2013</p>
    <p class="pull-right"><!--Powered by: <a href="#"></a>--></p>
</footer>

</div><!--/.fluid-container-->

<!-- external javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

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
<!-- plugin for gallery image view-->
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
<!--<script src="<?php /*echo $static;*/?>js/jquery.uploadify-3.1.min.js"></script>-->
<!-- history.js for cross-browser state change on ajax -->
<script src="<?php echo $static;?>js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="<?php echo $static;?>js/charisma.js"></script>
<!--表单异步提交-->
<script src="<?php echo $static;?>js/jquery.form.min.js"></script>

<script src="<?php echo $static;?>js/common.js"></script>


<script type="text/javascript">
    var current_channel = null;
    var view_channel = new Array();

    function change_channel(channel)
    {
        if (channel == current_channel) {
            return false;
        }
        $('.main-nav').children('li').removeClass('active');
       $('#channel_' + current_channel).removeClass('active');
        $('#channel_' + channel).addClass('active');

        $('#channel_' + current_channel + '_menus').css('display', 'none');
        $('#channel_' + channel + '_menus').css('display', '');

        var tmp_menu_list = $('#channel_' + channel + '_menus').find('a');

        tmp_menu_list.each(function (i, n) {
            if (i == 0) {
                $(n).click();
            }
        });


        current_channel = channel;
    }

    $(document).ready(function () {
           change_channel('<?php echo @$index_channel;?>');
    });

    function error_msg_show(alert_id, msg)
    {
        alert_show(alert_id, 'error', msg);
    }

    function success_msg_show(alert_id, msg)
    {
        alert_show(alert_id, 'success', msg);
    }

    function alert_show(alert_id, type, msg)
    {
        var alert_div = $('#' + alert_id);
        alert_div.attr('class', 'alert alert-' + type);
        alert_div.find('p').html(msg);
        alert_div.show();
    }

    function alert_hide(alert_id)
    {
        var alert_div = $('#' + alert_id);
        alert_div.hide();
    }

    function refresh_cache(url)
    {
        $.post(
            url,
            {},
            function(response){
                if(response.status) {
                    alert('缓存文件已更新');
                }else {
                    alert('操作失败，请重试或联系管理员！');
                }
            },
            'json');
    }
</script>
</body>
</html>