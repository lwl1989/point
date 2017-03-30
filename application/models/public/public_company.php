<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-7
 * Time: 下午1:53
 */
class public_company extends MY_Model{

    protected $_company_table = 'company_users';
    function __construct(){
        parent::__construct();
    }

    function entry_company($point){
        $this->db->where('is_del',0);
        $this->db->where('lng >',$point['right-bottom']['lng']);
        $this->db->where('lng <',$point['left-top']['lng']);
        $this->db->where('lat >',$point['right-bottom']['lat']);
        $this->db->where('lat <',$point['left-top']['lat']);

        $this->db->get($this->_company_table);
    }

    function get_company($zone_id=false){
        $this->db->select('id,name,address,charge');
        $this->db->where('is_del',0);
      //  $this->db->where('zone_id',$zone_id);
        $query = $this->db->get($this->_company_table);
        $result = $query->result_array();
        return $result;
    }


}