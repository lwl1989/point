<?php

class file_download extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table_name = 'document';
    }

	function file_download_count($file_id,$count){
		$this->db->where('id',$file_id);
		$this->db->set('download_count',intval($count)+1);
		$this->db->update($this->_table_name);
		return $this->db->affected_rows() > 0;
	}
}
