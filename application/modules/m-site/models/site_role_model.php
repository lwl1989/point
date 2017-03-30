<?php 
/**
 * class site_role_model
 *
 * @author Cavin <csp379@163.com>
 */

class site_role_model extends MY_Site_Model
{
    /**
     * @var string
     */
    protected $_table_name = 'site_roles';

    protected $user_table_name;

	public function __construct()
	{
		parent::__construct();

        $this->user_table_name = $this->db->dbprefix . 'users';


	}

    public function all_roles()
    {
        $conditions = [
            'site_id' => $this->_site_id
        ];

        return $this->fetch_array($conditions);
    }


    /**
     * 校验name字段
     *
     * @param $name
     * @return bool
     */
    public function check_name($name)
    {
        if ($name) {
            $condition = ['name' => $name];
            if ($this->fetch_count($condition)) {
                return false;
            }
            return true;
        }

        return false;
    }

    /**
     * 校验code字段
     *
     * @param $code
     * @return bool
     */
    public function check_code($code)
    {
        if ($code) {
            $condition = ['code' => $code];
            if ($this->fetch_count($condition)) {
                return false;
            }
            return true;
        }

        return false;
    }




    /**
     * @param $roles
     * @return array
     */
    public function get_menus_by_roles($roles)
    {
        $conditions = [
            'site_id' => $this->_site_id,
            'roles' => $roles,
        ];

        $rows = $this->fetch_array($conditions);

        $menus = [];
        foreach ($rows as $row) {
           $menus = array_merge($menus, json_decode($row['menus']));
        }

        return array_unique($menus);
    }


    protected function self_conditions($conditions)
    {
        if (isset($conditions['roles'])) {
            if (!is_array($conditions['roles'])) {
                $conditions['roles'] = explode(',', $conditions['roles']);
            }
            $this->db->where_in('code', $conditions['roles']);

            unset($conditions['roles']);
        }
        return $conditions;

    }



}