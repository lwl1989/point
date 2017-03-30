<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/31
 * Time: 12:09
 */


class pay extends MY_Controller{
    protected $alipay_config=array();
    function __construct(){
        parent::__construct();
        $this->load->config('alipay');
        $this->alipay_config = $this->config->item('alipay_config');
        $this->load->model('api_order');
    }

    /*
     * 支付
     * 会自动跳转到支付宝界面
     * 提交参数  order_id、subject、payment
     */
    function pay_order(){
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = site_url('api/pay/notify');
        //需http://格式的完整路径，不能加?id=123这类自定义参数
        //页面跳转同步通知页面路径
        $return_url = site_url('user/order');
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
        //商户订单号
        //商户网站订单系统中唯一订单号，必填
        $out_trade_no = trim($this->input->get('order_id'));
        $order = $this->api_order->get_order_by_id($out_trade_no);
        //https://pay.vancl.com/shopping_pay.aspx?orderid=770100031733&paymenttypeid=16&paymentbank=16&t=shop
        //订单名称
        $subject = '学霸银行';
        //必填
        //付款金额
        $total_fee = floatval(trim($order['price']));
        //必填
        //订单描述
        $body = '学霸银行打印订单';
        //商品展示地址
        $show_url = "http://www.xuebabank.com/";
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数
        //客户端的IP地址
        $exter_invoke_ip = "";

        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($this->alipay_config['partner']),
            "seller_email" => trim($this->alipay_config['seller_email']),
            "payment_type"	=> $payment_type,
            "notify_url"	=> $notify_url,
            "return_url"	=> $return_url,
            "out_trade_no"	=> $out_trade_no,
            "subject"	=> $subject,
            "total_fee"	=> $total_fee,
            "body"	=> $body,
            "show_url"	=> $show_url,
            "anti_phishing_key"	=> $anti_phishing_key,
            "exter_invoke_ip"	=> $exter_invoke_ip,
            "_input_charset"	=> trim(strtolower($this->alipay_config['input_charset']))
        );
        require_once(APPPATH."third_party/alipay/alipay_submit.class.php");
        $alipaySubmit = new AlipaySubmit($this->alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        /*$this->assign('html',$html_text);
        $this->display();*/
        echo $html_text;
    }

    function notify(){
        require_once(APPPATH.'third_party/alipay/alipay_notify.class.php');
        $alipayNotify = new AlipayNotify($this->alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        if($verify_result) {//验证成功
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];
            $order = $this->api_order->get_order_by_id($out_trade_no);
            if($trade_status == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                if($order['state']<6){
                    $this->api_order->confirm($out_trade_no);
                    $this->_source_action($order['order_id'],$order['info'],$order['company_id']);
                }
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
            else if ($trade_status == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                if($order['state']<2){
                    $this->api_order->payed($out_trade_no,'1',$trade_no);

                }
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }

            echo "success";		//请不要修改或删除
        }
        else {
            //验证失败
            echo "fail";
            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
    }

    function do_return(){
        require_once(APPPATH.'third_party/alipay/alipay_notify.class.php');
        $alipayNotify = new AlipayNotify($this->alipay_config);
        $verify_result = $alipayNotify->verifyReturn();

        //商户订单号
        $out_trade_no = $_GET['out_trade_no'];

        //支付宝交易号
        $trade_no = $_GET['trade_no'];

        //交易状态
        $trade_status = $_GET['trade_status'];


        if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
            //判断该笔订单是否在商户网站中已经做过处理
            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            //如果有做过处理，不执行商户的业务程序
            $order = $this->api_order->get_order_by_id($out_trade_no);
            if($_GET['trade_status'] == 'TRADE_FINISHED'){
                if($order['state']<6){
                    $this->api_order->confirm($out_trade_no);
                    //当交易完成后，款项到账进行处理，并不是当用户下单之后就入账
                    $this->_source_action($order['order_id'],$order['info'],$order['company_id']);
                }
            }else{
                if($order['state']<2){
                    $this->api_order->payed($out_trade_no,'1',$trade_no);
                }
            }
            //echo '支付成功，交易处理环节';
        }else {
            echo "trade_status=".$_GET['trade_status'];
        }

        echo "验证成功<br />";

    }

    function test($out_trade_no,$trade_no){
        $this->api_order->payed($out_trade_no,'1',$trade_no);
    }

}