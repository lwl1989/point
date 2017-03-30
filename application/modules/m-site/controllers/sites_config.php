<?php 
/**
 * class sites
 * 站点配置
 * @author zzj
 * Date: 2014.04.22
 * Time: 下午6:17
 */

class sites_config extends MY_Site_Manage_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('site_config');
	}

    public function index($page = 1)
    {

        $page = $this->input->get('page');
        $page = $page > 0? $page: 1;
        

        $conditions = array();

        
        $base_url = url_query($conditions, '/m-site/sites_config');
        
        
        $pagination = $this->site_config->pagination($base_url, $page, $conditions, 'id desc');
		//var_dump($this->db->last_query());
		
		
        //返回当最后一次列表页
        $this->session->set_userdata(
            'back_list_page',
            $this->get_self_url()
        );
		
		//var_dump($pagination);
        $this->assign('pagination', $pagination);
        $this->display();
    }
    

    public function edit()
    {
        $id = $this->_site_id;


        $site = $this->site_config->get($id);
        
        if (!$site) {
            show_404('该数据不存在或者已删除');
        }
		
		

        $this->assign('site', $site);
        $this->assign('back_list_page', $this->session->userdata('back_list_page'));

        $this->display();


    }

   
    function update()
    {
        if ($this->input->post('action') == 'update') {
        	
        	$data = array(
        		'id'=>$this->input->post('id'),
        		'name'=>$this->input->post('name'),
        		'title'=>$this->input->post('title'),
        		'keywords'=>$this->input->post('keywords'),
        		'description'=>$this->input->post('description'),
        	);
        	$this->site_config->update($data);
        	
        	
        	//更新缓存
        	/*$config_data = array();
			$config_data['name'] = $data['name'];
			$config_data['title'] = $data['title'];
			$config_data['keywords'] = $data['keywords'];
			$config_data['description'] = $data['description'];
			
			
        	$config_name = 'data/system.site_' . $data['id'];
	        $this->config->load($config_name, TRUE);
	        $this->config->set_item($config_name, $config_data);
	        $this->config->save($config_name);
        	echo '3213123';*/
        	$this->json_response(true);
        }
        
        
    }
    
    
    
    /**
     * 刷新站点配置缓存
     */
    public function refresh_cache()
    {
        
        
        $sites = $this->site_config->find_all();

        
		if($sites)
        foreach($sites as $site) {
        	$config_data = array();
            $config_data['name'] = $site['name'];
            $config_data['title'] = $site['title'];
            $config_data['keywords'] = $site['keywords'];
            $config_data['description'] = $site['description'];
            
            $config_name = 'data/system.site_' . $site['id'];

	        $this->config->load($config_name, TRUE);
	
	        $this->config->set_item($config_name, $config_data);
	
	        $this->config->save($config_name);
        }

        

        $this->json_response();


    }

}