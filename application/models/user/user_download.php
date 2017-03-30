<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/7
 * Time: 16:13
 */
class user_download extends MY_Model{
    protected $_table_name = 'user_download';
    protected $_user_table_name = 'users';
    function __construct(){
        parent::__construct();
    }

    function get_download_by_user($user_id){
        $this->db->select('download_time');
        $this->db->select('document.title,document.type,document.file_path,document.id');
        $this->db->where($this->_table_name.'.user_id',$user_id);
        $this->db->join('document','document.id='.$this->_table_name.'document_id');
        $this->db->order_by($this->_table_name.'id','desc');
        $query = $this->db->get($this->_table_name);
        if($query->num_rows()>0){
            return $query->result_array();
        }
        return null;
    }

    function exists_download($data){
        $this->db->where('user_id',$data['user_id']);
        $this->db->where('document_id',$data['document_id']);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows()==1){
            return true;
        }
        return false;
    }

    function update_users_score($user_id,$score,$add=true){
        $this->db->where('id',$user_id);
        if($add){
            $this->db->set('available_score','available_score+'.floatval($score),false);
            $this->db->set('score','score+'.floatval($score),false);
        }else{
            $this->db->set('available_score','available_score-'.floatval($score),false);
            $this->db->where('deposit >=',floatval($score));
        }
        $this->db->update($this->_user_table_name);
        return $this->db->affected_rows()>0;
    }

}