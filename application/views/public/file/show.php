
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>FlexPaper</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css" media="screen">
        html, body	{ height:100%; }
        body { margin:0; padding:0; overflow:auto; }
        #flashContent { display:none; }
    </style>
    <script src="<?php echo base_url() ?>static/js/jquery-2.1.3.min.js"></script>
    <script src="<?php echo base_url() ?>static/flex/js/flexpaper_flash.js"></script>
</head>
<body>
<body >
<div style="position:absolute;top:200px;left:80%; ">
    <a href="javascript:void(0);" id="do_print">我要打印</a>
</div>
<div style="width: 100%; height: 100%; clear: both;display: none;" id="div_to_print">
    <input type="hidden" value="<?php echo($file['id'])?>" id="file_id"/>
    <p><?php echo($file['title']);?></p>
    <input type="text" value="" id="file_num"/>
    <input type="button" value="我要下单" id="add_print_list"/>
</div>
<div style="position:absolute;left:10px;top:60px;min-width:800px;">
    <p id="viewerPlaceHolder" style="width:800px;height:553px;display:block">Document loading..</p>

    <script type="text/javascript">

        var fp = new FlexPaperViewer(
             '<?php echo base_url() ?>static/flex/FlexPaperViewer',
             'viewerPlaceHolder', { config : {
                 SwfFile : escape('<?php echo site_url('public/file/view').'/'.$file['id'];?>'),
                 Scale : 1,
                 ZoomTransition : 'easeOut',
                 ZoomTime : 0.5,
                 ZoomInterval : 0.2,
                 FitPageOnLoad : false,
                 FitWidthOnLoad : true,
                 PrintEnabled : true,
                 FullScreenAsMaxWindow : false,
                 ProgressiveLoading : false,
                 MinZoomSize : 0.2,
                 MaxZoomSize : 5,
                 SearchMatchAll : false,
                 InitViewMode : 'Portrait',

                 ViewModeToolsVisible : true,
                 ZoomToolsVisible : true,
                 NavToolsVisible : true,
                 CursorToolsVisible : true,
                 SearchToolsVisible : true,

                 localeChain: 'en_US'
             }});

        function onDocumentLoadedError(errMessage){
            $('#viewerPlaceHolder').html("文件暂时无法预览");
        }
    </script>


<script>
    $(document).ready(function(){
        $('#do_print').click(function(){
            $("#div_to_print").show();

        })
        $("#add_print_list").click(function(){
            var file_id = $('#file_id').val();
            var file_num = $('#file_num').val();
            $.ajax({
             'url':'<?php echo site_url('public/file/do_change_cart')?>',
             'dataType':'json',
             'data':{file_id:file_id,file_num:file_num},
             'type':'post',
             'success':function(data){
                 if(data.status==9){
                     alert('请登录');
                     window.location.href = '<?php echo site_url("auth/login") ?>';
                 }else if(data.status==false){
                    alert("加入打印序列失败");
                 }else{
                     alert("成功加入打印序列");
                 }
             },
             'error':function(){

             }
             });
        });
    });

</script>
</body>
</html>

