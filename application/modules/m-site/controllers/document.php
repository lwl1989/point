<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/17
 * Time: 20:27
 */
class document extends MY_Site_Manage_Controller{


    function __construct(){
        parent::__construct();
        $this->load->model('document_model');
        $this->assign('index_channel','contents');
    }

    function index(){
        $this->load->helper('image');
        $page = $this->input->get('page');
        $page = $page > 0? $page: 1;

        $conditions = array();
        if($this->input->get('name')){
            $conditions['title'] = $this->input->get('name');
            $this->assign('name', $this->input->get('name'));
        }else{
            $this->assign('name', "");
        }

        if($this->input->get('classify_id')){
            $conditions['classify_id'] = $this->input->get('classify_id');
            $this->assign('classify_id', $this->input->get('classify_id'));
        }else{
            $this->assign('classify_id', "");
        }
        $base_url = url_query($conditions, '/m-site/document/index');

        $pagination = $this->document_model->pagination($base_url, $page, $conditions, 'id desc');
        //返回当最后一次列表页
        $this->session->set_userdata(
             'back_list_page',
              $this->get_self_url()
        );
        $this->assign('pagination', $pagination);
        $this->display();
    }
}