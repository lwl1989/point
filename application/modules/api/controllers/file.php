<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-7
 * Time: 上午9:29
 */
class file extends MY_Api_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('public/file_base');
    }


    function select($classify_id=0,$page=1,$page_size=20){
        $offset = ($page-1)*$page_size;
        $file = $this->file_base->select($classify_id,$page_size,$offset);
        if(count($file)>1)
            $this->_json(array('state'=>true,'file'=>$file));
        $this->_json(array('state'=>true,'file'=>$file));
    }

    function show($file_id){
        $file = $this->file_base->get_file_by_id($file_id);
        if(!$file['create_pdf']){
            $this->_json(array('state'=>false,'msg'=>'此文档暂时不支持预览'));
        }else{
            $pdf_path = urldecode($this->_get_pdf_name($file['file_path']));
            $this->_json(array('state'=>true,'file'=>$file,'view_path'=>$pdf_path));
        }
    }

    function select_classify(){
        $this->load->model('classify/classify_model');
        $classify = $this->classify_model->select_classify_by_system();
        if(!$classify){
            $this->_json(array('state'=>false,'msg'=>'no classify'));
        }else{
            $this->_json(array('state'=>true,'classify'=>$classify));
        }
    }


}