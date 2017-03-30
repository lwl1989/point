<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/9
 * Time: 19:21
 */

class user_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table_name = 'users';
    }

    function get_users($condition,$limit = 10,$offset = 0){
        $this->db->select('id,username,nickname,mobile,sex,user_type,email');
        if(is_array($condition)){
            foreach($condition as $key=>$val){
                $this->db->where($key,$val);
            }
        }
        $query = $this->db->get($this->_table_name,$limit,$offset);
        if($query->num_rows>0){
            return $query->result_array();
        }
        return null;
    }

    function stop_user($user_id,$open_time){
        $this->db->where('id',$user_id);
        $this->db->set('closed',1);
        $this->db->set('open_time',$open_time);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows() > 0;
    }

    function re_back($user_id){
        $this->db->where('id',$user_id);
        $this->db->set('closed',0);
        $this->db->set('open_time','0000-00-00 00:00:00');
        $this->db->update($this->_table_name);
        return $this->db->affected_rows() > 0;
    }
    //function
}