<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="change_channel('contents');">内容管理</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url('m-site/companies');?>">店铺信息</a> <span class="divider">/</span>
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
			<form action="<?php echo site_url('m-site/companies')?>" >
			
			
			
			
			企业名称:<input type="text" name="name" class="input-small" value="<?php echo $name;?>"/>
			区域:<select id="zone_id" name="zone_id" class="selector_root">
                        <option value="">请选择区域</option>
                        <?php foreach($root_zones as $root_zone) :?>
                            <option value="<?php echo $root_zone['id'];?>" <?php if($zone_id==$root_zone['id'])echo 'selected';?>>
                                <?php echo $root_zone['name'];?>
                            </option>
                        <?php endforeach;?>
                    </select>
          	<button id="save_form_btn" type="submit" class="btn btn-primary">查询</button>

        </form>
        </div>     																																										       
	</div>
    <!--列表-->

    <div class="row-fluid">
        <span class="span6">
        </span>
        <span class="span6">
            <a href="<?php echo site_url('m-site/companies/add')?>" class="btn btn-toolbar btn-info pull-right">
                <i class="icon icon-add icon-white"></i>
                添加企业
            </a>
        </span>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>封面</th>
            <th>名称</th>
            <th>分类</th>
            <th>区域</th>
            <th>商圈</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="data_body">
        <?php if($pagination['list']): foreach($pagination['list'] as $vo):?>
            <tr id="data<?php echo $vo['id'];?>">
                <td><?php echo $vo['id'];?></td>
                <td>
                    <?php
                    if (trim($vo['cover'])) {
                        echo "<img src=\"".get_company_small_image($vo['cover'])."\" alt=\"".$vo['name']."\" width=\"40\" />";
                    } else {
                        echo "无";
                    }
                    ?>

                </td>
                <td>
                    <a href="<?php echo site_url('company/'.$vo['id']);?>" title="点击查看" target="_blank">
                        <?php echo $vo['name'];?>
                    </a>
                </td>
                <td>

                </td>
                <td>
                    <?php echo zone_name($vo['zone_id']);?>
                </td>
                <td>
                    <?php if($vo['zone_id']){?>
                        <p id="company_<?php echo $vo['id'];?>_circle"></p>
                        <a href="<?php echo site_url('m-site/companies/set_zone/'.$vo['id'])?>">设置</a>
                    <?php } else{ ?>
                        <a class="btn btn-info btn-mini"
                           href="<?php echo site_url('m-site/companies/set_zone/'.$vo['id'])?>">
                            <i class="icon-edit icon-white"></i>
                            设置区域
                        </a>
                    <?php }?>
                </td>

                <td>
                <!--    <a class="btn btn-info btn-mini"
                       href="<?php echo site_url('m-site/companies/edit/'.$vo['id'])?>">
                        <i class="icon-edit icon-white"></i>
                        基本
                    </a>-->
                    <a class="btn btn-info btn-mini"
                       href="<?php echo site_url('m-site/companies/list_charge/'.$vo['id'])?>">
                        <i class="icon-edit icon-white"></i>
                        收费信息
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