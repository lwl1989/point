<?php if($logined): ?>
<div class="col-md-4 " style="height: 440px;margin-top:60px;">
    <div class="row right_top"style="margin-left:30px;margin-right:30px;">
        <div class="row" style="border-bottom:solid 1px #CCC;margin:0 0;">
            <div class="col-md-11">学霸银行储户及存款情况</div>
        </div>
        <div class="row">
            <div class="col-md-4 leftFloat">
                <div class="col-md-11 num"style="margin-top:-2px;"><?php echo $count_message['document_count'];?></div>
                <div class="col-md-11"style="margin-top:-12px;">文档</div>
            </div>
            <div class="col-md-4 leftFloat">
                <div class="col-md-11 num"style="margin-top:-2px;"><?php echo $count_message['user_num'];?></div>
                <div class="col-md-11"style="margin-top:-12px;">用户</div>
            </div>
            <div class="col-md-4 leftFloat">
                <div class="col-md-11 num"style="margin-top:-2px;"><?php echo intval($count_message['deposit_total'])?></div>
                <div class="col-md-11"style="margin-top:-12px;">存款</div>
            </div>
        </div>
    </div>
    <div class="row right_bottom">
        <div class="row idInfo">
            <div class="col-md-3" style="width:25%;float:left;">
                <img class="img-circle" alt="" src="<?php echo user_avatar($user_id);?>" style="width:70px;height:70px;margin-top:7px;border:solid 4px #CCC;"/>
            </div>
            <div class="col-md-9" style="width:75%;float:left;">
                <div class="col-md-12" style="border-bottom:dotted 2px #14A7CC;width:100%;float:left;">账号：<?php echo $user['username'];?></div>
                <div class="col-md-12" style="width:100%;float:left;">
                    <div class="col-md-6" style="width:50%;float:left;">昵称：<?php echo $user['nickname'];?></div><div class="col-md-6" style="width:50%;float:left;">河北工业大学</div>
                </div>
            </div>
        </div>
    </div>
    <div class="tabbable" id="tabs-445084">
        <ul class="nav nav-tabs"style="margin-top:30px;">
            <li class="active"><a href="#panel-1" data-toggle="tab" style="color:#32465D;font-weight:bolder;">写评论</a></li>
            <li><a href="#panel-2" data-toggle="tab" style="color:#32465D;font-weight:bolder;">评论列表</a></li>
        </ul>
        <div class="tab-content" style="margin-top:37px;">
            <div class="tab-pane active" id="panel-1">
                <!-- 评论输入框 -->
                <textarea rows="6" id="comment_document_textarea" class="form-control" style="width:380px;resize:none;"></textarea>
            </div>
            <div class="tab-pane" id="panel-2">
                <!-- 评论列表 -->
                <table class="table table-hover" style="border-top: solid 3px #32465D;">
                    <thead>
                    <tr>
                        <th><label class="col-md-10 checkbox-inline"
                                   style="font-weight: bolder;"> <input
                                    type="checkbox" value="">主题
                            </label></th>
                        <th>时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($comments['list'] as $val): ?>
                        <tr>
                            <td><label class="checkbox-inline"><input
                                        type="checkbox" value=""><?php echo $val['content'];?>
                                </label></td>
                            <td><?php echo $val['comment_time'];?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-12" style="text-align: center;">
                       <?php echo $comments['page_html'];?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-8" style="margin-top:30px;min-width: 200px;" id="score_show">
        </div>
        <div class="col-md-4 ">
            <button  class="btn btn-default" style="margin-top:20px;" id="comment_document">评论文档</button>
        </div>
    </div>
    <div class="colmd12" style="margin-top:30px;">
        <button  class="col-md-4 btn btn-default" style="width:100px;background-color:#32465D;color:white;height:35px;" id="download_file">下载</button>
        <button  class="col-md-4 btn btn-default" style="width:110px;margin-left:20px;background-color:#32465D;color:white;height:35px;" id="add_print_list">添加到书单</button>
        <button  class="col-md-4 btn btn-default" style="width:100px;margin-left:20px;background-color:#32465D;color:white;height:35px;">打印</button>
    </div>

</div>
    <script src="/static/lib/raty/js/jquery.js"></script>
    <script src="/static/lib/raty/js/jquery.raty.min.js"></script>

    <script>
        $('#score_show').raty({start:5,hints: ['1', '2', '3', '4', '5'],target: '#result_score'});
        $('#score_show_ready').raty({ start: <?php echo $file['score'];?>,readOnly:true,showHalf:true});
        $('#comment_document').click(function(){
            var file_id = $('#file_id').val();
            var content = $('#comment_document_textarea').val();
            var user_id = <?php echo $user_id;?>;
            var score = $('#score_show-score').val();
            do_comment_for_document(file_id,content,user_id,score);
            $('#comment_document_textarea').val("");
        });
    </script>
    <script src="/static/lib/jquery-2.1.3.min.js"></script>
    <script src="/static/lib/jquery.form.min.js"></script>
    <script src="/static/lib/jquery.json.min.js"></script>
    <script src="/static/lib/jquery.validate.min.js"></script>
    <script src="/static/lib/base.js"></script>
    <script src="/static/public/js/transition.js"></script>
    <script src="/static/public/js/dropdown.js"></script>
    <script src="/static/public/js/collapse.js"></script>
    <script src="/static/public/js/carousel.js"></script>
<?php endif;?>