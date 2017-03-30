<?php 
/**
 * class resource_acl_model
 *
 * @author Cavin <csp379@163.com>
 */

class resource_acl_model extends MY_Site_Model
{
    /**
     * @var string
     */
    protected $_table_name = 'resource_acl';

	public function __construct()
	{
		parent::__construct();
	}

    /**
     * 角色的权限
     *
     * @param $role_code
     * @return array
     */
    public function exists_role_acls($role_code)
    {
        $conditions = [
            'site_id' => $this->_site_id,
            'role' => $role_code,
        ];

        return $this->fetch_array($conditions);

    }

    /**
     * 资源是否可以被请求
     *
     * @param $resource
     * @param $action
     * @param $roles
     */
    public function is_access($resource, $action, $roles)
    {
        $conditions = [
            'site_id' => $this->_site_id,
            'resource' => $resource,
            'action' => $action,

        ];

        $row = $this->getOne($conditions);
        if ($row) {
            $acl = explode(',', $row['roles']);
            if (!is_array($roles)) {
                $roles = explode(',', $roles);
            }
            $access = false;
            foreach ($acl as $role) {
                $role = ltrim($role, '{');
                $role = rtrim($role, '}');
                if (in_array($role, $roles)) {
                    $access = true;
                }
            }

            return $access;
        }
        return true;

    }

    /**
     * 添加角色
     *
     * @param $acl
     * @param $role
     */
    public function add_role($acl, $role)
    {
        $row = $this->getOne($acl);
        $role = "{".$role."}";

        if ($row) {
            if (empty($row['roles'])) {
                $row['roles'] = $role;
            } else {
                $roles = explode(',', $row['roles']);
                if (!in_array($role, $roles)) {
                    $roles[] = $role;
                    $row['roles'] = join(',', $roles);
                }
            }
            $this->save($row);

        } else {
            $acl['roles'] = $role;
            $this->insert($acl);
        }

        return true;
    }


    /**
     * 移除一个资源的角色权限
     *
     * @param $acl
     * @param $role
     */
    public function remove_role($acl, $role)
    {
        $role = "{".$role."}";
        $roles = explode(',', $acl['roles']);

        $new_roles = [];
        foreach ($roles as $had_role) {
            if ($had_role != $role) {
                $new_roles[] = $had_role;
            }
        }

        $data = [
            'id' => $acl['id'],
            'roles' => join(',', $new_roles)
        ];

        $this->save($data);

    }

    protected function self_conditions($conditions)
    {
        if (isset($conditions['role'])) {
            $this->db->like('roles', "{".$conditions['role']."}");
            unset($conditions['role']);
        }

        return $conditions;

    }







}