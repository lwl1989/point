<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/29
 * Time: 20:07
 */

class message extends MY_User_Controller{

    function __construct(){
        parent::__construct();
        $this->assign('css_load',array('user_account'));
        $this->assign('active','message');
    }

    function index(){
    //    echo '消息中心';
        $this->assign('head_title','个人中心 - 消息列表 -');
        $this->display();
    }

    function show(){
    //    echo '消息 正文';
        //如果消息未读的话
        $this->do_read();
        $this->assign('head_title','个人中心 - 消息 - 正文 -');
    }

    function del(){

    }

    /*
     * 将未读消息编程已读
     */
    private function do_read(){

    }
}