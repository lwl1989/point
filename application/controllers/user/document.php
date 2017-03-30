<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-2
 * Time: 下午5:25
 */

class document extends MY_User_Controller{
    protected $user_id;
    protected $list_row;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user/user_model');
        $this->load->model('user/user_file');
        $this->user_id = $this->_login_user['user_id'];
        $this->config->load('document', TRUE);
        $this->list_row	= $this->config->item('list_row', 'document');
        $this->assign('active','document');
        $this->assign('css_load',array('user_account'));
        $this->load->helper('pagination_user');
    }

    function index($page = 1,$classify = 0){
        $this->assign('head_title', '我的文档 - 我的账号');
        $offset = ($page-1)*$this->list_row;
        $condition = array(
            'user_id'   => $this->user_id,
        );
        if($classify){
            $condition['file_classify'] = $classify;
        }
        $this->load->model('document/document_comment');

        $my_file = $this->user_file->get_file($condition,$this->list_row,$offset);
        for($i=0;$i<count($my_file);$i++){
            $my_file[$i]['collect'] = $this->user_file->get_like_by_id($this->user_id,$my_file[$i]['id'],1);
            $my_file[$i]['like'] = $this->user_file->get_like_by_id($this->user_id,$my_file[$i]['id'],2);
            $comment = $this->document_comment->get_comment_count($my_file[$i]['id']);
            $my_file[$i]['comment_total'] = $comment['comment_total'];
            $my_file[$i]['avg_score'] = $comment['avg_score'];
        }

        $this->load->model('document/document_model');
        $count_document = $this->document_model->count_document($this->user_id);
        $count_document['like_total'] =   $this->document_model->count_like_total($this->user_id);
        $this->assign('count_document',$count_document);


        $base_url = '/user/document/index/';
        $count =$this->user_file->get_count_by_user($this->user_id);
        $pagination = create_pagination($base_url,$page,$this->list_row,$count);

        $this->assign('pagination',$pagination);
        $this->assign('file_list',$my_file);
        $this->display();
    }

    function del($file_id){
        if(!$file_id && is_integer(intval($file_id))){
            $this->json_response(false, array('field' => 'file_id'), '文件没有被选中');
        }

        $result = $this->user_file->soft_del($this->user_id,$file_id);
        if(!$result){
            $this->json_response(false,array(),'删除失败,联系管理员');
        }

        $this->json_response(true,array('del'=>1,'file_id'=>$file_id),'删除成功');
    }

    function down(){
        $this->load->model('document/document_model');
        $this->load->model('document/document_like');
        $count_document = $this->document_model->count_document($this->user_id);
        $count_document['like_total'] = $this->document_model->count_like_total($this->user_id);

        $page = $this->input->get('page');
        $page = $page > 0? $page: 1;
        $conditions = array('user_id'=>$this->user_id);
        /*下载文档*/
        $this->load->model('user/user_download');

        $base_url = url_query($conditions, '/user/download/index');

        $pagination = $this->user_download->pagination($base_url, $page, $conditions, 'id desc');
        if(is_array($pagination['list'])){
            $ids = array();
            $i=0;
            foreach($pagination['list'] as $val){
                $ids[$i] = $val['document_id'];
                $i++;
            }
            $this->load->model('public/file_base');
            $documents = $this->file_base->get_file_list($ids);
            $i=0;
            foreach($documents as $document){
                $pagination['list'][$i]['document'] = $document;
                $i++;
            }
        }
        //返回当最后一次列表页
        $this->session->set_userdata(
            'back_list_page',
            $this->get_self_url()
        );
        $this->assign('head_title','我的下载 - ');
        $this->assign('count_document',$count_document);
        $this->assign('pagination', $pagination);
        $this->display();
    }

    function like($page = 1){
        $offset = ($page-1)*$this->list_row;
        $this->load->model('document/document_model');
        $this->load->model('document/document_like');

        $count_document = $this->document_model->count_document($this->user_id);
        $count_document['like_total'] =   $this->document_model->count_like_total($this->user_id);
        $document_likes = $this->document_like->get_like_by_user($this->user_id,$this->list_row,$offset);
        if(is_array($document_likes)){
            $document_like_ids = array();
            $i=0;
            foreach($document_likes as $val){
                $document_like_ids[$i]= $val['document_id'];
                $i++;
            }
            $document_likes = $this->document_model->get_document_by_ids($document_like_ids);
        }else{
            $document_likes = null;
        }
        /*
         * 构建分页
         */
        $base_url = '/user/document/like/';
        $count =$this->document_like->get_like_count_by_user($this->user_id);
        $pagination = create_pagination($base_url,$page,$this->list_row,$count);
        $this->assign('head_title','我的收藏 - ');
        $this->assign('count_document',$count_document);
        $this->assign('pagination',$pagination);
        $this->assign('file_like',$document_likes);
        $this->display();
    }

    /*
     * 文件归档
     * 将文件分配分类属性
     */
    function place_file(){
        $this->assign('head-title','文件归档 - 我的文档');
        $this->display();
    }

    function do_place_file(){
        $file_id = intval(trim($this->input->post('file_id')));
        $classify_id = intval(trim($this->input->post('classify_id')));
        if(!$file_id or !$classify_id){
            $this->json_response(false,array('id'=>'lost'),'丢失文件ID或者分类ID');
        }

        $result = $this->user_file->set_file_classify($file_id,$classify_id);

        if(!$result){
            $this->json_response(false,array(),'归档失败，联系管理员');
        }

        $this->json_response(true,array('del'=>1,'file_id'=>$file_id,'classify_id'=>$classify_id),'文件归档成功');
    }

    function edit($file_id){
        if($file_id<1)
            exit('错误');
        $this->assign('head_title', '编辑文档信息 - 我的账号');
        $file_info = $this->user_file->get_file_by_id($this->user_id,$file_id);
        $this->assign('file',$file_info);
        $this->display();
    }

    function do_edit(){
        $data = array(
            'id'    => intval($this->input->post('id')),
            'title' => trim($this->input->post('title')),
            'intro' => trim($this->input->post('intro')),
            'tag' => trim($this->input->post('tag')),
            'thumbnail' => trim($this->input->post('thumbnail')),
            'file_classify' => intval($this->input->post('file_classify'))
        );
        $result = $this->user_file->updata_file($data);

        if(!$result){
            $this->return_json(false,'','更新文件信息失败');
        }
        $this->return_json(true,'','更新文件信息成功');
    }

    /*
     * 添加文集
     */
    function do_add_corpus(){
        $data = array(
            'user_id'       =>  $this->user_id,
            'name'          =>  trim($this->input->post('name')),
            'intro'         =>  trim($this->input->post('intro')),
            'document_ids'  =>  '',
            'is_del'        =>  0
        );
        $this->load->model('user/user_corpus');
        $result = $this->user_corpus->insert($data);

        if(!$result){
            $this->return_json(false,'','新建文集错误');
        }
        $this->return_json(true,'','新建文集成功');
    }
    /*
     * 更改文集基本属性
     */
    function do_change_corpus($corpus_id){
        $data = array(
            'id'            =>  $corpus_id,
            'user_id'       =>  $this->user_id,
            'name'          =>  trim($this->input->post('name')),
            'intro'         =>  trim($this->input->post('intro')),
        );
        $this->load->model('user/user_corpus');
        $result = $this->user_corpus->update($data,$corpus_id);

        if(!$result){
            $this->return_json(false,'','更改文集失败');
        }
        $this->return_json(true,'','更新文集信息成功');
    }
    /*
     * 软删除文集
     */
    function do_del_corpus($corpus_id){
        $this->load->model('user/user_corpus');
        $result = $this->user_corpus->soft_delete($corpus_id);
        if(!$result){
            $this->return_json(false,'','删除文集失败');
        }
        $this->return_json(true,'','删除文集信息成功');
    }

    /*
     * 文集列表
     */
    function corpus(){
        $this->load->model('user/user_corpus');
        $result = $this->user_corpus->get_corpus_by_user($this->user_id);
    //    var_dump($result);
        $this->assign('corpora',$result);
        $this->display();
    }

    function do_range_corpus(){
        $document_id  = intval(trim($this->input->post('document_id')));
        $corpus_id    = intval(trim($this->input->post('corpus')));
        $this->load->model('user/user_corpus');
        $result = $this->user_corpus->range_corpus($corpus_id,$document_id,$this->user_id);
        if(!$result){
            $this->return_json(false,'','文件归档失败');
        }
        $this->return_json(true,'','文件归档成功');
    }
}