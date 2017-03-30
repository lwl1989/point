<style type="text/css">
#lbsMap {width: 600px;height: 400px;overflow: hidden;margin:0;margin-top: 20px}
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=CjtrtFxjBbAAcBuW2gFVaXMs"></script>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
         <li>
            <a href="javascript:void(0);" onclick="change_channel('contents');">内容管理</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url('m-site/articles')?>">文章信息</a> <span class="divider">/</span>
        </li>
        <li>
            添加文章
        </li>
    </ul>
</div>

<div class="row-fluid">
    <form class="form-horizontal" method="post"
          id="save_form"
          action=""
          onsubmit="return false;">
        <fieldset>
            <legend>添加文章基本信息</legend>
            <div id="form_msg" class="alert" style="display: none;">
                <button type="button" class="close" onclick="$('#form_msg').hide();">×</button>
                <p></p>
            </div>



            <div class="control-group">
                <label class="control-label">文章名称</label>
                <div class="controls">
                    <input type="text" id="name" name="name" class="input-xlarge" />
                </div>
            </div>



            <div class="control-group">
                <label class="control-label">内容简介</label>
                <div class="controls">
                    <input type="text" id="intro" name="intro" class="input-xlarge" />
                </div>
            </div>

            <div class="control-group">
                <label for="picurl" class="control-label">图文封面：</label>
                <div class="controls">
                    <img id="thumb_img" src="" style="max-height:100px; display:none;" />
                    <input id="cover" type="text" name="pic" value="" class="input-xlarge" readonly="readonly" data-rule-required="true" data-rule-url="true" />
                    <span class="help-inline"><a class="btn" id="insertimage">选择图文封面</a></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">详细内容</label>
                <div class="controls">
                    <textarea name="message" id="message" style="width:700px;height:200px;visibility:hidden;"></textarea>
                    <script>var editor1;</script>
                    <script src="<?php echo base_url()?>static/kind/kindeditor-min.js"></script>
                </div>

            </div>



            <div class="form-actions">
                <!--<a class="btn"
                   href="<?php /*echo site_url('m-site/companies/select_cate');*/?>">
                    返回重新选择分类
                </a>-->
                <button id="save_form_btn" type="submit" class="btn btn-primary">保存</button>
                <input type="hidden" name="id" value="0" />
                <input type="hidden" name="action" value="save" />
            </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript">
    KindEditor.ready(function (K) {
        var editor1 = K.create('#message', {
            items : [
                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'image', 'link'],
            themeType: "simple",
            allowFileManager: true,
            allowFlashUpload: false,
            allowMediaUpload: false,
            allowFileUpload:false,
            uploadJson : '<?php echo site_url('api/configs/kind');?>',
            fileManagerJson : '<?php echo site_url('api/configs/files');?>',
            afterCreate : function() {
                this.sync();
                editor1.sync();
            },
            afterBlur:function(){
                this.sync();
                editor1.sync();
            }
        });
    });
    KindEditor.ready(function (K) {
        var editor = K.editor({
            themeType: "simple",
            allowFileManager: true,
            uploadJson : '<?php echo site_url('api/configs/kind');?>',
            fileManagerJson : '<?php echo site_url('api/configs/files');?>',
            urlType:'absolute'
        });
        K('#insertimage').click(function () {
            editor.loadPlugin('image', function () {
                editor.plugin.imageDialog({
                    imageUrl: K('#thumb').val(),
                    clickFn: function (url, title, width, height, border, align) {
                        K('#thumb').val(url);
                        if (K('#thumb_img')) {
                            K('#cover').hide();
                            K('#cover').val(align);
                            K('#thumb_img').attr('src', '<?php echo base_url();?>'+url);
                            K('#thumb_img').show();
                        }
                        editor.hideDialog();
                    }
                });
            });
        });
    });
    $(document).ready(function() {


        $('#establish_date').datepicker({ dateFormat: 'yy-mm-dd' });

        $('#save_form_btn').click(function() {
            var btn = $(this);
            var form_id = 'save_form';
            btn.prop('disabled', true);
            $.ajax({
                type:'post',
                url:'<?php echo site_url('m-site/articles/save')?>',
                dataType: 'json',
                data:{action:'save',cover:$('#cover').val(),message:$('#message').val(),name:$('#name').val(),intro:$('#intro').val()},
                success: function(response) {
                    if(response.status) {
                        success_msg_show('form_msg', '添加成功！您可以继续添加分类');
                        $('#' + form_id).resetForm();

                    }else if(!response.status) {
                        error_msg_show('form_msg', response.msg);
                    } else {
                        alert('操作失败，请重试或联系管理员！');
                        console.log(response);
                    }
                    btn.prop('disabled', false);
                }
            });
            return false;
        });

    });

</script>
