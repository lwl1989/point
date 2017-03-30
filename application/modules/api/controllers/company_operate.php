<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/22
 * Time: 11:15
 */


class company_operate extends MY_Api_Controller{

    function __construct(){
        parent::__construct();
    }

    function do_login(){
        $this->load->helper('validate');
        $this->load->library('Tank_auth');
        $account = $this->input->post('account');
        $password = $this->input->post('password');
        $check_mobile = is_mobile($account);
        $logined=false;
        if (!$check_mobile['status']) {
            $check_account = is_email($account);
            if (!$check_account['status']) {
                $this->_json(array('state'=>false,'msg'=>'account error'));
            }else{
                $logined=$this->tank_auth->login($account,$password,true,false,true,false);
            }
        }else{
            $logined=$this->tank_auth->login($account,$password,true,false,false,true);
        }
        if ($logined)
        {
            $user_id = $this->tank_auth->get_user_id();
            $this->load->model('company/company_base');
            $company = $this->company_base->get_user_by_id($user_id);
            $this->session->set_userdata('company_user_id',$company['id']);
            $this->json_response(true,$company,'获取数据成功');
        } else {
            $this->json_response(false,'','登录失败');
        }
    }

    function get_order($company_id){
        $company_id = $this->input->get('company_id')?$this->input->get('company_id'):$company_id;
        $state = $this->input->get('state')?$this->input->get('state'):1;
        $start = $this->input->get('start')?$this->input->get('start'):0;
        $end = $this->input->get('end')?$this->input->get('end'):time();
        if(!$company_id or $company_id!=$this->session->userdata('company_user_id')){
            $this->json_response(false,'','权限错误');
        }
       /* $start = strtotime('2015-05-22');
        $end =  strtotime('2015-05-23');*/
        $this->load->model('company/company_order');
        $this->load->model('document/document_model');
        $conditions = array(
            'place_time >'=>date("Y-m-d",$start),
            'place_time <'=>date("Y-m-d",$end),
            'company_id'=>$company_id
        );
        if($state)
            $conditions['state'] = $state;
        $fields = 'id,order_id,user_id,sum_num,price,sum_page,info,remarks,place_time';
        $order_list = $this->company_order->fetch_array($conditions,$fields);
        $message=array();
        $i = 0;
        foreach($order_list as $order){
            $message[$i] = json_decode($order['info'],true);
            $ids = array();
            foreach($message[$i] as $document){
                array_push($ids,$document['file_id']);
            }
            $documents = $this->document_model->get_title_with_page($ids);
            $count = count($documents);
            for($k=0;$k<$count;$k++){
                $message[$i][$k]['title'] = $documents[$k]['title'];
                $message[$i][$k]['page'] = $documents[$k]['page'];
                $message[$i][$k]['score'] = $documents[$k]['score'];
            }

            $order_list[$i]['message'] = $message[$i];
            $i++;
        }
        $this->json_response(true,$order_list,'订单获取成功');
    }


    function do_set_info(){
        $company_id = intval($this->input->post('company_id'));
        if($company_id!=$this->session->userdata('company_user_id')){
            $this->json_response(false,'','权限错误');
        }
       /* $this->config->load('document');
        $charge = $this->config->item('price', 'document');
        foreach ($charge as $name=>$value){
            $charge[$name] = $this->input->post($name);
        }*/
        $data = array(
            'address'   => trim($this->input->post('address')),
            'lng'       => trim($this->input->post('lng')),
            'lat'       =>  trim($this->input->post('lat')),
            'name'   =>  trim($this->input->post('name')),
         //   'charge'    =>  $charge,
         //   'number'  => $this->input->post('number'),
            'mobile'  => $this->input->post('mobile')
        );

        if(!$data)
            $this->json_response(false,array('field'=>'address'),'更新信息错误');

        $result =  $this->company_base->set_address($company_id,$data);

        if(!$result)
            $this->json_response(false,array('field'=>'address'),'更新信息失败');

        $this->json_response(true);
    }


    /*
    * 设置收费
    * 提交数据  A3 =>
     * json {'one':{'base'=>'1','sales':[{'num':100,'sale':'0.95'}{'num':500,'sale':'0.9'}]}}
    */
    function do_set_charge(){
        $company_id = intval($this->input->post('company_id'));
        if($company_id!=$this->session->userdata('company_user_id')){
            $this->json_response(false,'','权限错误');
        }
        $this->load->config('print_price',true);
        $charge_default = $this->config->item('print_price');
        $type = array();
        foreach($charge_default as $key=>$val){
            array_push($type,$key);
        }
        /*
         * 获取提交的新数据,没有提交的话，就为空
         */
        $charge = array();
        foreach($type as $val){
            $$val = trim($this->input->post($val));
            if(!$$val){
                $$val = $charge_default[$val];
            }else{
                $charge[$val] = $$val;
            }
        }
        $charge = json_encode($charge);
        $result = $this->company_base->change_charge($company_id,$charge);
        if($result){
            $this->json_response(true);
        }
        $this->json_response(false);
    }

    /*
     * 接收到订单   =》  修改订单状态
     */
    function has_receive(){
        $company_id = intval($this->input->post('company_id'));
        if($company_id!=$this->session->userdata('company_user_id')){
            $this->json_response(false,'','权限错误');
        }
        $order_id = trim($this->input->post('order_id'));
        $this->load->model('company/company_order');
        //$result = $this->company_order->receive($company_id,$order_id);
        $result = $this->company_order->printing($company_id,$order_id);
        if($result){
            $this->json_response(true);
        }
        $this->json_response(false);
    }

    /*
     * 打印完成订单  =》 修改订单状态、通知用户
     */
    function has_complete(){
        $company_id = intval($this->input->post('company_id'));
        if($company_id!=$this->session->userdata('company_user_id')){
            $this->json_response(false,'','权限错误');
        }
        $order_id = trim($this->input->post('order_id'));
        $this->load->model('company/company_order');
        $result = $this->company_order->complete($company_id,$order_id);
        if($result){
            $this->json_response(true);
        }
        $this->json_response(false);
    }

    /*
     * 申请提现金额
     */
    function do_withdrawals(){
        $company_id = intval($this->input->post('company_id'));
        if($company_id!=$this->session->userdata('company_user_id')){
            $this->json_response(false,'','权限错误');
        }

        $payment = floatval(trim($this->input->post('payment')));
        $this->load->model('company/company_base');
        $true = $this->company_base->judge_payment($company_id,$payment);
        if($true){
            $result = $this->company_base->update_company_payment($company_id,$payment,false);
            if($result){
                $this->load->helper('verify');
                $data = array(
                    'company_id'    => $company_id,
                    'payment'       => $payment,
                    'actions'       => 'withdrawals',
                    'create_time'   => date("Y-m-d H:i:s",time()),
                    'source_id'     => 'withdrawals'
                );
                $this->load->model('company/company_payment');
                $this->company_payment->insert($data);
                $this->json_response(true);
            }
            $this->json_response(false);
        }
    }
}