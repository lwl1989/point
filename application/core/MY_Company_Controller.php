<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/10
 * Time: 14:12
 */
class MY_Company_Controller extends MY_Portal_Controller{
    protected $company_id;
    protected $company_user;
    function __construct()
    {
        parent::__construct();
        $this->set_layout('company');
        $this->load->helper('url');
        if(!$this->_login_user){
            $this->auth('company');
        }else {
            $this->load->model('company/company_base');
            $company = $this->company_base->get_user_by_id($this->_login_user['user_id']);
            $this->company_user = $company;
            //var_dump($this->_login_user);
            //var_dump($company);
            if ($company) {
                $this->session->set_userdata('company_user_id', $company['id']);
            } else {
                if ($this->controller != 'login') {
                    redirect('company/login');
                }
            }
            $this->company_id = $this->session->userdata('company_user_id');
            $this->assign('company_id',$this->company_id);
        }
    }
}