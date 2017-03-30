<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15-2-27
 * Time: 下午2:15
 * 
 */
 class download extends  MY_User_Controller{

    protected $user_id;
    public function __construct()
    {
        parent::__construct();
        $this->user_id = $this->_login_user['user_id'];
	}
	function index(){
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
        $this->assign('pagination', $pagination);

        $this->display();
	}
	
 }