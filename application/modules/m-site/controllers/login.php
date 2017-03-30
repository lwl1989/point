<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class login extends MY_Site_Manage_Controller
{


    /**
     * @var site_admin_model
     */
    public $site_admin_model;


    /**
     * @var site_role_model
     */
    public $site_role_model;

    public function __construct()
    {
        parent::__construct();

        $this->set_layout();
    }

    public function index()
    {
        $this->display();
    }

    public function do_login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if ($this->tank_auth->login(
            $email,
            $password,
            false,
            false,
            true,false)
        ) {
            $user_id = $this->tank_auth->get_user_id();
            $login_user = $this->session->userdata('login_user');
            $this->site_admin = $login_user;

            if ($user_id == 1) {
                $this->site_admin['roles'] = 'SUPERADMIN';
                $this->session->set_userdata('site_admin', $this->site_admin);
                $this->json_response();
            }

            $this->load->model('site_admin_model');
            $admin = $this->site_admin_model->get_by_user_id($user_id);

            if (!$admin) {
                $this->json_response(false, [], '您不是管理员');
            }

            $this->load->model('site_role_model');



            $this->site_admin['roles'] = $admin['roles'];

            $menus = $this->site_role_model->get_menus_by_roles($admin['roles']);
            $this->site_admin['menus'] = $menus;

            $this->session->set_userdata('site_admin', $this->site_admin);
            $this->json_response();

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
}