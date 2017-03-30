<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-2-2
 * Time: 下午2:07
 */
class operate extends  MY_Portal_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_login_user = $this->session->userdata('login_user');
    }

    function testuploadview(){

        $this->_layout='';
        $this->auth();
        $this->assign('css_load',array('user_account','uploadify'));
        $this->assign('head_title','文件上传');
        $this->display();
    }
    /*
     * uploadify的上传接口
     */
    function testupload(){
        $this->config->load('upload');
        $config_rule = $this->config->item('file_conf');
        $user_id  = $this->_login_user['user_id'];
        $config['upload_path'] = $config_rule['upload_path'].$user_id.'/';
        $config['allowed_types'] = $config_rule['allowed_types'];
        $config['max_size'] = $config_rule['max_size'];
        $config['save_name'] = random_string('md5').random_string();
        if (!is_dir($config['upload_path'])) {
            _mkdir($config['upload_path']);
        }
        $this->load->library('upload',$config);
        $this->upload->do_upload("file");
        $str = $this->upload->display_errors("","");
        if($str!=''){
            $this->json_response(false,$this->upload->data(),$str);
        }else{
            $this->load->model('document/document_model');
            $data = $this->upload->data();
            $insert_data = array(
                'user_id'   =>  $user_id,
                'title'     =>  $data['raw_name'],
                'file_path' =>  $data['full_path'],
                'file_size' =>  $data['file_size'],
                'ext'       =>  $data['file_ext'],
                'file_type' =>  $data['file_type'],
                'md5'       =>  md5_file($data['full_path'])
            );

            $file_id=$this->document_model->insert($insert_data);
            //如果正确的插入了数据并且属于需要转换的文件  curl post

            if($file_id>0 and in_array($insert_data['ext'],explode('|',$config_rule['create_pdf_types']))){
                $config_url = $this->config->item('convert');
                $this->_curl_http_post($config_url['url'],
                    array(
                        'file_id'=>$file_id,
                        'user_id'=>$user_id,
                        'file'=>curl_file_create($data['full_path'])
                    ));
            }
            if(!in_array($insert_data['ext'],explode('|',$config_rule['create_pdf_types']))){
                $config_wanpitu = $this->config->item('upload_key');
                $ak  = $config_wanpitu['ak'];
                $sk  = $config_wanpitu['sk'];
                $this->load->library("Alibaba_image");
                $this->alibaba_image->set('ak',$ak);
                $this->alibaba_image->set('sk',$sk);
                $res = $this->alibaba_image->do_upload($user_id,$data['save_name'],$data['full_path']);
                //update_by_convert($document_id,$doc_path,$file_type,$swf_file_path,$file_size,$page)
                // page = 0  不提供打印
                $this->document_model->update_by_convert($file_id,$res['url'],$res['mimeType'],'',$res['fileSize'],0);
            }
        }
        $this->json_response(true,$this->upload->data(),"上传结束");
    }

    function upload(){
        $this->auth();

        $this->assign('css_load',array('index','upload','bootstrap'));
        $this->assign('head_title','文件上传');
        $this->assign('file_upload_url',base_url().'static/FileUpload/');
        $this->display();
    }
    function  get_classify($fid=0)
    {
        $this->load->config('data/classifies', true);
        $classify = $this->config->item('data/classifies');
        if ($fid != 0) {
            foreach ($classify as $v) {
                if ($v['id'] == $fid) {
                    return $v['children'];
                }
            }
        }
        return $classify;
    }

    /*
     * fileUpload上传接口
     */
    function do_upload(){
        $this->config->load('upload');
        $config = $this->config->item('file_url');
        $config['user_id']  = $this->_login_user['user_id'];
        $this->load->library('File_upload',$config);
    }
        /*
         * fileUpload上传接口完善信息
         */
    function uploaded(){
        $this->assign('head_title','文件上传 - 完善信息');
        $this->load->model('document/document_model');
        $ids = json_decode($this->session->userdata('file_upload_ids'),true);
        $files = $this->document_model->get_document_by_ids($ids);
        $this->assign('files',$files);
    }
            /*
             * 完成上传
             */
    function do_upload_document_info(){
        $this->load->model('document/document_model');
        $json = $this->input->post('files');
        $files = json_decode($json,true);
        if(!is_array($files) or count($files)<0){
            $this->json_response(false,'','数据错误');
        }
        foreach($files as $file) {
            $data['file_classify'] = $file['file_classify'];
            $data['id'] = $file['id'];
            $data['intro'] = $file['intro'];

            if($file['tag']){
                $data['tag'] = $file['tag'];  //{'tag1','tag2','tag3'}
                $tags = json_decode($file['tag'],true);
                $this->load->model('document/document_tags');
                foreach($tags as $tag){
                    $exists = $this->document_tags->getOne(array('is_del'=>0,'tag'=>$tag));
                    if($exists){
                        $this->document_tags->tag_add_num($exists['id']);
                    }else{
                        $this->document_tags->insert(array('tag'=>$tag));
                    }
                }
            }
            $this->document_model->insert($data);
        }
        redirect('/user/document');
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
        $this->load->model('document/document_model');
        $err = array();
        $ids = array();
        foreach($files as $file){
            //获取PDF的路径
            $pdf_path = $this->_get_pdf_name($file['file_path']);
            $pdf_path = $this->_get_path_($pdf_path);
            $file['ext'] = '.'.$this->_get_suffix($file['file_path']);
            //数据库存储优化
            $file_path = $file['file_path'];
            $file['user_id'] = $this->_login_user['user_id'];
            $file['file_path'] = urlencode($file['file_path']);
            $file['title'] = $this->_del_suffix($file['title']);

            if(file_exists($pdf_path)){
                $file['create_pdf'] = 1;
                $file['page'] = $this->_get_page($pdf_path,false);
            }

            $id = $this->document_model->save($file);

            if(!$id){
                array_push($err,$file);
            }else{
                $ids[] = $id;
                if(!$pdf_path)
                    $this->do_convert($id,$this->_get_path_($file_path));
            }
        }
        $this->session->set_userdata('file_upload_ids',json_encode($ids));
        //redirect('document/operate/uploaded');
        if(count($err)){
            $this->json_response(false,"",$err);
        }
        $this->json_response(true,"",site_url('document/operate/uploaded'));
    }

    /*
     * 上传的时候删除
     * 直接删除源文件
     */
    function do_del($file_id){
        $this->load->model('public/file_base');
        $file = $this->file_base->get_file_by_id($file_id);
        $file_path = $file['file_path'];
        $real_file_name = urldecode($this->_get_name($file_path));
        $swf_file_name = $this->_change_suffix($real_file_name,'swf');
        $pdf_file_name = $this->_change_suffix($real_file_name,'pdf');
        //$swf_path = $this->_get_path_($swf_file_name);
       // $pdf_file_path = $this->_get_path_($pdf_file_name);
        $file_path = $this->_get_path_($real_file_name);
        //@unlink ($swf_path);
        //@unlink ($pdf_file_path);
        @unlink ($file_path);
        $this->file_base->del($file_id);
        $this->json_response(true);
    }

    /*
     * flexpaper获取数据
     */
    function view($file_id = 0,$ext="swf")
    {
        header('Content-type:application/x-shockwave-flash;charset=utf-8');
        $ext = $this->input->get('ext')?$this->input->get('ext'):$ext;
        $ext = $ext?$ext:'swf';
        $file_id = intval($file_id);
        if($file_id<0){
            $this->json_response(false,'','document id error');
        }
        $this->load->model('public/file_base');
        $file = $this->file_base->get_file_by_id($file_id);
        if(!$file){
            $this->json_response(false,'','document not exists');
        }
        if (!$file['swf_file_path']) {
            $this->json_response(false,'','document not to convert');
        }
        $file['file_path'] = urldecode($file['file_path']);
       // $pdf_path = $this->_get_pdf_name($file['file_path']);
       // $swf_path = $this->_change_suffix($pdf_path,'swf');
       // $pdf_path = $this->_get_path_($pdf_path);
        $swf_path = $this->_get_path_($file["swf_file_path"]);
       // $file_path = $this->_change_suffix($pdf_path,$ext);
       /* switch($ext){
            case 'self':
                $http_path = base_url('data/uploads').'/'.$file['file_path'];
                break;
            case 'pdf':
                $http_path = $this->_get_pdf_name(base_url('data/uploads').'/'.$file['file_path']);
                break;
            default:
                $http_path = $this->_get_swf_name(base_url('data/uploads').'/'.$file['file_path']);
        }
*/
        echo $this->_curl_file($swf_path);
 /*       if (file_exists($file_path)) {
                echo $this->_curl_file($http_path);
            }else{
                if($ext=='swf'){
                    $this->load->library("Flexpaper");
                    $output = $this->flexpaper->convert($pdf_path, $swf_path);
                    if (rtrim($output) === "[Converted]") {
                        echo $this->_curl_file($http_path);
                    } else {
                        echo $output;
                    }
                }else {
                    echo $this->_curl_file($http_path);
                }
        }*/
    }


    /*
     * 显示文件界面
     */

    function show($file_id = 0,$classify_id = 0){
        $page = $this->input->get('page')?$this->input->get('page'):1;
        $this->load->model('document/document_model');
        $file = $this->document_model->getOne(array('id'=>$file_id));
        if(!$file["swf_file_path"]){
            $this->show_message('没有内容可以显示噢',0,'/',2);
        }
        $this->load->model('document/document_comment');
        $conditions = array('is_del'=>0,'document_id'=>$file_id);
        $base_url = url_query($conditions, '/m-site/classifies/index');

        $this->session->set_userdata(
            'back_list_page',
            $this->get_self_url()
        );

        $comments = $this->document_comment->pagination($base_url, $page, $conditions, 'id desc');
        //var_dump($comments);
        $this->assign('comments',$comments);
        $this->assign('head_title','文件预览 - '.$file['title']);
        $this->assign('file',$file);
        $this->display();
    }



    function search(){
        $this->load->model('public/file_base');
        $keyword = $this->input->post('keyword')?$this->input->post('keyword'):$this->input->get('keyword');
        if(!$keyword){
            $this->assign('no_key',1);
        }else{
            $this->assign('no_key',0);
        }
        $this->assign('head_title','搜索 -'.$keyword);
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


        $search = array();
        $not_in = array();

        foreach($result as $v){
            if($v!="")
            {
                $back = $this->file_base->get_like($v,$not_in);
                if(is_array($back)){
                    $search = array_merge_recursive($search,array($back));
                    foreach($back as $v)
                    {
                        //$not_in[$i] = $v['id'];
                        $not_in = array_merge_recursive($not_in,array($v['id']));
                    }
                }
            }
        }

        $this->assign('search',$search[0]);
        $this->display();
    }

    function down($file_id){
        if (!intval($file_id)) {
            $this->json_response(false,'','document not exists;');
        }
        if(!$this->_login_user){
            $this->json_response(false,'','login user not exists');
        }
        $this->load->model('public/file_base');
        /*
         * 文件下载数加1
         * 获取文件信息
         */
        $file = $this->file_base->get_file_by_id($file_id);
        if(!$file or $file['is_del']){
            $this->json_response(false,'','document not exists;');
        }
        $user_id = $file['user_id'];
        $this->file_base->download_count_increment($file_id);
        if($user_id){
            $this->load->model('user/user_download');
            $down_load = array('user_id'=>$this->_login_user['user_id'],'document_id'=>$file_id);
            //如果此用户没有下载过此文件
            if(!$this->user_download->exists_download($down_load)){
                $down_load['download_time'] = date('Y-m-d H:i:s');
                $this->user_download->update_users_score($user_id,1);
                $this->user_download->insert($down_load);
                $this->load->model('user/deposit_msg');
                $data = array(
                    'actions'   => 'be_downloaded',
                    'source_id' => $file_id,
                    'score'     => 1,
                    'create_time'   =>  date("Y-m-d H:i:s",time()),
                    'user_id'   =>$user_id
                );
                $this->deposit_msg->insert($data);
            }
        }
        /*
         * 从配置文件中获取到BUFF
         */
        $this->load->config('document',true);
        $buffer=$this->config->item('document')['down_load']['buffer'];
        ("Content-type:text/html;charset=utf-8");
        $file_name = iconv('utf-8','gb2312',$file['title']).$file['ext'];
        $file_path=$file["swf_file_path"];//读取网盘
        if(!file_exists($file_path)){
            echo "没有该文件文件";
            return ;
        }
        $fp=fopen($file_path,"r");
        $file_size=filesize($file_path);
        //下载文件需要用到的头
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length:".$file_size);
        Header("Content-Disposition: attachment; filename=".$file_name);

        $file_count=0;
        //向浏览器返回数据
        while(!feof($fp) && $file_count<$file_size){
            $file_con=fread($fp,$buffer);
            $file_count+=$buffer;
            echo $file_con;
        }
        fclose($fp);
    }

    /*
     * flex备用

    function num_pages($file_id){
        $this->load->model('public/file_base');
        $file = $this->file_base->get_file_by_id($file_id);
        $pdf_path = $this->_get_pdf_name(urldecode($file['file_path']));
        $swf_path = $this->_change_suffix($pdf_path,'swf');
        $pdf_path = $this->_get_path_($pdf_path);
        //echo $swf_path = $this->_get_path_($swf_path);
        //var_dump(file_exists($swf_path));
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

    function http_get_page($file_id){
        $this->load->model('public/file_base');
        $file = $this->file_base->get_file_by_id($file_id);
        $pdf_path = $this->_get_pdf_name(urldecode($file['file_path']));
        $path = $this->_get_path_($pdf_path);
        if(!file_exists($path)) return false;
        if(!is_readable($path)) return false;
        // 打开文件
        $fp=@fopen($path,"r");
        if (!$fp) {
            return false;
        }else {
            $max=0;
            while(!feof($fp)) {
                $line = fgets($fp,255);
                if (preg_match('/\/Count [0-9]+/', $line, $matches)){
                    preg_match('/[0-9]+/',$matches[0], $matches2);
                    if ($max<$matches2[0]) $max=$matches2[0];
                }
            }
            fclose($fp);
            echo $max;
        }
    }

    function do_convert($document_id,$file_path){
        $this->load->config('document',true);
        $convert_url = $this->config->item('document')['convert'];
        $convert_url .= '?id='.$document_id.'&path='.$file_path;
        $this->_curl_http($convert_url);
    }




    function test($file_id=false){
       /* $this->load->model('public/file_base');
        $files = $this->file_base->select();

        foreach($files as $file){
            $pdf_path = $this->_get_path_($this->_get_pdf_name(urldecode($file['file_path'])));
            $page = $this->_get_page($pdf_path,false);
            if($page>0){
                $result = $this->file_base->set_page($page,$file['id']);
                echo $file['id'];
               var_dump($this->file_base->db->last_query().'<br/>');
               // var_dump($file['page']);
            }

        }
        echo FCPATH;
        $this->_layout='';
        $this->display();
       // echo '321312';
       //
        //var_dump($page);
       // var_dump($this->session->userdata('cart'));
    }

    */

}