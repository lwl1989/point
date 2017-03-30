<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-7
 * Time: 上午10:06
 */

class apps extends MY_Model{

    protected $_access_table_name = 'app_access';
    protected $_token_table_name = 'token';
    protected $_operate_table_name = 'client_info';
    function __construct(){
        parent::__construct();
    }

    function get_token($appid,$appsecret){
        $this->db->where('appid',$appid);
        $this->db->where('appsecret',$appsecret);
        $this->db->where('is_true',1);

        $query = $this->db->get($this->_access_table_name);

        if($query->num_rows() == 1) return $query->row();
        return null;
    }

    function set_token($token){
        $arr['token'] = $token;
        $arr['access_time'] = date('Y-m-d H:i:s',time());

        $result = $this->db->insert($this->_token_table_name,$arr);
        if(!$result)
            return false;
        return true;
    }

    function verify_token($token,$expire_period = 3600){
        $this->db->where('token',$token);
        $this->db->where('UNIX_TIMESTAMP(access_time) >',time() - $expire_period);

        $query = $this->db->get($this->_token_table_name);

        if($query->num_rows() == 1) return $query->row();
        return null;

    }

    function set_operate_token($token,$operate_token,$user_id){
        $this->db->set('token',$token);
        $this->db->set('user_id',$user_id);
        $this->db->set('operate_token',$operate_token);
        $result = $this->db->insert($this->_operate_table_name);
        if(!$result)
            return false;
        return true;

    }

    function verify_operate_token($user_id,$token){
        $this->db->where('operate_token',$token);
        $this->db->where('user_id',$user_id);
        $query = $this->db->get($this->_operate_table_name);
        if($query->num_rows() == 1) return $query->row();
        return null;
    }
}