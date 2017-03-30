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
<div class="row" style="margin-top:100px;">
    <?php require($views_path . 'public/company_left.php');?>

    <div class="col-md-9">
        <div class="colmdbtl rightTitle yj" style="right:40px;left:40px;">我的订单</div>
        <div class="row">
            <div class="col-md-12" style="margin-top:30px;">
                <div class="tabbable" id="tabs-445084">
                    <ul class="nav nav-tabs">
                        <li <?php if($state==1){?>class="active" <?php }?> ><a href="/company/order/index?status=1">收到订单(未支付)</a></li>
                        <li <?php if($state==2){?>class="active" <?php }?> ><a href="/company/order/index?status=2">收到订单(已支付)</a></li>
                        <li <?php if($state==4){?>class="active" <?php }?> ><a href="/company/order/index?status=4">正在打印</a></li>
                        <li <?php if($state==5){?>class="active" <?php }?> ><a href="/company/order/index?status=5">已打印</a></li>
                        <li <?php if($state==6){?>class="active" <?php }?> ><a href="/company/order/index?status=6">已完成</a></li>
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
                                    <th style="width:35px;">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($orders as $order): ?>
                                    <tr class="order_list">
                                        <td><label class="checkbox-inline" style="color:<?php order_state_color($order['state'])?>;"><input
                                                    type="checkbox" value=""><?php echo get_order_title($order['message']);?>
                                            </label></td>
                                        <td style="color:<?php order_state_color($order['state'])?>;"><?php echo $order['order_id'];?></td>
                                        <td style="color:<?php order_state_color($order['state'])?>;"><?php echo order_state($order['state'])?></td>

                                        <td><?php echo substr($order['place_time'],0,9);?></td>
                                        <td><?php echo $order['sum_num'];?>份</td>
                                        <td><?php echo $order['price'];?>元</td>


                                            <?php if($order['state']==5){  ?>
                                                <a onclick="confirm_order('<?php echo $order['order_id'];?>');" href="javascript:void(0)" style="color:red;font-weight:bolder;">确认订单</a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"><img alt="" src="/static/public/images/dropdown.png"/></a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo site_url('user/order/details').'/'.$order['order_id']?>">订单详情</a></li>
                                                    <li><?php if($order['state']>1 && $order['state']<4){  ?>
                                                            <a  href="javascript:void(0)" style="color:red;font-weight:bolder;" onclick="print_order('<?php echo $order['order_id'];?>','<?php echo $company_id;?>',this);">打印订单</a>
                                                        <?php } ?></li>
                                                    <li><?php if($order['state']==4){  ?>
                                                            <a onclick="printed_order('<?php echo $order['order_id'];?>','<?php echo $company_id;?>',this);" href="javascript:void(0)" style="color:red;font-weight:bolder;">打印完成</a>
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
               <?php echo $pagination;?>
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
