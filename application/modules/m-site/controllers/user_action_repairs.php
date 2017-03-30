<?php 
/**
 * class companies
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-10-11
 * Time: 下午9:17
 */

class User_action_repairs extends MY_Site_Manage_Controller
{
	public function __construct()
	{
		parent::__construct();

	}

    public function repair()
    {
        
    	$this->load->model('user_action_repair_model');
        
        
    	$this->user_action_repair_model->repair();
		
		

        $this->display();
    }

}