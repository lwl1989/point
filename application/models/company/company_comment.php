<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/22
 * Time: 8:17
 */

class company_comment extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table_name = "company_comments";
    }

    function get_comments_count($conditions=array(),$is_del=0){
        $this->db->select("company_comments.*");
        $this->db->select("users.username");
        $this->db->select("company_users.name");
        $this->db->where('edu_db_company_comments.is_del',$is_del);
        if(isset($conditions['company_name'])){
            $this->db->where('company_users.name',$conditions['company_name']);
        }
        if(isset($conditions['user_name'])){
            $this->db->where('users.username',$conditions['user_name']);
        }
        $this->db->where('is_audit',$conditions['is_audit']);
        $this->db->join('users','edu_db_users.id=edu_db_company_comments.user_id');
        $this->db->join('company_users','edu_db_company_users.id=edu_db_company_comments.company_id');
        $this->db->from($this->_table_name);
        return $this->db->count_all_results();
    }

    function get_comments_list($page=1,$conditions=array(),$is_del=0){
        $offset = ($page-1)*15;
        $this->db->select("company_comments.*");
        $this->db->select("users.username");
        $this->db->select("company_users.name");
        $this->db->where('edu_db_company_comments.is_del',$is_del);
        if(isset($conditions['company_name'])){
            $this->db->where('company_users.name',$conditions['company_name']);
        }
        if(isset($conditions['user_name'])){
            $this->db->where('users.username',$conditions['user_name']);
        }
        $this->db->where('is_audit',$conditions['is_audit']);
        $this->db->join('users','edu_db_users.id=edu_db_company_comments.user_id');
        $this->db->join('company_users','edu_db_company_users.id=edu_db_company_comments.company_id');
        $query = $this->db->get($this->_table_name,15,$offset);
        if($query->num_rows>0){
            return $query->result_array();
        }
        return null;
    }
    function get_comments_by_company($company_id,$is_del=false,$is_audit=false){
        $this->db->where("company_id",$company_id);
        if($is_del){
            $this->db->where('is_del',$is_del);
        }
        if($is_audit){
            $this->db->where('is_audit',$is_audit);
        }
        $query = $this->db->get($this->_table_name);
        if($query->num_rows>0){
            return $query->result_array();
        }
        return null;
    }

    /*
     * 赞同
     */
    function agree_by_id($comment_id){
        $this->db->where('id',$comment_id);
        $this->db->set('agree_count','agree+1', FALSE);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows() > 0;
    }

    /*
     * 不赞同
     */
    function not_agree_by_id($comment_id){
        $this->db->where('id',$comment_id);
        $this->db->set('not_agree_count','not_agree_count+1', FALSE);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows() > 0;
    }

    /*
     * 通过审核
     */
    function audit($comment_id){
        $this->db->where('id',$comment_id);
        $this->db->set('is_audit',1);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows() > 0;
    }

    /*
     * 禁止
     */
    function forbidden($comment_id){
        $this->db->where('id',$comment_id);
        $this->db->set('is_forbidden',1);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows() > 0;
    }
    function back_forbidden($comment_id){
        $this->db->where('id',$comment_id);
        $this->db->set('is_forbidden',0);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows() > 0;
    }


}