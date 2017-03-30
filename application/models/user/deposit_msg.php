<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/21
 * Time: 11:15
 */

class deposit_msg extends MY_Model{
    protected $_table_name = 'user_deposit_msg';
    protected $_user_table_name = 'users';

    function __construct(){
        parent::__construct();
    }


    function update_users_deposit($user_id,$score,$add=true){
        $this->db->where('id',$user_id);
        if($add){
            $this->db->set('deposit','deposit+'.floatval($score),false);
        }else{
            $this->db->set('deposit','deposit-'.floatval($score),false);
            $this->db->where('deposit >=',floatval($score));
        }
        $this->db->update($this->_user_table_name);
        return $this->db->affected_rows()>0;
    }

    //function get_user()
    public function pagination_deposit
    (
        $base_url, $page = 1,$user_id,$actions=array()
    ) {
        $this->_CI->load->library('pagination');
        $per_page = 20;
        //$fields = '*';
        $total_rows = $this->get_deposit_count($user_id,$actions);

        $config = array();
        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $this->_CI->pagination->initialize($config);
        $page_html = $this->_CI->pagination->create_links();


        $start = ($page - 1)  * $per_page;
        $this->db->order_by('id','desc');
        $this->db->where('user_id',$user_id);
        $this->db->where_in('actions',$actions);
        $list = $this->db->get($this->_table_name,$per_page,$start);
        $list = $list->result_array();
        return array('list' => $list, 'page_html' => $page_html);
    }

    function get_deposit_count($user_id,$actions=array()){
        $this->db->where('user_id',$user_id);
        $this->db->where_in('actions',$actions);
        return $this->db->count_all_results($this->_table_name);
    }



}