<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class welcome extends  MY_Portal_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth');
	}

	function index()
	{
       // $this->load->model('document/document_model');
       // $this->load->model('user/user_model');
       // $statistics = $this->user_model->get_users_num();
       // $statistics['document_num'] = $this->document_model->get_document_num();

        $this->set_layout('default');
        $this->load->config('data/classifies',true);
        $this->assign('classify',$this->config->item('data/classifies'));
        //$this->assign('statistics',$statistics);
        $this->assign('head_title', '您的知识银行');

        //$this->assign('js_load',array( 'common','bootstrap'));
        $this->display();
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */