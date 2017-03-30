<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-16
 * Time: 下午9:53
 */

function order_state($state){

    $CI =& get_instance();
    $CI->config->load('order');

    $order_state = $CI->config->item('state_cn');
    $str_state = '';
    if($state){
        foreach($order_state as $key=>$v){
            if($v==$state)
            {
                $str_state = $key;
                break;
            }
        }
    }
    return $str_state;
}

function order_state_en($state){

    $CI =& get_instance();
    $CI->config->load('order');

    $order_state = $CI->config->item('state');
    $str_state = '';
    if($state){
        foreach($order_state as $key=>$v){
            if($v==$state)
            {
                $str_state = $key;
                break;
            }
        }
    }
    return $str_state;
}

function order_state_color($state){
    switch($state){
        case 1:
            echo 'red';
            break;
        case 2:
            echo 'green';
            break;
        case 3:
            echo 'red';
            break;
        case 4:
            echo '#000000';
            break;
        case 5:
            echo 'blue';
            break;
        case 6:
            echo '#5323fa';
            break;
        default:
            echo 'red';
    }
}


function get_order_title($arr){
    $title ='';
    $count = count($arr);
    if($count>1){
        foreach($arr as $val){
            if(strlen($title)<30){
                $title .= $val['title'].'、';
            }
        }
        $title = substr($title,0,strlen($title)-3);//gbk占用3个编码
        $title .= '等';
    }else{
        $title = $arr[0]['title'];
    }
    return $title;

}