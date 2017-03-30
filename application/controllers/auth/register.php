<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-8
 * Time: 下午9:25
 */

class register extends MY_Portal_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->assign('css_load', array('user_account'));
        //$this->set_layout('');
        $this->assign('head_title','注册 - ');
    }

    function index()
    {
        if ($this->tank_auth->is_logged_in()) {//登录
            redirect('');
        } elseif ($this->tank_auth->is_logged_in(FALSE)) {//登录，未激活
            //redirect('/t_auth/send_again/');
            $this->_show_message('<h1>注册已关闭</h1>',2);

        } elseif (!$this->config->item('allow_registration', 'tank_auth')) {//如果注册关闭
            $this->_show_message('<h1>注册已关闭</h1>',2);
        }

        /**
         * 手机端

        $this->load->library('user_agent');
        if ($this->agent->is_mobile())
        {
            //$data["views_path"] = 'application/modules/webapp/views/';
            //$data["css_load"]  = array('web_common','auth');
            //$this->load->view("/webapp/auth/register/index.php",$data);
            //加载手机端界面
            return ;
        }*/
        $this->save_last_url();

        $this->display();
    }

    function do_register($type = 'email')
    {
        $this->load->helper('validate');
        $username = $this->input->post('email')?$this->input->post('email'):$this->input->post('mobile');
        if(!$username)
               $this->return_json('10001');
        $username_type = $this->input->post('email')?'email':'mobile';
        $user_type = $this->input->post('user_type')?$this->input->post('user_type'):'ordinary';
        if($type=='email'){
            $password = trim($this->input->post('password_email'));
            $re_password = trim($this->input->post('re_password_email'));
        }else{
            $password = trim($this->input->post('password'));
            $re_password = trim($this->input->post('re_password'));
        }

        if ($password != $re_password) {
            $this->return_json('10803');
        }
       /* $check_password = is_password($password);
        if (!$check_password['status']) {
            $this->return_json('10804');
        }*/

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
            $this->json_response(true,'','注册成功');
        }else{
            $this->json_response(true,'','注册失败');
        }


    }

    function send_email_after(){
        $email = $this->session->userdata('register_email');
        //$this->session->unset_userdata('register_email');
        $this->assign('head_title','学霸银行 - 注册成功');
        $this->assign('email',$email);
        $this->display();
    }

    private function _user_email($data)
    {
        $check_email = is_email($data['username']);
        if (!$check_email['status']) {
            $this->return_json('10203',$check_email['msg']);
        }
        $data['email'] = $data['username'];
        $back = $this->tank_auth->create_user(
            $data['username'],$data['email'],$data['password'],false
        );
        if(!$back){
            $this->return_json('10802');
        }
        //发送邮件
       /**/
        $backmsg = $this->_send_email_for_register($data['username']);
        if(!$backmsg){
            $this->return_json('10408',$backmsg);
        }
        return $back;
    }

    private function _user_mobile($data)
    {
        $check_mobile = is_mobile($data['username']);
        if (!$check_mobile['status']) {
            $this->return_json('10203',$check_mobile['msg']);
        }
        $data['mobile'] = $data['username'];
        $back = $this->tank_auth->create_user_mobile(
            $data['username'],$data['mobile'],$data['password'],false
        );
        return $back;
    }
    public function check_email()
    {
        $email = $this->input->post('param');
        if ($email) {
            $this->load->model('tank_auth/users');
            if ($this->users->is_email_available($email)) {
                $this->json_response(true);
            } else {
                $this->json_response(false,'','该邮箱已被注册');
            }
        }
    }

    public function check_mobile(){
        $mobile = $this->input->post('param');
        if ($mobile) {
            $this->load->model('tank_auth/users');
            if ($this->users->is_mobile_available($mobile)) {
                $this->json_response(true);
            } else {
                $this->json_response(false,'','该手机已被注册');
            }
        }
    }

    public function check_verify(){
        $mobile = $this->input->post('mobile');
        $verify = $this->input->post('verify');
        $data	= $this->tank_auth->get_session_register();
        if ($mobile==$data['mobile']) {
            if (md5($verify)==$data['verify']) {
                $this->json_response(true);
            } else {
                $this->json_response(false,'','验证码错误');
            }
        }else{
            $this->json_response(false,'','验证码错误');
        }
    }

    public function send_verify(){
        $mobile = $this->input->post('param');
        $flag=$this->_check_mobile($mobile);
        if (!$flag) {
            $this->return_json('10302');
        } //检测手机
        $flag = $this->tank_auth->send_verify_register($mobile);
        $this->return_json($flag);
    }

    function send_email_again(){
        //$email = trim($this->input->post('email'));
        $email = $this->session->userdata('register_email');
        if(!$email){
            $this->json_response(false);
        }
        $this->_send_email_for_register($email);
        $this->json_response(true);
    }


    private function _send_email_for_register($email){

        $data = $this->tank_auth->set_activate_email_key($email);
        $data['username'] = $email;
        $this->session->set_userdata('register_email',$email);

        if($data){
            $flag = $this->send_email('welcome',$email,'注册 - 学霸银行',$data);
            $msg = "邮件已发送到您的邮箱{$email},请及时登录邮箱完成激活账户。";
            return $msg;
        }
        else
            return false;

    }




}