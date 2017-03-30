<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈
 * Date: 14-11-8
 * Time: 下午8:55
 * 用户控制器-登录后-权限控制
 */

class MY_User_Controller extends MY_Portal_Controller{

    function __construct()
    {
        parent::__construct();
        //用户基础类
       // $this->load->model('user/base');
        $this->_login_user = $this->session->userdata('login_user');
        $this->load->helper('url');
        if(!$this->_login_user){
            $this->auth();
        }

    }

} 