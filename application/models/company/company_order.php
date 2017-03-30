<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-5
 * Time: 下午1:17
 */

class company_order extends MY_User_Model{

    function __construct(){
        parent::__construct();
        $this->_table_name = 'order';
    }

    /*
     * 获取订单列表
     */
    function get_order_by_id($company_id,$order_by = 'id',$state = 0,$limit = 10, $offset = 0){
        $this->db->where('company_id',$company_id);
        $this->db->where('state',$state);
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by, "desc");
        $query = $this->db->get($this->_table_name);

        return $query->result_array();
    }
    /*
     * 获取订单数量
     */
    function get_order_count_by_id($company_id,$state = 0){
        $this->db->where('company_id',$company_id);
        $this->db->where('state',$state);
        $this->db->from($this->_table_name);
        return $this->db->count_all_results();
    }

    /*
     * 完成打印,修改订单状态
     */
    function complete($company_id,$order_id,$state = 5){
        $state = intval($state);
        $this->db->where('company_id',$company_id);
        $this->db->where('order_id',$order_id);
        $this->db->where('state',$state-1);
        $this->db->set('state',$state);
        $this->db->set('printed_time',date("Y-m-d H:i:s",time()));
        $this->db->update($this->_table_name);
        return $this->db->affected_rows() > 0;
    }

    /*
     * 开始打印,修改订单状态
     */
    function printing($company_id,$order_id,$state = 4){
        $state = intval($state);
        $this->db->where('company_id',$company_id);
        $this->db->where('order_id',$order_id);
        $this->db->where('state <',$state);
        $this->db->set('state',$state);
        $this->db->set('company_receive_time',date("Y-m-d H:i:s",time()));
        $this->db->update($this->_table_name);
        return $this->db->affected_rows() > 0;
    }

    /*
     * 删除订单?
     */
    function del($company_id,$order_id){
        $state = array('2','3','4','5');
        $this->db->where('company_id',$company_id);
        $this->db->where('order_id',$order_id);
        $this->db->where_not_in('state',$state);

        $this->db->set('is_del',1);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows() > 0;
    }

    /*
     * recevice 公司用户接收到
     */
   /* function receive($company_id,$order_id){
        $this->db->set('company_receive_time',date("Y-m-d H:i:s",time()));
        $this->db->where('company_id',$company_id);
        $this->db->where('order_id',$order_id);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows() > 0;
    }*/

}