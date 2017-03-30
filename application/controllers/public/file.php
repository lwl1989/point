<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-2-2
 * Time: 下午2:07
 */
class file extends  MY_Portal_Controller
{
    function __construct(){
        parent::__construct();
        $this->_login_user = $this->session->userdata('login_user');
    }

    function index(){
        echo uri_string().'<br/>';
        echo current_url().'<br/>';
        echo uri_string().'<br/>';
    }

    function upload(){
        $this->auth();
        $this->assign('css_load',array('index','upload','bootstrap'));
        $this->assign('head_title','文件上传');
        $this->assign('file_upload_url',base_url().'static/FileUpload/');
        $this->load->model('classify/classify_model');
        $classify = $this->classify_model->select_classify_by_user($this->_login_user['user_id']);
        $this->assign('classify',$classify);
        $this->display();
    }

    function do_upload(){
        $this->config->load('upload');
        $config = $this->config->item('file_url');
        $config['user_id']  = $this->_login_user['user_id'];
        $this->load->library('File_upload',$config);
    }
    /*
     * 确认上传
     * method:post
     * param:
     *       file_info:json
     */
    function sure_upload(){
        $json = $this->input->post('files');
        $files = json_decode($json,true);
        $this->load->model('public/file_uploads');
        $err = array();
        foreach($files as $file){
            $file['user_id'] = $this->_login_user['user_id'];
            $file['file_path'] = urlencode($file['file_path']);
            $file['file_type'] = $this->_get_suffix($file['file_path']);

            $pdf_path = $this->_change_suffix($file['file_path'],'pdf');
            $file['title'] = $this->_del_suffix($file['title']);
            if(file_exists($pdf_path)){
                 $file['create_pdf'] = 1;
            }
            $result = $this->file_uploads->save($file);
            if(!$result){
                array_push($err,$file);
            }
        }
        if(count($err)){
            $this->json_response(false,"",$err);
        }
        $this->json_response(true);
    }
    /*
     * 上传的时候删除
     * 直接删除源文件
     */

    function do_del($file_id){
        $this->load->model('public/file_base');
        $file = $this->file_base->get_file_by_id($file_id);
        $file_path = $file['file_path'];
        $real_file_name = iconv('utf-8','gbk',urldecode($this->_get_name($file_path)));
        $swf_file_name = $this->_change_suffix($real_file_name,'swf');
        $pdf_file_name = $this->_change_suffix($real_file_name,'pdf');
        $swf_path = $this->_get_path_($swf_file_name);
        $pdf_file_path = $this->_get_path_($pdf_file_name);
        $file_path = $this->_get_path_($real_file_name);
        @unlink ($swf_path);
        @unlink ($pdf_file_path);
        @unlink ($file_path);
        $this->file_base->del($file_id);
        $this->json_response(true);
    }

    function test(){
        $this->assign('css_load',array('index','upload','bootstrap'));
        $this->assign('head_title','文件上传');
        $this->assign('file_upload_url',base_url().'static/FileUpload/');
        $this->load->model('classify/classify_model');
        $classify = $this->classify_model->select_classify_by_user($this->_login_user['user_id']);
        $this->assign('classify',$classify);
        $this->display();
    }

    function do_upload_test(){
        $this->config->load('upload');
        $config = $this->config->item('file_url');
        $config['user_id']  = $this->_login_user['user_id'];
        $this->load->library('File_upload_1',$config);
    }

    /*
     * flexpaper获取数据
     */
    function view($file_id = 0)
    {
        header('Content-type:application/x-shockwave-flash;charset=utf-8');
        $this->load->model('public/file_base');
        $file = $this->file_base->get_file_by_id($file_id);
        if (!$file['create_pdf']) {
            exit('404,not found the file!');
        }
    //  $pdf_path = iconv('utf-8', 'gbk', urldecode($this->_get_pdf_name($file['file_path'])));
        $swf_path = $this->_get_path_($file['title'].'.swf',$file['user_id']);
        $pdf_path = $this->_get_path_($file['title'].'.pdf',$file['user_id']);
        $http_swf_path = $this->_get_swf_name(base_url('data/uploads').'/'.urldecode($file['file_path']));
        //echo $this->_curl_file($http_swf_path);
        if (file_exists($swf_path)) {
            echo $this->_curl_file($http_swf_path);
        }else{
            $this->load->library("Flexpaper");
            $output = $this->flexpaper->convert($pdf_path, $swf_path);
            if (rtrim($output) === "[Converted]") {
                /* header('Content-type: application/x-shockwave-flash');
                 header('Accept-Ranges: bytes');
                 header('Content-Length: ' . filesize($swf_path));
                 echo file_get_contents($swf_path);*/
                echo $this->_curl_file($http_swf_path);
            } else {
                echo $output;
            }
        }
    }

    private function _curl_file($path){
        $ch = curl_init($path);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_BINARYTRANSFER,true);
        $output = curl_exec($ch);
        return $output;
    }

    /*
     * 显示文件界面
     */

    function show($file_id = 0,$classify_id = 0){
        $this->_layout = '';
        $this->load->model('public/file_base');
        $file = $this->file_base->get_file_by_id($file_id);
        if(!$file['create_pdf']){
            exit('404,not found the file!');
        }
       /* $config = array(
            'source_charset'=>'utf-8',
            'target_charset'=>'utf-8',
            'load_all'  =>  false
        );
        $this->load->library('phpanalysis',$config);
        $this->phpanalysis->SetSource($file['title']);
        $this->phpanalysis->differMax = false;
        $this->phpanalysis->unitWord = false;
        $this->phpanalysis->StartAnalysis( false );
        $result = $this->phpanalysis->GetFinallyResult(' ', true);
        $result = explode(' ',$result);
        $recommend = array();
        $j=count($recommend);
        $not_in = array();
        $not_in[0] =$file['id'];
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

        $tag = explode(',',$file['tag']);
        foreach($tag as $value){
            $back = $this->file_base->get_tag_like($value,$not_in);
            if(!is_null($back)){
                $recommend[$j]=$back;
                foreach($back as $v)
                {
                    $not_in[$i] = $v['id'];
                    $i++;
                }
                $j++;
            }
        }*/
        //urldecode($this->_get_pdf_name($file['file_path']));

       // $this->assign('pdf_path',$pdf_path);
       // $this->assign('recommend',$recommend)
        $this->assign('file',$file);
        $this->display();
    }

    /*
     * flex备用
     */
    function num_pages($file_id){
        $this->load->model('public/file_base');
        $file = $this->file_base->get_file_by_id($file_id);
        $pdf_path = urldecode($this->_get_pdf_name($file['file_path']));
        $swf_path = $this->_get_swf_name($pdf_path);
        if(!file_exists($swf_path)){
            $this->load->library("flexpaper");
            $output = $this->flexpaper->convert($pdf_path,$swf_path);
            if(rtrim($output) === "[Converted]"){
                $pagecount = count(glob($swf_path));
            }
        }else{
            $pagecount = count(glob($swf_path));
        }
        if($pagecount!=0)
            echo $pagecount;
        else
            echo $output;
    }

    /*
     *
     */
    function do_down(){
        $this->auth();
        $this->load->model('classify/classify_model');
        $classify = $this->classify_model->select_classify_by_user($this->_login_user['user_id']);
        var_dump($classify);
    }


    private function _get_name($file_path){
        $file_name = end(explode("/",$file_path));
        return $file_name;
    }
    private function _get_swf_name($file_name){
        $name = $this->_change_suffix($file_name,'swf');
        return $name;
    }
    private function _get_pdf_name($file_name){
        $name = $this->_change_suffix($file_name,'pdf');
        return $name;
    }

    private function _get_path_($file_name,$user_id=false){
        // $file_name = $this->_get_path($file_name);
        if($user_id){
            return $_SERVER['DOCUMENT_ROOT'].'/data/uploads/'.$user_id.'/'.$file_name;
        }else{
            return $_SERVER['DOCUMENT_ROOT'].'/data/uploads/'.$this->_login_user['user_id'].'/'.$file_name;
        }

    }/**/

    private function _change_suffix($file_name,$suffix = 'pdf'){
        $name = $this->_del_suffix($file_name);
        return $name.'.'.$suffix;
    }
    private function _del_suffix($file_name){
        $arr = explode('.',$file_name);
        $name ='';
        for($i=0;$i<count($arr)-1;$i++){
            if($i!=0){
                $name .= '.'.$arr[$i];
            }else{
                $name .= $arr[$i];
            }
        }
        return $name;
    }
    private function _get_suffix($file_name){
        return end(explode('.',$file_name));
    }

    private function _office_to_pdf($file_path) {
        header("Content-type:text/html; charset=utf-8");
        if (substr(php_uname(), 0, 7) == "Windows"){
            $cmd = "C:/jod.bat ".$file_path;
            pclose(popen($cmd,'r'));
        }
        else {
            $cmd = "java -jar /alidata/www/office_to_pdf/jod5.jar ".$file_path;
            pclose(popen($cmd,'r'));
        }
    }
}