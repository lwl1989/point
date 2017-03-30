<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-15
 * Time: 下午8:17
 */

class MY_Api_Controller extends MY_Controller{
    protected $is_app=true;
    function __construct(){
        parent::__construct();
        $this->load->model('api/apps');
    }

    protected function _verify($token){
        $result = $this->apps->verify_token($token);
        if(!$result)
            $this->_json(array('state'=>false,'msg'=>'token error'));
    }

    protected function _verify_operate_token($user_id,$token){
        if($token){
            $result = $this->apps->verify_operate_token($user_id,$token);
            if(!$result)
                $this->_json(array('state'=>false,'msg'=>'token error'));
        }else{
            $login_user_id = $this->session->userdata('login_user')['user_id'];
            if(!$login_user_id){
                $this->_json(array('state'=>false,'msg'=>'token error'));
            }
            $this->is_app = false;
            if($user_id!=$login_user_id){
                $this->_json('',false,'权限错误');
            }
            return true;
        }
    }
    protected function _get_pdf_name($file_name){
        $name = $this->_change_suffix($file_name,'pdf');
        return $name;
    }
    protected function _change_suffix($file_name,$suffix = 'pdf'){
        $name = $this->_del_suffix($file_name);
        return $name.'.'.$suffix;
    }
    protected function _del_suffix($file_name){
        $arr = explode('.',$file_name);
        $name ='';
        for($i=0;$i<count($arr)-1;$i++){
            if($i!=0){
                $name .= '.'.$arr[$i];
            }else{
                $name .= $arr[$i];
            }
        }
        return $name;
    }

    public function user_action($user_id, $action, $data = array())
    {
        if (empty($action)) {
            return false;
        }

        $this->load->config('user_actions');
        $config = $this->config->item($action);

        if (!$config) {
            return false;
        }
        $this->load->model('user/user_action_model');
        //登陆每天只新增一次积分
        if (isset($config['today_first']) && $config['today_first'] == 1) {
            if ($this->user_action_model->today_had_done($user_id, $action)) {
                return false;
            }
        }
    }

    protected function _json($arr,$status=true,$msg=''){
        if($this->is_app){
            echo json_encode($arr);
        }else{
            $this->json_response($status,$arr,$msg);
        }
        exit();
    }
}