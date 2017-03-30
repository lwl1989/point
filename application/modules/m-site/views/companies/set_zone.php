<style type="text/css">
    #lbsMap {width: 600px;height: 400px;overflow: hidden;margin:0;margin-top: 20px}
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=CjtrtFxjBbAAcBuW2gFVaXMs"></script>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="change_channel('contents');">内容管理</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url('m-site/companies')?>">店铺信息</a> <span class="divider">/</span>
        </li>
        <li>
            添加企业
        </li>
    </ul>
</div>

<div class="row-fluid">
    <form class="form-horizontal" method="post"
          id="save_form"
          action="<?php echo site_url('m-site/companies/do_set_zone')?>"
          onsubmit="return false;">
        <fieldset>
            <legend><?php echo $company_name;?>  --  打印店区域设置</legend>
            <div id="form_msg" class="alert" style="display: none;">
                <button type="button" class="close" onclick="$('#form_msg').hide();">×</button>
                <p></p>
            </div>



            <div class="control-group">
                <label class="control-label">请选择区域</label>
                <div class="controls" id="zone_selector">
                    <select id="root_zone" name="root_zone" class="selector_root">
                        <option value="">请选择区域</option>
                        <?php foreach($root_zones as $root_zone) :?>
                            <option value="<?php echo $root_zone['id'];?>">
                                <?php echo $root_zone['name'];?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">区域</label>
                <div class="controls" id="zone_selector_label">
                    <span class="label label-important selected_label">未选择</span>
                    <input type="hidden" name="zone_id" class="selected_id" />
                </div>
            </div>
            <div class="form-actions">
                <!--<a class="btn"
                   href="<?php /*echo site_url('m-site/companies/select_cate');*/?>">
                    返回重新选择分类
                </a>-->
                <button id="save_form_btn" type="submit" class="btn btn-primary">保存</button>
                <input type="hidden" name="id" value="<?php echo $id?>" />
                <input type="hidden" name="action" value="save" />
            </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {


        var zone_selector  = new Tree_selector('zone_selector', '<?php echo site_url('api/zones/find')?>');
        zone_selector.init();

        $('#establish_date').datepicker({ dateFormat: 'yy-mm-dd' });

        $('#save_form_btn').click(function() {
            var btn = $(this);
            var form_id = 'save_form';

            btn.prop('disabled', true);
            var options = {
                dataType: 'json',
                success: function(response) {
                    if(response.status) {

                        success_msg_show('form_msg', '设置成功！您可以继续添加分类');
                        $('#' + form_id).resetForm();

                        cate_selector.resetSelector();
                        zone_selector.resetSelector();

                    }else if(!response.status) {
                        error_msg_show('form_msg', response.msg);
                    } else {
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


    // 百度地图API功能

</script>
