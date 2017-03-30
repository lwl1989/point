<div class="page-content">

    <div class="container-fluid" >
        <div class="row-fluid">
            <div class="span12">
                <h3 class="page-title">
                    新闻列表 <small>News list</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="/m-admin">首页</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li><a href="<?php echo(site_url('m-admin/wechat_key'));?>">微信关键字</a></li>

                </ul>
            </div>
                <div class="portlet box light-grey">

                    <div class="portlet-title">

                        <div class="caption"><i class="icon-globe"></i>列表</div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                        </div>

                    </div>

                    <div class="portlet-body">

                        <div class="clearfix">

                            <div class="btn-group">

                                <button id="sample_editable_1_new" class="btn green">

                                    添加关键字 <i class="icon-plus"></i>

                                </button>

                            </div>

                            <div class="btn-group pull-right">

                                <div class="dataTables_filter" id="sample_1_filter">
                                    <label>搜索: <input type="text" aria-controls="sample_1" class="m-wrap medium" id="search_news"></label>
                                </div>
                            </div>

                        </div>

                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <div class="row-fluid">
                            </div>
                            <div class="span9" style="color: red;">

                                <p><span>微信公众号接口:<?php echo site_url('wechat/index');?></span>
                                    &nbsp;&nbsp;&nbsp;&nbsp;token:可以在配置文件里设置 默认为 "sypsm"</p>


                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover dataTable" id="sample_1" aria-describedby="sample_1_info">
                                <thead>

                                <tr role="row">
                                    <th style="width: 24px;" class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="">
                                        <div class="checker"><span><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"></span></div>
                                    </th>
                                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Username: activate to sort column ascending" style="width: 254px;">发布者</th>
                                    <th class="hidden-480 sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="Email" style="width: 462px;">标题</th>
                                    <th class="hidden-480 sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Points: activate to sort column ascending" style="width: 201px;">点击量</th>
                                    <th class="hidden-480 sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="Joined" style="width: 301px;">发布时间</th>
                                    <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="" style="width: 267px;"></th>
                                </tr>

                                </thead>

                                <tbody role="alert" aria-live="polite" aria-relevant="all">

                                <?php foreach ($pagination['list'] as $v): ?>
                                    <tr class="gradeX odd">

                                        <td class=" sorting_1">
                                            <div class="checker"><span><input type="checkbox" class="checkboxes" value="1"></span></div></td>

                                        <td class=""><?php echo $v['keyword'];?></td>

                                        <td class="hidden-480 "><a href="<?php echo site_url('news/show').'/'.$v['id'];?>"><?php echo $v['intro'];?></a></td>

                                        <td class="hidden-480 "><?php echo ($v['type']==1)?'文本':'图文';?></td>

                                        <td class="center hidden-480 "><?php echo $v['keyword_pinyin'];?></td>

                                        <td class=" "><a href="<?php echo site_url('m-admin/wechat_key/del').'/'.$v['id'] ?>"><span class="label label-warning">删除</span></a></td>

                                    </tr>
                                <?php endforeach;?>


                                </tbody></table>
                           <div class="row-fluid">
                                    <div class="span6"><div class="dataTables_info" id="sample_1_info"></div></div>
                                    <div class="span6"><div class="dataTables_paginate paging_bootstrap pagination">
                                    <?php echo $pagination['page_html'];?>
                           </div></div></div></div>

                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
<script>
    $('#sample_editable_1_new').click(function(){
       window.location.href = '<?php echo site_url("m-admin/wechat_key/set_key");?>';
    });
    $('#search_news').keydown(function(e){
        if(e.keyCode==13){
            var key = $('#search_news').val();
            var url =encodeURI('<?php echo(site_url("m-admin/news/search/"))?>'+'/'+key);
            window.location.href = url;
        }
    });
</script>