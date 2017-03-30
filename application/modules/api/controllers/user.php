<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-7
 * Time: 上午9:28
 */

class user extends MY_Api_Controller{

    function __construct(){
        parent::__construct();
        $this->load->library('tank_auth');
        $this->load->model("user/user_model");
    }



    function do_login($token){
        $this->_verify($token);
        $this->load->helper('validate');
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
            $this->user_action($user_id, 'user_login');
            $this->load->model('api/apps');
            $operate_token = md5(sha1($token));
            $this->apps->set_operate_token($token,$operate_token,$user_id);
            $this->_json(array('state'=>true,'user_id'=>$user_id,'operate_token'=>$operate_token));
        } else {
            $this->_json(array('state'=>false));
        }

    }

    function do_register($token,$is_mobile = 0){
        $this->_verify($token);
        $this->load->helper('validate');
        if($is_mobile == 0){
            $username = $this->input->post('email');
            $username_type = 'email';
        }else{
            $username = $this->input->post('mobile');
            $username_type = 'mobile';
        }

        if(!$username)
            $this->_json(array('state'=>false,'msg'=>'账户名错误'));
        $user_type = $this->input->post('user_type');
        $password = trim($this->input->post('password'));
        $re_password = trim($this->input->post('re_password'));
        $back = null;

        if ($password != $re_password) {
            $this->_json(array('state'=>false,'msg'=>'密码和确认密码不一致'));
        }
        $check_password = is_password($password);
        if (!$check_password['status']) {
            $this->_json(array('state'=>false,'msg'=>'密码格式错误'));
        }

        $data = array(
            'username'  =>  $username,
            'user_type' =>  $user_type,
            'password'  =>  $password
        );
        if($username_type=='email'){
            $back = $this->_user_email($data);
        }else{
            $back = $this->_user_mobile($data);
        }
        if (!is_null($back)) {
            $this->_json(array('state'=>true));
        }else{
            $this->_json(array('state'=>false));
        }
    }



    function do_update_user($user_id,$operate_token){
        $this->_verify_operate_token($user_id,$operate_token);
        $data = array(
            'id' => $user_id,
            'address' => trim($this->input->post('address')),
            'nickname'	=> trim($this->input->post('nickname')),
            'qq'	=> trim($this->input->post('qq')),
            'introduce'	=> trim($this->input->post('introduce')),
            'province'  =>  trim($this->input->post('province')),
            'city'  =>  trim($this->input->post('city')),
            'province_now'  => trim($this->input->post('province_now')),
            'city_now'  => trim($this->input->post('city_now')),
        );

        if ($this->input->post('sex') == 1 || $this->input->post('sex') == 0) {
            $data['sex'] = $this->input->post('sex');
        }

        if ($this->user_model->save($data)) {
            $this->_json(array('state'=>true));
        }
        $this->_json(array('state'=>false));
    }

    function get_classify($user_id,$operate_token){
        $this->_verify_operate_token($user_id,$operate_token);
        $this->load->model('classify/classify_model');
        $classify = $this->classify_model->select_classify_by_user($user_id);
        if(!$classify){
            $this->_json(array('state'=>false,'msg'=>'no classify'));
        }else{
            $this->_json(array('state'=>true,'classify'=>$classify));
        }
    }

    function get_file($user_id,$operate_token,$classify= 0,$page=1,$page_size =10){
        $this->_verify_operate_token($user_id,$operate_token);
        $this->load->model('user/user_file');
        $offset = ($page-1)*$page_size;
        $condition = array(
            'user_id'   => $user_id,
        );
        if($classify){
            $condition['file_classify'] = $classify;
        }
        $my_file = $this->user_file->get_file($condition,$page_size,$offset);
        for($i=0;$i<count($my_file);$i++){
            $my_file[$i]['collect'] = $this->user_file->get_like_by_id($user_id,$my_file[$i]['id'],1);
            $my_file[$i]['like'] = $this->user_file->get_like_by_id($user_id,$my_file[$i]['id'],2);
        }
        $this->_json(array('state'=>true,'my_file'=>$my_file));
    }

    function get_order($user_id,$operate_token,$state='all',$page=1,$page_size =5){
        $this->_verify_operate_token($user_id,$operate_token);
        $this->load->model('user/user_order');
        $offset = ($page-1)*$page_size;
        if($state == 'all'){
            $my_order = $this->user_order->select($user_id,0,0,$page_size,$offset);
        }else{
            $my_order = $this->user_order->select($user_id,$state,0,$page_size,$offset);
        }
        $this->load->helper('order');
        $this->load->model('public/file_base');
        $i = 0;
        foreach($my_order as $order){
            $message[$i] = json_decode($order['info'],true);
            $my_order[$i]['message'] = $message[$i];
            unset($my_order[$i]['info']);
            $i++;
        }
        $this->_json(array('state'=>true,'my_order'=>$my_order),true);
    }

    /*
     * 提交打印订单
     */
    function place_order($user_id,$operate_token){
        $this->_verify_operate_token($user_id,$operate_token);
        $file_info = trim($this->input->post('file_info'));
        $order_info['company_id'] = $this->input->post('company_id');
        $order_info['user_id'] = $user_id;
        $order_info['info'] = json_encode($file_info);
        $order_info['remarks'] =  $this->input->post('remarks')?$this->input->post('remarks'):'';
        $file_info = json_decode($file_info,true);
        $sum = 0;
        foreach($file_info as $file){
            $sum +=   $file['file_num'];
        }
        $order_info['sum_num'] = $sum;
        $this->load->helper('verify');
        $order_info['order_id'] = 'xb'.rand_pass(10).date("YmdHiS",time());
        $this->load->model('user/order');
        $result = $this->order->insert_order($order_info);
        if(!$result){
            $this->_json(array('state'=>false),false);
        }
        $this->_json(array('state'=>true,'order'=>$order_info),true);
    }
    /*
     * 当客户端退出时执行,更新购物车  or 打开购物车
     */
    function do_change_cart($user_id,$operate_token){
        $this->_verify_operate_token($user_id,$operate_token);
        $order_info = trim($this->input->post('file_info'));
        $this->_verify_operate_token($user_id,$operate_token);
        $result = $this->user_model->set_cart($user_id,$order_info);
        if($result){
            $this->_json(array('state'=>true),false);
        }
        $this->_json(array('state'=>false),true);
    }
    /*
     * 获取购物车
     */
    function get_cart($user_id,$operate_token){
        $this->_verify_operate_token($user_id,$operate_token);
        $this->load->model('user/user_model');
        $result = $this->user_model->get_cart($user_id);
        $i=0;
        foreach($result as $cart){
            $message = json_decode($cart['file_info'],true);
            $result[$i]['message'] = $message;
            unset($result[$i]['file_info']);
            $i++;
        }
        if($result){
            $this->_json(array('state'=>true,'my_cart'=>$result),true);
        }
        $this->_json(array('state'=>true,'my_cart'=>null),true);
    }

    function del_order($user_id,$operate_token){
        $this->_verify_operate_token($user_id,$operate_token);
        $this->load->model('user/user_order');
        $order_id = intval(trim($this->input->post('order_id')));
        $order_state = $this->user_order->get_state($order_id);

        $order_config = $this->load->config('order');

        if($order_state!=$order_config['state']['fail_pay'] or $order_state!=$order_config['state']['place'] or $order_state!=$order_config['state']['user_confirm']){
            $this->_json(array('state'=>false,'msg'=>'此类型订单不允许删除'),false);
        }

        $result = $this->user_order->del($order_id,$user_id);

        if(!$result){
            $this->_json(array('state'=>false,'msg'=>'订单删除失败'),false);
        }
        $this->_json(array('state'=>true,'msg'=>'订单删除成功,您可以在回收站内看到它们'),true);
    }

    function confirm_order($user_id,$operate_token){
        $this->_verify_operate_token($user_id,$operate_token);
        $this->load->model('user/user_order');
        $order_id = trim($this->input->post('order_id'));
        $order_state = $this->user_order->get_state($order_id);
        $order_config = $this->load->config('order');

        if($order_state!=$order_config['state']['printed']){
            $this->_json(array('state'=>true,'msg'=>'订单状态不允许确认'),false);
        }

        $result = $this->user_order->confirm($order_id,$user_id);

        if(!$result){
            $this->_json(array('state'=>false,'msg'=>'订单确认失败'),false);
        }
        $this->_json(array('state'=>true),true);
    }

    function get_user($user_id,$operate_token){
        $this->_verify_operate_token($user_id,$operate_token);
        $this->load->model('user_api');
        $result = $this->user_api->get_user_by_id($user_id);
        if(!$result){
            $this->_json(array('state'=>false),false);
        }
        $this->_json(array('state'=>true,'user'=>$result),true);
    }
     private function _user_email($data)
    {
        $check_email = is_email($data['username']);
        if (!$check_email['status']) {
            $this->_json(array('state'=>false,'msg'=>'用户名错误'));
        }
        $data['email'] = $data['username'];
        $back = $this->tank_auth->create_user(
            $data['username'],$data['email'],$data['password'],false
        );
        //发送邮件
       /* $backmsg = $this->_send_email_for_register($data['username']);
        if($backmsg){
            $this->return_json('10408',$backmsg);
        }*/
        return $back;
    }

    private function _user_mobile($data)
    {
        $check_mobile = is_mobile($data['username']);
        if (!$check_mobile['status']) {
            $this->_json(array('state'=>false,'msg'=>'用户名错误'),false);
        }
        $data['mobile'] = $data['username'];
        $back = $this->tank_auth->create_user_mobile(
            $data['username'],$data['mobile'],$data['password'],false
        );
        return $back;
    }
}