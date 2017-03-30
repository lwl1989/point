<?php 
/**
 * 城市区域管理
 *
 * class zones
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-9-30
 * Time: 下午4:49
 */

class zones extends MY_Site_Manage_Controller
{
	public function __construct()
	{
		parent::__construct();

        $this->load->model('zone');
	}

    /**
     * 区列表
     *
     * @param int $p_id 当前列表的父级id
     */
    public function index($p_id = 0)
    {
        $zones = $this->zone->find_by_p_id($p_id);

        if ($p_id > 0) {
            $parent = $this->zone->get($p_id);
            if (!$parent) {
                show_404();
            }
            $back_p_id = $parent['p_id'];
            $path = $parent['path'].$p_id.'/';
        } else {
            $back_p_id = -1;
            $path = '/';
        }

        $this->session->set_userdata(
            'back_list_page',
            $this->get_self_url()
        );

        $parent_zone = $this->zone->get($p_id);

        $this->assign('p_id', $p_id);
        $this->assign('back_p_id', $back_p_id);
        $this->assign('zones', $zones);
        $this->assign('parent_zone', $parent_zone);
        $this->assign('path', $path);
        $this->display();

    }

    /**
     * 添加，编辑区处理
     */
    public function save()
    {
        if ($this->input->post('action') == 'save') {

            //@todo form校验
            $name = $this->input->post('name');
            $id = $this->input->post('id');

            $data = array(
                'id' => $id,
                'site_id' => $this->_site_id,
                'p_id' => $this->input->post('p_id'),
                'path' => $this->input->post('path'),
                'name' => $name,
                'sort_order' => $this->input->post('sort_order'),
                'is_display' => 1,
            );
            $id = $this->zone->save($data);

            if ($id) {
                $data['id'] = $id;
                $this->json_response(true, $data);
            } else {
                $this->json_response(false);
            }

        }
    }

    public function del()
    {
        if ($this->input->post('action') == 'del') {
            $id = intval($this->input->post('id'));
            if ($id > 0) {
                if ($this->zone->count_child($id) > 0) {
                    $this->json_response(false, array(), '子区域未删除!不能删除当前区域');
                } elseif ($this->zone->soft_delete($id)) {
                    $this->json_response(true);
                }
            }
        }
    }

    public function refresh_cache()
    {
        $conditions = [
            'site_id' => $this->_site_id,
        ];
        $zones = $this->zone->fetch_array($conditions);

        $zones_name = array();

        foreach($zones as $zone) {
            $zones_name[$zone['id']] = $zone['name'];
        }


        $config_name = 'data/zones.site_' . $this->_site_id;

        $this->config->load($config_name, TRUE);

        $this->config->set_item($config_name, $zones_name);

        $this->config->save($config_name);

        $this->json_response();
    }


}