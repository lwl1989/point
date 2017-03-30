<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/10
 * Time: 19:29
 */

class company_list extends MY_Api_Controller{

    function __construct(){
        parent::__construct();
    }

    function get_companies($site_id = 1){
        $p_id = intval($this->input->get('p_id'));
        $this->load->config('recommend');
        $source_config = $this->config->item('source');
        $source = @$source_config[$p_id]['source'];
        if(!$source){
            $this->json_response(true);
        }
        $this->load->model($source);
        $data = $this->$source->select(array('is_del'=>0));
        if($data)
            $this->json_response(true,$data);
        $this->json_response(false);
    }

}