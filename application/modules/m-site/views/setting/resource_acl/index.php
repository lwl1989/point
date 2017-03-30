<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="change_channel('system');">系统设置</a> <span class="divider">/</span>
        </li>
        <li>
            角色设置
        </li>
    </ul>
</div>

<div class="row-fluid">

    <!--列表-->

    <div class="row-fluid">
        <span class="span6 pull-right">
            <a href="#" class="btn btn-toolbar btn-info pull-right"
               onclick="add()">
                <i class="icon icon-add icon-white"></i>
                添加角色
            </a>
        </span>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>角色名称</th>
            <th>角色代码</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="data_body">
        <?php if($roles): foreach($roles as $role):?>
            <tr id="data<?php echo $role['id'];?>">
                <td><?php echo $role['id'];?></td>
                <td class="role_name"><?php echo $role['name'];?></td>
                <td class="role_code"><?php echo $role['code'];?></td>
                <td>

                    <a class="btn btn-warning btn-mini"
                       href="<?php echo site_url('m-site/setting/resource_acl/role_resources/'.$role['id'])?>">
                        <i class="icon-zoom-in icon-white"></i>
                        角色权限
                    </a>

                    <a class="btn btn-info btn-mini" href="#"
                       onclick="edit(<?php echo $role['id'];?>)">
                        <i class="icon-edit icon-white"></i>
                        编辑
                    </a>
                    <a class="btn btn-danger btn-mini" href="#"
                       onclick="return del(<?php echo $role['id'];?>);">
                        <i class="icon-trash icon-white"></i>
                        删除
                    </a>

                </td>
            </tr>
        <?php endforeach;endif;?>
        </tbody>
    </table>

    <div class="row-fluid">
    </div>
    <!--/列表-->
</div>

<div class="modal hide fade" id="role_modal" style="display: none;">
    <form id="add_form" class="form-horizontal modal_ajax" style="margin: 0;"
          method="post"
          action="<?php echo site_url('m-site/setting//resource_acl/save')?>"
          onsubmit="return false;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3 class="modal-title">添加角色</h3>
        </div>
        <div class="modal-body">
            <div id="form_msg" class="alert" style="display: none;">
                <button type="button" class="close" onclick="$('#form_msg').hide();">×</button>
                <p></p>
            </div>
            <div class="control-group">
                <label class="control-label">角色名称</label>
                <div class="controls">
                    <input id="name_txt" type="text" name="name" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">角色代码</label>
                <div class="controls">
                    <input  id="code_txt" type="text" name="code" value="" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="action" value="save"/>
            <input type="hidden" id="role_id" name="id" value="0"/>
            <input type="button" class="btn" data-dismiss="modal" value="关闭" />
            <input id="modal_submit" type="submit" class="btn btn-primary"
                   value="保存" />
        </div>
    </form>
</div>
<script  type="text/javascript">

    var operate = 'add';

    function edit(role_id)
    {
        alert_hide('form_msg');
        operate = 'edit';
        $('#role_id').val(role_id);

        var tr = $('#data' + role_id);
        var name = tr.find('.role_name').text();
        var code = tr.find('.role_code').text();

        $('#name_txt').val(name);
        $('#code_txt').val(code);

        $('.modal-title').text('编辑角色');
        $('#role_modal').modal('show');



    }

    function add()
    {
        alert_hide('form_msg');
        operate = 'add';
        $('#role_id').val(0);

        $('#name_txt').val('');
        $('#code_txt').val('');

        $('.modal-title').text('添加角色');
        $('#role_modal').modal('show');
    }

    function del(role_id)
    {
        if(!confirm('确定要删除当前角色？'))
            return false;
        $.post(
            "<?php echo site_url('m-site/setting/resource_acl/del')?>",
            { id: role_id, action: 'del' },
            function(response){
                if(response.status) {
                    $('#data' + role_id).fadeOut();
                }else if(!response.status){
                    alert(response.msg);
                }else {
                    alert('操作失败，请重试或联系管理员！');
                    console.log(response);
                }
            },
            'json');
        return false;
    }

    $(document).ready(function() {
        $('#modal_submit').click(function() {
            var btn = $(this);
            btn.prop('disabled', true)

            var name = $('#name_txt').val();
            var code = $('#code_txt').val();

            if ($.trim(name) == '') {
                error_msg_show('form_msg', '角色名称不能为空');
                btn.prop('disabled', false);
                return false;
            }

            if ($.trim(code) == '') {
                error_msg_show('form_msg', '角色代码不能为空');
                btn.prop('disabled', false);
                return false;
            }

            var form_id = $('form.modal_ajax').attr('id');
            var options = {
                dataType: 'json',
                success: function(response) {
                    if(response.status) {

                        if (operate == 'add') {
                            $('#name_txt').val('');
                            $('#code_txt').val('');

                            success_msg_show('form_msg', '添加成功！您可以继续添加角色');
                        } else {
                            success_msg_show('form_msg', '编辑成功!');
                            setTimeout(function() {
                                $('#role_modal').modal('hide');
                            }, 800)
                        }

                    }else {
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