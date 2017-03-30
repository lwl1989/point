<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/22
 * Time: 22:54
 */

class wechat_keyword_model extends MY_Model{

    protected $_table_name = 'wechat_keyword';

    function __construct(){
        parent::__construct();
    }

    function find_by_key($key){
        $this->db->where('keyword',$key);
        $this->db->or_where('keyword_pinyin',$key);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows==1) return $query->result_array()[0];
        return array();
    }


}