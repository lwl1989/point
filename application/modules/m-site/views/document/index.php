<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="change_channel('contents');">内容管理</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url('m-site/document');?>">文档列表</a> <span class="divider">/</span>
        </li>

        <li>
            文档列表
        </li>
    </ul>
</div>

<div class="row-fluid">
    <div class="box">
        <div class="box-header well" data-original-title="">
            <h3>查询</h3>
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>

        <div class="box-content" style="display: block;">
            <form action="<?php echo site_url('m-site/document')?>" >
                文档名:<input type="text" name="name" class="input-small" value="<?php echo $name;?>"/>
                <button id="save_form_btn" type="submit" class="btn btn-primary">查询</button>
            </form>
        </div>
    </div>
    <!--列表-->

    <div class="row-fluid">
        <span class="span6">
        </span>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>存储路径</th>
            <th>分类ID</th>
            <th>文件大小</th>
            <th>PDF？</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="data_body">
        <?php if($pagination['list']): foreach($pagination['list'] as $vo):?>
            <tr id="data<?php echo $vo['id'];?>">
                <td><?php echo $vo['id'];?></td>
                <td>
                    <?php echo $vo['title'];?>
                </td>
                <td>
                    <?php echo urldecode($vo['file_path']);?>
                </td>
                <td>
                    <?php echo zone_name($vo['file_classify']);?>
                </td>
                <td>
                    <?php echo zone_name($vo['file_size']);?>
                </td>
                <td>
                    <?php if($vo['create_pdf']){?>
                        已生成PDF
                    <?php } else{ ?>
                        未生成
                    <?php }?>
                </td>

                <td>
                    <a class="btn btn-info btn-mini"
                       href="<?php echo site_url('m-site/companies/edit/'.$vo['id'])?>">
                        <i class="icon-edit icon-white"></i>
                        修改标签
                    </a>
                    <a class="btn btn-info btn-mini"
                       href="<?php echo site_url('m-site/companies/create_pdf?file_path='.$vo['file_path'])?>">
                        <i class="icon-edit icon-white"></i>
                        生成PDF
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


<script  type="text/javascript">

    function del(id)
    {
        if(!confirm('确定要删除当前企业信息？'))
            return false;
        $.post(
             "<?php echo site_url('m-site/companies/del')?>",
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

    function set_circle(company_id, zone_id)
    {
        $.getJSON(
             '<?php echo site_url('api/business_circles/find');?>',
             {zone_id: zone_id},
             function (response) {

                 if (response.status) {
                     if (response.data.length > 0) {
                         var data = response.data;
                         var html = '';
                         for (var i in data) {
                             html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                         }
                         $('#modal_business_circle').html(html);
                         $('#modal_company_id').val(company_id);
                         $('#circle_modal').modal('show');
                     } else {
                         alert('企业设置的区域下无商圈数据');
                     }
                 } else {
                     alert(response.msg);
                 }

             }
        );

    }

    $(document).ready(function() {
        $('#modal_submit').click(function() {

            var btn = $(this);
            btn.prop('disabled', true)

            var form_id = $('form.modal_ajax').attr('id');
            var company_id = $('#modal_company_id').val();
            var circle_name = $("#modal_business_circle").find("option:selected").text();
            var options = {
                dataType: 'json',
                success: function(response) {
                    if(response.status) {


                        success_msg_show('form_msg', '设置成功!');
                        setTimeout(function() {
                            $('#circle_modal').modal('hide');
                            $('#company_'+ company_id +'_circle').html(circle_name);
                        }, 800)
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