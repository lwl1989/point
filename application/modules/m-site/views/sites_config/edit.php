<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="#">站点配置</a>
        </li>
    </ul>
</div>

<div class="row-fluid">
    <form class="form-horizontal" method="post"
          id="save_form"
          action="<?php echo site_url('m-site/sites_config/update')?>" 
          onsubmit="return false;">
        <fieldset>
            <legend>站点配置基本信息</legend>
			<div id="form_msg" class="alert" style="display: none;">
                <button type="button" class="close" onclick="$('#form_msg').hide();">×</button>
                <p></p>
            </div>
            <div class="control-group">
                <label class="control-label">名称</label>
                <div class="controls">
                    <input type="text" name="name" class="input-xlarge"
                           value="<?php if(isset($site['name'])) echo $site['name'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">标题</label>
                <div class="controls">
                    <input type="text" name="title" class="input-xlarge"
                           value="<?php echo $site['title'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">关键字</label>
                <div class="controls">
                    <input type="text" name="keywords" class="input-xlarge"
                           value="<?php if(isset($site['keywords'])) echo $site['keywords']; ?>" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="establish_date">描述</label>
                <div class="controls">
                    <textarea name="description" class="textarea"><?php echo $site['description'];?></textarea>
                </div>
            </div>


            <div class="form-actions">
                
                <button id="save_form_btn" type="submit" class="btn btn-primary">保存</button>
                <input type="hidden" name="id" value="<?php echo $site['id'];?>" />
                <input type="hidden" name="action" value="update" />
            </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
      $('#save_form_btn').click(function() {

            var btn = $(this);
            var form_id = 'save_form';

            btn.prop('disabled', true);
            var options = {
                dataType: 'json',
                success: function(response) {
                    if(response.status) {
                        success_msg_show('form_msg', '保存成功！');
                        //$('#' + form_id).resetForm();

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
</script>
