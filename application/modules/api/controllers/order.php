<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-7
 * Time: 上午9:29
 */

class order extends MY_Api_Controller{


    function  __construct(){
        parent::__construct();
    }

    //function

    function do_order_again($order_id){
        $user_id = $this->session->userdata('login_user')['user_id'];
        if(!$user_id){
            $this->json_response(false);
        }
        $this->load->model('user/user_order');
        $order = $this->user_order->get_order_by_id($order_id);
        unset($order['id']);
        unset($order['state']);
        unset($order['place_time']);
        unset($order['payed_time']);
        unset($order['company_receive_time']);
        unset($order['printed_time']);
        unset($order['user_confirm_time']);
        unset($order['receive_money_time']);
        $this->load->helper('verify');
        $time = time();
        $order['place_time'] = $time;
        $order['order_id'] = date("YmdHiS",$time).rand_pass(8);
        $id = $this->user_order->insert($order);
        if($id){
            $this->json_response(true);
        }
        $this->json_response(false);
    }
}