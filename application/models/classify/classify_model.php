<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-14
 * Time: 下午2:06
 */

class classify_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table_name = 'document_classify';
    }

    function select_classify_by_user($user_id,$is_del = 0){
        $this->db->where('create_user',$user_id);
        $this->db->where('is_del',$is_del);
        $query = $this->db->get($this->_table_name);
        return $query->result();
    }

    function select_classify_by_system($is_del = 0){
        $this->db->select('id,name,intro');
        $this->db->where('create_user',0);
        $this->db->where('is_del',$is_del);
        $query = $this->db->get($this->_table_name);
        return $query->result();
    }
   /* function select_classify_by_user($user_id=0){
        $this->db->where('user_id',$user_id);
    }*/
}