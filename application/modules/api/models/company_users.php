<?php 
/**
 * class Company
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-10-19
 * Time: 上午11:40
 */

class company_users extends MY_Site_Model
{
    /**
     * @var string
     */
    protected $_table_name = 'company_users';

	public function __construct()
	{
		parent::__construct();
	}


    function select($data){
        //$this->db->where('site_id',$data['site_id']);
        $this->db->where('is_del',$data['is_del']);
        $query =$this->db->get($this->_table_name);
        if($query->num_rows()>0){
            return $query->result_array();
        }
        return null;
    }
    function select_cover($data){
        $this->db->select('id,name,cover');
        //$this->db->where('site_id',$data['site_id']);
        $this->db->where('is_del',$data['is_del']);
        $query =$this->db->get($this->_table_name);
        if($query->num_rows()>0){
            return $query->result_array();
        }
        return null;
    }
}