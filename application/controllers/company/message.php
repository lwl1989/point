<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/6/14
 * Time: 0:28
 */

class message extends MY_Company_Controller{

    function __construct(){
        parent::__construct();
    }
    function index(){
        $this->display();
    }
}