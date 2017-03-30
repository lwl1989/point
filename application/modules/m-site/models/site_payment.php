<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/6/25
 * Time: 10:19
 */


class site_payment extends MY_Model{
    protected $_table_name = "users";
    function __construct(){
        parent::__construct();
    }

    function set_type($type){
        if($type=="user"){
            $this->_table_name = "user_deposit_msg";
        }else if($type=="company"){
            $this->_table_name = "company_payment";
        }
    }

    function set_true($id){
        $this->db->where("id",$id);
        $this->db->where("is_true",0);
        $this->db->set("is_true",1);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows()>0;
    }

}