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
                        <li class="active" ><a href="/user/document" style="color:#32465D;font-weight:bolder;">我上传的</a></li>
                        <li><a href="/user/document/like"  style="color:#32465D;font-weight:bolder;">我收藏的</a></li>
                        <li><a href="/user/document/down"  style="color:#32465D;font-weight:bolder;">我下载的</a></li>
                        <li class="total-num right"><a class="btn btn-default">总数：<?php echo $count_document['total'];?>篇</a></li>
                        <li class="new-collect"><a class="btn btn-primary" href="#">新建文集</a></li>
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
                                    <th>评价</th>
                                    <th>上传时间</th>
                                    <th>下载量</th>
                                    <th>打印量</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($file_list as $file): ?>
                                    <tr>
                                        <td><?php echo $file['title'] ?></td>
                                        <td>
                                            <div class="dropdown" style="display: none;">
                                                <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                                    <img alt="" src="/static/public/images/dropdown.png"/></a>
                                                <ul class="dropdown-menu dropdown-menu2">
                                                    <li><a href="javascript:void(0);" onclick="do_print(<?php echo $file['id'] ?>)">打印</a></li>
                                                    <li><a href="/down/<?php echo $file['id'] ?>">下载</a></li>
                                                    <li><a href="javascript:void(0);" onclick="user_del_document(<?php echo $file['id'] ?>,this)">删除</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td><?php echo $file['file_size'] ?>K</td>
                                        <td><div id="score_document_<?php echo $file['id'];?>" data-num="5" style="cursor:pointer"></div>
                                            <?php echo $file['score_num'];?>人评</td>
                                        <script>
                                            $('div#score_document_<?php echo $file['id'];?>').raty({
                                                hints: ['1', '2', '3', '4', '5'],
                                                start: '<?php echo $file['score']; ?>',
                                                showHalf: true,
                                                readOnly: true,
                                            });
                                        </script>
                                        <td><?php echo $file['upload_time'] ?></td>
                                        <td><?php echo $file['download_count'] ?></td>
                                        <td><?php echo $file['print_count'] ?></td>
                                        <!--    <td colspan="2"
                                            style="color: red; text-align: center; font-weight: bolder;">待审核</td>
                                        <td><?php echo $file['title'] ?></td>
                                        <td><?php echo $file['like'] ?></td>
                                        <td><?php echo $file['collect'] ?></td>
                                        <td><a href="del/<?php echo $file['id'] ?>"  >删除</a> </td>-->
                                    </tr>
                                <?php endforeach ?>
                                </tbody>
                            </table>
                            </div><!-- 我下载的选项卡内容 -->
                        </div>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-sm-offset-3 col-sm-6" style="text-align: center;">
                <?php echo $pagination;?>
            </div>
        </div>
    </div>
</div>
<!--
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta http-equiv="content-type" content="text/html;charset=utf-8">
<table>
    <tr>
        <th>文件名</th>
        <th>点赞数</th>
        <th>收藏数</th>
        <th>操作</th>
    </tr>
    <?php foreach($file_list as $file): ?>
    <tr>
        <td><?php echo $file['title'] ?></td>
        <td><?php echo $file['like'] ?></td>
        <td><?php echo $file['collect'] ?></td>
        <td><a href="del/<?php echo $file['id'] ?>"  >删除</a> </td>
    </tr>
    <?php endforeach ?>
</table>
-->