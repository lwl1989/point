<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/8/13
 * Time: 14:46
 */
class document_md5 extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table_name="document";
    }

    function get_document_by_md5($md5){
        $this->db->select('title,page,file_size,file_type,file_path,swf_file_path,ext');
        $this->db->where("md5",$md5);
        $query =$this->db->get($this->_table_name);
        if($query->num_rows()>0){
            return $query->result_array()[0];
        }
        return null;
    }
}
