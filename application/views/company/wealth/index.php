<script src="<?php echo base_url()?>static/public/js/tab.js"></script>
<style type="text/css">

</style>
<div class="row" style="margin-top:100px;">
    <?php require($views_path . 'public/company_left.php');?>
    <div class="col-md-9">
        <div class="colmdbtl rightTitle yj" style="right:40px;left:40px;">财富中心</div>
        <div class="row">
            <?php //require($views_path . 'public/count_info.php');?>
            <div class="col-md-10 col-md-offset-1" style="border:solid 2px #32465D;">
                <div class="row" style="border-bottom:solid 2px #32465D;">
                    <div class="col-md-12" style="border-right:solid 1px #32465D;">
                        <div class="cfzx" style="height:115px;line-height:115px;font-weight:bolder;color:#32465D;">存款</div>
                        <div class="col-md-9">
                            <div style="height:115px;line-height:115px;font-weight:bolder;"><span style="color:#32465D;">总额：</span><span style="color:#9A5C33"><?php echo $company_user['available_payment'];?>元</span></div>
                           <div style="height:57px;line-height:57px;font-weight:bolder;">现额：<span style="color:#9A5C33"><?php echo $company_user['payment'];?>元</span></div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12" style="height:60px;line-height:60px;border-right:solid 1px #32465D;">
                        <div class="col-md-7" style="font-weight:bolder;color:#32465D;">存款=订单提交总额-平台提成-用户返利</div>
                        <div class="col-md-5" style="font-weight:bolder;color:silver;">可直接提现</div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="margin-top:30px;" style="border: none;">
                    <div class="tabbable" id="tabs-445084" >
                        <ul class="nav nav-tabs" style="border: none;">
                            <li class="total-num" style="float: left; margin-left: 38%;">
                                <a class="btn btn-default" href="/user/wealth/history/deposit" style="height: 50px;line-height: 40px;">存款收支</a>
                            </li>
                            <li class="total-num" style="float: left;">
                                <a class="btn btn-default" href="" style="height: 50px;line-height: 40px;">我要提现</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

    </div>
</div>