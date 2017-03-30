<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/11
 * Time: 1:04
 */
class recommend extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table_name = 'recommend';
    }

    function select_recommend($data,$source = 'companies'){
        $this->db->select( $source.'.id,'.$source.'.name,'.$source.'.cover');
        $this->db->where($this->_table_name.'.site_id',$data['site_id']);
        if($data['func'])
            $this->db->where('func',$data['func']);
        $this->db->join($source, $source.'.id = '.$this->_table_name.'.source_id');
        $query = $this->db->get($this->_table_name);
        if($query->num_rows>0){
            return $query->result_array();
        }
        return null;
    }
}