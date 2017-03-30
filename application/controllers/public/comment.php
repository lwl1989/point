<?php
 class comment extends  MY_User_Controller
 {

     protected $user_id;

     public function __construct()
     {
         parent::__construct();
     }

     function do_collect(){
         $user_id = $this->_login_user['user_id'];
         if(!$user_id){
             $this->json_response(9);
         }
         $document_id = trim($this->input->post("file_id"));
         $operate_type = trim($this->input->post("operate_type"));
         $this->load->model('public/file_base');
         if($this->file_base->collect_exists($user_id,$document_id,$operate_type)){
             $this->json_response(false,'','文件已经被收藏过了');
         }
         $result = $this->file_base->file_like($user_id,$document_id,$operate_type);
         if(!$result){
             $this->json_response(false,'','文件收藏失败');
         }
         $this->json_response(true);
     }

     function do_del_collect(){
         $user_id = $this->_login_user['user_id'];
         if(!$user_id){
             $this->json_response(9);
         }
         $document_id = trim($this->input->post("file_id"));
         $operate_type = trim($this->input->post("operate_type"));
         $this->load->model('public/file_base');
         $result = $this->file_base->del_like($user_id,$document_id,$operate_type);
         if(!$result){
             $this->json_response(false,'','文件收藏失败');
         }
         $this->json_response(true);
     }

 }