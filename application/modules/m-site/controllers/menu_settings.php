<?php 
/**
 * class 菜单设置
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-11-18
 * Time: 上午1:08
 */

class menu_settings extends MY_Site_Manage_Controller
{
    private $_menu_key;

	public function __construct()
	{
		parent::__construct();

        $this->load->model('menu_setting');

        $this->_menu_key = array(
            'categories_panel',
            'categories_panel_name' => '分类导航菜单',
        );

	}


    public function index()
    {
        $this->display();
    }

    public function menus($menu_key)
    {
        if (!in_array($menu_key, $this->_menu_key)) {
            show_404();
        }

        $this->load->library('Tree');
        $all_menus = $this->menu_setting->find_all_by_menu_key($menu_key);

        //$this->tree->setNode(0, -1, '顶级菜单');

        foreach($all_menus as $menu) {
            $this->tree->setNode($menu['id'], $menu['p_id'], $menu);
        };

        //print_r($this->tree->getParent(1));exit;

        $this->assign('tree', $this->tree);

        $this->assign('menu_key', $menu_key);
        $this->assign('menu_name', $this->_menu_key[$menu_key.'_name']);


        $this->display();
    }

    private function _init_tree($menu_key)
    {
        $this->load->library('Tree');

        $all_menus = $this->menu_setting->find_all_by_menu_key($menu_key);

        $this->tree->setNode(0, -1, '顶级菜单');

        foreach($all_menus as $menu) {
            $this->tree->setNode($menu['id'], $menu['p_id'], $menu['name']);
        };

        $this->assign('tree', $this->tree);


    }

    public function add($menu_key)
    {
        if (!in_array($menu_key, $this->_menu_key)) {
            show_404();
        }

        $this->_init_tree($menu_key);

        $this->assign('menu_name', $this->_menu_key[$menu_key.'_name']);
        $this->assign('menu_key', $menu_key);

        $this->display();
    }

    public function edit($id)
    {
        $menu = $this->menu_setting->get($id);

        if (!$menu) {
            show_404();
        }



        $this->assign('menu', $menu);

        $this->assign('menu_name', $this->_menu_key[$menu['menu_key'].'_name']);
        $this->assign('menu_key', $menu['menu_key']);

        $this->_init_tree($menu['menu_key']);

        $this->display();


    }

    function save()
    {
        if ($this->input->post('action') == 'save') {

            $id = $this->input->post('id')? $this->input->post('id'): 0;

            $p_id = $this->input->post('p_id');

            if ($p_id == 0) {
                $path = '/';
            } else {
                $parent = $this->menu_setting->get($p_id);
                if (!$parent) {
                    $this->json_response(false, array(), '上级菜单不存在或者已删除');
                }
                $path = $parent['path'] . $p_id . '/';
            }

            if ($this->input->post('old_p_id') && $p_id != $this->input->post('old_p_id')) {
                if ($this->menu_setting->count_child($id) > 0) {
                    $this->json_response(false, array(), '编辑菜单有下级菜单不能修改所属分类');
                }
            }



            $data = array(
                'id' => $id,
                'site_id' => $this->_site_id,
                'menu_key' => $this->input->post('menu_key'),
                'group_key' => $this->input->post('group_key'),
                'p_id' => $p_id,
                'path' => $path,
                'icon_name' => $this->input->post('icon_name'),
                'name' => $this->input->post('name'),
                'type' => $this->input->post('type'),
                'cate_id' => $this->input->post('cate_id'),
                'url' => $this->input->post('url'),
                'target' => $this->input->post('target'),
                'sort_order' => $this->input->post('sort_order'),

            );

            $id = $this->menu_setting->save($data);

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
                if ($this->menu_setting->count_child($id) > 0) {
                    $this->json_response(false, array(), '子菜单未删除!不能删除当前菜单');
                } elseif ($this->menu_setting->soft_delete($id)) {
                    $this->json_response(true);
                }
            }
        }
    }

    public function refresh_categories_panel()
    {
        $menu = array(
            'root' => array(),
            'level-1' => array(),
            'level-2' => array(),
        );
        $menu['root'] = $this->menu_setting->find_by_menu_key_and_group('categories_panel', 'root', 0);

        foreach ($menu['root'] as $key => $root) {
            $menu['level-1'][$key] = $this->menu_setting
                ->find_by_menu_key_and_group('categories_panel', 'level-1', $root['id']);

        }

        foreach ($menu['root'] as $key => $root) {
            $titles = $this->menu_setting
                ->find_by_menu_key_and_group('categories_panel', 'level-2', $root['id']);

            if (is_array($titles) && count($titles) > 0) {
                foreach ($titles as $k => $title) {
                    $menu['level-2'][$key][$k]['title'] = $title;
                    $menu['level-2'][$key][$k]['tags'] = $this->menu_setting
                        ->find_by_menu_key_and_group('categories_panel', 'level-3', $title['id']);
                }
            }
        }

        $config_name = 'data/categories_panel.site_' . $this->_site_id;

        $this->config->load($config_name, TRUE);

        $this->config->set_item($config_name, $menu);

        $this->config->save($config_name);

        $this->json_response();

    }


}