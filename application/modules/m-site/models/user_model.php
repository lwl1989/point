<?php 
/**
 * class user_model
 */

class user_model extends MY_Site_Model
{
    /**
     * @var string
     */
    protected $_table_name = 'users';
    protected $_user_actions = 'user_actions';

	public function __construct()
	{
		parent::__construct();
		$this->_user_actions = $this->db->dbprefix.'user_actions';
	}

    public function search_by_username($username, $limit = 5)
    {
        $sql = "select id , username from {$this->_table_name}
                where username like '%{$username}%'
                limit {$limit}";
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    protected function self_conditions($conditions)
    {
        if (isset($conditions['username'])) {
            $this->db->like('username', $conditions['username']);
            unset($conditions['username']);
        }

        return $conditions;
    }
    
     function get_user_id($id)
    {
    	$sql="select user_id from exp_db_company_comments where id=".$id;
    	$query = $this->db->query($sql);
    	$res=$query->result_array();
    	return $res[0];
    }
    
   
    
    
	   

}