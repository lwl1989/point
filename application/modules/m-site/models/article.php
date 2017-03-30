<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/13
 * Time: 18:02
 */
class article extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table_name = 'article';
    }

    function select($data){
        $this->db->where('site_id',$data['site_id']);
        $this->db->where('is_del',$data['is_del']);
        $query =$this->db->get($this->_table_name);
        if($query->num_rows()>0){
            return $query->fetch_array();
        }
        return null;
    }

}