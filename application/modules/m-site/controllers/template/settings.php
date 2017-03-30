<?php 
/**
 * class settings
 *
 * @author Cavin <csp379@163.com>
 * Date: 14-3-31
 * Time: 下午9:48
 */

class settings extends MY_Site_Manage_Controller
{
	public function __construct()
	{
		parent::__construct();	
	}

    public function index()
    {
        $this->display();
    }
}