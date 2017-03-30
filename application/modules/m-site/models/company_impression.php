<?php 
/**
 * class company_impression
 *
 * @author zzj
 * Date: 2014.07.27
 */

class company_impression extends MY_Site_Model
{

    protected $_table_name = 'company_impressions';
    protected $_company_comments = 'company_comments';

	public function __construct()
	{
		parent::__construct();
		$this->_company_comments = $this->db->dbprefix.'company_comments';
	}
	
	public function update_count($company_id)
	{
		$sql_1 = "select id,company_id from {$this->_table_name} where company_id={$company_id}";
		$company_impressions = $this->db->query($sql_1)->result_array();
		
		foreach ($company_impressions as $company_impression){
			$id = $company_impression['id'];
			$sql_2 = "select count(id) count from {$this->_company_comments} where company_id={$company_id} and (impression_ids like '%,{$id},%' or impression_ids like '{$id},%' or impression_ids like '%,{$id}' or impression_ids={$id}) and is_del=0";
			
			$count = $this->db->query($sql_2)->row_array();
			var_dump($count);
			if($count){
				$sql_3 = "update {$this->_table_name} set count={$count['count']} where id={$id}";
				//var_dump($sql_3);
				$this->db->query($sql_3);
			}
		}
	}
	
}