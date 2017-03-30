<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/29
 * Time: 19:44
 */

class wealth extends MY_Company_Controller{

    function __construct(){
        parent::__construct();
        $this->assign('active','wealth');
        $this->assign('css_load',array('user_account'));
    }

    function index(){
        $this->assign('head_title','商家中心 - 财富中心 -');
        /*$this->load->model('document/document_model');
        $count_document = $this->document_model->count_document($this->_login_user['user_id']);
        $count_document['like_total'] =   $this->document_model->count_like_total($this->_login_user['user_id']);
        $this->assign('count_document',$count_document);*/
        $this->assign('company_user',$this->company_user);
        //var_dump($this->company_user);
        $this->display();
    }

    /*
     * 历史记录
     */
    function history($type="deposit"){
        $page = $this->input->get('page')?$this->input->get('page'):1;

        $this->assign('head_title','商家中心 - 财富中心 - 支出详情 -');
        $this->load->model('company/company_paymenyt');
        $this->load->config('user_actions');

        $base_url = url_query('', '/company/wealth/history/'.$type);
        $config_deposit = $this->config->item('deposit_msg');
        $actions = array();
        foreach($config_deposit as $key=>$val){
                if($val['type']==$type){
                    $actions[]=$key;
                }
        }
        $pagination = $this->company_paymenyt->pagination_deposit($base_url, $page,$this->_login_user['user_id'],$actions);
        $this->session->set_userdata(
            'back_list_page',
            $this->get_self_url()
        );
        foreach($pagination['list'] as $key=>$val){
            $pagination['list'][$key]['cn'] = $config_deposit[$pagination['list'][$key]['actions']]['cn'];
            $pagination['list'][$key]['color'] = ($config_deposit[$pagination['list'][$key]['actions']]['func']=="add")?'green':'red';
            $pagination['list'][$key]['flag'] = ($config_deposit[$pagination['list'][$key]['actions']]['func']=="add")?'+':'-';
        }
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
            $this->json_response(false,"","提现金额太小了");
        }
        if($this->company_user['available_payment']<$score){
            $this->json_response(false,"","您的余额不足噢");
        }
        $data = array(
            'actions' =>  "reflect",
            'source_id' =>$source_id,
            'score'     => $score,
            'create_time'=> date("Y-m-d H:i:s",$time),
            'is_true'   =>  0
        );
        $this->load->model('company/company_payment');
        $result = $this->company_payment->insert($data);
        if($result){
            $this->json_response(true);
        }
        $this->json_response(false);
    }
}