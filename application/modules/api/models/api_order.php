<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/6/2
 * Time: 9:12
 */

class api_order extends MY_Model{

    protected $_table_name = 'order';
    protected $_payed_name = 'payed';
    function __construct(){
        parent::__construct();
    }


    function get_order_by_id($order_id){
        $this->db->where('order_id',$order_id);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows()==1)
            return $query->result_array()[0];
        return null;
    }

    function payed($order_id,$payed_func,$serial_number){
        $this->db->where('order_id',$order_id);
        $this->db->set('state',2);
        $this->db->set('payed_time',date("Y-m-d H:i:s",time()));
        $this->db->set('payed_func',$payed_func);
        $this->db->set('serial_number',$serial_number);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows()>0;
    }

    function confirm($order_id){
        $this->db->where('order_id',$order_id);
        $this->db->set('state',6);
        $this->db->set('user_confirm_time',date("Y-m-d H:i:s",time()));
        $this->db->update($this->_table_name);
        return $this->db->affected_rows()>0;
    }
}

