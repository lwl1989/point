<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/27
 * Time: 13:49
 */

class login extends MY_Company_Controller{

    function __construct(){
        parent::__construct();
    }
    function index(){
        //var_dump($this->session->userdata('login_user'));
        $this->display();
    }
}