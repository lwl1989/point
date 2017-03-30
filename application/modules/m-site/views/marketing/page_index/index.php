<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="change_channel('marketing');">营销管理</a> <span class="divider">/</span>
        </li>
        <li>
             <a href="<?php echo site_url('m-site/marketing/page_index/index')?>">页面管理</a> <span class="divider">/</span>
        </li>
        <li>
            首页推荐
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
            <form action="<?php echo site_url('m-site/marketing/page_index')?>" >

                推荐方式:<select id="recommend_type" name="recommend_type" class="selector_root">
                    <option value="">请选择推荐类别</option>
                    <option value="companies">公司推荐
                    </option>
                    <option value="article">内容推荐
                    </option>
                </select>
                <button id="save_form_btn" type="submit" class="btn btn-primary">查询</button>

            </form>
        </div>
    </div>
    <div class="row-fluid">
        <span class="span6">
        </span>
        <span class="span6">
            <a class="btn btn-info btn-mini pull-right"
               onclick="refresh_cache('<?php echo site_url('m-site/marketing/page_index/generate_config');?>')"
               href="#">
                <i class="icon-refresh icon-white"></i>
                更新缓存文件
            </a>
        </span>
    </div>

    <!--列表-->

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>推荐方式</th>
            <th>推荐内容</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="data_body">
        <?php foreach ($items as  $item):?>
            <tr>
                <td><?php echo $item['id']?></td>
                <td>
                    <?php
                    foreach($func as $val): ?>
                         <?php if($val['func']==$item['func']){
                           echo  $val['func_cn'];
                        }?>
                    <?php endforeach; ?>
                </td>
                <td>
                    <a href="http://node.aixiu.com/<?php if($recommend_source=='companies'){echo 'company';}else{ echo $recommend_source;}?><?php echo '/'.$item['source_id'];?>">
                    <?php echo $item['name'];?>
                    </a>
                </td>
                <td>
                    <a class="btn btn-primary btn-mini"
                       href="<?php echo site_url('m-site/marketing/page_index/set_recommend/'.$item['id']);?>">
                        <i class="icon-zoom-in icon-white"></i>
                        更改
                    </a>

                </td>
            </tr>
        <?php endforeach;?>

        </tbody>
    </table>
</div>
