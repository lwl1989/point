<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/8/13
 * Time: 14:41
 */

class check_file extends  MY_Api_Controller{

    function __construct(){
        parent::__construct();
    }

    function md5(){
        $md5 = trim($this->input->post("md5"));
        $title = trim($this->input->post("title"));
        $user_id = trim($this->input->post('user_id'));
        $this->load->model("document_md5");
        $result = $this->document_md5->getOne(array("md5"=>$md5));
        if($result){
            $data['title'] = $title;
            $data['page'] = $result['page'];
            $data['file_size'] = $result['file_size'];
            $data['file_type'] = $result['file_type'];
            $data['file_path'] = $result['file_path'];
            $data['swf_file_path'] = $result['swf_file_path'];
            $data['ext'] = $result['ext'];
            $data['upload_time'] = date("Y-m-d H:i:s");
            $data['user_id'] = $user_id;
            $this->document_md5->insert($data);
            $this->json_response(true,"","文件已秒传");
        }
        $this->json_response(false);

    }
}