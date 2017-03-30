<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/26
 * Time: 11:33
 */

class document extends MY_Api_Controller{

    function __construct(){
        parent::__construct();
    }

    /*
     * 获取评论列表
     * 传入参数  文件ID
     */
    function get_comments($document_id){
        if(!$document_id){
            $this->_json(array('state'=>false,'msg'=>'文件ID未传入'));
        }
        $this->load->model('document/document_comment');
        $result = $this->document_comment->get_comment_by_document($document_id);
        if(!$result)
        {
            $this->_json(array('state'=>true,'msg'=>'文件评论暂时为空'));
        }
        $this->_json(array('state'=>true,'comments'=>$result));
    }

    /*
     * 搜索、分词算法
     * 传入参数: 关键字  post
     */
    function search(){
        $this->load->model('public/file_base');
        $keyword = trim($this->input->post('keyword'));
        //$keyword='软件';
        $config = array(
            'source_charset'=>'utf-8',
            'target_charset'=>'utf-8',
            'load_all'  =>  false
        );
        $this->load->library('phpanalysis',$config);
        $this->phpanalysis->SetSource($keyword);
        $this->phpanalysis->differMax = false;
        $this->phpanalysis->unitWord = false;
        $this->phpanalysis->StartAnalysis( false );
        $result = $this->phpanalysis->GetFinallyResult(' ', true);
        $result = explode(' ',$result);

        $not_in = array();
        $recommend = array();
        $j=0;
        $i=1;
        foreach($result as $v){
            if($v!="")
            {
                $back = $this->file_base->get_like($v,$not_in);
                if(is_array($back)){
                    $recommend[$j]=$back;
                    foreach($back as $v)
                    {
                        $not_in[$i] = $v['id'];
                        $i++;
                    }
                    $j++;
                }
            }
        }
        $this->json_response(true,$recommend);
    }

    /*
     * 生成PDF后，调用此接口更新文档
     */
    function convert(){

       $document_id = $this->input->post('document_id');
        if(!$document_id){
            $this->json_response(false,"","no document_id");
        }
        //var_dump($this->input->post());
        //$this->load->model('document/document_mode');
         $doc_path = $this->input->post('docpath');
         $swf_file_path = $this->input->post('swfpath');
         $page = $this->input->post('page');
         $file_type = $this->input->post('type');
         $file_siez = $this->input->post('size');
         $this->load->model('document/document_model');
         if($this->document_model->update_by_convert($document_id,$doc_path,$file_type,$swf_file_path,$file_size,$page)){
             $this->json_response(true);
         }
         $this->json_response(false,"",$this->document_model->db->last_query());
    }

    /*
     * 获取config生成的子类
     */
    function  get_classify($fid=0){
        $this->load->config('data/classifies',true);
        $classify = $this->config->item('data/classifies');
        if($fid!=0){
            foreach($classify as  $v){
                if($v['id']==$fid){
                    $this->_json(array('state'=>true,'classify'=>$v['children']));
                }
            }
        }
        //$this->_json(array('state'=>true,'classify'=>$classify));
        $this->json_response(true,$classify);
    }
    /*
     * 获取config中自定义的基类
     */
    function get_classify_base($id){
        $this->load->config('classify_base',true);
        $classify = $this->config->item('classify_base');
        foreach ($classify as $key=>$val) {
            if($key==$id){
                $this->json_response(true,$val['tags']);
            }
        }
        //$this->_json(array('state'=>true,'classify'=>$classify));
        $this->json_response(true,$classify);
    }

    function do_upload($operate_token=false,$form_name='file'){
        $user_id = intval($this->input->post('user_id'));
        $this->_verify_operate_token($user_id,$operate_token);
        //$user_id=6;
        $this->config->load('upload');
        $urls = $this->config->item('file_url');
        $settings = $this->config->item('file_conf');
        $config['user_id']  = $user_id;
        $config = array();
        $config['upload_path'] = FCPATH . $urls['upload_dir'].$user_id.'/';
        $config['allowed_types'] = $settings['allowed_types'];
        $config['max_size'] = $settings['max_size'];

        $suffix = $this->_get_suffix($_FILES[$form_name]['name']);
        $file_name = $this->_del_suffix($_FILES[$form_name]['name']);
        if(!in_array($suffix,explode('|',$settings['allowed_types']))){
            $this->json_response(false,'','文件类型不符合');
        }
        $config['file_name'] = $this->randomString(true).$this->randomString().'.'.$suffix;
        $this->load->library('upload', $config);
        if (!is_dir($config['upload_path'])) {
            _mkdir($config['upload_path']);
        }
        if (!$this->upload->do_upload($form_name, true))
        {
            $this->json_response(false,'','上传失败');
        } else {

            $upload_data = $this->upload->data();
            $upload_data['save_path'] = $urls['upload_dir'].$user_id.'/'. $upload_data['file_name'];
            $this->load->model('document/document_model');
            $pdf_path = $this->_get_pdf_name($upload_data['save_path']);
            $pdf_path = FCPATH.$pdf_path;
            $file['user_id'] = $user_id;
            $file['file_path'] = urlencode($user_id.'/'. $upload_data['file_name']);
            $file['file_type'] = $upload_data['file_type'];
            $file['title'] = iconv('gb2312','utf-8',$file_name);
            $file['file_size'] =  filesize($upload_data['save_path']);
            $file['upload_time'] = date("Y-m-d H:i:s",time());
            $file['ext'] = $upload_data['file_ext'];
            $id = $this->document_model->save($file);
            if(in_array($suffix,explode('|',$settings['create_pdf_types']))){
                if(!file_exists($pdf_path)){
                    $this->do_convert($id,$upload_data['save_path']);
                    //临时文件转化方案  之后修改为JAVAWEB服务
                    $this->execInBackground(FCPATH.$upload_data['save_path']);
                }else{
                    $file['create_pdf'] = 1;
                    $file['page'] = $this->_get_page($pdf_path);
                }
            }
            if(!$id){
                $this->json_response(false);
            }
            $this->json_response(true,$file,'上传成功');
        }
        $this->json_response(false);

    }

    private function execInBackground($file_name) {
        header("Content-type:text/html; charset=utf-8");
        if (substr(php_uname(), 0, 7) == "Windows"){
             $cmd = "start /B "."C:/java/jod.bat ".$file_name;
            pclose(popen($cmd,'r'));
        }
        else {
            $cmd = "java -jar /alidata/www/office_to_pdf/jod5.jar ".$file_name;
            pclose(popen($cmd,'r'));
        }
    }


}