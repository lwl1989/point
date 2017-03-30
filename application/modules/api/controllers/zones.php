<?php 
/**
 * class Zones
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-10-19
 * Time: 下午3:15
 */

class Zones extends MY_Api_Controller
{
	public function __construct()
	{
		parent::__construct();

        $this->load->model('zone');
	}

    public function find()
    {
        $p_id = intval($this->input->get('p_id'));

        if ($p_id < 0) {
            $this->json_response(false, array(), 'Bad Request!');
        }

        $data = $this->zone->find_by_p_id($p_id);

        $this->json_response(true, $data);

    }

    public function find_all(){
        $data = $this->zone->find_all();

        $this->json_response(true, $data,"获取成功");
    }
}