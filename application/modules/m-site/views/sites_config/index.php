<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="#">站点设置</a>
        </li>
    </ul>
</div>

<div class="row-fluid">
	
    <div class="row-fluid">
        <span class="span6">
            
        </span>
        <span class="span6">
            
            <a href="#"
               onclick="refresh_cache('<?php echo site_url('m-site/sites_config/refresh_cache')?>')"
               class="btn btn-toolbar btn-primary pull-right" style="margin-right: 3px;">
                <i class="icon icon-refresh icon-white"></i>
                更新缓存
            </a>
        </span>
    </div>
	<!--列表-->
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>站点名称</th>
                <th>标题</th>
                <th>关键字</th>
                <th>描述</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody id="data_body">
             <?php if($pagination['list']): foreach($pagination['list'] as $site):?>
            <tr id="data<?php echo $site['id'];?>">
                <td><?php echo $site['id'];?></td>
                <td class="category_name"><?php echo $site['name'];?></td>
                <td><?php echo $site['title'];?></td>
                <td><?php echo $site['keywords'];?></td>
                <td><?php echo $site['description'];?></td>
                <td>
                    <a class="btn btn-info btn-mini" href="/m-site/sites_config/edit/<?php echo $site['id'];?>"
                       >
                        <i class="icon-edit icon-white"></i>
                        编辑
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


<script  type="text/javascript">

    var operate = 'add';

    function edit(category_id)
    {
        alert_hide('form_msg');
        operate = 'edit';
        $('#category_id').val(category_id);

        var tr = $('#data' + category_id);
        var name = tr.find('.category_name').text();
        var sort_order = tr.find('.category_sort_order').text();

        $('#name_txt').val(name);
        $('#sort_order_txt').val(sort_order);

        $('.modal-title').text('编辑分类');
        $('#category_modal').modal('show');



    }


    function add()
    {
        alert_hide('form_msg');
        operate = 'add';
        $('#category_id').val(0);

        $('#name_txt').val('');
        $('#sort_order_txt').val(255);

        $('.modal-title').text('添加分类');
        $('#category_modal').modal('show');
    }

    function del(category_id)
    {
        if(!confirm('确定要删除当前分类？'))
            return false;
        $.post(
            "<?php echo site_url('m-site/company_categories/del')?>",
            { id: category_id, action: 'del' },
            function(response){
                if(response.status) {
                    $('#data' + category_id).fadeOut();
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
                error_msg_show('form_msg', '分类名称不能为空');
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
                            success_msg_show('form_msg', '添加成功！您可以继续添加分类');
                        } else {
                            success_msg_show('form_msg', '编辑成功!');
                            setTimeout(function() {
                                $('#category_modal').modal('hide');
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