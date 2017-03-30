<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
       <li>
            <a href="javascript:void(0);" onclick="change_channel('system');">系统设置</a> <span class="divider">/</span>
        </li>
        <li>
             <a href="<?php echo site_url('m-site/setting/resource_acl/index')?>">角色设置</a> <span class="divider">/</span>
        </li>
        <li>
            角色权限设置
        </li>
    </ul>
</div>

<div class="row-fluid">
    <div class="row-fluid">
        <span class="span6 pull-right">
            <a href="<?php echo site_url('m-site/setting/resource_acl')?>" class="btn btn-toolbar btn-info pull-right">
                <i class="icon icon-arrowreturn-se icon-white"></i>
                返回角色列表
            </a>
        </span>
    </div>

    <form class="form-horizontal" method="post"
          id="save_form"
          action="<?php echo site_url('m-site/setting/resource_acl/role_resources/'.$role['id'])?>"
          onsubmit="return false;">
        <fieldset>
            <legend><?php echo $role['name']?>(<?php echo $role['code'];?>)</legend>
        </fieldset>
        <div id="form_msg" class="alert" style="display: none;">
            <button type="button" class="close" onclick="$('#form_msg').hide();">×</button>
            <p></p>
        </div>

        <?php foreach($channels as $channel_code => $channel_name):?>
        <div class="row-fluid">
            <h4><?php echo $channel_name;?></h4>
            <?php if (isset($menus[$channel_code])):foreach($menus[$channel_code] as $sub1_menu_name => $sub2_menus):?>
            <div class="span5">
                <h5><?php echo $sub1_menu_name;?></h5>
                <?php if ($sub2_menus):foreach ($sub2_menus as $sub3_menu_name => $sub3_menu):?>
                    <ul class="dashboard-list">
                        <li>
                            <label>
                                <input type="checkbox" name="resources[]"
                                       <?php
                                       $checked = 'checked';
                                       foreach ($sub3_menu['action'] as $action) {
                                           $key = $sub3_menu['resource'].'/'.$action;
                                           if (!in_array($key, $acl)) {
                                               $checked = '';
                                               break;
                                           }
                                       }
                                       echo $checked;
                                       ?>
                                       value="<?php echo $sub3_menu['resource'];?>|<?php echo join(',', $sub3_menu['action'])?>|<?php echo $sub3_menu['url'];?>">
                            <?php echo $sub3_menu_name;?>
                            </label>
                    <?php if (isset($sub3_menu['groups'])) :foreach($sub3_menu['groups'] as $group):?>
                                <label class="checkbox">
                                    <?php
                                    $resource = isset($group['resource'])?$group['resource']:$sub3_menu['resource'];
                                    ?>
                                    <input type="checkbox" name="resources[]" value="<?php echo $resource;?>|<?php echo join(',', $group['action'])?>"
                                        <?php
                                        $checked = 'checked';
                                        foreach ($group['action'] as $action) {
                                            $key = $resource.'/'.$action;
                                            if (!in_array($key, $acl)) {
                                                $checked = '';
                                                break;
                                            }
                                        }
                                        echo $checked;
                                        ?>>
                                    <?php echo $group['title'];?>
                                </label>
                    <?php endforeach;endif;?>
                            </li>

                    </ul>

                <?php endforeach;endif;?>
            </div>
            <?php endforeach;endif;?>
        </div>
        <?php endforeach;?>

        <div class="form-actions">
            <button id="save_form_btn" type="submit" class="btn btn-primary">保存</button>
            <input type="hidden" name="role_code" value="<?php echo $role['code'];?>" />
            <input type="hidden" name="action" value="save" />
        </div>

    </form>

</div>

<script type="text/javascript">
    $(document).ready(function() {

        $('#save_form_btn').click(function() {
            var btn = $(this);
            var form_id = 'save_form';

            btn.prop('disabled', true);
            var options = {
                dataType: 'json',
                success: function(response) {
                    if(response.status) {
                        alert('保存成功');

                    }else if(!response.status) {
                        alert(response.msg);
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