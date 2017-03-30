<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-2
 * Time: 下午5:42
 */
/*账户信息*/
class account extends MY_Company_Controller{

    protected  $user_id;

    function __construct(){

        parent::__construct(); 
        $this->user_id = $this->session->userdata("company_user_id");
        $this->load->model('company/company_base');
        $this->assign('head_title','商家中心');
    }

    /*
     * 打印店账户中心首页
     */
    function index(){
        //var_dump($this->user_id);
        $user_info =  $this->company_base->get_user_by_id($this->user_id);
        $this->assign('user',$user_info);

        $this->display();
    }

    function shop_info(){
        $info = $this->company_base->get_company_users($this->company_id);
        $this->assign('shop',$info);
        $this->display();
    }

    function do_set_info(){
        $this->config->load('document');
       /* $charge = $this->config->item('price', 'document');
        foreach ($charge as $name=>$value){
                $charge[$name] = $this->input->post($name);
        }*/
        $data = array(
            'address'   => trim($this->input->post('address')),
            'lng'       => trim($this->input->post('lng')),
            'lat'       =>  trim($this->input->post('lat')),
            'company_name'   =>  trim($this->input->post('company')),
         //   'charge'    =>  $charge,
			'number'  => $this->input->post('number'),
			'mobile'  => $this->input->post('mobile')
        );

        if(!$data)
            $this->json_response(false,array('field'=>'address'),'更新信息错误');

        $result =  $this->company_base->set_address($this->user_id,$data);

        if(!$result)
            $this->json_response(false,array('field'=>'address'),'更新信息失败');

        $this->json_response(true);
    }

    function set_charge(){
        $this->load->config('print_price',true);
        $charge_default = $this->config->item('print_price');
        $this->assign('charge',$charge_default);
        $this->display();
    }

    /*
     * 设置收费
     * 提交数据  A3 => json {'one':{'base'=>'1','sales':[{'num':100,'sale':'0.95'}{'num':500,'sale':'0.9'}]}}
     */
    function do_set_charge(){
        $company_id = intval($this->input->post('company_id'));
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
            /*if(!$$val){
                $$val = $charge_default[$val];
            }*/
            $charge[$val] = $$val;
        }
        $charge = json_encode($charge);
        $result = $this->company_base->change_charge($company_id,$charge);
        if($result){
            $this->json_response(true);
        }
        $type->json_response(false);
    }

    public function change_password()
    {
        $this->assign('head_title', '修改密码 - 我的账号');
        $this->assign('active','change_password');
        $this->display();
    }


    public function do_change_password()
    {
        $password = trim($this->input->post('password'));
        $new_password = trim($this->input->post('new_password'));
        $re_password = trim($this->input->post('re_password'));
        if ($new_password != $re_password) {
            $this->json_response(false, array('field' => 're_password'), '重复密码错误');
        }

        $this->load->helper('validate');

        $check_password = is_password($password);
        if (!$check_password['status']) {
            $this->json_response(false, array('field' => 'old_password'), '旧密码格式错误');
        }

        $check_new_password = is_password($new_password);
        if (!$check_new_password['status']) {
            $this->json_response(false, array('field' => 'new_password'), '新密码格式错误');
        }

        if ($this->tank_auth->change_password($password, $new_password)) {	// success
            $this->json_response();
        } else {														// fail
            $errors = $this->tank_auth->get_error_message();
            $this->json_response(false, '', $errors);
        }


    }
}