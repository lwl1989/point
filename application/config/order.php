<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-3
 * Time: 下午3:31
 */
/*
$config = array(

    'state' => array(
        'place'             => '1',
        'payed'             => '2',
        'fail_pay'          => '3',
        'company_receive'   => '4',
        'printed'           => '5',
        'user_confirm'      => '6'
    ),

    'over_message_for_self'   => array(
        'flag' => '【学霸网】',
        'content'  =>  '您的订单已完成,请及时上打印店'
    ),

    'over_message_for_send'  => array(
        'flag' => '【学霸网】',
        'content'  =>   '您的订单已经托运给快递，请耐心等待噢!'
    )

);*/
$config['state_cn'] = array(
    '未支付'             => '1',
    '已支付'             => '2',
    '支付失败'             => '3',
    '打印店作业中'        => '4',
    '打印完成'           => '5',
    '用户确认完毕'      => '6'
);
$config['state'] = array(
    'place'             => '1',
    'payed'             => '2',
    'fail_pay'          => '3',
    'company_receive'   => '4',
    'printed'           => '5',
    'user_confirm'      => '6'
);