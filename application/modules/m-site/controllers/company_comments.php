<?php 
/**
 * class company_comments
 *
 * @author zzj
 * Date: 2014.04.18
 */

class company_comments extends MY_Site_Manage_Controller
{
	public function __construct()
	{
		parent::__construct();

        $this->load->helper('image_helper');
        $this->load->model('company_comments_my_site');

        if ($this->session->userdata('back_list_page')) {
            $back_list_page = $this->session->userdata('back_list_page');
        } else {
            $back_list_page = site_url('m-site/company_comments');
        }
        $this->assign('back_list_page', $back_list_page);
        $this->assign('index_channel','contents');

	}



	/**
	 *
	 * 
	 */
    public function index()
    {

        $this->load->model('company/company_comment');

    	$page = $this->input->get('page');
        $page = $page > 0? $page: 1;
        
        
        $conditions = array(
            'is_audit' => $this->input->get('is_audit')?$this->input->get('is_audit'):0
        );
         $url_conditions = array();

        if($this->input->get('company_name')){
        	$conditions['company_name'] = $this->input->get('company_name');
        	$url_conditions['company_name'] = $this->input->get('company_name');
        	$this->assign('company_name', $this->input->get('company_name'));
        }
        
        if($this->input->get('user_name')){
        	$conditions['user_name'] = $this->input->get('user_name');
        	$url_conditions['user_name'] = $this->input->get('user_name');
        	$this->assign('user_name', $this->input->get('user_name'));
        }

        $base_url = url_query($url_conditions, 'm-site/company_comments/index/');

        $result = $this->company_comment->get_comments_list($page,$conditions);
        $count  = $this->company_comment->get_comments_count($conditions);
        $this->load->helper('pagination_user');
        $pagination['list']=$result;
        $pagination['page_html']=create_pagination($base_url,$page,15,$count);

        //返回当最后一次列表页
        $this->session->set_userdata(
            'back_list_page',
            $this->get_self_url()
        );
       // var_dump($pagination);
        $this->assign('pagination', $pagination);
        $this->display();

    }


    function do_audit(){
        $id = intval($this->input->post('id'));
        $this->load->model('company/company_comment');
        $result = $this->company_comment->audit($id);

        if($result){
            $this->json_response(true,"","通过");
        }
        $this->json_response(false,"","审核失败");
    }

    function do_forbidden(){
        $id = intval($this->input->post('id'));
        $this->load->model('company/company_comment');
        $result = $this->company_comment->forbidden($id);

        if($result){
            $this->json_response(true,"","禁止成功");
        }
        $this->json_response(false,"","禁止失败");
    }


    function  do_back_forbidden(){
        $id = intval($this->input->post('id'));
        $this->load->model('company/company_comment');
        $result = $this->company_comment->back_forbidden($id);

        if($result){
            $this->json_response(true,"","撤销成功");
        }
        $this->json_response(false,"","失败");
    }
    
}