<?php 
/**
 * class site_admin_model
 *
 * @author Cavin <csp379@163.com>
 */

class site_admin_model extends MY_Site_Model
{
    /**
     * @var string
     */
    protected $_table_name = 'site_admin';

    /**
     * @var string
     */
    protected $user_table_name;

	public function __construct()
	{
		parent::__construct();

        $this->user_table_name = $this->db->dbprefix . 'users';
	}

    public function get_by_user_id($user_id)
    {
        return $this->getOne(['site_id' => $this->_site_id, 'user_id' => $user_id]);
    }

    /**
     * @param array $conditions
     * @param int $page
     * @param int $rows
     * @return mixed
     */
    public function page_list($conditions = [], $page = 1, $rows = 20)
    {
        $offset = ($page -1) * $rows;

        $sql = $this->build_sql($conditions);
        $sql .= " limit {$offset}, {$rows}";

        $query = $this->db->query($sql);

        $companies = $query->result_array();

        return $companies;
    }

    /**
     * @param array $conditions
     * @return string
     */
    protected function build_sql($conditions = [])
    {
        $sql = "select a.*, b.username from {$this->_table_name} as a
                left join {$this->user_table_name} as b on a.user_id = b.id
                where site_id = {$this->_site_id}";

      /**/  if (!isset($conditions['is_del'])) {
            $sql .= ' and b.is_del = 0';
        }

        return $sql;
    }

    /**
     * @param array $conditions
     * @return mixed
     */
    public function total_rows($conditions = []) {
        $sql = $this->build_sql($conditions);
        $query = $this->db->query($sql);
       // echo $this->db->last_query();
        return $query->num_rows();
    }





}