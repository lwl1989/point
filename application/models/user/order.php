<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-7
 * Time: 下午2:49
 */
class order extends  MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table_name = 'order';
    }

    function insert_order($data){
        $data['place_time'] = date("Y-m-d H:i:s");
        if ($this->db->insert($this->_table_name, $data)) {
            $file_id = $this->db->insert_id();
            return array('file_id' => $file_id);
        }
        return NULL;
    }
}