<?php 
/**
 * class login
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-12-8
 * Time: 上午1:41
 */

class login extends MY_Portal_Controller
{

	public function __construct()
	{
		parent::__construct();
        $this->assign('css_load', array('common'));
        $this->assign('css_load',array('user_account'));
    //    $this->set_layout('');
	}

    public function index()
    {
        $this->assign('head_title','用户登录 - ');
        if ($this->tank_auth->is_logged_in()) {
            redirect('');
        } elseif ($this->tank_auth->is_logged_in(FALSE)) {
            redirect('/t_auth/send_again/');
        }
        $this->save_last_url();
        $this->display();
    }

    public function do_login()
    {

		$this->load->helper('validate');
        $account = $this->input->post('account');
		$password = $this->input->post('password');
		$check_mobile = is_mobile($account);
        $remember = $this->input->post('remember')?$this->input->post('remember'):false;
		$logined=false;
		if (!$check_mobile['status']) {
			$check_account = is_email($account);
			if (!$check_account['status']) {
				$this->json_response(false, array('field' => 'mobile'), '账号错误');
			}else{
				$logined=$this->tank_auth->login($account,$password,$remember,false,true,false);
			}
		}else{
			$logined=$this->tank_auth->login($account,$password,$remember,false,false,true);
		}
        if ($logined)
        {
           /* $user_id = $this->tank_auth->get_user_id();
            if ($action = $this->user_action($user_id, 'user_login')) {
                $message = $action['msg'];
            } else {
                $message = '';
            }*/
            $username = $this->tank_auth->get_username();
            //var_dump($logined);
            $url = $this->get_last_url();
            //redirect('user/account');
            $this->json_response(true, array('url'=>$url),$username);

        } else {
            $errors = $this->tank_auth->get_error_message();
            if (isset($errors['banned'])) {								// banned user
                $this->json_response(false, array(), '您被禁止登录');

            } elseif (isset($errors['not_activated'])) {				// not activated user
                //redirect('/t_auth/send_again/');
                $this->json_response(false, array(), '请先激活您的账号');

            } else {
                $this->json_response(false, '', $errors);
            }
        }

    }
	
	public function activate($activate_key=false)
	{
        $this->assign('head_title','学霸银行 - 邮箱激活');
		if(!$activate_key)
          {
		        $this->assign('activate',false);
                $this->show_message('激活码错误',0,'/',2);
            //$this->display();
		  }

		if($this->tank_auth->activate_email_first($activate_key)){
			//$this->show_message('用户激活成功',0,site_url(''));
            $email = $this->session->userdata('register_email');
            $this->session->unset_userdata('register_email');
            $this->assign('email',$email);
		    $this->assign('activate',true);
            //$this->show_message('用户激活成功,正在进入用户中心',0,'/user/account',2);
            $this->display();
		}else{
		    $email = $this->session->userdata('register_email');
		    $this->assign('activate',false);
            $this->assign('email',$email);
            $this->display();
        }
	}
}