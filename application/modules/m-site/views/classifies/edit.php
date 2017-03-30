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
            <a href="<?php echo site_url('m-site/classifies')?>">分类列表</a> <span class="divider">/</span>
        </li>
        <li>
            修改文章分类
        </li>
    </ul>
</div>

<div class="row-fluid">
    <form class="form-horizontal" method="post"
          id="save_form"
          action=""
          onsubmit="return false;">
        <fieldset>
            <legend>添加分类信息</legend>
            <div id="form_msg" class="alert" style="display: none;">
                <button type="button" class="close" onclick="$('#form_msg').hide();">×</button>
                <p></p>
            </div>

            <div class="control-group">
                <label class="control-label">名称</label>
                <div class="controls">
                    <input type="text" id="name" name="name" class="input-xlarge" value="<?php echo $classify_['name'];?>" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">名称</label>
                <div class="controls">
                   <select name="fid">
                       <option value="<?php echo $classify_['fid'];?>" selected="selected">不选择不修改</option>
                       <?php foreach($classifies as $classify):?>
                           <option value="<?php echo $classify['id'];?>"><?php echo $classify['name'];?></option>
                       <?php endforeach;?>
                   </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">内容简介</label>
                <div class="controls">
                    <input type="text" id="intro" name="intro" class="input-xlarge" value="<?php echo $classify_['intro'];?>" />
                </div>
            </div>

            <div class="form-actions">
                <button id="save_form_btn" type="submit" class="btn btn-primary">保存</button>
                <input type="hidden" name="id" value="<?php echo $classify_['id'];?>" />
                <input type="hidden" name="action" value="save" />
            </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#establish_date').datepicker({ dateFormat: 'yy-mm-dd' });

        $('#save_form_btn').click(function() {
            var btn = $(this);
            var form_id = 'save_form';
            btn.prop('disabled', true);
            $.ajax({
                type:'post',
                url:'<?php echo site_url('m-site/classifies/save')?>',
                dataType: 'json',
                data:{action:'save',id:$('input[name=id]').val(),fid:$("select[name=fid]").val(),name:$('#name').val(),intro:$('#intro').val()},
                success: function(response) {
                    if(response.status) {
                        success_msg_show('form_msg', '修改成功！您可以继续操作');
                        $('#' + form_id).resetForm();

                    }else if(!response.status) {
                        error_msg_show('form_msg', response.msg);
                    } else {
                        alert('操作失败，请重试或联系管理员！');
                        console.log(response);
                    }
                    btn.prop('disabled', false);
                }
            });
            return false;
        });

    });

</script>
