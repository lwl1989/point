<?php
/**
 * 用户中心
 * User: o0无忧亦无佈
 * Date: 14-11-10
 * Time: 下午11:47
 */

class account extends MY_User_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user/user_model');
        $this->assign('css_load',array('user_account'));
        $this->assign('active','account');
    }

    public function index()
    {
        $this->assign('head_title', '基本信息 - 我的账号');
        $this->display();
    }

    public function avatar()
    {
        $this->assign('head_title', '头像设置 - 我的账号');
        $this->display();
    }


    public function avatar_upload()
    {
        $str=file_get_contents('php://input');
        if($str)
        {
            $u_id = abs(intval($this->_login_user['user_id']));
            $u_id = sprintf("%09d", $u_id);
            $dir1 = substr($u_id, 0, 3);
            $dir2 = substr($u_id, 3, 2);
            $dir3 = substr($u_id, 5, 2);
            $dir = 'data/avatars/'.$dir1.'/'.$dir2.'/'.$dir3.'/';
            if (!is_dir(FCPATH.$dir)) {
                _mkdir(FCPATH.$dir);
            }
            $file_name 		= substr($u_id, -2).'_avatar';
            $default_name 	= $dir.$file_name.'_default.png';
            $middle_file	= $dir.$file_name.'_middle.png';
            $small_file		= $dir.$file_name.'_small.png';
            $this->load->helper('file');
            if (!write_file($default_name, $str))
            {
                $data=array('type'=>'avatarError','source'=>'AvatarUpload','data'=>array('code'=>201,'msg'=>'上传头像失败'));
                $data=json_encode($data);
                echo $data;
            }
            else
            {
                compress_image($default_name,120,120,$middle_file);
                compress_image($default_name,50,50,$small_file);
                $data=array('type'=>'avatarSuccess','source'=>'AvatarUpload','data'=>array('code'=>200,'msg'=>'上传头像成功','pic'=>$default_name));
                $data=json_encode($data);
                echo $data;
            }
        }
        else
        {
            $data=array('type'=>'avatarError','source'=>'AvatarUpload','data'=>array('code'=>201,'msg'=>'没有图片信息'));
            $data=json_encode($data);
            echo $data;
        }
    }

    function update_info()
    {
        $this->assign('head_title', '基本信息 - 我的账号');
        $this->display();
    }

    function do_update_info()
    {
        $data = array(
            'id' => $this->_login_user['user_id'],
            'address' => trim($this->input->post('address')),
            'nickname'	=> trim($this->input->post('nickname')),
            'qq'	=> trim($this->input->post('qq')),
            'introduce'	=> trim($this->input->post('introduce')),
            'province'  =>  trim($this->input->post('province')),
            'city'  =>  trim($this->input->post('introduce')),
            'province_now'  => trim($this->input->post('province_now')),
            'city_now'  => trim($this->input->post('city_now')),
            'mobile'    =>  trim($this->input->post('mobile'))
        );

        if ($this->input->post('sex') == 1 || $this->input->post('sex') == 0) {
            $data['sex'] = $this->input->post('sex');
        }

        if ($this->user_model->save($data)) {
            $this->json_response();
        }
        $this->json_response(false);

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

    public function change_email()
    {
        $this->assign('head_title', '修改邮箱 - 我的账号');
        $this->display();
    }


    public function do_change_email()
    {
        $password = $this->input->post('password');
        $old_email = $this->input->post('old_email');
        $new_email = $this->input->post('new_email');

        if ($old_email == $new_email) {
            $this->json_response(false, array('field' => 'new_email'), '新邮箱和当前邮箱一样');
        }

        $this->load->helper('validate');
        $check_new_email = is_email($new_email);
        if (!$check_new_email['status']) {
            $this->json_response(false, array('field' => 'new_email'), '新邮箱格式错误');
        }

        if (!$this->tank_auth->user_password_available($password)) {
            $this->json_response(false, array('field' => 'password'), '密码错误');
        }

        if (!$this->tank_auth->is_email_available($new_email)) {
            $this->json_response(false, array('field' => 'new_email'), '新邮箱已注册');
        }

        //如果原始邮箱没激活，则直接修改邮箱，不用通过发送邮件
        if ($this->input->post('email_is_activated') == 0) {
            if ($this->users->not_activated_email_change(
                $this->_login_user['user_id'], $old_email, $new_email)
            ) {//修改成功
                //退出登录
                $this->tank_auth->logout();
                $this->json_response();
            }
            $this->json_response(false);
        } else {//如果是已激活的邮箱修改
            if (!is_null($data = $this->tank_auth->set_new_email(
                $new_email, $password))
            ) {// success
                $data['change_period'] = $this->config->item('email_change_expire', 'tank_auth') / 3600;
                //$data['site_name'] = $this->config->item('website_name', 'tank_auth');
                var_dump($data);exit();
                $this->send_email('change_email', $data['new_email'], '修改邮箱', $data);

                $msg = "邮件已发送到您的新邮箱{$new_email}）,请在{$data['change_period']}小时内登录邮箱完成修改。";
                $this->json_response(true, array('activated' => 1), $msg);

            } else {
                $errors = $this->tank_auth->get_error_message();
                $this->json_response(false, array('activated' => 1), $errors);
            }
        }

    }

    public function reset_email($user_id, $new_email_key)
    {
        $user_id = intval($user_id);
        if ($user_id == $this->_login_user['user_id']) {
            $this->load->model('user/user_model');
            $user = $this->user_model->get($user_id);

            if($user) {

                $key_created = strtotime($user['new_email_key_created']);

                $dateline = $key_created + $this->config->item('email_change_expire', 'tank_auth');
                if (time() > $dateline ) {
                    $this->show_message(
                        '<h1>修改邮箱链接已失效！<span class="timer">2</span>秒后将调整到用户中心，邮箱修改页面。</h1>',
                        2,
                        site_url('user/account/change_email'),
                        2
                    );
                }
                if ($new_email_key != $user['new_email_key']) {
                    $this->show_message(
                        '<h1>邮箱修改码错误！<span class="timer">2</span>秒后将调整到用户中心，邮箱修改页面。</h1>',
                        1,
                        site_url('user/account/change_email'),
                        2
                    );
                }
                if ($this->tank_auth->activate_new_email($user_id, $new_email_key)) {
                    $this->tank_auth->logout();
                    $this->show_message(
                        '<h1>邮箱激活成功！已退出登录，<span class="timer">2</span>秒后将调整到用户登录页面。</h1>',
                        0,
                        site_url('user/welcome'),
                        2
                    );
                } else {
                    $this->show_message(
                        '<h1>邮箱激活成功！<span class="timer">2</span>秒后将调整到用户中心，邮箱修改页面。</h1>',
                        0,
                        site_url('user/account/change_email'),
                        2
                    );
                }
            }

        }

    }


    public function activate_email()
    {
        $this->load->model('user/user_model');
        $this->assign('head_title', '邮箱激活 - 我的账号');
        $this->display();
    }

    /**
     * 发送邮箱激活邮件
     */
    public function send_activate_email_key()
    {
      /*  if ($user['email_is_activated'] == 1) {
            $this->json_response(false, array(), '邮箱已激活');
        }

        $data = array(
            'user_id' => $user['id'],
            'activate_email_key' => md5(rand().microtime()),
        );
        $user_data = array(
            'id' => $user['id'],
            'activate_email_key' => $data['activate_email_key'],
            'activate_email_created' => date('Y-m-d H:i:s')
        );
        if ($this->user_model->save($user_data)) {
            $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;
            $this->send_email('activate_email', $user['email'], '邮箱激活', $data);
            $this->json_response();

        } else {
            $this->json_response(false, array(), '发送邮件失败！请联系我们客服！');
        }*/
    }


    public function do_activate_email($user_id, $activate_key)
    {
        $user_id = intval($user_id);
        $activate_key = trim($activate_key);
        if ($user_id < 1 || empty($activate_key)) {
            $this->show_message('<h1>请求错误</h1>', 1,'/');
        }

        $this->load->model('user/user_model');
        $user = $this->user_model->get($this->_login_user['user_id']);

        $key_created = strtotime($user['activate_email_created']);

        $dateline = $key_created + $this->config->item('email_activation_expire', 'tank_auth');
        if (time() > $dateline ) {
            $this->show_message(
                '<h1>邮箱激活链接已失效！<span class="timer">2</span>秒后将调整到用户中心，邮箱激活页面。</h1>',
                2,
                site_url('user/account/activate_email'),
                2
            );
        }
        if ($activate_key != $user['activate_email_key']) {
            $this->show_message(
                '<h1>邮箱激活码错误！<span class="timer">2</span>秒后将调整到用户中心，邮箱激活页面。</h1>',
                1,
                site_url('user/account/activate_email'),
                2
            );
        }

        $update = array(
            'id' => $user_id,
            'email_is_activated' => 1,
            'activate_email_key' => '',
            'activate_email_created' => '0000-00-00 00:00:00',
        );

        if ($this->user_model->save($update)) {
            //邮箱激活,积分处理
            $this->user_action($user_id, 'user_activate_email');
            $this->show_message(
                '<h1>邮件激活成功！<span class="timer">2</span>秒后将调整到用户中心。</h1>',
                0,
                site_url('user/welcome'),
                2
            );
        }
        $this->show_message(
            '<h1>邮箱激活码失败！<span class="timer">2</span>秒后将调整到用户中心，邮箱激活页面。</h1>',
            1,
            site_url('user/account/activate_email'),
            2
        );

    }
	
	/*下载列表*/
/*	public function upload($file_id,$url['download_count']){
		
	}*/
	
	/*收藏列表*/
	/*public function collect($file_id){
		
	}
	
	/*评论列表*/
	/*public function comment($file_id){
		
	}*/
	
}