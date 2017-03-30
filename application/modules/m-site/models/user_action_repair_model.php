<?php 
/**
 * class Company
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-10-19
 * Time: 上午11:40
 */

class User_action_repair_model extends MY_Site_Model
{
    /**
     * @var string
     */
    protected $_table_name = 'user_actions';
    protected $_user_table = 'users';

	public function __construct()
	{
		parent::__construct();
		$this->_user_table = $this->db->dbprefix . $this->_user_table;
	}

    public function repair()
    {
        $sql_1 = "select * from {$this->_table_name}
                where ref_table is not null and ref_table_id is null";

        $result = $this->db->query($sql_1)->result_array();
        
        $length = count($result);

        
        $update_1 = "update {$this->_table_name} set ref_table = 'company_comments',is_usefull=0 where action='user_comment_company' and ref_table is null";
        $this->db->query($update_1);
        
        $update_2 = "update {$this->_table_name} set ref_table = 'company_images',is_usefull=0 where action='user_comment_image' and ref_table is null";
        $this->db->query($update_2);
        
        
        //更新ref_table_id
        for($x=0;$x<$length;$x++){
        	$user_actions = $result[$x];        	
        	$ref_table_id = unserialize($user_actions['data'])[0];
        	var_dump($ref_table_id);
        	
        	$update = "UPDATE `{$this->_table_name}` SET `ref_table_id` = {$ref_table_id} 
        	 WHERE `id` = {$result[$x]['id']}";
        	$this->db->query($update);
        }
        
        
        
        //更新用户表积分和成长值
        $sql_2 = "select * from {$this->_user_table}";
        $result2 = $this->db->query($sql_2)->result_array();
        $length2 = count($result2);
        
        
        
        
        for($i=0;$i<$length2;$i++){
        	
        	
        	
        	$sql_3 = "select sum(score) score,sum(grow) grow from `{$this->_table_name}` where is_usefull=1 and user_id={$result2[$i]['id']}";
        	$user_sum = $this->db->query($sql_3)->row_array();
        	
        	
        	if(!empty($user_sum['score'])){
        		$update_3 = "UPDATE `{$this->_user_table}` set score={$user_sum['score']} , grow={$user_sum['grow']} where id={$result2[$i]['id']}";
        		$this->db->query($update_3);
        	}
        	
        	
        }


        return true;
    }
    
    protected function self_conditions($conditions)
    {

        return $conditions;
    }
}