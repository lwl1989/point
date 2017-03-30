<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-3
 * Time: 下午2:25
 */

class user_file extends MY_User_Model{


    function __construct(){
        parent::__construct();
        $this->_table_name = 'document';
    }
    /*
     * 获取用户文件
     */
    function get_file($condition,$limit,$offset,$order=''){
        $conditions = array_merge(array(
            'is_del' => 0
        ),$condition);

        if ($order == '') {
            $order = 'id desc';
        } else {
            $order .= ',id desc';
        }
        $fields = 'id,user_id,title,intro,score,score_num,upload_time,file_path,print_count,file_size,download_count';
        $options = array(
            'order' => array($order),
            'limit' => array($limit, $offset),
        );

        return $this->fetch_array($conditions, $fields, $options);
    }
    /*
     * 获取文件数
     */
    function get_count_by_user($user_id){
        $this->db->where('user_id',$user_id);
        $this->db->from($this->_table_name);
        return $this->db->count_all_results();
    }
    /*
     * 获取文件点赞数
*/
    function get_like_by_id($user_id,$document_id,$type=1){
        $this->db->where('user_id',$user_id);
        $this->db->where('document_id',$document_id);
        $this->db->where('operate_type',$type);
        $this->db->from($this->_file_like_table);
        return $this->db->count_all_results();
    }
    /*
     * 软删除
     */
    function soft_del($user_id,$file_id){
        $this->db->where('user_id',$user_id);
        $this->db->where('id',$file_id);

        $this->db->set('is_del',1);
        $this->db->update($this->_file_table);
        return $this->db->affected_rows() > 0;
    }

    function get_file_by_id($user_id,$file_id){
        $this->db->where('id',$file_id);
        $this->db->where('user_id',$user_id);

        $query = $this->db->get($this->_file_table);

        if ($query->num_rows() == 1) return $query->row();
        return NULL;
    }

    function get_file_deleted($user_id,$limit,$offset,$order=''){
        $conditions = array(
            'user_id' => $user_id,
            'is_del'  => 1
        );

        if ($order == '') {
            $order = 'id desc';
        } else {
            $order .= ',id desc';
        }

        $fields = 'id,user_id,title,intro,upload_time,file_path,views_count,print_count';
        $options = array(
            'order' => array($order),
            'limit' => array($limit, $offset),
        );
        return $this->fetch_array($conditions, $fields, $options);
    }

}