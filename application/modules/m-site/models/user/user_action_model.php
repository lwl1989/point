<?php 

class user_action_model extends MY_Site_Model
{
    protected $_table_name = 'user_actions';

    protected $_user_table = 'users';
    
    protected $_image_table = 'company_images';

	public function __construct()
	{
		parent::__construct();

        $this->_user_table = $this->db->dbprefix . $this->_user_table;
        $this->_image_table = $this->db->dbprefix . $this->_image_table;
	}

   	/**
   	 * 
   	 * @param unknown $user_id
   	 * @param unknown $data
   	 * @return boolean
   	 */
    public function update_action($user_id,$id) {
        
		
        
        
        
        $sql_1 = "select * from `{$this->_table_name}` where is_usefull=0 and action ='user_comment_company' 
        	and ref_table_id = {$id}";
        $user_actions_1 = $this->db->query($sql_1)->row_array();
        
        if($user_actions_1){
        	$score = $user_actions_1['score'];
        	$grow = $user_actions_1['grow'];
        	$image_ids = $user_actions_1['company_image_ids'];
        	
        	
        	
        	$update_1 = "UPDATE  `{$this->_table_name}` set is_usefull = 1 where action='user_comment_company' 
        	and ref_table_id = {$id}";
        	$this->db->query($update_1);
        	
        	$update_2 = "UPDATE `{$this->_user_table}` SET
        	`score` =  `score` + {$score},
        	`grow` =  `grow`+ {$grow} WHERE `id` = {$user_id} ";
        	$this->db->query($update_2);
        	
        	//查询该条评论对应的图片
        	
        	if($image_ids!=""){
        		$sql_2 = "select t1.* from `{$this->_table_name}` t1 where exists(select
        		1 from `{$this->_image_table}` t2 where t2.id in({$image_ids})
        		and t1.ref_table_id = t2.id and t2.user_id={$user_id}
        		and t2.is_del=0 ) and
        		t1.action='user_comment_image' and is_usefull = 0 ";
        		$user_actions_2 = $this->db->query($sql_2)->result_array();
        		$user_actions_count = count($user_actions_2);
        		 
        		for($x=0;$x<$user_actions_count;$x++ ){
        		
        			$user_action_i = $user_actions_2[$x];
        		
        			$score_i = $user_action_i['score'];
        			$grow_i = $user_action_i['grow'];
        			$id_i = $user_action_i['id'];
        			
        			$update_3 = "UPDATE  `{$this->_table_name}` set is_usefull = 1 where id={$id_i}";
        			$this->db->query($update_3);
        			 
        			$update_4 = "UPDATE `{$this->_user_table}` SET
        			`score` =  `score` + {$score_i},
        			`grow` =  `grow`+ {$grow_i} WHERE `id` = {$user_id} ";
        			$this->db->query($update_4);
        		
        			var_dump();
        		}
        	}
        	
        }
        

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', $insert.';'.$update);
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
        //return true;
    }

   


}