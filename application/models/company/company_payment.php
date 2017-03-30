<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/30
 * Time: 10:56
 */

class company_payment extends MY_Model{

    protected $_table_name = 'company_payment';
    function __construct(){
        parent::__construct();
        $this->_table_name='company_payment';
    }

    function withdrawals($company_id,$payment){
        $this->db->where('id',$company_id);
        $this->db->set('available_payment','available_payment-'.$payment,false);
        $this->db->update('company_users');
        return $this->db->affected_rows()>0;
    }

    public function pagination_payment
    (
        $base_url, $page = 1,$company_id,$actions=array(),$source_id=null
    ) {
        $this->_CI->load->library('pagination');
        $per_page = 20;
        //$fields = '*';
        if($company_id)
            $total_rows = $this->get_payment_count($company_id,$actions);
        else
            $total_rows = $this->get_payment_counts($actions,$source_id);

        $config = array();
        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $this->_CI->pagination->initialize($config);
        $page_html = $this->_CI->pagination->create_links();


        $start = ($page - 1)  * $per_page;
        $this->db->order_by('id','desc');
        if($company_id)
            $this->db->where('company_id',$company_id);
        if($source_id){
            $this->db->where('source_id',$source_id);
        }
        $this->db->where_in('actions',$actions);
        $list = $this->db->get($this->_table_name,$per_page,$start);
        $list = $list->result_array();
        return array('list' => $list, 'page_html' => $page_html);
    }

    function get_payment_count($company_id,$actions){
        $this->db->where('company_id',$company_id);
        $this->db->where('actions',$actions);
        $this->db->from($this->_table_name);
        return $this->db->count_all_results();
    }

    function get_payment_counts($actions,$source_id){
        if($source_id){
            $this->db->where('source_id',$source_id);
        }
        $this->db->where('actions',$actions);
        $this->db->from($this->_table_name);
        return $this->db->count_all_results();
    }

    function do_reflect_true($id){
        $this->db->where('id',$id);
        $this->db->set('is_true',1);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows()>0;
    }

}