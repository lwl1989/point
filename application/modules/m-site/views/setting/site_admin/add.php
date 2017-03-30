<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="change_channel('system');">系统设置</a> <span class="divider">/</span>
        </li>
        <li>
             <a href="<?php echo site_url('/m-site/setting/site_admin/index')?>">管理员设置</a><span class="divider">/</span>
        </li>
        <li>
            添加管理员
        </li>
    </ul>
</div>

<div class="row-fluid">
    <form class="form-horizontal" method="post"
          id="save_form"
          action="<?php echo site_url('m-site/setting/site_admin/save')?>"
          onsubmit="return false;">
        <fieldset>
            <legend>添加管理员</legend>
            <div id="form_msg" class="alert" style="display: none;">
                <button type="button" class="close" onclick="$('#form_msg').hide();">×</button>
                <p></p>
            </div>

            <div class="control-group">
                <label class="control-label">搜索用户</label>
                <div class="controls">
                    <div class="input-append">
                        <input id="username_txt"
                               name="username"
                               size="16"
                               type="text"><button id="user_search_btn" class="btn" type="button">GO！</button>
                    </div>
                </div>
            </div>



            <div class="control-group">
                <label class="control-label">选择用户</label>
                <div class="controls" id="user_select_box">
                    没有可以选择的用户
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">角色</label>
                <div class="controls">
                    <?php if ($roles): foreach($roles as $role):?>
                        <label class="checkbox">
                            <input type="checkbox" name="roles[]" value="<?php echo $role['code'];?>"><?php echo $role['name'];?>
                        </label>
                    <?php endforeach;endif;?>
                </div>
            </div>

            <div class="form-actions">
                <button id="save_form_btn" type="submit" class="btn btn-primary">保存</button>
                <input type="hidden" name="id" value="0" />
                <input type="hidden" name="action" value="save" />
            </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        $('#user_search_btn').click(function () {
            var val = $.trim($('#username_txt').val());
            if (!val) {
                return;
            }
            var url = '<?php echo site_url('m-site/setting/site_admin/find_user?username=')?>' + val;
            $("#user_select_box").load(url);
            //change_ad_type(type);
        });

        $('#save_form_btn').click(function() {
            var btn = $(this);
            var form_id = 'save_form';

            btn.prop('disabled', true);
            var options = {
                dataType: 'json',
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
            };
            $('#' + form_id).ajaxSubmit( options );
            return false;
        });

    });
</script>
