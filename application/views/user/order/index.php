<style>
    a:hover{
         text-decoration: none;
    }
    a:click{
        text-decoration: none;
    }
    a:visited{
        text-decoration: none;
    }
</style>
<!-- 遮罩体部分结束 -->
<script src="<?php echo base_url()?>static/public/js/collapse.js"></script>
<script src="<?php echo base_url()?>static/public/js/tab.js"></script>
<!-- 免费帮你做，又免费多送你个功能  -->
<script src="<?php echo base_url()?>static/public/js/modal.js"></script>
<script src="<?php echo base_url()?>static/public/js/tooltip.js"></script>
<script src="<?php echo base_url()?>static/public/js/popover.js"></script>
<script src="<?php echo base_url() ?>static/lib/raty/js/jquery.js"></script>
<script src="<?php echo base_url() ?>static/lib/raty/js/jquery.raty.min.js"></script>
<div class="row" style="margin-top:100px;">
    <?php require($views_path . 'public/user_leftmenu.php');?>

    <div class="col-md-9">
        <div class="colmdbtl rightTitle yj" style="right:40px;left:40px;">我的订单</div>
        <div class="row">
            <div class="col-md-12" style="margin-top:30px;">
                <div class="tabbable" id="tabs-445084">
                    <ul class="nav nav-tabs">
                        <li <?php if(!$state){?>class="active" <?php }?> ><a href="<?php echo site_url('user/order/index')?>">所有订单</a></li>
                        <li <?php if($state==1){?>class="active" <?php }?> ><a href="<?php echo site_url('user/order/index')?>?state=1">未支付</a></li>
                        <li <?php if($state==2){?>class="active" <?php }?> ><a href="<?php echo site_url('user/order/index')?>?state=2">已支付</a></li>
                        <li <?php if($state==6){?>class="active" <?php }?> ><a href="<?php echo site_url('user/order/index')?>?state=6">已完成</a></li>
                        <li class="total-num"><a class="btn btn-default">总数：xx个</a></li>
                    </ul>
                        <img alt="" src="<?php echo base_url()?>static/public/images/rubbish.png"/>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="panel-1">
                            <!-- 我上传的选项卡内容 -->
                            <table class="table table-hover" style="border-top: solid 3px #32465D;">
                                <thead>
                                <tr>
                                    <th>
                                        <label class="checkbox-inline" style="font-weight: bolder;">
                                            <input type="checkbox" value="">订单名
                                        </label>
                                    </th>
                                    <th>订单号</th>
                                    <th>订单状态</th>
                                    <th>下单时间</th>
                                    <th>数量</th>
                                    <th>金额</th>
                                    <th>操作</th>
                                    <th style="width:35px;">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($my_order as $order): ?>
                                    <tr>
                                        <td><label class="checkbox-inline" style="color:<?php order_state_color($order['state'])?>;"><input
                                                    type="checkbox" value=""><?php echo get_order_title($order['message']);?>
                                            </label></td>
                                        <td style="color:<?php order_state_color($order['state'])?>;"><?php echo $order['order_id'];?></td>
                                        <td style="color:<?php order_state_color($order['state'])?>;"><?php echo order_state($order['state'])?></td>

                                        <td><?php echo substr($order['place_time'],0,9);?></td>
                                        <td><?php echo $order['sum_num'];?>份</td>
                                        <td><?php echo $order['price'];?>元</td>
                                        <td><a href="#" style="color:#17A8CD;font-weight:bolder;">评论</a>

                                            <?php if($order['state']==5){  ?>
                                                <a onclick="confirm_order('<?php echo $order['order_id'];?>');" href="javascript:void(0)" style="color:red;font-weight:bolder;">确认订单</a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="dropdown-toggle" href="#" data-toggle="dropdown"><img alt="" src="/static/public/images/dropdown.png"/></a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo site_url('user/order/details').'/'.$order['order_id']?>">订单详情</a></li>
                                                    <li><a href="javascript:void(0);" onclick="do_place_again('<?php echo $order['order_id'];?>')">再次订单</a></li>
                                                    <li><?php if($order['state']>1 && $order['state']<5){  ?>
                                                            <a  href="<?php echo site_url('user/order/eligible_refund')?>" style="color:red;font-weight:bolder;">申请退款</a>
                                                        <?php } ?></li>
                                                    <li><?php if($order['state']==5){  ?>
                                                            <a onclick="confirm_order('<?php echo $order['order_id'];?>');" href="javascript:void(0)" style="color:red;font-weight:bolder;">确认订单</a>
                                                        <?php } ?></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        <div class="row">
            <div class="col-sm-offset-1 col-sm-6" style="text-align: left;float: left;">
                <ul class="pagination">
                    <?php if($page>1){?><li><a href="<?php echo site_url('user/order/index/').'/'.($page-1).'?state='.$state;?>">上一页</a></li><?php }?>
                    <?php if(($page-2)>0){?><li>
                        <a href="<?php echo site_url('user/order/index/').'/'.($page-2).'?state='.$state;?>"><?php echo $page-2;?></a></li><?php }?>
                    <?php if(($page-1)>0){?><li>
                        <a href="<?php echo site_url('user/order/index/').'/'.($page-1).'?state='.$state;?>"><?php echo $page-1;?></a></li><?php }?>
                    <li>
                        <a href="<?php echo site_url('user/order/index/').'/'.($page).'?state='.$state;?>"><?php echo $page;?></a></li>
                    <?php if(($count-($page)*$limit)>0){?><li>
                        <a href="<?php echo site_url('user/order/index/').'/'.($page+1).'?state='.$state;?>"><?php echo $page+1;?></a></li> <?php }?>
                    <?php if(($count-($page+1)*$limit)>0){?><li>
                        <a href="<?php echo site_url('user/order/index/').'/'.($page+2).'?state='.$state;?>"><?php echo $page+2;?></a></li> <?php }?>
                    <?php if(($count-($page)*$limit)>0){?><li>
                        <a href="<?php echo site_url('user/order/index/').'/'.($page+1).'?state='.$state;?>">下一页</a></li> <?php }?>
                </ul>
            </div>
        </div>
    </div>


<!-- 遮罩体部分开始 -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">评论</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin: 0px;">
                    <textarea rows="6" class="form-control" placeholder="请在此输入评论内容"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-left">评分</div>
                <div class="pull-right">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary">发布</button>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    function show_order(id){
        if($('.order_message_'+id).hasClass('hide')){
            $('.order_message_'+id).removeClass('hide');
        }else{
            $('.order_message_'+id).addClass('hide');
        }
    }
    function confirm_order(order_id){
        $.ajax({
            url:'<?php echo site_url('user/order/confirm_order')?>',
            type:'post',
            dataType:'json',
            data:{order_id:order_id},
            success:function(data){
                if(data.status==true){
                    alert('确认订单成功');
                }else{
                    alert('确认订单失败');
                }
            }
        })
    }
    function del_order(order_id){
        $.ajax({
            url:'<?php echo site_url('user/order/del_order')?>/'+order_id,
            type:'get',
            dataType:'json',
            data:{order_id:order_id},
            success:function(data){
                if(data.status==true){
                    alert('确认订单成功');
                }else{
                    alert('确认订单失败');
                }
            }
        })
    }
</script>
