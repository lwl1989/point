<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-5
 * Time: 下午2:13
 */
class file_base extends MY_Model{
	protected $_like_table = 'document_like';
    protected $_tag_table = 'tag';
    function __construct(){
        parent::__construct();
        $this->_table_name = 'document';
    }
    function select($classify_id=0,$limit = 10,$offset = 0){
        if($classify_id){
            $this->db->where('classify_id',$classify_id);
        }
        $this->db->where('is_del',0);
        $query = $this->db->get($this->_table_name,$limit,$offset);
        return $query->result_array();
    }
    function get_file_by_id($file_id){
        $this->db->where('id',$file_id);
        $this->db->select('id,ext,user_id,file_classify,file_type,score,title,intro,tag,file_size,upload_time,file_path,create_pdf,views_count,print_count');
        $this->db->limit(1);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows()==1){
            $result =  $query->result_array();
            return $result[0];
        }
        return null;
    }

    function get_file_list($file_ids){
        $this->db->where_in('id',$file_ids);
        $query = $this->db->get($this->_table_name);
        return $query->result_array();
    }
	
	function get_file_path($file_id){
		//$this->db->where('download_count',$download_count);
		//$this->db->where('file_path',$file_path);
		$this->db->where('id',$file_id);
		$this->db->where('is_del',0);
		$query = $this->db->get($this->_table_name);
		$result = $query->result_array();
		//$data['file_path'] = $result['file_path'];
		//$data['download_count'] = $result['download_count'];
		return $result;
		
	}
	
	function file_like($user_id,$file_id,$operate_type){
		$data['user_id'] =$user_id;
		$data['document_id'] =$file_id;
		$data['operate_type'] =$operate_type;
        if ($this->db->insert($this->_like_table, $data)) {
            $file_id = $this->db->insert_id();
            return array('file_id' => $file_id);
        }
        return NULL;
	}
    function collect_exists($user_id,$document_id,$operate_type){
        $this->db->where('user_id',$user_id);
        $this->db->where('document_id',$document_id);
        $this->db->where('operate_type',$operate_type);
        $query = $this->db->get($this->_like_table);
        if($query->num_rows()==1){
            return true;
        }
        return false;
    }
    function del_like($user_id,$document_id,$operate_type){
        $this->db->where('user_id',$user_id);
        $this->db->where('document_id',$document_id);
        $this->db->where('operate_type',$operate_type);
        $query = $this->db->delete($this->_like_table);
        return $this->db->affected_rows()>0;
    }

    function del($file_id){
        $this->db->where('id',$file_id);
        $this->db->delete($this->_table_name);
        return $this->db->affected_rows() > 0;
    }

    function get_like($key_word,$not_in){
        $this->db->select('id,title,intro,views_count,print_count,file_size,upload_time,page,download_count,upload_time');
        $this->db->where('create_pdf',1);
        $this->db->like('title',$key_word);
        $this->db->where('is_del',0);
        $this->db->order_by('id','desc');
        if(count($not_in)>0){
            $this->db->where_not_in('id',$not_in);
        }
        $this->db->order_by('print_count','desc');
        $this->db->limit(5);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows>0){
        $data = $query->result_array();
        return $data;}else{
            return null;
        }
    }

    function get_tag_like($tag,$not_in){
        $this->db->select('id,title');
        $this->db->like('tag',$tag);
        $this->db->where('is_del',0);
        $this->db->where_not_in('id',$not_in);
        $this->db->order_by('id','desc');
        $this->db->order_by('print_count','desc');
        $this->db->limit(2);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows>0){
            $data = $query->result_array();
            return $data;}else{
            return null;
        }
    }

    function download_count_increment($file_id){
        $this->db->where('id',$file_id);
        $this->db->set('download_count','download_count+1',false);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows()>0;
    }

    function set_page($page,$id){
        $this->db->where('id',$id);
        $this->db->set('page',$page);
        $this->db->update($this->_table_name);
        return $this->db->affected_rows()>0;
    }
}