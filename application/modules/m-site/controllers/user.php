<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/9
 * Time: 19:19
 */
class user extends MY_Site_Manage_Controller{
    protected $limit = 10;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('image_helper');
        $this->load->model('site_config');
        $this->load->model('user/user_model');
        $this->assign('index_channel','contents');
    }

    public function index($page = 1){
        if(intval($page)<1){
            exit('page error!');
        }
        $condition = array(
            'is_del'    => 0
        );
        $user_type = $this->input->get('user_type');
        if($user_type){
            $condition['user_type'] = $user_type;
        }
        $user_status = $this->input->get('user_status');  //?user_status=stop ...  账号封停  禁言之类的
        if($user_status){
            $condition[$user_status]=$user_status;
        }
        $base_url = url_query($condition, '/m-site/users/index');
        $pagination = $this->user_model->pagination($base_url, $page, $condition, 'id desc');
        $this->session->set_userdata(
             'back_list_page',
             $this->get_self_url()
        );

        $this->assign('pagination', $pagination);
        $this->display();
    }


    public function user_by_del($page = 1){
        if(intval($page)<1){
            exit('page error!');
        }
        $condition = array(
             'is_del'    => 1
        );
        $user_type = $this->input->get('user_type');
        if($user_type){
            $condition['user_type'] = $user_type;
        }
        $user_status = $this->input->get('user_status');  //?user_status=stop ...  账号封停  禁言之类的
        if($user_status){
            $condition[$user_status]=$user_status;
        }
        $base_url = url_query($condition, '/m-site/users/index');
        $pagination = $this->user_model->pagination($base_url, $page, $condition, 'id desc');
        $this->session->set_userdata(
             'back_list_page',
             $this->get_self_url()
        );

        $this->assign('pagination', $pagination);
        $this->display();
    }

    function del(){
        $result = $this->user_model->soft_delete($this->input->post('id'));
        if($result)
            $this->json_response(true);
        $this->json_response(false);
    }

    function stop($timeout = 86400){
        $open_time = date('Y-m-d H:i:s',time()+intval($timeout));
        $result = $this->user_model->stop_user($this->input->post('id'),$open_time);
        if($result)
            $this->json_response(true,'',$open_time);
        $this->json_response(false);
    }
    function reback(){
        $result = $this->user_model->re_back($this->input->post('id'));
        if($result)
            $this->json_response(true);
        $this->json_response(false);
    }

    /*private function _get_offset($page){
        $offset = ($page-1)*$this->limit;
        return $offset;
    }*/
}