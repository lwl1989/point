<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/7/12
 * Time: 21:36
 */

class withdraw_deposit extends MY_Site_Manage_Controller{

    function __construct(){
        parent::__construct();
        $this->assign('index_channel','contents');
    }


    function index(){
        $page = $this->input->get('page')?$this->input->get('page'):1;
        $source_id=$this->input->get('source_id');

        $this->load->model('company/company_payment');

        $base_url = url_query('', '/company/wealth/history');

        $pagination = $this->company_payment->pagination_payment($base_url,$page,null,'reflect',$source_id);
        //echo $this->company_payment->db->last_query();

        $this->session->set_userdata(
            'back_list_page',
            $this->get_self_url()
        );
        //
        $this->assign('source_id',$source_id);
        $this->assign('pagination', $pagination);
        $this->display();
    }

    function do_reflect(){
        $id = $this->input->post('id');
        if(!$id){
            $this->json_response(false,'','id 错误');
        }
        $this->load->model('company/company_payment');
        $result = $this->company_payment->do_reflect_true($id);
        //echo $this->company_payment->db->last_query();
        if($result){
            $this->json_response(true);
        }else{
            $this->json_response(false,'','处理失败');
        }
    }
}


