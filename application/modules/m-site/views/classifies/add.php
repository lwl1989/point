<style type="text/css">
#lbsMap {width: 600px;height: 400px;overflow: hidden;margin:0;margin-top: 20px}
</style>
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
            添加文章分类
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
                    <input type="text" id="name" name="name" class="input-xlarge" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">父类</label>
                <div class="controls">
                   <select name="fid">
                       <option value="0">请选择</option>
                       <?php foreach($classifies['base'] as $key=>$classify):?>
                           <option value="<?php echo $key?>"><?php echo $classify['type'];?></option>
                       <?php endforeach;?>
                   </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">标签</label>
                <div class="controls">
                    <select name="tag" id="tag">
                        <option value="0">请选择</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">内容简介</label>
                <div class="controls">
                    <input type="text" id="intro" name="intro" class="input-xlarge" />
                </div>
            </div>

            <div class="form-actions">
                <button id="save_form_btn" type="submit" class="btn btn-primary">保存</button>
                <input type="hidden" name="id" value="0" />
                <input type="hidden" name="action" value="save" />
            </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        $('select[name=fid]').change(function(){
            var id = $(this).val();
            //alert(id);
            $.ajax({
                url:'/api/document/get_classify_base/'+id,
                type:'get',
                dataType: 'json',
                success:function(response){
                    if(response.status) {
                        var str = '<option value="">请选择</option>';
                        for(i=0;i<response.data.length;i++){
                            str+="<option value='"+i+"'>"+response.data[i].tag+"</option>";
                        }
                        $('#tag').html('');
                        $('#tag').append(str);
                    }
                }
            });
        });
        $('select[name=tag]').change(function(){
            //alert($(this).val());
        });
        $('#establish_date').datepicker({ dateFormat: 'yy-mm-dd' });

        $('#save_form_btn').click(function() {
            var btn = $(this);
            var form_id = 'save_form';
            btn.prop('disabled', true);
            $.ajax({
                type:'post',
                url:'<?php echo site_url('m-site/classifies/save')?>',
                dataType: 'json',
                data:{action:'save',type:$("select[name=type]").val(),tag:$("select[name=tag]").val(),message:$('#message').val(),name:$('#name').val(),intro:$('#intro').val()},
                success: function(response) {
                    if(response.status) {
                        success_msg_show('form_msg', '添加成功！您可以继续添加分类');
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
