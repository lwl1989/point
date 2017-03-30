<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/10
 * Time: 10:24
 */

class recommend extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table_name = 'recommend';
    }

    function display($recommend_id,$site_id){
        $this->db->where('id',$recommend_id);
        $this->db->where('site_id',$site_id);
        $this->db->set('is_display',1);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows()>0;
    }

    function close_display($recommend_id,$site_id){
        $this->db->where('id',$recommend_id);
        $this->db->where('site_id',$site_id);
        $this->db->set('is_display',1);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows()>0;
    }

    function select_recommend($data,$source = 'company_users'){
        //
        $this->db->select($this->_table_name.'.*');
        $this->db->select($source.'.name,'.$source.'.cover');
        $this->db->where($this->_table_name.'.site_id',$data['site_id']);
        if(isset($data['func']))
            $this->db->where('func',$data['func']);
        $this->db->join($source, $source.'.id = '.$this->_table_name.'.source_id','right');
        $query = $this->db->get($this->_table_name);
        // echo $this->db->last_query();
        if($query->num_rows>0){
            return $query->result_array();
        }
        return null;
    }

    function find_one($id){
        $this->db->where('id',$id);
        $this->db->limit(1);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows==1)
            return $query->result_array()[0];
        return null;
    }
}