<?php 
/**
 * class logout
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-12-9
 * Time: 上午1:44
 */

class logout extends MY_Portal_Controller
{
	public function __construct()
	{
		parent::__construct();	
	}

    public function index()
    {
		$this->save_last_url();
        $this->tank_auth->logout();
        redirect($this->session->userdata('last_url'));
        // $this->show_message('<h1>您已安全退出</h1>', 0,'/',2);
    }
}