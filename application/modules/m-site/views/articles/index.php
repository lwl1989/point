<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="change_channel('contents');">内容管理</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url('m-site/articles');?>">文章管理</a> <span class="divider">/</span>
        </li>

        <li>
            店铺列表
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
			<form action="<?php echo site_url('m-site/articles')?>" >

			
			文章名称:<input type="text" name="name" class="input-small" value="<?php echo $name;?>"/>
          	<button id="save_form_btn" type="submit" class="btn btn-primary">查询</button>

        </form>
        </div>     																																										       
	</div>
    <!--列表-->

    <div class="row-fluid">
        <span class="span6">
        </span>
        <span class="span6">
            <a href="<?php echo site_url('m-site/articles/add')?>" class="btn btn-toolbar btn-info pull-right">
                <i class="icon icon-add icon-white"></i>
                添加文章
            </a>
        </span>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>封面</th>
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
                    if (trim($vo['cover'])) {
                        echo "<img src=\"".base_url().$vo['cover']."\" alt=\"".$vo['name']."\" width=\"40\" />";
                    } else {
                        echo "无";
                    }
                    ?>

                </td>
                <td>
                    <?php
                        echo $vo['intro'];
                    ?>

                </td>

                <td>
                    <a class="btn btn-info btn-mini"
                       href="<?php echo site_url('m-site/articles/edit/'.$vo['id'])?>">
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


<script  type="text/javascript">

    function del(id)
    {
        if(!confirm('确定要删除当前文章信息？'))
            return false;
        $.post(
            "<?php echo site_url('m-site/articles/del')?>",
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