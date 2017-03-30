<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/25
 * Time: 9:31
 */


class user_cart extends MY_Model{


    function __construct(){
        parent::__construct();
        $this->_table_name = 'cart';
    }

    function update_cart($user_id,$file_info){
        $this->db->where('user_id',$user_id);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows()==1){
            $this->db->where('user_id',$user_id);
            $this->db->set('file_info',$file_info);
            $this->db->update($this->_table_name);
            return $this->db->affected_rows() > 0;
        }else{
            $this->db->set('file_info',$file_info);
            $this->db->set('user_id',$user_id);
            $this->db->insert($this->_table_name);
            return $this->db->affected_rows() > 0;
        }
    }

    function get_cart_by_user($user_id){
        $this->db->where('user_id',$user_id);
        $this->db->limit(0);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows()==1){
            return $query->result_array()[0];
        }
        return null;
    }

}