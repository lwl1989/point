<?php 
/**
 * class companies
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-10-11
 * Time: 下午9:17
 */

class Companies extends MY_Site_Manage_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('image_helper');
        $this->load->model('company');
        $this->load->model('zone');
        $this->load->model('site_config');
        $this->assign('index_channel','contents');
	}

    public function index()
    {
        $this->load->helper('image');
        $page = $this->input->get('page');
        $page = $page > 0? $page: 1;

        $root_zones = $this->zone->find_by_p_id(0);
        $this->assign('root_zones', $root_zones);


        $conditions = array();
       /* if($this->input->get('cate_id')){
        	
        	$conditions['cate_id'] = $this->input->get('cate_id');
        	$this->assign('cate_id', $this->input->get('cate_id'));
        	
        }else{
        	$this->assign('cate_id', "");
        } */
        if($this->input->get('zone_id')){
        	$conditions['zone_id'] = $this->input->get('zone_id');
        	$this->assign('zone_id', $this->input->get('zone_id'));
        }else{
        	$this->assign('zone_id', "");
        }
        if($this->input->get('name')){
        	$conditions['name'] = $this->input->get('name');
        	$this->assign('name', $this->input->get('name'));
        }else{
        	$this->assign('name', "");
        }
        
        $base_url = url_query($conditions, '/m-site/companies/index');
        

        $pagination = $this->company->pagination($base_url, $page, $conditions, 'id desc');

        $this->session->set_userdata(
            'back_list_page',
            $this->get_self_url()
        );
       // var_dump($pagination);
        $this->assign('pagination', $pagination);
        $this->display();
    }

    function list_charge($company_id){
        $this->load->config('print_price',true);
        $charge_default = $this->config->item('print_price');
        $this->load->model('company/company_base');
        $company = $this->company_base->get_company_by_id($company_id);
        if($company['charge']){
            $company['charge']= json_decode($company['charge']);
        }else{
            $company['charge']=$charge_default;
        }
        $this->assign("charge",$company['charge']);
       // var_dump($company['charge']);
        $this->display();
    }

    function set_zone($company_id){
        $this->load->model('company/company_base');
        $company = $this->company_base->get_company_by_id($company_id);
        $root_zones = $this->zone->find_by_p_id(0);
        $this->assign('company_name',$company['name']);
        $this->assign('root_zones', $root_zones);
        $this->assign('id',$company_id);
        $this->display();
    }

    function do_set_zone(){
        $id = intval($this->input->post('id'));
        $zone_id = intval($this->input->post('zone_id'));
        $this->load->model('company/company_base');
        $result = $this->company_base->set_zone($id,$zone_id);
        //echo $this->company_base->db->last_query();
        if($result){
            $this->json_response(true,"","设置成功");
        }
        $this->json_response(false,"","设置失败");
    }


}