<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/26
 * Time: 11:17
 */
class document_comment extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table_name = 'document_comments';
    }

    function get_comment_by_document($document_id){
        $this->db->select('user_id,content,comment_time');
        $this->db->select('nickname');
        $this->db->where('document_id',$document_id);
        $this->db->where('document_comments.is_del',0);
        $this->db->join('users','document_comments.user_id=users.id');
        $query = $this->db->get($this->_table_name);
        if($query->num_rows()>0)
            return $query->result_array();
        return null;
    }

    function get_comment_by_user($user_id){
        $this->db->where('user_id',$user_id);
        $this->db->where('is_del',0);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows()>0)
            return $query->result_array();
        return null;
    }

    function get_comment_count($document_id){
        $this->db->select('count(*) as comment_total,avg(`score`) as avg_score');
        $this->db->where('document_id',$document_id);
        $this->db->where('is_del',0);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows()==1)
            return $query->result_array()[0];
        return null;
    }

    function judge_commented($user_id,$document_id){
        $this->db->where('document_id',$document_id);
        $this->db->where('user_id',$user_id);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows()==1)
            return $query->result_array()[0]['id'];
        return null;
    }

    function avg_score($document_id){
        $this->db->where('document_id',$document_id);
        $this->db->select_avg('score');
        $query = $this->db->get($this->_table_name);
        if($query->num_rows()==1)
            return floatval($query->result_array()[0]['score']);
        return null;
    }

}