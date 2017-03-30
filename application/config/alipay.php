<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/31
 * Time: 11:06
 */

$config = array(
    'alipay_config' => array(
        'partner'       =>  '',     //合作身份者id，以2088开头的16位纯数字
        'seller_email'  =>  '',     //收款支付宝账号
        'key'           =>  '',     //安全检验码，以数字和字母组成的32位字符
        'sign_type'     =>  strtoupper('MD5'),
        'input_charset' =>  strtolower('utf-8'),
        'cacert'        =>  FCPATH.'application/config/cacert.pem',
        'transport'     =>  'http'
    )
);
