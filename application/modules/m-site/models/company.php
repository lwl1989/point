<?php 
/**
 * class Company
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-10-19
 * Time: 上午11:40
 */

class Company extends MY_Site_Model
{
    /**
     * @var string
     */
    protected $_table_name = 'company_users';

	public function __construct()
	{
		parent::__construct();
	}

    public function search_by_name($name, $rows = 6)
    {
        $sql = "select * from {$this->_table_name}
                where name like '%{$name}%'
                limit {$rows}";

        $query = $this->db->query($sql);

        return $query->result_array();
    }
    
    protected function self_conditions($conditions)
    {
        if (isset($conditions['name'])) {
            $name = $conditions['name'];
            $where = "name like '%{$name}%'";
            $this->db->where($where);

            unset($conditions['name']);
        }
        
        if (isset($conditions['cate_id'])) {
        	$zone_id = $conditions['cate_id'];
        	$where = "(cate_id = {$zone_id} or cate_path = '/{$zone_id}/')";
        	$this->db->where($where);
        
        	unset($conditions['cate_id']);
        }

//        if (!isset($conditions['site_id'])) {
//            if ($this->_site_id != 0) {
//                $condition = "(site_id = 0 or site_id = {$this->_site_id})";
//                $this->db->where($condition);
//            } else {
//                $this->db->where('site_id = 0');
//            }
//        }

        return $conditions;
    }
}