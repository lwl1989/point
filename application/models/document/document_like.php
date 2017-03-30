<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/26
 * Time: 11:26
 */

class document_like extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table_name = 'document_like';
    }
    function document_like($user_id,$file_id,$operate_type){
        $data['user_id'] =$user_id;
        $data['document_id'] =$file_id;
        $data['operate_type'] =$operate_type;
        if ($this->db->insert($this->_table_name, $data)) {
            $file_id = $this->db->insert_id();
            return array('file_id' => $file_id);
        }
        return NULL;
    }

    function get_like_by_user($user_id,$limit=false,$offset=false,$type=1){
        if($limit){
            $this->db->limit($limit);
            $this->db->offset($offset);
        }
        $this->db->select('document_id');
        $this->db->where('user_id',$user_id);
        $this->db->where('operate_type',$type);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows>0){
            return $query->result_array();
        } else{
            return null;
        }
    }
    function get_like_count_by_user($user_id,$type=1){
        $this->db->select('document_id');
        $this->db->where('user_id',$user_id);
        $this->db->where('operate_type',$type);
        $this->db->from($this->_table_name);
        return $this->db->count_all_results();
    }


    function get_like($key_word,$not_in){
        $this->db->select('id,title,upload_time,page,download_count,upload_time,is_del');
        $this->db->like('title',$key_word);
        $this->db->where('is_del',0);
        $this->db->order_by('id','desc');
        $this->db->where_not_in('id',$not_in);
        $this->db->order_by('print_count','desc');
        $this->db->limit(2);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows>0){
            $data = $query->result_array();
            return $data;
        } else{
            return null;
        }
    }

    function get_tag_like($tag,$not_in){
        $this->db->select('id,title');
        $this->db->like('tag',$tag);
        $this->db->where('is_del',0);
        $this->db->where_not_in('id',$not_in);
        $this->db->order_by('id','desc');
        $this->db->order_by('print_count','desc');
        $this->db->limit(3);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows>0){
            $data = $query->result_array();
            return $data;}else{
            return null;
        }
    }
}