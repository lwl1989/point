<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/13
 * Time: 18:00
 */

class articles extends MY_Site_Manage_Controller{

    function __construct(){
        parent::__construct();
        $this->load->helper('image_helper');
        $this->load->model('article');
        $this->assign('index_channel','contents');
    }

    function index(){
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
        $base_url = url_query($conditions, '/m-site/articles/index');

        $pagination = $this->article->pagination($base_url, $page, $conditions, 'id desc');
        $this->session->set_userdata(
             'back_list_page',
             $this->get_self_url()
        );

        $this->assign('pagination', $pagination);
        $this->display();
    }

    function add(){
        $this->display();
    }

    function save(){
        if ($this->input->post('action') == 'save') {

            $id = $this->input->post('id')? $this->input->post('id'): 0;
            $data = array(
                 'site_id' => $this->_site_id,
                 'name' => trim($this->input->post('name')),
                 'intro' => trim($this->input->post('intro')),
                 'cover' => $this->input->post('cover'),
                 'message' => $this->input->post('message'),
            );

            if (!$id) {
                $data['create_time'] = date('Y-m-d',time());
                $result = $this->article->save($data);
                $id = $result;
            } else {
                $result =  $this->article->update($data,$id);
            }


            if ($id) {
                $data['id'] = $result;
                $this->json_response(true, $data);
            } else {
                $this->json_response(false);
            }
        }
    }

    function edit($article_id){
        if($article_id<1){
            exit('error by id');
        }
        $article = $this->article->getOne(array('id'=>$article_id));
        if(!$article){
            exit('content is null');
        }
        $this->assign('article',$article);
        $this->display();
    }

    function del(){
        $article_id = intval(trim($this->input->post('id')));
        if($article_id<1){
            $this->json_response(false);
        }
        $article = $this->article->soft_delete($article_id);
        if($article){
            $this->json_response(true);
        }
        $this->json_response(false);
    }


}