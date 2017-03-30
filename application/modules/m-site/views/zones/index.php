<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="change_channel('system');">系统设置</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url('m-site/zones/index/')?>">城市区域</a> <span class="divider">/</span>
        </li>
        <li>
            <?php echo @$parent_zone['name']?>
        </li>
    </ul>
</div>

<div class="row-fluid">

    <!--列表-->

    <div class="row-fluid">
        <span class="span6">
            <?php if ($back_p_id > -1): ?>
            <a class="btn btn-toolbar btn-primary"
               href="<?php echo site_url('m-site/zones/index/'.$back_p_id)?>">
                <i class="icon icon-arrowreturn-se icon-white"></i>
                返回上级
            </a>
            <?php endif;?>
        </span>
        <span class="span6">
            <a href="#" class="btn btn-toolbar btn-info pull-right"
               onclick="add()">
                <i class="icon icon-add icon-white"></i>
                添加区域
            </a>
            <a href="#"
               onclick="refresh_cache('<?php echo site_url('m-site/zones/refresh_cache')?>')"
               class="btn btn-toolbar btn-primary pull-right" style="margin-right: 3px;">
                <i class="icon icon-refresh icon-white"></i>
                更新区域缓存
            </a>
        </span>

    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>区域名称</th>
                <th>排序</th>
                <th>是否显示</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody id="data_body">
            <?php if($zones): foreach($zones as $zone):?>
            <tr id="data<?php echo $zone['id'];?>">
                <td><?php echo $zone['id'];?></td>
                <td class="zone_name"><?php echo $zone['name'];?></td>
                <td class="zone_sort_order"><?php echo $zone['sort_order'];?></td>
                <td>
                    <?php
                        $display = is_display($zone['is_display']);
                    ?>
                    <span class="label label-<?php echo $display['class'];?>">
                        <?php echo $display['label'];?>
                    </span>
                </td>
                <td>


                    <a class="btn btn-info btn-mini" href="#"
                        onclick="edit(<?php echo $zone['id'];?>)">
                        <i class="icon-edit icon-white"></i>
                        编辑
                    </a>
                    <a class="btn btn-danger btn-mini" href="#"
                        onclick="return del(<?php echo $zone['id'];?>);">
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

<div class="modal hide fade" id="zone_modal" style="display: none;">
    <form id="add_form" class="form-horizontal modal_ajax" style="margin: 0;"
          method="post"
          action="<?php echo site_url('m-site/zones/save')?>"
          onsubmit="return false;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3 class="modal-title">添加区域</h3>
        </div>
        <div class="modal-body">
            <div id="form_msg" class="alert" style="display: none;">
                <button type="button" class="close" onclick="$('#form_msg').hide();">×</button>
                <p></p>
            </div>
            <div class="control-group">
                <label class="control-label">区域名称</label>
                <div class="controls">
                    <input id="name_txt" type="text" name="name" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">排序</label>
                <div class="controls">
                    <input  id="sort_order_txt" type="number" name="sort_order" value="255" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="action" value="save"/>
            <input type="hidden" id="zone_id" name="id" value="0"/>
            <input type="hidden" name="p_id" value="<?php echo $p_id;?>"/>
            <input type="hidden" name="path" value="<?php echo $path;?>"/>
            <input type="button" class="btn" data-dismiss="modal" value="关闭" />
            <input id="modal_submit" type="submit" class="btn btn-primary"
                   value="保存" />
        </div>
    </form>
</div>
<script  type="text/javascript">

    var operate = 'add';

    function edit(zone_id)
    {
        alert_hide('form_msg');
        operate = 'edit';
        $('#zone_id').val(zone_id);

        var tr = $('#data' + zone_id);
        var name = tr.find('.zone_name').text();
        var sort_order = tr.find('.zone_sort_order').text();

        $('#name_txt').val(name);
        $('#sort_order_txt').val(sort_order);

        $('.modal-title').text('编辑区域');
        $('#zone_modal').modal('show');



    }

    function add()
    {
        alert_hide('form_msg');
        operate = 'add';
        $('#zone_id').val(0);

        $('#name_txt').val('');
        $('#sort_order_txt').val(255);

        $('.modal-title').text('添加区域');
        $('#zone_modal').modal('show');
    }

    function del(zone_id)
    {
        if(!confirm('确定要删除当前区域？'))
            return false;
        $.post(
            "<?php echo site_url('m-site/zones/del')?>",
            { id: zone_id, action: 'del' },
            function(response){
                if(response.status) {
                    $('#data' + zone_id).fadeOut();
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
            var sort_order = parseInt($('#sort_order_txt').val());

            if ($.trim(name) == '') {
                error_msg_show('form_msg', '区域名称不能为空');
                btn.prop('disabled', false);
                return false;
            }

            if (sort_order < 0 && sort_order > 9999) {
                error_msg_show('form_msg', '排序请填写0-9999之间的整数');
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
                            success_msg_show('form_msg', '添加成功！您可以继续添加区域');
                        } else {
                            success_msg_show('form_msg', '编辑成功!');
                            setTimeout(function() {
                                $('#zone_modal').modal('hide');
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