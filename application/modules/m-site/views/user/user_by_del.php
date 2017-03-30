<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="change_channel('contents');">内容管理</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url('m-site/user');?>">用户</a> <span class="divider">/</span>
        </li>

        <li>
            已删除用户
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
            <form action="<?php echo site_url('m-site/user')?>" >

                区域:<select id="user_type" name="user_type" class="selector_root">
                    <option value="">请用户类别</option>
                    <option value="company">公司用户
                    </option>
                    <option value="ordinary">普通用户
                    </option>

                </select>
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
            <th>用户名</th>
            <th>昵称</th>
            <th>联系电话</th>
            <th>邮箱</th>

            <th>用户类别</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="data_body">
        <?php if($pagination['list']): foreach($pagination['list'] as $vo):?>
            <tr id="data<?php echo $vo['id'];?>">
                <td><?php echo $vo['id'];?></td>
                <td>
                    <?php echo $vo['username'];?>


                </td>
                <td>
                    <?php echo $vo['nickname'];?>
                </td>
                <td>
                    <?php echo $vo['mobile'];?>
                </td>
                <td>
                    <?php echo $vo['email'];?>
                </td>
                <td>
                    <?php if($vo['user_type']=='company'){ ?>
                        公司用户
                    <?php }else{ ?>
                        普通用户
                    <?php } ?>
                </td>


                <td>
                    <a class="btn btn-info btn-mini"
                       href="return stop(<?php echo $vo['id'];?>);">
                        <i class="icon-stop icon-blue"></i>
                        封停账户
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
        if(!confirm('确定要完全删除当前用户信息？（不可还原）'))
            return false;
        $.post(
             "<?php echo site_url('m-site/user/del_true')?>",
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

    function reback(id)
    {
        if(!confirm('确定要完全删除当前用户信息？（不可还原）'))
            return false;
        $.post(
             "<?php echo site_url('m-site/user/reback')?>",
             { id: id, action: 'update' },
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

    /*function set_circle(company_id, zone_id)
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

    }*/

</script>