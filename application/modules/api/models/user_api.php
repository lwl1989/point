<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/12
 * Time: 21:18
 */
class user_api extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table_name = 'users';
    }

    function get_user_by_id($user_id){
        $this->db->select('username,nickname,introduce,qq,email,mobile,province,city,address,score,available_score,deposit,user_type');
        $this->db->where('id',$user_id);
        $this->db->where('is_del',0);
        $this->db->limit(1);
        $query =$this->db->get($this->_table_name);
        if($query->num_rows()==1){
            return $query->result_array()[0];
        }
        return null;
    }
}