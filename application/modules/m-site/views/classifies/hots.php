<style type="text/css">
#lbsMap {width: 600px;height: 400px;overflow: hidden;margin:0;margin-top: 20px}
</style>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
         <li>
            <a href="javascript:void(0);" onclick="change_channel('system');">系统管理</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url('m-site/classifies')?>">分类列表</a> <span class="divider">/</span>
        </li>
        <li>
            热词
        </li>
    </ul>
</div>

<div class="row-fluid">

        <span class="span6">
            &nbsp;&nbsp;&nbsp;&nbsp;
        </span>
</div>
<div class="row-fluid">
    <form class="form-horizontal" method="post"
          id="save_form"
          action=""
          onsubmit="return false;">
        <fieldset>
            <legend><h2 style="display: inline;"><?php echo $type;?></h2>  的热词列表
                <a href="<?php echo site_url('m-site/classifies/add_hot')?>" class="btn btn-toolbar btn-info pull-right" style="margin-left: 20px;">
                    <i class="icon icon-add icon-white"></i>
                    添加热词
                </a></legend>
            <div id="form_msg" class="alert" style="display: none;">
                <button type="button" class="close" onclick="$('#form_msg').hide();">×</button>
                <p></p>
            </div>


            <div class="control-group">
                <label class="control-label">热词信息</label>
                <div class="controls">
                   <?php foreach($hots as $hot):?>
                       <div>
                       <button type="button" class="btn" onclick="delete_hot('<?php echo $hot?>',this);">点击删除</button>
                       &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hot?><br/>
                       <br/>
                       </div>
                   <?php endforeach;?>
                </div>
            </div>


            <div class="form-actions">
            </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript">
    function delete_hot(hot,obj) {

        $.ajax({
         type:'post',
         url:'<?php echo site_url('m-site/classifies/do_del_hot')?>',
         dataType: 'json',
         data:{type_key:<?php echo $type_key?>,hot:hot},
         success: function(response) {
             if(response.status) {
             success_msg_show('form_msg', '删除成功！您可以继续添加分类');
             $(obj).parent().fadeOut(1000);

             }else if(!response.status) {
             error_msg_show('form_msg', response.msg);
             } else {
             alert('操作失败，请重试或联系管理员！');
             console.log(response);
             }

            }
         });
        return false;
    }
</script>
