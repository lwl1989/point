<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/11
 * Time: 21:10
 */
class static_message extends MY_Api_Controller{

    function __construct(){
        parent::__construct();
    }

    function get_index($site_id =1){
        $config_name = 'data/recommend_site_'.$site_id;
        $this->config->load($config_name);
        $index_message = $this->config->item('index');
        if($index_message){
            $this->json_response(true,$index_message,'获取成功');
        }
        $this->json_response(false,'','没有数据');
    }

    function get_content($site_id=1){
        $config_name = 'data/recommend_site_'.$site_id;
        $this->config->load($config_name);
        $content = $this->config->item('content');
        if($content){
            $this->json_response(true,$content,'获取成功');
        }
        $this->json_response(false,'','没有数据');
    }

    function get_index_wedding($site_id=1){
        $config_name = 'data/recommend_site_'.$site_id;
        $this->config->load($config_name);
        $index_message = $this->config->item('index_recommend_wedding');
        if($index_message){
            $this->json_response(true,$index_message,'获取成功');
        }
        $this->json_response(false,'','没有数据');
    }

    function get_content_wedding($site_id=1){
        $config_name = 'data/recommend_site_'.$site_id;
        $this->config->load($config_name);
        $index_message = $this->config->item('index_recommend_wedding');
        if($index_message){
            $this->json_response(true,$index_message,'获取成功');
        }
        $this->json_response(false,'','没有数据');
    }

    function get_company($company_id = 11212){
        $this->load->model('company');
        $company = $this->company->get_company_by_id($company_id);
        if($company){
            $this->json_response(true,$company,'获取成功');
        }
        $this->json_response(false,'','没有数据');
    }

    function get_user($user_id=false){
        if(!$user_id){
            $this->json_response(false,'','ID错误');
        }
        $this->load->model('user_api');
        $user = $this->user_api->get_user_by_id($user_id);
        if($user){
            $this->json_response(true,$user,'获取成功');
        }
        $this->json_response(false,'','没有数据');
    }

    function get_wedding($wedding_id){
        if(!$wedding_id){
            $this->json_response(false,'','ID错误');
        }
        $this->load->model('wedding_api');
        $user = $this->wedding_api->get_wedding_by_id($wedding_id);
        if($user){
            $this->json_response(true,$user,'获取成功');
        }
        $this->json_response(false,'','没有数据');
    }
}