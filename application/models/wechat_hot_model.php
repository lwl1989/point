<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/22
 * Time: 22:54
 */

class wechat_hot_model extends MY_Model{

    protected $_table_name = 'wechat_hot_key';

    function __construct(){
        parent::__construct();
    }


    function exists_key($key,$openid){
        $this->db->where('keyword',$key);
        $this->db->where('open_id',$openid);
        return $this->db->count_all_results();
    }


}