<?php 
/**
 * class company_comments
 *
 * @author zzj
 * Date: 2014.04.18
 */

class company_comments_my_site extends MY_Site_Model
{

    protected $_table_name = 'company_comments';
    protected $user_table;
    protected $company_table;
    protected $impression_table;
    protected $image_table;
    /**
     * 审核日志表
     */
    protected $company_comments_audit_log;
    
    protected $user_actions = 'user_actions';

	public function __construct()
	{
		parent::__construct();
		$this->user_table = $this->db->dbprefix.'users';
		$this->company_table = $this->db->dbprefix.'company_users';
		$this->image_table = $this->db->dbprefix.'company_images';
		$this->impression_table = $this->db->dbprefix.'company_impressions';
		$this->company_comments_audit_log = $this->db->dbprefix.'company_comments_audit_log';
		$this->user_actions = $this->db->dbprefix.'user_actions';
	}
	
	
	
	
	protected function build_sql($conditions = array()){
		
		$sql = "select a.*,b.username,c.name from {$this->_table_name} as a," .
				"{$this->user_table} as b ,{$this->company_table} as c ";
		//var_dump($sql);		
		$sql.=" where a.user_id = b.id and a.company_id = c.id and a.company_id = c.id";
		
		$sql.=" and a.site_id={$this->_site_id} and a.is_del=0 and a.is_forbidden=0";
		
		if(isset($conditions['is_audit']))
		$sql.=" and a.is_audit={$conditions['is_audit']}";
		
		if(isset($conditions['company_name'])){
			$company_name = $conditions['company_name'];
			$sql.=" and (c.name like '%{$company_name}%') ";
		}
		
		if(isset($conditions['user_name'])){
			$user_name = $conditions['user_name'];
			$sql.=" and (b.username like '%{$user_name}%') ";
		}
		
		if(isset($conditions['order_by']))
		$sql.=" order by {$conditions['order_by']}";
		else
		$sql.=" order by a.id asc";
		echo $sql;
		
		return $sql;
	}
	
	
	public function page_list($conditions = array(),$base_url, $page = 1, $rows = 20){
		
		
		
		$offset = ($page -1) * $rows;

        $sql = $this->build_sql($conditions);
        
        $sql .= " limit {$offset}, {$rows}";
        
        //var_dump($sql);
        $query = $this->db->query($sql);

        $comments = $query->result_array();
        //var_dump($comments);
        if (count($comments) > 0) {
            foreach ($comments as $key => $comment) {
                //店铺印象
                $comments[$key]['impressions'] = $this->find_impressions($comment['impression_ids']);
                //评论图片
                $comments[$key]['images'] = $this->find_images($comment['company_image_ids']);
            }
        }
        
        $config = array();
        $config['base_url'] = $base_url;
        $config['total_rows'] = $this->total_rows($conditions);
        $config['per_page'] = 20;
        //var_dump($config);
        $this->_CI->load->library('pagination');
        $this->pagination->initialize($config);
        $page_html = $this->pagination->create_links();
        //var_dump($page_html);
        return array('list' => $comments, 'page_html' => $page_html);
        
        
	}
	
	/**
     * 获取记录数
     *
     * @param $company_id
     * @param $conditions
     * @return mixed
     */
    public function total_rows($conditions = array()) {
        $sql = $this->build_sql($conditions);
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
	
	/**
     * 获取评论的印象
     *
     * @param $impression_ids
     * @return array
     */
    public function find_impressions($impression_ids)
    {
        if (!$impression_ids || empty($impression_ids)) {
            return array();
        }
        $sql = "select id, name from {$this->impression_table}
                where id in ({$impression_ids})";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    /**
     * 查询店铺所有印象
     * 
     * @param unknown $company_id
     * @return multitype:
     */
    public function find_company_impressions($company_id){
    	if(!$company_id){
    		return array();
    	}else{
    		$sql = "select id, name,count from {$this->impression_table}
    		 where company_id={$company_id} order by count desc";
    		return $this->db->query($sql)->result_array();
    	}
    }
    
    /**
     * 获取评论的图片
     *
     * @param $image_ids
     * @return array
     */
    public function find_images($image_ids)
    {
        if (!$image_ids || empty($image_ids)) {
            return array();
        }
        //@todo 是否要is_del = 0
        $sql = "select id, image_url from {$this->image_table}
                where id in ({$image_ids}) and is_del=0";
        $query = $this->db->query($sql);

        return $query->result_array();
    }
    
    /**
     * 点评审核通过操作
     * 
     */
    public function do_audit_pass($id=0){
    	
    	
    	if($id>0){
    		//当前用户
	    	$login_user = $this->session->userdata('login_user');
	    	
	    	$this->db->set('is_audit', 1);
			$this->db->where('id', $id);
	    	
	        $result = $this->db->update($this->_table_name);
	        
	        //日志对象
	        $data_log = array(
	        	'comment_id'=>$id,
	        	'audit_user_id'=>$login_user['user_id'],
				'audit_code'=>1,
				'created' => date('Y-m-d H:i:s')
	        );
	        
	        //写审核日志
	        $this->parse_conditions($data_log);
	        $this->db->insert($this->company_comments_audit_log, $data_log);
	    	
	        return $result;
    	}
    	
    	
    	return 0;
    }
    
    
    /**
     * 点评审核不通过操作
     * 
     */
    public function do_audit_failed($id=0){
    	
    	if($id>0){
    		//当前用户
	    	$login_user = $this->session->userdata('login_user');
	    	
	    	//var_dump($login_user);
	    	
	    	$this->db->set('is_audit', -1);
			$this->db->where('id', $id);
	    	
	        $result = $this->db->update($this->_table_name);
	        
	        //日志对象
	        $data_log = array(
	        	'comment_id'=>$id,
	        	'audit_user_id'=>$login_user['user_id'],
				'audit_code'=>-1,
				'created' => date('Y-m-d H:i:s')
	        );
	        
	        
	        //写审核日志
	        $this->parse_conditions($data_log);
	        $this->db->insert($this->company_comments_audit_log, $data_log);
	        
	        return true;
    	}
    	
    	
    	return false;
    }
    
    /**
     * 审核未通过的点评返回待审
     */
    public function do_again_need_audit($id=0){
    	
    	if($id>0){
    		//当前用户
	    	$login_user = $this->session->userdata('login_user');
	    	
	    	$this->db->set('is_audit', 0);
			$this->db->where('id', $id);
	    	
	        $result = $this->db->update($this->_table_name);
	        
	        //日志对象
	        $data_log = array(
	        	'comment_id'=>$id,
	        	'audit_user_id'=>$login_user['user_id'],
				'audit_code'=>0,
				'created' => date('Y-m-d H:i:s')
	        );        
	        
	        //写审核日志
	        $this->parse_conditions($data_log);
	        $this->db->insert($this->company_comments_audit_log, $data_log);
	        
	        return true;
    	}
    	
    	
    	return false;
    }
    
    /**
     * 
     * @param unknown $id
     * @param unknown $is_usefull
     */
	public function update_user_actions($id,$is_usefull=1,$action){
		
		if($is_usefull===1){
			$this->db->set('is_usefull', 1);
			$this->db->where('is_usefull', 0);
		}else{
			$this->db->set('is_usefull', 0);
			$this->db->where('is_usefull', 1);
		}
		
		if(isset($action)){
			$this->db->where('action', $action);
		}
		
		$this->db->where('id', $id);
		
		return $this->db->update($this->user_actions);
	}
	
	public function update_user_actions_by_ref_table_id($ref_table_id,$is_usefull=1,$action){
	
		if($is_usefull===1){
			$this->db->set('is_usefull', 1);
			$this->db->where('is_usefull', 0);
		}else{
			$this->db->set('is_usefull', 0);
			$this->db->where('is_usefull', 1);
		}
	
		if(isset($action)){
			$this->db->where('action', $action);
		}
		if(isset($ref_table_id)){
			$this->db->where('ref_table_id', $ref_table_id);
		}
	
		return $this->db->update($this->user_actions);
	}
	public function update_users($user_id){
		
		$sql_1 = "update {$this->user_table} set score= (select sum(score) from {$this->user_actions} where is_usefull=1 and user_id=".$user_id.") where id=".$user_id;
		$this->db->query($sql_1);
		
		
		$sql_2 = "update {$this->user_table} set grow= (select sum(grow) from {$this->user_actions} where is_usefull=1 and user_id=".$user_id.") where id=".$user_id;
		$this->db->query($sql_2);

	}
	
	/**
	 * 获取积分数据
	 */
	public function get_user_actions($table_id,$action="user_comment_company")
	{
		$sql = "select id,score,grow from {$this->user_actions} where action='".$action."' and is_usefull=0 and ref_table_id in (".$table_id.")";
		return $this->db->query($sql)->result_array();
	}
	
	/**
	 * 
	 * 获取点评图片
	 * @param unknown $image_ids
	 */
	public function get_company_comment_images($image_ids){
		$sql = "select * from {$this->image_table} where is_del=0 and id in(".$image_ids.")";
		return $this->db->query($sql)->result_array();
	}
	
	
	/**
	 * 根据积分id更新用户积分表
	 * @param unknown $ref_table_id
	 */
	public function update_user_action_for_again_need_audit($ref_table_id){
		$this->db->set('is_usefull', 0);
		$this->db->where('is_usefull', 1);
		$this->db->where('ref_table_id', $ref_table_id);
		return $this->db->update($this->user_actions);
	}
	
	
}