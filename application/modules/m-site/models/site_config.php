<?php 
/**
 * class sites
 *
 * @author zzj
 * Date: 14-4-22
 * Time: 上午11:40
 */

class site_config extends MY_Site_Model
{
    /**
     * @var string
     */
    protected $_table_name = 'sites';

	public function __construct()
	{
		parent::__construct();
	}

    public function find_all(){
    	$query = $this->db->get($this->_table_name);
    	return $query->result_array();
    }
}