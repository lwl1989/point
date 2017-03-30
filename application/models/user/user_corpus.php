<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/7
 * Time: 12:21
 */
class user_corpus extends MY_Model{

    protected $_table_name = "document_corpus";
    function __construct(){
        parent::__construct();
        $this->db->where('is_del',0);
    }

    function get_corpus_by_user($user_id){
        $this->db->where('user_id',$user_id);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows()>0){
            return $query->result_array();
        }
        return null;
    }

    function range_corpus($corpus_id,$document_id,$user_id){
        $sql = "UPDATE `edu_db_document_comments` SET content=concat(content,"
            .$document_id."',') WHERE id="
            .$corpus_id." and user_id=".$user_id;
        $this->db->query($sql);
        return $this->db->affected_rows()>0;
    }
}