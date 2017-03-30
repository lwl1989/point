<?php 
/**
 * class user_action
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-12-10
 * Time: 下午2:33
 */

class user_action_model extends MY_Model
{
    protected $_table_name = 'user_actions';

    protected $_user_table = 'users';

	public function __construct()
	{
		parent::__construct();

        $this->_user_table = $this->db->dbprefix . $this->_user_table;
	}

    /**
     * 添加用户动作记录，更新用户表
     *
     * @param $user_id
     * @param $action
     * @param $score
     * @param $grow
     * @param array $data
     */
    public function add_action(
        $user_id, $action, $score, $grow,
        $is_usefull = 1, $data = array()
    ) {
    	$ref_table_id = '';
    	$ref_table = '';
    	
    	if(count($data)>0){
    		$ref_table_id = $data[0];
    	}
    	
    	if($action==='user_comment_company'){
    		$ref_table = 'company_comments';
    	}else if($action==='user_comment_image'){
    		$ref_table = 'company_images';
    	}
    	
        $data = serialize($data);


        $datetime = date('Y-m-d H:i:s');
        $this->db->trans_begin();
        $insert = "INSERT INTO  `{$this->_table_name}` (
                `user_id`, `action`, `score`, `grow`, `is_usefull`,`data`, `created` , `ref_table`, `ref_table_id`
                ) VALUES (
                {$user_id}, '{$action}',  {$score}, {$grow}, {$is_usefull}, '{$data}',  '{$datetime}','{$ref_table}','{$ref_table_id}')";
        $this->db->query($insert);

        if ($is_usefull) {
            $update = "UPDATE `{$this->_user_table}` SET
                      `score` =  `score` + {$score},
                      `grow` =  `grow`+ {$grow} WHERE `id` = {$user_id}";
            $this->db->query($update);
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

    /**
     * 查询今天有没做这事情
     *
     * @param $user_id
     * @param $action
     * @return bool
     */
    public function today_had_done($user_id, $action)
    {
        $today = date('Y-m-d').' 00:00:00';
        $sql = "select id from {$this->_table_name}
                where user_id = {$user_id}
                and `action` = '{$action}' and unix_timestamp(created) >= unix_timestamp('{$today}')";
        $query = $this->db->query($sql);

        return $query->num_rows() == 0?false: true;
    }

    /**
     * 查询有没做这事情
     *
     * @param $user_id
     * @param $action
     * @return bool
     */
    public function had_done($user_id, $action)
    {
        $sql = "select id from {$this->_table_name}
                where user_id = {$user_id}
                and `action` = '{$action}'";
        $query = $this->db->query($sql);
        return $query->num_rows() == 0?false: true;
    }



}