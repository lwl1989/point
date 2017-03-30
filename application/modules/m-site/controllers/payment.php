<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/6/25
 * Time: 10:18
 */

class payment extends MY_Site_Manage_Controller{


    function __construct(){
        parent::__construct();
        $this->load->model("site_payment");
    }

    function index(){
        $type = $this->input->get('type')?$this->input->get('type'):"user";
        $page = $this->input->get('page')?$this->input->get('page'):1;

        $conditions = array();
        $conditions['actions'] = "reflect";

        $base_url = url_query($conditions, '/m-site/payment/index');

        $this->site_payment->set_type($type);
        $pagination = $this->site_payment->pagination($base_url, $page, $conditions, 'id desc');

        $this->session->set_userdata(
            'back_list_page',
            $this->get_self_url()
        );
        //var_dump($pagination);
        $this->assign('pagination', $pagination);
        $this->display();
    }

    function do_reflect($id){
        $type = $this->input->get('type');
        if(!$type){
            exit("错误");
        }
        $this->site_payment->set_type($type);
        $payment = $this->site_payment->getOne(array('id'=>$id));
        if($payment){
            $flag = $this->site_payment->set_true($id);
            if($flag){
                //这里增加短信提示,人工转账成功后
                $this->json_response(true);
            }
        }
        $this->json_response(false);
    }
}