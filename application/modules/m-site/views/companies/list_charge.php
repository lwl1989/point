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
            价格设置
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

    </div>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>规格</th>
            <th>单双面</th>
            <th>基础价格</th>
            <th>折扣信息</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="data_body">
        <?php  foreach($charge as $key=>$vo):?>
            <?php foreach($vo as $key_1=>$val_1):?>
            <tr id="">
                <td><?php echo $key;?></td>
                <td>
                    <?php switch($key_1){
                        case 'one':
                            echo '单面';
                            break;
                        case 'two':
                            echo '双面';
                            break;
                        case 'color_one':
                            echo '彩印单面';
                            break;
                        case 'color_two':
                            echo '彩印双面';
                            break;
                                }
                    ?>
                </td>
                <td>
                    <?php echo $val_1['base'];?>
                </td>
                <td>
                <?php foreach($val_1['sales'] as $key_2=>$val_2):?>
                        数量<?php echo $val_2['num'];?>以上，折扣<?php echo $val_2['sale'];?><br/>
                <?php endforeach;?>
                </td>

                <td>

                    <a class="btn btn-danger btn-mini" href="#"
                       onclick="">
                        <i class="icon-trash icon-white"></i>
                        还原
                    </a>

                </td>
            </tr>
            <?php endforeach;?>
        <?php endforeach;?>
        </tbody>
    </table>


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