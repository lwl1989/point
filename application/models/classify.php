<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/15
 * Time: 11:39
 */

class classify extends MY_Model{
    protected $_table_name="document_classify";
    function __construct(){
        parent::__construct();
    }

    function get_true_father(){
        $this->db->select('id,name,intro');
        $this->db->where('is_del',0);
        $this->db->where('fid',0);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows()>0){
            return  $query->result_array();
        }
        return null;
    }

    function get_tag_children($tag_id,$type_id){
        $this->db->select('id,name,intro');
        $this->db->where('tag',$tag_id);
        $this->db->where('tag',$type_id);
        $this->db->where('is_del',0);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows()>0){
            return  $query->result_array();
        }
        return array();
    }
}