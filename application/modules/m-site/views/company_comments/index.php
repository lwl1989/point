<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="change_channel('contents');">内容管理</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url('m-site/company_comments');?>">评论列表</a> <span class="divider">/</span>
        </li>

        <li>
            评论列表
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
            <form action="<?php echo site_url('m-site/company_comments/index')?>" >
                公司名:<input type="text" name="company_name" class="input-small" value="<?php echo @$company_name;?>"/>
                用户名:<input type="text" name="user_name" class="input-small" value="<?php echo @$user_name;?>"/>
                是否审核:<select name="is_audit">
                    <option value="1">已审核</option>
                    <option value="0">未审核</option>
                </select>
                是否禁止:<select name="is_forbidden">
                    <option value="1">禁止</option>
                    <option value="0">正常</option>
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
            <th>公司名</th>
            <th>内容</th>

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
                    <?php echo $vo['name'];?>
                </td>
                <td>
                    <?php echo $vo['content'];?>
                </td>


                <td>
                    <?php if($vo['is_audit'] && !$vo['is_forbidden']): ?>
                        <a class="btn btn-info btn-mini"
                           href="javascritp:void(0)"  onclick="forbidden(<?php echo $vo['id']?>,this)">
                            <i class="icon-edit icon-white"></i>
                            禁止
                        </a>
                    <?php endif; ?>
                    <?php if(!$vo['is_audit']): ?>
                    <a class="btn btn-info btn-mini"
                       href="javascritp:void(0)"  onclick="audit(<?php echo $vo['id']?>,this)">
                        <i class="icon-edit icon-white"></i>
                        通过审核
                    </a>
                    <?php endif; ?>
                    <?php if($vo['is_forbidden']): ?>
                        <a class="btn btn-info btn-mini"
                           href="javascritp:void(0)"  onclick="back_forbidden(<?php echo $vo['id']?>,this)">
                            <i class="icon-edit icon-white"></i>
                            恢复
                        </a>
                    <?php endif ?>
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


    function audit(id,obj){
        if(!confirm('通过此信息？'))
            return false;
        $.post(
            "/m-site/company_comments/do_audit",
            { id: id },
            function(response){
                if(response.status) {
                    $(obj).fadeOut();
                    alert(response.msg);
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

    function forbidden(id,obj){
        if(!confirm('禁止此信息？'))
            return false;
        $.post(
            "/m-site/company_comments/do_forbidden",
            { id: id },
            function(response){
                if(response.status) {
                    $(obj).fadeOut();
                    alert(response.msg);
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

    function back_forbidden(id,obj){
        if(!confirm('确定要撤销禁止此信息？'))
            return false;
        $.post(
            "/m-site/company_comments/do_back_forbidden",
            { id: id },
            function(response){
                if(response.status) {
                    $(obj).fadeOut();
                    alert(response.msg);
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

    });
</script>