<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/15
 * Time: 11:38
 */

class classifies extends MY_Site_Manage_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('classify');
    }

    function index(){
        $this->load->config('data/classifies', true);
        $classify = $this->config->item('data/classifies');
        $page = $this->input->get('page');
        $page = $page > 0? $page: 1;
        $conditions=array();
        $conditions['is_del'] = 0;
        if($this->input->get('name')){
            $conditions['name'] = $this->input->get('name');
            $this->assign('name', $this->input->get('name'));
        }else{
            $this->assign('name', "");
        }
        $base_url = url_query($conditions, '/m-site/classifies/index');

        $pagination = $this->classify->pagination($base_url, $page, $conditions, 'id desc');
        $this->session->set_userdata(
            'back_list_page',
            $this->get_self_url()
        );
        $this->assign('classifies',$classify);
        $this->assign('pagination', $pagination);
        $this->display();
    }
    function add(){
        $classifies = $this->get_classify();
        //var_dump($classifies);
        $this->assign('classifies',$classifies);
        $this->display();
    }
    function  get_classify($fid=0)
    {
        $this->load->config('classify_base',true);
        $classify['base'] = $this->config->item('classify_base');
        $this->load->config('data/classifies', true);
        $classify['buffer'] = $this->config->item('data/classifies');
        if ($fid != 0) {
            foreach ($classify as $v) {
                if ($v['id'] == $fid) {
                    return $v['children'];
                }
            }
        }
        return $classify;
    }

    function save(){
        if ($this->input->post('action') == 'save') {

            $id = $this->input->post('id')? $this->input->post('id'): 0;
            $data = array(
                'name' => trim($this->input->post('name')),
                'intro' => trim($this->input->post('intro')),
                'tag' => $this->input->post('tag')?intval($this->input->post('tag')):0,
                'type' => intval($this->input->post('type')),
            );

            if (!$id) {
                $result = $this->classify->save($data);
                $id = $result;
            } else {
                $result =  $this->classify->update($data,$id);
            }


            if ($id) {
                $data['id'] = $result;
                $this->json_response(true, $data);
            } else {
                $this->json_response(false);
            }
        }
    }

    function edit($classify_id){
        if($classify_id<1){
            exit('error by id');
        }
        $classify = $this->classify->getOne(array('id'=>$classify_id));
        if(!$classify){
            exit('content is null');
        }
        $classifies = $this->get_classify();
        $this->assign('classifies',$classifies);
        $this->assign('classify_',$classify);
        $this->display();
    }

    function del(){
        $article_id = intval(trim($this->input->post('id')));
        if($article_id<1){
            $this->json_response(false);
        }
        $classify = $this->classify->soft_delete($article_id);
        if($classify){
            $this->json_response(true);
        }
        $this->json_response(false);
    }

    public function generate_config()
    {
        $this->load->config('classify_base',true);
        $classify = $this->config->item('classify_base');
        foreach($classify as $key_type=>$v){
            $i=0;
            foreach($v['tags'] as $key_tag=>$tag){
                $classify[$key_type]['tags'][$key_tag]['classify']=$this->classify->get_tag_children($key_tag,$key_type);
                $i++;
            }
        }
        //echo '<pre>';
        //var_dump($classify);
          $config_name = 'data/classifies';

          $this->config->load($config_name, TRUE);

          $this->config->set_item($config_name, $classify);

          $this->config->save($config_name);

          $this->json_response();
    }

    function add_hot(){
        $this->load->config('data/classifies', true);
        $classify = $this->config->item('data/classifies');
        $this->assign('classifies',$classify);
        $this->display();
    }
    /*
     * 添加热词
     */
    function do_add_hot(){
        $this->load->config('data/classifies', true);
        $classify = $this->config->item('data/classifies');
        $type_key = $this->input->post('type_key');
        $hot = array($this->input->post('hot'));
        if(!$hot){
            $this->json_response(false,'','热词错误');
        }
        foreach($classify as $key=>$val){
            if($type_key==$key){
                $classify[$type_key]['hot']=array_merge($classify[$type_key]['hot'],$hot);
            }
        }
        $config_name = 'data/classifies';

        $this->config->load($config_name, TRUE);

        $this->config->set_item($config_name, $classify);

        $this->config->save($config_name);

        $this->json_response();
    }

    /*
     * 删除热词

    function del_hot(){
        $this->load->config('data/classifies', true);
        $classify = $this->config->item('data/classifies');
        $this->assign('classifies',$classify);
        $this->display();
    }
    */

    function do_del_hot(){
        $this->load->config('data/classifies', true);
        $classify = $this->config->item('data/classifies');
        $type_key = $this->input->post('type_key');
        $hot = $this->input->post('hot');
        foreach($classify as $key=>$val){
            if($type_key==$key){
                foreach($val['hot'] as $hot_key=>$value){
                     if($hot==$value){
                         unset($classify[$type_key]['hot'][$hot_key]);
                     }
                }
            }
        }
        $config_name = 'data/classifies';

        $this->config->load($config_name, TRUE);

        $this->config->set_item($config_name, $classify);

        $this->config->save($config_name);

        $this->json_response();
    }
    /*
     * 热词
     */
    function hots($type_key){
        $this->load->config('data/classifies', true);
        $classify = $this->config->item('data/classifies');
        $hot=array();
        $type='';
        foreach($classify as $key=>$val){
            if($type_key==$key){
                $hot = $classify[$type_key]['hot'];
                $type = $classify[$type_key]['type'];
            }
        }
        $this->assign('type',$type);
        $this->assign('hots',$hot);
        $this->assign('type_key',$type_key);
        $this->display();
    }
}