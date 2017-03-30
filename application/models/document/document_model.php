<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/26
 * Time: 12:05
 */

class document_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table_name = 'document';
    }

    function get_file_by_id($document_id,$show=true){
        $this->db->where('is_del',0);
        $this->db->where('create_pdf',1);
        $query = $this->db->get($this->_table_name);
        if ($query->num_rows() == 1)
            return $query->result_array()[0];
        return NULL;
    }
    function get_document_num($user_id){
        $this->db->where('is_del',0);
        $this->db->where('user_id',$user_id);
        $this->db->select('count(*) as document_num');
        $query = $this->db->get($this->_table_name);
        if ($query->num_rows() == 1)
            return $query->result_array()[0]['document_num'];
        return NULL;
    }

    function get_document_by_ids($document_ids){
        $this->db->select('id,user_id,is_del,page,title,intro,upload_time,file_path,print_count,file_size,download_count');
        $this->db->where_in('id',$document_ids);
        $this->db->where('is_del',0);
        $query = $this->db->get($this->_table_name);
        if ($query->num_rows() >0) return $query->result_array();
        return NULL;
    }

    function get_title($document_id){
        $this->db->select('title');
        $this->db->where('id',$document_id);
        $this->db->limit(1);
        $query = $this->db->get($this->_table_name);
        if ($query->num_rows() == 1) return $query->result_array()[0]['title'];
        return NULL;
    }

    function get_title_with_page($document_ids){
        $this->db->select('title,page,score');
        $this->db->where_in('id',$document_ids);
       // $this->db->limit(1);
        $query = $this->db->get($this->_table_name);
        if ($query->num_rows() >0) return $query->result_array();
        return NULL;
    }

    function count_document($user_id){
        $this->db->select('count(*) as total,views_count,print_count,download_count');
        $this->db->where('user_id',$user_id);
        $query = $this->db->get($this->_table_name);
        if ($query->num_rows() == 1) return $query->result_array()[0];
        return NULL;
    }
    function count_documents(){
        $this->db->where('is_del',0);
        return $this->db->count_all_results($this->_table_name);
    }

    function count_like_total($user_id){
        $this->db->select('count(*) as like_total');
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('document_like');
        if ($query->num_rows() == 1) return $query->result_array()[0]['like_total'];
        return NULL;
    }

    function score_num_increment($document_id){
        $this->db->where('id',$document_id);
        $this->db->set('score_num', 'score_num+1', FALSE);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows()>0;
    }

    function update_avg($document_id,$score){
        $this->db->set('score',$score);
        $this->db->where('id',$document_id);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows()>0;
    }

    function update_print_count($document_id,$print_num,$add=true){
        if($add){
            $this->db->set('print_count','print_count+'.$print_num,false);
        }else{
            $this->db->set('print_count','print_count-'.$print_num,false);
            $this->db->where('print_count >',$print_num);
        }
        $this->db->where('id',$document_id);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows()>0;
    }

    function update_views_count($document_id){
        $this->db->set('views_count','views_count+1',false);
        $this->db->where('id',$document_id);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows()>0;
    }

    function update_by_convert($document_id,$doc_path,$file_type,$swf_file_path,$file_size,$page){
        $this->db->set('file_path',$doc_path);
        $this->db->set('file_size',$file_size);
        $this->db->set('file_type',$file_type);
        $this->db->set('swf_file_path',$swf_file_path);
        $this->db->set('page',$page);
        $this->db->where('id',$document_id);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows()>0;
    }


}