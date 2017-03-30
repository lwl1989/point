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
            编辑管理员
        </li>
    </ul>
</div>

<div class="row-fluid">
    <form class="form-horizontal" method="post"
          id="save_form"
          action="<?php echo site_url('m-site/setting/site_admin/save')?>"
          onsubmit="return false;">
        <fieldset>
            <legend>编辑管理员</legend>
            <div id="form_msg" class="alert" style="display: none;">
                <button type="button" class="close" onclick="$('#form_msg').hide();">×</button>
                <p></p>
            </div>



            <div class="control-group">
                <label class="control-label">角色</label>
                <div class="controls">
                    <?php
                    $admin_roles = explode(',', $admin['roles']);
                    if ($roles): foreach($roles as $role):?>
                        <label class="checkbox">
                            <input type="checkbox" name="roles[]" value="<?php echo $role['code'];?>"
                                <?php if(in_array($role['code'], $admin_roles)) echo 'checked';?>><?php echo $role['name'];?>
                        </label>
                    <?php endforeach;endif;?>
                </div>
            </div>

            <div class="form-actions">
                <button id="save_form_btn" type="submit" class="btn btn-primary">保存</button>
                <input type="hidden" name="id" value="<?php echo $admin['id'];?>" />
                <input type="hidden" name="user_id" value="<?php echo $admin['user_id'];?>" />
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

                        success_msg_show('form_msg', '保存成功');

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
