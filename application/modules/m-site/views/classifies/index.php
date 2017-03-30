<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="change_channel('system');">系统设置</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url('m-site/classifies');?>">文档文类管理</a> <span class="divider">/</span>
        </li>

        <li>
            分类列表
        </li>
    </ul>
</div>

<div class="row-fluid">
	<div class="box">
	</div>
    <!--列表-->

    <div class="row-fluid">
        <span class="span6">

        </span>
        <span class="span6">
            <a href="<?php echo site_url('m-site/classifies/add')?>" class="btn btn-toolbar btn-info pull-right" style="margin-left: 20px;">
                <i class="icon icon-add icon-white"></i>
                添加分类
            </a>&nbsp;&nbsp;&nbsp;&nbsp;
             <a href="javascritp:void(0);" class="btn btn-toolbar btn-info pull-right" onclick="config_();">
                 <i class="icon icon-add icon-white"></i>
                 更新文件缓存
             </a>&nbsp;&nbsp;&nbsp;&nbsp;
        </span>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>所属顶级分类</th>
            <th>所属标签</th>
            <th>简介</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="data_body">
        <?php if($pagination['list']): foreach($pagination['list'] as $vo):?>
            <tr id="data<?php echo $vo['id'];?>">
                <td><?php echo $vo['id'];?></td>
                <td>

                    <?php
                        echo $vo['name'];
                    ?>

                </td>
                <td>
                    <?php
                        echo $vo['type'];
                    ?>

                </td>
                <td>
                    <?php
                    echo $vo['tag'];
                    ?>

                </td>
                <td>
                    <?php
                        echo $vo['intro'];
                    ?>
                </td>

                <td>
                    <a class="btn btn-info btn-mini"
                       href="<?php echo site_url('m-site/classifies/edit/'.$vo['id'])?>">
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
    <div>
        这个由于很少修改的，所以节约时间没做(热词除外)
    </div>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>标签</th>
            <th>分类顶级属性</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="data_body">
            <?php foreach ($classifies as $type_key=>$classify) :?>
                <?php foreach ($classify['tags'] as $tag) :?>
                <tr>
                    <td><?php echo $tag['tag'];?></td>
                    <td><?php echo $classify['type'];?></td>
                    <td><a class="btn btn-info btn-mini"
                           href="<?php echo site_url('m-site/classifies/hots/'.$type_key)?>">
                            <i class="icon-edit icon-white"></i>
                            编辑热词
                        </a></td>
                </tr>
                    <?php endforeach;?>
            <?php endforeach;?>

</tbody>
    </table>

        <!--/列表-->
</div>


<script  type="text/javascript">
    function config_(){
        $.get(
            "<?php echo site_url('m-site/classifies/generate_config')?>",
            function(response){
                if(response.status) {
                    alert('生成成功');
                }else if(!response.status){
                    alert(response.msg);
                }else {
                    alert('操作失败，请重试或联系管理员！');
                    console.log(response);
                }
            },
        'json');
    }
    function del(id)
    {
        if(!confirm('确定要删除当前分类？'))
            return false;
        $.post(
            "<?php echo site_url('m-site/classifies/del')?>",
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