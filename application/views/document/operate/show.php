
<script src="/static/lib/flex/js/flexpaper_flash.js"></script>
<script src="/static/public/js/tab.js"></script>
<style type="text/css">
    .navbar-default {background:white;}
    .navbar-brand {padding-top:5px;}
    .navbar-default .navbar-nav>li>a, .btn-default, .radio label, .checkbox label{color: #32465D;font-weight: bolder;font-size: 16px;}
    .btn {font-weight: bolder;font-size:16px;}
    /* 最大宽度为768px时，里面的样式生效；即宽度小于768px时，里面的样式生效 */
    @media(max-width:768px){
        .mediaPaddingLeft{
            padding-left:10px;
        }
    }
    .mediaPaddingLeft a{color:#32465D;font-weight:bolder;font-size:16px;margin:15px 0 0 10px;display:inline-block;}
    .leftTitle,.rightTitle{background:#32465D;font-weight: bolder;font-size: 20px;color:white;height:56px;line-height:56px;}.leftTitle,.rightTitle{background:#32465D;font-size: 18px;color:white;height:50px;line-height:50px;vertical-align:middle;text-align:center;font-family:微软雅黑;}
    .leftTitle{text-align:center;}
    .rightTitle{text-align:left;}
    .left-mid{width:33.33%;float:left;border-right:dotted 1px #ccc;}
    .left-mid:last-child{border-right:none;}
    .left-mid div{text-align:center;white-space:nowrap;}
    .num{color:#9A5C33;font-size:30px;}
    .content{font-weight:bolder;}
    .list-group .boderBottom{border-top:none;border-right:none; border-bottom:solid 1px #ccc;border-left:none;margin-bottom:0px;font-size:16px;
        padding-top:0px;padding-bottom:0px;height:74px;line-height:74px;}


    .navbar-default {background:white;}
    .navbar-brand {padding-top:5px;}
    .navbar-default .navbar-nav>li>a, .btn-default, .radio label, .checkbox label{color: #32465D;font-weight: bolder;font-size: 16px;}
    .btn {font-weight: bolder;font-size:16px;}
    .right_top{height:80px;border:solid 2px #32465D;border-radius:20px;text-align:center;color:#14A7CC;font-weight:bolder;
        font-size:14px;margin:20px 10px;}
    .right_top .num{font-size: 14px;color: #32465D;}
    .right_top div{height:32px;line-height:32px;}
    .right_bottom{height: 85px;border:solid 2px #14A7CC;}
    .leftFloat{width:33.33%;float:left;padding:0px;}
    /* 最大宽度为768px时，里面的样式生效；即宽度小于768px时，里面的样式生效 */
    @media(max-width:768px){
        .mediaPaddingLeft{
            padding-left:10px;
        }
    }
    .mediaPaddingLeft a{color:#32465D;font-weight:bolder;font-size:16px;margin:15px 0 0 10px;display:inline-block;}
    .right_bottom .row{margin-left:0;margin-right:0;}
    .idInfo .col-md-3{text-align:center;padding:0;}
    .idInfo .col-md-9 div{text-align:left;padding:0;color:#32465d;font-weight:bolder;font-size:14px;}
    .idInfo .col-md-9 .col-md-12{height:42px;line-height:42px;}
    #myModal{
        z-index:9999;
        position:fixed;
        top:30%;
        left:30%;
        display:none;
    }
</style>
<div class="col-md-12">
    <div class="colmd8">
        <div class="colmd12"  style="margin-top:80px;">
            <form class="bs-example bs-example-form" role="form">
                <div class="input-group input-group-lg" style="font-weight:bolder;">
                    <span class="input-group-addon" style="background-color:white;border-color:#32465D;">
                        <span class="glyphicon glyphicon-file"></span>
                    </span>
                    <input type="text" class="form-control" value="<?php echo($file['title']);?>" readonly="readonly" style="color:#32465D;background-color:white;border-left:none;border-color:#32465D;">
                    <input type="hidden" value="<?php echo($file['id'])?>" id="file_id"/>
                </div>
            </form>
        </div>
        <div class="colmd12" style="margin-top:30px;color:#32465D;font-weight:bolder;">
            <div class="form-control" style="border-color:#32465D;height:120px;">
                <div class="col-md-5">文库>公共课>计算机</div>
                <div class="text-right">
                    <img src="/static/public/images/收藏前的星星.gif"/>
                    <button  class="btn btn-default" onclick="do_collect(<?php echo($file['id'])?>,1,this);">收藏</button>
                </div>
                <div class="col-md-8">
                    <span>评分：</span>
                    <div id="score_show_ready" style="display: inline;"></div>
                    <span>（136人评论）</span>
                </div><br/>
                <div class="col-md-6" style="margin-top:20px;">
                    <span>吸引读者: </span>
                    <span><?php echo $file['views_count'];?>人阅读 </span>
                    <span><?php echo $file['download_count'];?>次下载 </span>
                    <span><?php echo $file['print_count'];?>次打印 </span>
                </div>
                <div class="text-right">
                    <button class="btn btn-default">举报文档</button>
                </div>
            </div>
        </div>
        <div class="colmd12" style="margin-top:30px">
            <p id="viewerPlaceHolder" style="width:800px;height:800px;">
            </p>
        </div>
    </div>
    <?php require_once($views_path . "public/site_user_info.php"); ?>
</div>
<!--
<div class="row">
    <div class="col-lg-4">
    <div style="position:absolute;top:200px;">
        <a href="javascript:void(0);" id="do_print">我要打印</a>
    </div>
    <div style="width: 100%; height: 100%; clear: both;display: none;margin-top: 200px;" id="div_to_print">
        <input type="hidden" value="<?php echo($file['id'])?>" id="file_id"/>
        <p><?php echo($file['title']);?></p>
        <input type="text" value="" id="file_num"/>
        <input type="button" value="我要下单" id="add_print_list"/>
    </div>
    <div>文档评分：
        <div id="score_show"  data-num="5" style="position:absolute;top:250px;">
        </div>
    </div>

    </div>
    <div class="col-lg-8">
        <div style="position:absolute;left:10px;top:60px;min-width:800px;">
            <p id="viewerPlaceHolder" style="width:800px;height:553px;display:block">Document loading..</p>
        </div>
    </div>
</div>
-->


    <script type="text/javascript">
        var fp = new FlexPaperViewer(
             '/static/lib/flex/FlexPaperViewer',
             'viewerPlaceHolder', { config : {
                 SwfFile : escape('<?php echo site_url('document/operate/view').'/'.$file['id'];?>'),
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
        $("#download_file").click(function(){
            var file_id = $('#file_id').val();
            window.location.open='/document/operate/down/'+file_id;
        });

        $("#add_print_list").click(function(){
            var file_id = $('#file_id').val();
            var file_num = $('#file_num').val();
            $.ajax({
             'url':'/public/cart/do_change_cart',
             'dataType':'json',
             'data':{file_id:file_id,file_num:file_num},
             'type':'post',
             'success':function(data){
                 if(data.status==9){
                     alert('请登录');
                     window.location.href = '/auth/login';
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


