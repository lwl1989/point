<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/29
 * Time: 19:44
 */

class wealth extends MY_User_Controller{

    function __construct(){
        parent::__construct();
        $this->assign('active','wealth');
        $this->assign('css_load',array('user_account'));
    }

    function index(){
        $this->assign('head_title','个人中心 - 财富中心 -');
        $this->load->model('document/document_model');
        $count_document = $this->document_model->count_document($this->_login_user['user_id']);
        $count_document['like_total'] =   $this->document_model->count_like_total($this->_login_user['user_id']);
        $this->assign('count_document',$count_document);
        $this->display();
    }

    /*
     * 历史记录
     */
    function history($type="deposit"){
        $page = $this->input->get('page')?$this->input->get('page'):1;
        $this->assign('head_title','个人中心 - 财富中心 - 支出详情 -');
        $this->load->model('user/deposit_msg');
        $this->load->config('user_actions');

        $base_url = url_query('', '/user/wealth/history/'.$type);
        $config_deposit = $this->config->item('deposit_msg');
        $actions = array();
        foreach($config_deposit as $key=>$val){
                if($val['type']==$type){
                    $actions[]=$key;
                }
        }
        $pagination = $this->deposit_msg->pagination_deposit($base_url, $page,$this->_login_user['user_id'],$actions);
        $this->session->set_userdata(
            'back_list_page',
            $this->get_self_url()
        );
        //echo '<pre>';
        //var_dump($pagination);
        foreach($pagination['list'] as $key=>$val){
            $pagination['list'][$key]['cn'] = $config_deposit[$pagination['list'][$key]['actions']]['cn'];
            $pagination['list'][$key]['color'] = ($config_deposit[$pagination['list'][$key]['actions']]['func']=="add")?'green':'red';
            $pagination['list'][$key]['flag'] = ($config_deposit[$pagination['list'][$key]['actions']]['func']=="add")?'+':'-';
        }
        //echo '<pre>';
        //var_dump($pagination);
        $this->assign('pagination', $pagination);
        $this->display();
    }
    //提现页面
    function reflect(){
        $this->display();
    }
    //提现操作
    function do_reflect(){
        $this->load->helper('verify');
        $time = time();
        $source_id = date("YmdHiS",$time).rand_pass(5);
        $score = floatval($this->input->post('payment'));
        if($score<100){
            $this->json_response(false,"","金额未达到提现额度");
        }
        $user = $this->user_model->get_user_by_id($this->_login_user['user_id']);
        if($user["deposit"]<$score){
            $this->json_response(false,"","您的余额不足噢");
        }
        $conditions = array(
            'actions' =>  "reflect",
            'source_id' =>$source_id,
            'score'     => $score,
            'create_time'=> date("Y-m-d H:i:s",$time),
            'is_true'   =>  0
        );
        $this->load->model('user/deposit_msg');
        $result = $this->deposit_msg->insert($conditions);
        if($result){
            $this->json_response(true);
        }
        $this->json_response(false);
    }


}