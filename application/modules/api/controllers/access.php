<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-7
 * Time: 上午10:14
 */

class access extends MY_Controller{

    function __construct(){
        parent::__construct();
    }

    function get_token($appid,$appsecret){
        $this->load->model('api/apps');
        $result = $this->apps->get_token($appid,$appsecret);
        if(!$result)
        {
            $arr = array(
                'state' => false
            );
            $this->_json($arr);
        }
        $token = md5(sha1(time()));
        $result = $this->apps->set_token($token);
        if(!$result)
        {
            $arr = array(
                'state' => false
            );
            $this->_json($arr);

        }
        $arr = array(
            'state' => true,
            'token' => $token
        );

        $this->_json($arr);
    }

    /*function set_operate_token($token){
        $this->load->model('api/apps');
    }*/

  /*  function get_operate_token($token){

    }*/


}
