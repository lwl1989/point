<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-3
 * Time: 下午2:22
 */

class user_model extends MY_Model
{
    protected $_table_name = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_user_rank($score)
    {
        $sql="select count(*)+1 from exp_db_users where score >".$score;
        $query=$this->db->query($sql);
        $result=$query->result_array();
        return $result[0]['count(*)+1'];
    }

    public function  get_history($id,$times,$month)
    {
        if(!is_array($times))
        {
            $sql="select sum(score) from exp_db_user_actions where is_usefull=1 and created< '".$times."' and user_id=".$id;
            $query=$this->db->query($sql);
            $result=$query->result_array();
            return $result[0]['count(score)'];
        }
        else
        {
            $result=array();
            for($i=0;$i<12;$i++)
            {
                $sql=sprintf('select sum(score) from exp_db_user_actions where is_usefull=1 and created < "%s" and user_id=%d',$times[$i],$id);
                $query=$this->db->query($sql);
                $result[$i]=$query->result_array();

                $result[$i]['month']=$month[$i+1];

            }
            return $result;
        }
    }


    public function update_user_score($int_uid, $int_score)
    {
        if($int_score >= 0)
        {
            $sql = "update {$this->_table_name} set score = score + $int_score where id = $int_uid";
        }
        else
        {
            $int_do = 0 - $int_score;
            $sql = "update {$this->_table_name} set score = score - $int_do where id = $int_uid and score >= $int_do";
        }
        return $this->db->query($sql);
    }


    function set_cart($user_id,$file_info){
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('cart');
        if($query->now_rows == 1){
            $this->db->set('user_id',$user_id);
            $this->db->set('file_info',$file_info);
            $this->db->where('user_id',$user_id);
            $this->db->update($this->_table_name);
            return $this->db->affected_rows() > 0;
        }else{
            $data['user_id'] = $user_id;
            $data['file_info'] = $file_info;
            return $this->db->insert('cart',$data);
        }

    }

    function get_cart($user_id){
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('cart');
        if($query->now_rows() == 1){
            $result =$query->fetch_array();
            return $result[0];
        }
        return null;
    }

    function get_user_by_id($user_id)
    {
        $this->db->select('username,nickname,mobile,available_score,users.score,deposit,users.id as uid,sex,email,qq,introduce,address');
        $this->db->select('count(*) as document_num');
        $this->db->where('users.id', $user_id);
        $this->db->where('users.is_del',0);
        $this->db->join('document','document.user_id=users.id');
        $this->db->limit(1);
        $query = $this->db->get($this->_table_name);
        //echo $this->db->last_query();
        if ($query->num_rows() == 1) return $query->result_array()[0];
        return NULL;
    }

    function get_users_num($user_id){
        $this->db->where('is_del',0);
        $this->db->where('id',$user_id);
        $this->db->select('count(*) as user_num,sum(deposit) as deposit_total');
        $query = $this->db->get($this->_table_name);
        if ($query->num_rows() == 1)
            return $query->result_array()[0];
        return NULL;

    }

    function get_user_count(){
        $this->db->where('user_type','ordinary');
        $this->db->select('count(*) as user_num,sum(deposit) as deposit_total');
        $query = $this->db->get($this->_table_name);
        if ($query->num_rows() == 1)
            return $query->result_array()[0];
        return NULL;
    }

}
