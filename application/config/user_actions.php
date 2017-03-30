<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
    /*   'user_register' => array(
           'name'  => '新用户注册',
           'score' => 100,
           'grow'  => 100,
           'msg'   => 'hi！我是学霸银行，欢迎您我的新伙伴！您的积分 +100, 成长值 +100，',
       ),
       'user_login' => array(
           'name'  => '每天登录',
           'score' => 2,
           'grow'  => 2,
           'msg'   => 'hi！我是学霸银行，欢迎您每天登陆！您的积分 +2, 成长值 +2',
           'today_first' => 1,//今天第一次登陆时才计算积分
       ),
       'user_activate_email' => array(
           'name'  => '邮箱认证',
           'score' => 20,
           'grow'  => 20,
           'msg'   => '邮箱认证，您的积分 +20, 成长值 +20',
           'first' => 1,//第一次激活才有积分，后面更换邮箱激活没有积分
       ),
       'user_comment_company' => array(
           'name'  => '店铺点评',
           'score' => 5,
           'grow'  => 5,
           'msg'   => 'hi！我是学霸银行，感谢您参与店铺点评！您的积分 + 成长值 +5',
           'need_confirm' => 1,//用户操作时，不计入积分，待管理员确认
       ),
       /*'user_document_by_printed'=>array(
           'name'  =>  '打印积分',
           'score' =>
       ),*/
    'deposit_msg'=>
        array(
            //订单收入order、下载收入be_downloaded、消费consume_deposit,消费consume_score,提现reflect
            'order'             => array(
                                    'cn'=>'订单收入',
                                    'func'=>'add',
                                    'type'=>'deposit'),
            'be_downloaded'     => array(
                                    'cn'=>'下载收入',
                                    'func'=>'add',
                                    'type'=>'score'),
            'consume_deposit'   => array(
                                    'cn'=>'消费存款',
                                    'func'=>'reduction',
                                    'type'=>'deposit'),
            'consume_score'     => array(
                                    'cn'=>'消费积分',
                                    'func'=>'reduction',
                                    'type'=>'score'),
            'reflect'           => array(
                                    'cn'=>'提现',
                                    'func'=>'reduction',
                                    'type'=>'deposit')
        )

);