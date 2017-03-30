<div class="page-content">

    <div class="container-fluid" >
        <div class="row-fluid">
            <div class="span12">
                <h3 class="page-title">
                    增加商品 <small>Add product</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="/m-admin">首页</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li><a href="<?php echo(site_url('m-admin/wechat_key'));?>">微信关键字</a> <i class="icon-angle-right"></i></li>
                    <li class="pull-right no-text-shadow">
                    </li>
                    <li><a href="#">添加</a></li>
                    <li class="pull-right no-text-shadow">
                    </li>

                </ul>
            </div>

            <form action="<?php echo site_url('m-admin/wechat_key/do_save');?>" class="form-horizontal" method="post">

                <div class="control-group">

                    <label class="control-label">关键字</label>

                    <div class="controls">

                        <input type="text" placeholder="关键字:比如 你好" class="m-wrap large" name="keyword">

                        <span class="help-inline"></span>

                    </div>

                </div>

                <div class="control-group">

                    <label class="control-label">功用</label>

                    <div class="controls">

                        <input type="text" placeholder="作用是干什么的" class="m-wrap large" name="intro">

                        <span class="help-inline"></span>

                    </div>

                </div>

                <div class="control-group" >

                    <label class="control-label">消息类型</label>

                    <div class="controls">
                        <select class="medium m-wrap" tabindex="1" name="type" id="type">
                            <option value="0">请选择</option>
                            <option value="1">文本</option>
                            <option value="2">图文</option>
                        </select>

                    </div>

                </div>

                <div class="control-group text_add hide">
                    <label class="control-label">添加内容</label>
                    <div class="controls">
                        <input type="text" placeholder="文本回复的内容" class="m-wrap large" name="source_text">
                        <span class="help-inline"></span>
                    </div>
                </div>


                <div class="control-group images_add hide">
                    <label class="control-label">添加内容</label>
                    <div class="controls">
                        <button id="add_citiao" type="button" class="btn btn-default" style="margin-left: 10%;">添加内容</button>
                    </div>
                </div>
                <div class="add_source">

                </div>


                <div class="form-actions">
                    <div class="danger hide blue" id="error_message" style="color: red;"></div>
                    <button type="button" class="btn blue" id="do_add"><i class="icon-ok"></i> Save</button>
                    <button type="button" class="btn">Cancel</button>
                </div>

            </form>

        </div>
    </div>
</div>
<script src="/static/js/lib/jquery.json.min.js"></script>
<script>
  $(document).ready(function() {
      var citiao_id = $(".add_source").children(".control-group").length;
      $('#type').change(function(){
          var type = $(this).val();
          if(type==0||type==1){
              $('.text_add').removeClass('hide');
              $('.images_add').addClass('hide');
          }else{
              $('.text_add').addClass('hide');
              $('.images_add').removeClass('hide');
          }
      });
      $("#add_citiao").click(function () {
          str = '<div class="source_images" alt="' + citiao_id + '"><div class="control-group title_images" >' +
          '<label class="control-label">标题</label>' +
          '<div class="controls"> <input type="text" id="title_' + citiao_id + '" name="title_' + citiao_id + '" class="input-xlarge" /> </div><br/>' +
          '<label class="control-label">简介</label>' +
          '<div class="controls"> <input type="text" id="Description_' + citiao_id + '" name="Description_' + citiao_id + '" class="input-xlarge" /> </div><br/>' +
          '<label class="control-label">封面链接</label>' +
          '<div class="controls"> ' +
          '<input type="text"  id="image_' + citiao_id + '" name="image_' + citiao_id + '" class="input-xlarge"  /><span>(可以为外部网址的图片)</span>' +
          ' </div><br/>'+
          '<label class="control-label">外部链接</label>' +
          '<div class="controls"> ' +
          '<input type="text"  id="url_' + citiao_id + '" name="url_' + citiao_id + '" class="input-xlarge"  /><span>(可以为外部网址)</span>' +
          ' </div><br/>'+
          '<label class="control-label">排序值</label><div class="controls"> ' +
          '<input type="text"  id="sort_' + citiao_id + '" name="sort_' + citiao_id + '" class="input-xlarge"  />' +
          ' </div>'+'</div>';
          str += '  <div class="control-group" > <label class="control-label">选择来源</label> <div class="controls">'+
          '<select class="medium m-wrap" tabindex="1" name="source_selected" id="source_'+citiao_id+'">'+
          '<option value="0">请选择</option>'+
          '<option value="notice">新闻、通知</option> <option value="products">商品</option> </select> </div> </div>';
          str+='<div class="source_list"></div></div>';
          $(".add_source").append(str);
          citiao_id++;
      });
      $("select[name=source_selected]").live("change",function(){
          var obj = $(this);

          var id = $(this).attr('id').substr(7);
         // alert(id);
          var url = '';
          var type = $(this).val();
          if(type=='products'){
                  url= '<?php echo site_url('api/product/get_list');?>';
              }else if(type=='notice'){
                  url= '<?php echo site_url('api/notice/get_list');?>';
              }else{
              //    alert('错误');
              obj.parent().parent().parent().find('.source_list').html('');
                  return false;
              }

          $.ajax({
              'method': 'get',
              'dataType': 'json',
              'url': url,
              'success': function (data) {
                  if (data.status == true) {
                     var i =0;
                      var count = data.data.length;
                      var str = '<div class="control-group" > <label class="control-label">选择内容</label> <div class="controls">';
                      str +=  '<select class="medium m-wrap" tabindex="1" name="source_id" id="source_id_'+id+'">';
                      for(;i<count;i++){
                          str += '<option value="'+data.data[i].id+'">'+data.data[i].name+'</option>';
                      }
                      str += '</div></div><div style="border: 1px solid #eee;height: 2px;"></div>';
                      obj.parent().parent().parent().find('.source_list').html('');
                      obj.parent().parent().parent().find('.source_list').append(str);
                  }
              }
          });
      });

      var size = '';
      $('#do_add').click(function () {
          var type =$('#type').val();
          var keyword = $("input[name=keyword]").val();
          var intro = $("input[name=intro]").val();
          var source_post = '';
          if(type==0||type==1){
              source_post = $('input[name=source_text]').val();
          }else{
              var num_div =$(".add_source").children(".source_images").length;
              var i=0;
              var myArray=new Array();
              for(;i<num_div;i++){
                  var id =  $(".add_source .source_images").eq(i).attr('alt');
                  var title_id = '#title_'+id;
                  var cover_id = "#image_"+id;
                  var source_id = "#source_"+id;
                  var source_id_id = '#source_id_'+id;

                  var sort_id = '#sort_'+id;
                  var title = $(title_id).val();
                  var Description = $('#Description_'+id).val();
                  var source = $(source_id).val();
                  var source_id_val = $(source_id_id).val();
                  var cover = $(cover_id).val();
                  var sort = $(sort_id).val();
                  var url =$('#url_'+id).val();
                  myArray[i] = { title:title,url:url,description:Description,source:source,picUrl:cover,sort:sort,source_id:source_id_val}
              }
               source_post = $.toJSON(myArray);
          }
              $.ajax({
                  'method': 'post',
                  'data': {
                      type: type,
                      source:source_post,
                      keyword:keyword,
                      intro:intro
                  },
                  'dataType': 'json',
                  'url': '<?php echo site_url('m-admin/wechat_key/do_save');?>',
                  'success': function (data) {
                      if (data.status == true) {
                          alert('添加成功');
                          window.location.href = '<?php echo site_url('m-admin/wechat_key');?>';
                      } else {
                          alert('添加失败');
                      }
                  }
              });

      });
      $('#cid').change(function () {
          var fid = $(this).children('option:selected').val();
          var div_id = 'radio_' + fid;
          $('#select_classify').find('.controls').hide();
          $('#' + div_id).show();
      });
  });
</script>

<!-- END PAGE -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="footer">

    <div class="footer-inner">

        2013 © Metronic by keenthemes.

    </div>

    <div class="footer-tools">

			<span class="go-top">

			<i class="icon-angle-up"></i>

			</span>

    </div>

</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->

