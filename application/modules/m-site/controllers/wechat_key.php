<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/23
 * Time: 0:19
 */

class wechat_key extends MY_Site_Manage_Controller{
    protected $config_wechat;
    protected $page_size = 10;
    function __construct(){
        parent::__construct();
        $this->load->model('wechat_keyword_model');
        $this->load->config('wechat');
        $this->config_wechat = $this->config->item('wechat');
    }

    function index(){
        $page = $this->input->get('page');
        $page = $page > 0? $page: 1;
        $conditions['is_del'] = 0;
        if($this->input->get('name')){
            $conditions['keyword'] = $this->input->get('name');
            $this->assign('name', $this->input->get('name'));
        }else{
            $this->assign('name', "");
        }
        $base_url = url_query($conditions, '/m-admin/wechat_key/index');

        $pagination = $this->wechat_keyword_model->pagination($base_url, $page, $conditions, 'id desc');
        $this->session->set_userdata(
            'back_list_page',
            $this->get_self_url()
        );
        $this->assign('pagination', $pagination);
        $this->display();
    }

    function set_key(){

        $this->display();
    }

    function do_save(){
        $id =$this->input->post('id');
        $data = array(
            'source'    =>  $this->input->post('source'),
            'keyword'   =>  $this->input->post('keyword'),
            'type'   =>  $this->input->post('type'),
        );
        $this->load->library("pinyin");
        $data['keyword_pinyin'] = $this->pinyin->output($data['keyword'],true);
        if($id){
            $this->wechat_keyword_model->update($data,$id);
            $this->json_response(true);
        }
        $keywords = $this->wechat_keyword_model->find_by_key($data['keyword']);
        if($keywords){
            $this->wechat_keyword_model->update($data,$keywords['id']);
            $this->json_response(true);
        }
        $this->wechat_keyword_model->insert($data);
        $this->json_response(true);
    }

    function change_key($id){
        $keywords = $this->wechat_keyword_model->getOne(array('id'=>$id));
        if($keywords){
            if(!($keywords['type']==1)){
                $message = array();
                $source = json_decode($keywords['source'],true);
                foreach($source as $val){
                    $this->load->model('wechats/wechat_'.$val['source']);
                    $source_class = 'wechat_'.$val['source'];
                    $message = array_merge_recursive($message,array($this->$source_class->get_source_by_id($val['source_id'])));
                }
                $keywords['source']=$message;
            }
        }
        $this->assign('keyword',$keywords);
        $this->display();
    }

    function del($id){
        $this->wechat_keyword_model->soft_delete($id);
        echo '删除成功';
    }
    protected function get_keyword($key){
        $this->load->model('wechat_keyword_model');
        $keywords = $this->wechat_keyword_model->find_by_key($key);
        if($keywords){
            if($keywords['type']==1)
                return array($keywords['source'],'text');
            $message = array();
            $source = json_decode($keywords['source'],true);
            foreach($source as $val){
                $this->load->model('wechats/wechat_'.$val['source']);
                $source_class = 'wechat_'.$val['source'];
                $message = array_merge_recursive($message,array($this->$source_class->get_source_by_id($val['source_id'])));
            }
            return array($message,'images');
        }
        return false;
    }
}