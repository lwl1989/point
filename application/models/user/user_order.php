<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15-2-10
 * Time: 2015-2-16 11:19
 */
class user_order extends  MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table_name = 'order';
    }
	
	function get_state(){
       
    }
	
	function select($user_id,$state = false,$limit = 10,$offset = 0,$is_del = 0){
        $this->db->select('id,order_id,info,state,place_time,user_id,company_id,sum_num,price');
        $this->db->where('user_id',$user_id);
        if($state)
            if($state==2)
                $this->db->where_in('state',array(2,3,4,5));
            else
            $this->db->where('state',$state);
        $this->db->where('is_del',$is_del);
        $this->db->order_by('id', "desc");
        $query = $this->db->get($this->_table_name,$limit,$offset);
        return $query->result_array();
    }
    function get_count_by_user($user_id){
        $this->db->where('user_id',$user_id);
        $this->db->from($this->_table_name);
        return $this->db->count_all_results();
    }
	
	function del($order_id,$user_id){
       $this->db->where('user_id',$user_id);
       $this->db->where('order_id',$order_id);
       $this->db->set('is_del',1);
       $this->db->update($this->_table_name);
       return $this->db->affected_rows() > 0;
    }

    function real_del($order_id,$user_id){
       $this->db->where('user_id',$user_id);
       $this->db->where('order_id',$order_id);
       $this->db->delete($this->_table_name);
       return $this->db->affected_rows()>0;
    }

    function confirm($order_id,$user_id){
        $this->db->where('user_id',$user_id);
        $this->db->where('order_id',$order_id);
        $this->db->set('state',6);
        $this->db->set('user_confirm_time',date("Y-m-d H:i:s",time()));
        $this->db->update($this->_table_name);
        return $this->db->affected_rows()>0;
    }

    function get_order_by_id($order_id){
        $this->db->where('order_id',$order_id);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows()==1)
            return $query->result_array()[0];
        return null;
    }
}