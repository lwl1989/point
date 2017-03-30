<script type="text/javascript">
    $(function(){
        $(".table-hover tbody tr").mouseover(function(){
            $(this).find(".dropdown").css("display","block");
        }).mouseout(function(){
            $(this).find(".dropdown").css("display","none");
        });
        $('a[data-toggle="tab"]').on('show.bs.tab',function(e){
            if($(this).attr("href")=="#panel-1"){
                $(".tabbable .new-collect").css("display","block");
            }else{
                $(".tabbable .new-collect").css("display","none");
            }
        });
    });
</script>
<style>
    .table{border-bottom:solid 1px #ccc;}
    .table-hover > tbody > tr:hover{background-color: #D9EEF4;}
    .dropdown{display:none;}
    .tabbable .total-num,.tabbable .new-collect{float:right;}
    .tabbable .total-num a,.tabbable .total-num a:hover,.tabbable .total-num a:active,.tabbable .total-num a:visited{
        background:transparent;border:solid 2px #32465D;padding-top:2px;padding-bottom:2px;border:solid 2px #32465D;
        border-radius:5px;margin-top:7px;margin-left:10px;}
    .tabbable .new-collect a,.tabbable .new-collect a:hover,.tabbable .new-collect a:active,.tabbable .new-collect a:visited{
        background:#32465D;padding-top:3px;padding-bottom:3px;border-radius:5px;margin-top:7px;}
</style>
<script src="<?php echo base_url()?>static/public/js/tab.js"></script>
<script src="<?php echo base_url() ?>static/lib/raty/js/jquery.raty.min.js"></script>
<div class="row" style="margin-top:100px;">
    <?php require($views_path . 'public/user_leftmenu.php');?>
    <div class="col-md-9">
        <div class="colmdbtl rightTitle yj" style="right:40px;left:40px;">我的文档</div>
            <div class="row">
        <?php require($views_path . 'public/count_info.php');?>
            <div class="col-md-12">
                <div class="tabbable" id="tabs-445084">
                    <ul class="nav nav-tabs">
                        <li  ><a href="/user/document" style="color:#32465D;font-weight:bolder;">我上传的</a></li>
                        <li><a href="/user/document/like"  style="color:#32465D;font-weight:bolder;">我收藏的</a></li>
                        <li class="active"><a href="/user/document/down"  style="color:#32465D;font-weight:bolder;">我下载的</a></li>
                        <li class="total-num right"><a class="btn btn-default">总数：<?php echo $count_document['total'];?>篇</a></li>
                    </ul>

                    <div class="tab-content" style="margin-top:37px;">
                        <div class="tab-pane active" id="panel-1">
                            <!-- 我上传的选项卡内容 -->
                            <table class="table table-hover" style="border-top: solid 3px #32465D;">
                                <thead>
                                <tr>
                                    <th>文档名称
                                    </th>
                                    <th style="width:35px;">&nbsp;</th>
                                    <th>文档大小</th>
                                    <th>评分</th>
                                    <th>评价数</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach($pagination['list'] as $file): ?>
                                    <tr>
                                        <td><a href="/file/<?php echo $file['document']['id'];?>"> <?php echo $file['document']['title'] ?></a></td>
                                        <td style="width:35px;">&nbsp;</td>
                                        <td><?php echo $file['document']['file_size'] ?>K</td>
                                        <td><div id="score_document_<?php echo $file['document']['id'];?>"
                                                 data-num="5" class="score_document"></div>
                                            </td>
                                        <script>
                                            $('div#score_document_<?php echo $file['document']['id'];?>').raty({
                                                start: '<?php echo $file['document']['score']; ?>',
                                                showHalf: true,
                                                readOnly: true
                                            });
                                        </script>
                                        <td>&nbsp;<?php echo $file['document']['score_num'];?>人评</td>
                                    </tr>
                                <?php endforeach ?>
                                </tbody>
                            </table>
                        </div><!-- 我下载的选项卡内容 -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-offset-3 col-sm-6" style="text-align: center;">
                <?php echo $pagination['page_html'];?>
            </div>
        </div>
    </div>
</div>