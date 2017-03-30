<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('m-site')?>">管理首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="change_channel('contents');">内容管理</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url('m-site/withdraw_deposit');?>">提现管理</a> <span class="divider">/</span>
        </li>

        <li>
            申请列表
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
            <form action="<?php echo site_url('m-site/withdraw_deposit')?>" >
                流水号查询:<input type="text" name="source_id" class="input-small" value="<?php echo $source_id;?>"/>
                <button id="save_form_btn" type="submit" class="btn btn-primary">查询</button>
            </form>
        </div>
    </div>
    <!--列表-->

    <div class="row-fluid">
        <span class="span6">
        </span>

    </div>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>商家ID</th>
            <th>source_id</th>
            <th>提现金额</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="data_body">
        <?php if($pagination['list']): foreach($pagination['list'] as $vo):?>
            <tr id="data<?php echo $vo['id'];?>">
                <td><?php echo $vo['id'];?></td>
                <td>

                    <?php
                    echo $vo['company_id'];
                    ?>

                </td>
                <td>
                    <?php
                    echo $vo['source_id'];
                    ?>

                </td>
                <td>
                    <?php
                    echo $vo['score'];
                    ?>

                </td>
                <td>
                    <a class="btn btn-info btn-mini statues_deposit"
                       href="javascript:void(0);">
                        <i class="icon-edit icon-white"></i>
                        <?php if($vo['is_true'])
                            echo '完成';
                        else
                            echo '等待';
                        ?>
                    </a>
                </td>
                <td class="is_true_deposit">

                    <?php if(!$vo['is_true']): ?>
                    <a class="btn btn-danger btn-mini" href="#"
                       onclick="return do_true(<?php echo $vo['id'];?>);">
                        <i class="icon-trash icon-white"></i>
                        处理
                    </a>
                    <?php endif ?>
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


<script  type="text/javascript">

    function do_true(id)
    {
        if(!confirm('此提现作业已处理？'))
            return false;
        $.post(
            "<?php echo site_url('m-site/withdraw_deposit/do_reflect')?>",
            { id: id, action: 'del' },
            function(response){
               // response.toJSON;
              //  response.
                if(response.status) {
                    $('#data' + id).find('.statues_deposit').html('<i class="icon-edit icon-white"></i>完成');
                    $('#data' + id).find('.is_true_deposit').html('');
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

</script>