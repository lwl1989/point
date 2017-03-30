<div class="col-md-3">
    <div class="col-md-12 leftTitle yj">
        个人中心
    </div>
    <div class="row">
        <div class="colmd11" style="margin-top:15px;margin-bottom:15px;">
            <div class="left-mid">
                <div class="num"><?php echo $statistics['document_num'];?></div>
                <div class="content">文档数</div>
            </div>
            <div class="left-mid">
                <div class="num"><?php echo round($statistics['deposit_total']);?></div>
                <div class="content">
                    财富总值
                </div>
            </div>
            <div class="left-mid">
                <div class="num"><?php echo $user['available_score'];?></div>
                <div class="content">
                    可用积分
                </div>
            </div>
        </div>
    </div>
    <div class="list-group">

        <a class="list-group-item boderBottom  " href="<?php echo site_url('user/document');?>" style="font-weight:bolder;">
            <span class="glyphicon glyphicon-chevron-right"></span>
            &nbsp;&nbsp;文档列表
        </a>
        <a class="list-group-item boderBottom" href="<?php echo site_url('user/order');?>" style="font-weight:bolder;">
            <span class="glyphicon glyphicon-chevron-right"></span>
            &nbsp;&nbsp;我的订单
        </a>
        <a class="list-group-item  boderBottom" href="<?php echo site_url('user/account');?>" style="font-weight:bolder;">
            <span class="glyphicon glyphicon-chevron-right"></span>
            &nbsp;&nbsp;个人信息
        </a>
        <a class="list-group-item boderBottom " href="<?php echo site_url('user/account/change_password');?>" style="font-weight:bolder;">
            <span class="glyphicon glyphicon-chevron-right"></span>
            &nbsp;&nbsp;修改密码
        </a>
        <a class="list-group-item boderBottom " href="<?php echo site_url('user/message');?>" style="font-weight:bolder;">
            <span class="glyphicon glyphicon-chevron-right"></span>
            &nbsp;&nbsp;消息
        </a>
        <a href="<?php echo site_url('user/wealth');?>">
            <button class="btncf btn-default" style="background-color:#fff;width: 256px;margin-top:10px;">
                财富中心</button></a>
        <br><br>
		
        <button class="btncf btn-default" style="background-color:#fff;width: 256px;" onclick="window.location.href='/cart'">我的书单</button>
    </div>
</div>