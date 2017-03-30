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
    .navbar-default {background:white;}
    .navbar-brand {padding-top:5px;}
    .navbar-default .navbar-nav>li>a, .btn-default, .radio label, .checkbox label{color: #32465D;font-weight: bolder;font-size: 16px;}
    .btn {font-weight: bolder;font-size:16px;}
    /* 最大宽度为768px时，里面的样式生效；即宽度小于768px时，里面的样式生效 */
    @media(max-width:768px){
        .mediaPaddingLeft{
            padding-left:10px;
        }
    }
    .mediaPaddingLeft a{color:#32465D;font-weight:bolder;font-size:16px;margin:15px 0 0 10px;display:inline-block;}
    .leftTitle,.rightTitle{background:#32465D;font-weight: bolder;font-size: 20px;color:white;height:56px;line-height:56px;}
    .leftTitle{text-align:center;}
    .rightTitle{text-align:left;}
    .left-mid{width:33.33%;float:left;border-right:dotted 1px #ccc;}
    .left-mid:last-child{border-right:none;}
    .left-mid div{text-align:center;white-space:nowrap;}
    .num{color:#9A5C33;font-size:30px;}
    .content{font-weight:bolder;}
    .list-group .boderBottom{border-top:none;border-right:none; border-bottom:solid 1px #ccc;border-left:none;margin-bottom:0px;font-size:16px;
        padding-top:0px;padding-bottom:0px;height:74px;line-height:74px;}
    .right-bottom{padding-left:40px;}
    .right-bottom .row{border-bottom:solid 1px #ccc;padding-top:10px;padding-bottom:10px;}
    .right-bottom .row:first-child{border-top:solid 1px #ccc;margin-top:30px;}
    .title,.right-content{color:#657471;}
    .title{font-size:16px;font-weight:bolder;padding-left:0px;width:50%;float:left;}
    .right-content{font-size:13px;}
    .right-content .col-md-1,.right-content .col-md-5,.right-content .col-md-6{float:left;}
    .right-content .col-md-1{width:8.333%;}
    .right-content .col-md-5{width:41.666%;}
    .right-content .col-md-6{width:50%;}
</style>
<div class="row" style="margin-top:100px;">
    <?php require($views_path . 'public/user_leftmenu.php');?>
    <div class="col-md-9">
        <div class="colmdbtl rightTitle yj" style="right:40px;left:40px;">订单详情</div>
        <div class="col-md-9 right-bottom">
            <div class="row">
                <div class="col-md-12 title">商家信息</div>
            </div>
            <div class="row right-content">
                <div class="col-md-6">名称：<?php echo $company['name'];?></div>
                <!--<div class="col-md-6">店主姓名：<?php echo $company['name'];?></div>-->
                <div class="col-md-6">地址：<?php echo $company['address'];?></div>
                <div class="col-md-6">联系电话：<?php echo $company['mobile'];?></div>
                <!--<div class="col-md-6">邮箱：18459643215@163.com</div>-->
            </div>
            <div class="row">
                <div class="col-md-12 title">订单信息</div>
            </div>
            <div class="row right-content">
                <div class="col-md-6">订单号：<?php echo $order['order_id'];?></div>
                <div class="col-md-6">总数量：<?php echo $order['sum_num'];?></div>
                <div class="col-md-6">总页数：<?php echo $order['sum_page'];?></div>
                <div class="col-md-6">总金额：<?php echo $order['price'];?></div>
            </div>
            <?php $i=1; foreach($order_message as $document): ?>
                <div class="row right-content">
                    <div class="col-md-1">(<?php echo $i;?>)</div>
                    <div class="col-md-6">
                        <div>订单名称：<?php echo $document['title'];?></div>
                        <div>数量：<?php echo $document['file_num'];?></div>
                    </div>
                    <div class="col-md-5">
                        <div>页数：<?php echo $document['page'];?></div>
                        <div>金额：<?php echo $document['price'];?>*<?php echo $document['file_num'];?>*<?php echo $document['page'];?></div>
                    </div>
                </div>
            <?php endforeach;?>

            <div class="row">
                <div class="col-md-6 title">订单状态：<?php echo order_state($order['state'])?></div>
                <div class="col-md-6 title">时间：<?php echo $order[order_state_en($order['state']).'_time'];?></div>
            </div>
            <div class="row right-content">
                <div class="col-md-6">下单时间</div><div class="col-md-6"><?php echo $order['place_time'];?></div>
                <div class="col-md-6">支付时间</div><div class="col-md-6"><?php echo $order['payed_time'];?></div>
                <div class="col-md-6">打印时间</div><div class="col-md-6"><?php echo $order['printed_time'];?></div>
                <div class="col-md-6">收货时间</div><div class="col-md-6"><?php echo $order['user_confirm_time'];?></div>
            <!--    <div class="col-md-6">完成时间</div><div class="col-md-6"><?php echo $order['place_time'];?></div>-->
            </div>
        </div>
    </div>
</div>