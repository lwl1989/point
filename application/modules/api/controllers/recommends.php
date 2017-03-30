<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/11
 * Time: 1:02
 */
class recommends extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('recommend');
    }

    function get_index($limit = 6){

    }

    function get_content($source = 'wedding',$limit = 4){

    }


}