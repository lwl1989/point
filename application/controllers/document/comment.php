<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/29
 * Time: 21:22
 */

class comment extends MY_Portal_Controller{

    function __construct(){
        parent::__construct();
    }

    function do_comment(){
        $document_id = intval($this->input->post('document_id'));
        $score = intval($this->input->post('score'));
        $user_id = intval($this->input->post('user_id'));
        if($user_id!=$this->_login_user['user_id']){
            $this->json_response(true,'','登录用户和评论用户不符合');
        }
        $this->load->model('document/document_comment');

        $data = array(
            'user_id'=>$user_id,
            'document_id'   =>  $document_id,
            'score' => $score,
            'comment_time'  =>  date('Y-m-d H:i:s',time())
        );
        $commented = $this->document_comment->judge_commented($user_id,$document_id);
        if($commented){
            $data['id']=$commented;
            $result = $this->document_comment->update($data,$commented);
            if($result){
                $this->load->model('document/document_model');
                $avg_score = $this->document_comment->avg_score($document_id);
                $this->document_model->update_avg($document_id,$avg_score);
                $this->json_response(true);
            }
        }else{
            $result = $this->document_comment->insert($data);
            if($result){
                $this->load->model('document/document_model');
                $this->document_model->score_num_increment($document_id);
                $avg_score = $this->document_comment->avg_score($document_id);
                $this->document_model->update_avg($document_id,$avg_score);
                $this->json_response(true);
            }
        }
        $this->json_response(false);
    }

    function test(){
        $this->_layout='';
        $this->display();
    }

}