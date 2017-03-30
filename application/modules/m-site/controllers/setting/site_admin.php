<?php

/**
 * Class site_admin
 */
class site_admin extends MY_Site_Manage_Controller
{


    /**
     * @var site_admin_model
     */
    public $site_admin_model;

    /**
     * @var site_role_model
     */
    public $site_role_model;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('site_admin_model');

    }


    //管理员列表
    public function index()
    {
        $get = $this->input->get();
        $page = (isset($get['page']) && $get['page'] > 1)?$get['page']:1;


        $rows = 20;
        $this->load->library('pagination');
        $total_rows = $this->site_admin_model->total_rows();

        $pagination = [];
        $pagination['list'] = $this->site_admin_model->page_list([], $page, $rows);

        $config = [];
        $config['base_url'] = site_url('m-site/setting/site_admin/index?');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $rows;
        $this->pagination->initialize($config);
        $pagination['page_html'] = $this->pagination->create_links();

        $this->assign('pagination', $pagination);
        $this->display();

    }


    /**
     * 添加管理员
     */
    public function add()
    {
        $this->load->model('site_role_model');

        $roles = $this->site_role_model->all_roles();

        $this->assign('roles', $roles);

        $this->display();
    }

    public function edit($id)
    {
        $admin = $this->site_admin_model->get($id);
        if (!$admin) {
            show_404('该数据不存在或者已被删除');
        }

        $this->load->model('site_role_model');

        $roles = $this->site_role_model->all_roles();

        $this->assign('roles', $roles);
        $this->assign('admin', $admin);
        $this->display();
    }


    /**
     * 添加，编辑post请求
     */
    public function save()
    {
        $post = $this->input->post();
        $id = intval($post['id']);

        if (!isset($post['user_id'])) {
            $this->json_response(false, [], '请选择用户');
        }

        if (!isset($post['roles']) || empty($post['roles'])) {
            $this->json_response(false, [], '请选择角色');
        }

        if ($id == 0) {
            $condition = [
                'site_id' => $this->_site_id,
                'user_id' => $post['user_id'],
            ];

            if ($this->site_admin_model->fetch_count($condition)) {
                $this->json_response(false, [], '该用户已经是管理员');
            }
        }

        $data = [
            'id' => $id,
            'site_id' => $this->_site_id,
            'user_id' => $post['user_id'],
            'roles' => join(',', $post['roles'])
        ];

        $this->site_admin_model->save($data);
        $this->json_response();


    }



    /**
     * 删除
     */
    public function del()
    {
        if ($this->input->post('action') == 'del') {
            $id = intval($this->input->post('id'));
            if ($id > 0) {
                if ($this->site_admin_model->soft_delete($id)) {
                    $this->json_response(true);
                } else {
                    $this->json_response(
                        false,
                        array(),
                        $this->site_admin_model->get_error_msg()
                    );
                }
            }
        }
    }

    public function find_user()
    {
        $name = trim($this->input->get('username'));
        $this->load->model('user_model');
        $users = $this->user_model->search_by_username($name);
        //print_r($companies);exit;
        if ($users) {
            $html = '';
            foreach ($users as $user) {
                $html .= "<label class='radio'>";
                $html .= "<input type='radio' name='user_id' value='".$user['id']."'>";
                $html .=  $user['username'];
                $html .= "</label>";
                $html .= "<div style=\"clear:both\"></div>";
            }
            echo $html;
        } else {
            echo "没符合条件的用户";
        }
    }




}