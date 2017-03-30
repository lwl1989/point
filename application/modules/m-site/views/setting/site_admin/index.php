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
            人员管理
        </li>
    </ul>
</div>

<div class="row-fluid">

    <!--列表-->

    <div class="row-fluid">
        <span class="span6">
        </span>
        <span class="span6">
            <a href="<?php echo site_url('m-site/setting/site_admin/add')?>" class="btn btn-toolbar btn-info pull-right">
                <i class="icon icon-add icon-white"></i>
                添加管理员
            </a>
        </span>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>角色</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="data_body">
        <?php if($pagination['list']): foreach($pagination['list'] as $vo):?>
            <tr id="data<?php echo $vo['id'];?>">
                <td><?php echo $vo['id'];?></td>
                <td><?php echo $vo['username'];?></td>
                <td><?php echo $vo['roles'];?></td>
                <td>
                    <a class="btn btn-info btn-mini"
                       href="<?php echo site_url('m-site/setting/site_admin/edit/'.$vo['id'])?>">
                        <i class="icon-edit icon-white"></i>
                        编辑
                    </a>

                    <a class="btn btn-danger btn-mini" href="#"
                       onclick="return del(<?php echo $vo['id'];?>);">
                        <i class="icon-trash icon-white"></i>
                        删除
                    </a>

                </td>
            </tr>
        <?php endforeach;endif;?>
        </tbody>
    </table>

    <div class="row-fluid pagination pagination-centered">
        <?php echo $pagination['page_html'];?>
    </div>
    <!--/列表-->
</div>


<div class="modal hide fade" id="circle_modal" style="display: none;">
    <form id="circle_setting_form" class="form-horizontal modal_ajax" style="margin: 0;"
          method="post"
          action="<?php echo site_url('m-site/companies/set_circle')?>"
          onsubmit="return false;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3 class="modal-title">设置商圈</h3>
        </div>
        <div class="modal-body">
            <div id="form_msg" class="alert" style="display: none;">
                <button type="button" class="close" onclick="$('#form_msg').hide();">×</button>
                <p></p>
            </div>

            <div class="control-group">
                <label class="control-label">商圈</label>
                <div class="controls">
                    <select name="business_circle_id" id="modal_business_circle">

                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="action" value="save"/>
            <input type="hidden" id="modal_company_id" name="id" value="0"/>
            <input type="button" class="btn" data-dismiss="modal" value="关闭" />
            <input id="modal_submit" type="submit" class="btn btn-primary"
                   value="确定" />
        </div>
    </form>
</div>

<script  type="text/javascript">

    function del(id)
    {
        if(!confirm('确定要删除当前人员的管理权限？'))
            return false;
        $.post(
            "<?php echo site_url('m-site/setting/site_admin/del')?>",
            { id: id, action: 'del' },
            function(response){
                if(response.status) {
                    $('#data' + id).fadeOut();
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


</script>