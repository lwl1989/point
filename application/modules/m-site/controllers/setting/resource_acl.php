<?php

/**
 * Class resource_acl
 */
class resource_acl extends MY_Site_Manage_Controller
{

    /**
     * @var site_role_model
     */
    public $site_role_model;

    /**
     * @var resource_acl_model
     */
    public $resource_acl_model;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('site_role_model');
    }


    //角色列表
    public function index()
    {
        $this->load->model('site_role_model');
        $roles = $this->site_role_model->fetch_array();

        $this->assign('roles', $roles);

        $this->display();

    }

    /**
     * 添加，编辑post请求
     */
    public function save()
    {
        $name = trim($this->input->post('name'));
        $code = strtoupper(trim($this->input->post('code')));
        $id = intval($this->input->post('id'));
        if ($id > 0) {
            $role = $this->site_role_model->get($id);
        }
        if ((isset($role) && $role['name'] != $name) &&!$this->site_role_model->check_name($name)) {
            $this->json_response(false, [], '角色名称已存在');
        }

        if ((isset($role) && $role['code'] != $code) && !$this->site_role_model->check_code($code)) {
            $this->json_response(false, [], '角色代码已存在');
        }

        $data = [
            'id' => $id,
            'site_id' => $this->_site_id,
            'name' => $name,
            'code' => $code,
        ];

        $this->site_role_model->save($data);

        $this->json_response();

    }

    /**
     * 角色权限设置
     *
     * @param $role_id
     */
    public function role_resources($role_id)
    {
        $this->load->model('resource_acl_model');

        if ($this->input->post('action')) {
            $post = $this->input->post();
            if (!isset($post['resources']) || empty($post['resources'])) {
                $this->json_response(false, [], '角色权限不能为空');
            }
            $role = $this->site_role_model->get($role_id);

            if (!$role) {
                $this->json_response(false, [], '角色不存在');
            }

            if ($role['code'] != $post['role_code']) {
                $this->json_response(false, [], '请求错误，角色不匹配');
            }
            $role = $post['role_code'];
            $resources = $post['resources'];


            $exists_role_acls = $this->resource_acl_model->exists_role_acls($role);

            foreach ($exists_role_acls as $acl) {
                $this->resource_acl_model->remove_role($acl, $role);
            }
            $menus = [];
            foreach ($resources as $acl) {
                $arr = explode('|', $acl);

                if (count($arr) == 3) {
                    $resource = $arr[0];
                    $actions = $arr[1];
                    $menus[] = $arr[2];
                } else if (count($arr) == 2){
                    $resource = $arr[0];
                    $actions = $arr[1];
                } else {
                    $this->json_response(false, [], '请求错误');
                }

                $actions = explode(',', $actions);

                foreach ($actions as $action) {
                    $resource_action = [
                        'site_id' => $this->_site_id,
                        'resource' => $resource,
                        'action' => $action,
                    ];
                    //添加权限
                    $this->resource_acl_model->add_role($resource_action, $role);
                }
                //更新菜单
                $this->site_role_model->save([
                    'id' => $role_id,
                    'menus' => json_encode($menus),
                ]);

            }

            $this->json_response();

        }
        $role = $this->site_role_model->get($role_id);

        if (!$role) {
            show_404('角色不存在或者已被删除');
        }
        $mapper = include dirname(__FILE__) . '/../../resource_mapper.php';

        $channels = $mapper['channels'];
        $menus = $mapper['menus'];

        $exists_role_acls = $this->resource_acl_model->exists_role_acls($role['code']);
        $acl = [];
        foreach ($exists_role_acls as $exists_role_acl) {
            $key = $exists_role_acl['resource'].'/'.$exists_role_acl['action'];
            $acl[] = $key;
        }

        $this->assign('channels', $channels);
        $this->assign('menus', $menus);
        $this->assign('role', $role);
        $this->assign('acl', $acl);

//        print_r($acl);exit;

        $this->display();
    }


    /**
     * 删除
     */
    public function del()
    {
        if ($this->input->post('action') == 'del') {
            $id = intval($this->input->post('id'));
            if ($id > 0) {
                if ($this->site_role_model->soft_delete($id)) {
                    $this->json_response(true);
                } else {
                    $this->json_response(
                        false,
                        array(),
                        $this->site_role_model->get_error_msg()
                    );
                }
            }
        }
    }




}