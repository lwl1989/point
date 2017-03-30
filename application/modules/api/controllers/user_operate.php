<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/26
 * Time: 12:23
 */

class user_operate extends MY_Api_Controller{


    function __construct(){
        parent::__construct();
    }

    /*
     * 对文件收藏 点赞等
     * post: user_id  document_id operate_type(1.收藏2.点赞)
     */
    function do_like($operate_token=false){
        $user_id = intval(trim($this->input->post('user_id')));
        $this->_verify_operate_token($user_id,$operate_token);

        $document_id = intval(trim($this->input->post('document_id')));
        $operate_type = trim($this->input->post('operate_type'));
        if(!$document_id){
            $this->_json(array('state'=>false,'msg'=>'文件ID未传入'));
        }
        $this->load->model('public/file_base');
        $result = $this->file_base->file_like($user_id,$document_id,$operate_type);
        if(!$result){
            $this->_json(array('state'=>false,'msg'=>'操作失败'),false);
        }
        $this->_json(array('state'=>true),true);
    }

    /*
     *对文件进行评论
     * post: user_id  document_id content
     */
    function do_comment_for_document($operate_token=false){
        $user_id = intval(trim($this->input->post('user_id')));
        $this->_verify_operate_token($user_id,$operate_token);
        $document_id = intval(trim($this->input->post('document_id')));
        $content = trim($this->input->post('content'));
        $score = intval($this->input->post('score'));
        $data = array(
            'user_id'   =>  $user_id,
            'document_id'   =>  $document_id,
            'content'   =>  $content,
            'score'     =>  $score,
            'comment_time'  =>  date('Y-m-d H:i:s',time())
        );
        $this->load->model('document/document_comment');
        $commented = $this->document_comment->judge_commented($user_id,$document_id);
        if($commented){
            $data['id']=$commented;
            $result = $this->document_comment->update($data,$commented);
            if($result){
                $this->load->model('document/document_model');
                $avg_score = $this->document_comment->avg_score($document_id);
                $this->document_model->update_avg($document_id,$avg_score);
                $this->_json(array('state'=>true),true);
            }
        }else{
            $result = $this->document_comment->insert($data);
            if($result){
                $this->load->model('document/document_model');
                $this->document_model->score_num_increment($document_id);
                $avg_score = $this->document_comment->avg_score($document_id);
                $this->document_model->update_avg($document_id,$avg_score);
                $this->_json(array('state'=>true),true);
            }
        }
        $this->_json(array('state'=>true),true);
    }

    /*
     *对公司进行评论
     * post: user_id  document_id operate_type(1.收藏2.点赞)
     */
    function do_comment_for_company($operate_token=false){
        $user_id = intval(trim($this->input->post('user_id')));
        $company_id = intval(trim($this->input->post('company_id')));
        $content = trim($this->input->post('content'));
        $this->_verify_operate_token($user_id,$operate_token);
        $data = array(
            'user_id'   =>  $user_id,
            'company_id'   =>  $company_id,
            'content'   =>  $content
        );
        $this->load->model('company/company_comment');
        $result = $this->company_comment->insert($data);
        if(!$result){
            $this->_json(array('state'=>false,'msg'=>'操作失败'),false);
        }
        $this->_json(array('state'=>true),true);
    }

    /*
     *对文档进行评分
     * post: user_id  score document_id
     */
    function do_comment_score($operate_token=false){
        $document_id = intval($this->input->post('document_id'));
        $score = intval($this->input->post('score'));
        $user_id = intval($this->input->post('user_id'));
        $this->_verify_operate_token($user_id,$operate_token);

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
                $this->_json(array('state'=>true));
            }
        }else{
            $result = $this->document_comment->insert($data);
            if($result){
                $this->load->model('document/document_model');
                $this->document_model->score_num_increment($document_id);
                $avg_score = $this->document_comment->avg_score($document_id);
                $this->document_model->update_avg($document_id,$avg_score);
                $this->_json(array('state'=>true));
            }
        }
        $this->_json(array('state'=>false),false);
    }

    /*
     * 申请退款
     */
    function do_eligible_refund($operate_token=false){
        $user_id = intval($this->input->post('user_id'));
        $this->_verify_operate_token($user_id,$operate_token);
        $data =array(
            'user_id'   => $user_id,
            'order_id'  => $this->input->post('order_id'),
            //'source'    => trim($this->input->post('source')),
            'message'   => trim($this->input->post('message')),
            'images'    => $this->input->post('images')    //图片的ID  3，5,7，9
        );
        $this->load->model('user/eligible_refund');
        $result = $this->eligible_refund->insert($data);
        if(!$result){
            $this->_json(array('state'=>false,'msg'=>'操作失败'),false);
        }
        $this->_json(array('state'=>true),true);
    }
}