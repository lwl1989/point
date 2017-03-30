<?php
/**
 * 项目公用controller
 *
 * @author Cavin <csp379@163.com>
 *
 * @class MY_Controller
 * @package \core
 */


/**
 * Class MY_Controller
 *
 * @property CI_Loader     $load
 * @property CI_Output     $output
 * @property CI_Input      $input
 * @property CI_Log        $log
 * @property CI_Pagination $pagination
 * @property CI_Session    $session
 *
 */
class MY_Controller extends CI_Controller
{
    /**
     * 视图布局名称(layout)
     *
     * @var string
     */
    protected $_layout = 'main';

    /**
     * 模块
     *
     * @var string
     */
    protected $module = '';

    /**
     * 所在模块controllers下的目录名称
     *
     * @var string
     */
    protected $directory = '';

    /**
     * 控制器名称
     *
     * @var string
     */
    protected $controller;

    /**
     * 控制器方法名称
     *
     * @var string
     */
    protected $action;



    /**
     * 赋值给view的数据
     *
     * @var array
     */
    private $_data = array();

    public function __construct()
    {

        parent::__construct();

        //$this->site_info();

        $this->module = $this->router->module;
        $this->controller = $this->router->class;
        $this->action = $this->router->method;

        if (empty($this->module)) {
           $this->directory = trim($this->router->directory, '/');
        } else {
            $str = substr(
                $this->router->directory,
                strpos($this->router->directory, 'controllers')
            );
            $this->directory = substr($str, 12);

            $this->directory = trim($this->directory, '/');
            $this->directory = trim($this->directory, '\\');
        }


        $this->load->helper('url');
        $this->load->helper('my_helper');

    }

    /**
     * 通过二级域名解析分站信息
     *
     * @return array
     */
    protected function parse_site()
    {
        $this->load->helper('cookie');

        preg_match('/^(\w+)\.(.*?)$/i', getenv('HTTP_HOST'), $matches);
        $site['id']=1;
        return $site;
    }

    /**
     * @param int $site_id
     * @param string $site_key
     * @param string $domain
     */
    protected function set_site_cookie($site_id, $site_key)
    {
        $expire = 60*60*24*365;
        set_cookie(array(
            'name' 		=> 'hiioo_site_id',
            'value'		=> $site_id,
            'expire'	=> $expire
        ));
        set_cookie(array(
            'name' 		=> 'hiioo_site_key',
            'value'		=> $site_key,
            'expire'	=> $expire
        ));
    }

    /**
     * 给视图赋值
     *
     * @param string $key 要赋值的变量名称
     * @param mix    $val 变量的值
     */
    public function assign($key, $val)
    {
        $this->_data[$key] = $val;
    }

    /**
     * 调用视图，显示
     *
     * @param string $file 视图文件地址
     */
    public function display($file = '')
    {
        if($file == '') {
            if ($this->router->directory) {
                if (empty($this->module)) {
                    $file = $this->router->directory;

                } else {
                    $str = substr(
                        $this->router->directory,
                        strpos($this->router->directory, 'controllers')
                    );
                    $str = substr($str, 12);
                    $file = $str;
                }
            }
            $file .= $this->router->class . '/'. $this->router->method;
        }

        $layout_file = 'layouts/'. $this->_layout .'.php';

        //调用页面前的调用
        $this->before_display();

        $content = $this->load->view($file, $this->_data, true);

        if (!is_file($this->get_views_path() . $layout_file)) {
            echo $content;
        } else {
            $this->load->view($layout_file, array('layout_content' => $content));
        }
    }

    //在显示页面前，要处理的代码,在具体的controller里面重写
    protected function before_display()
    {

    }

    /**
     * 设置布局模板名称
     *
     * @param string $layout_name
     */
    public function set_layout($layout_name = '')
    {
        $this->_layout = $layout_name;

    }

    /**
     * 获取视图地址
     *
     * @return string
     */
    public function get_views_path() {
        if ($this->router->module == '') {
            return APPPATH . 'views/';
        } else {
            return APPPATH . 'modules/' . $this->router->module . '/views/';
        }
    }

    /**
     * Function: 生成表单的Hash
     *
     * @param string $key 用于区别同一个控制器的不同方法
     *
     * @return string
     */
    public function generate_form_hash ($key = '')
    {
        $chars = md5(uniqid(mt_rand(), TRUE));
        $controller = $this->router->fetch_class(); //获取控制器名称
        $this->session->set_userdata('hash_' . $controller . $key, $chars);
        return $chars;
    }

    /**
     * 验证提交的hash
     *
     * @param string $key  key
     * @param string $hash hash
     *
     * @return boolean
     */
    public function validate_form_hash($key, $hash)
    {
        $controller = $this->router->fetch_class(); //获取控制器名称

        try {
            $tmp_data = $this->session->userdata('hash_' . $controller . $key);
            $this->session->set_userdata('hash_' . $controller . $key, '');
            return $tmp_data == $hash;
        } catch (ErrorException $e) {
            return FALSE;
        }

        return FALSE;
    }

    /**
     * 返回json数据
     *
     * @param bool   $status 状态
     * @param mix  $data   数据
     * @param mix $msg    提示信息
     *
     * @return void
     */
    public function json_response($status = true, $data = array(), $msg = '')
    {
        echo json_encode(array(
            'status' => $status,
            'data' => $data,
            'msg' => $msg,
        ));

        exit;

    }

    /**
     * 获取完整的当前url
     *
     * @return string
     */
    public function get_self_url()
    {
        return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }

    /**
     * Show info message
     *
     * @param   string
     * @return  void
     */
    function _show_message($message, $url = '')
    {
        $this->session->set_flashdata('message', $message);
        redirect($url);
    }


    protected function send_email($type = '', $email  = '', $subject = '', $data = array())
    {
        $this->load->config('email');
        $admin = $this->config->item('admin');

        $data['site_name'] = $admin['name'];


        $this->load->library('email');
        $this->email->from($admin['email'], $admin['name']);
        $this->email->reply_to($admin['email'], $admin['name']);
        $this->email->to($email);

        $this->email->subject(sprintf($subject, $admin['name']));
        $this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
        //$this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
		

        if(!$this->email->send())
        {
            /*echo $this->email->print_debugger();
            throw new Exception('邮件发送失败');*/
            return false;
        }
        return true;

    }


    /**
     * 显示提示信息操作
     *
     * 所显示的提示信息并非完全是错误信息。如：用户登陆时用户名或密码错误，可用本方法输出提示信息
     *
     * 注：显示提示信息的页面模板内容可以自定义. 方法：在项目视图目录中的error子目录中新建message.html文件,自定义该文件内容
     * 显示错误信息处模板标签为<!--{$message}-->
     *
     * 本方法支持URL的自动跳转，当显示时间有效期失效时则跳转到自定义网址，若跳转网址为空则函数不执行跳转功能，当自定义网址参数为-1时默认为:返回上一页。
     * @access public
     * @param string $message       所要显示的提示信息
     * @param string $goto_url      所要跳转的自定义网址
     * @param int    $limit_time    显示信息的有效期,注:(单位:秒) 默认为2秒
     * @param int    $error_no      显示信息类型，注：0-成功 | 1-失败 | 2 提示 
     * @return void
     */
    protected function show_message($message, $error_no=0,$goto_url = null, $limit_time = 2) {

        //参数分析
        if (!$message) {
            return false;
        }

        //当自定义跳转网址存在时
        if (!is_null($goto_url)) {
            $limit_time = 1000 * $limit_time;
            //分析自定义网址是否为返回页
            if ($goto_url == -1) {
                $goto_url = 'javascript:history.go(-1);';
                $message .= '<br/><a href="javascript:history.go(-1);" target="_self">如果你的浏览器没反应,请点击这里...</a>';
            } else{
                //防止网址过长，有换行引起跳转变不正确
                $goto_url = str_replace(array("\n","\r"), '', $goto_url);
                $message .= '<br/><a href="' . $goto_url . '" target="_self">如果你的浏览器没反应,请点击这里...</a>';
            }
            $message .= '<script type="text/javascript">function redirect_url(url){location.href=url;}setTimeout("redirect_url(\'' . $goto_url . '\')", ' . $limit_time . ');</script>';
        }
        $data = array(
            'message' => $message,
            'timer'=>$limit_time/1000,
            'error'=>$error_no
        );
        echo $this->load->view('show_message/index.php', $data, true);
        exit;
    }

    protected function upload_image($file_name, $type, $site_id)
    {
        $this->load->config('upload_images');

        $settings = $this->config->item($type);


        // print_r($settings);exit;

        $file_path = $site_id.'/'.$settings['file_path'].'/'. date('Ym');

        $config = array();
        $config['upload_path'] = FCPATH . 'data/'.$file_path;
        $config['allowed_types'] = $settings['allowed_types'];
        $config['max_size'] = $settings['max_size'];
        $config['file_name'] = random_string('md5').random_string() . '.jpg';
        

        $this->load->library('upload', $config);
        if (!is_dir($config['upload_path'])) {
            _mkdir($config['upload_path']);
        }
        // print_r($_FILES);exit;
        if ( !$this->upload->do_upload($file_name, true))
        {
            return false;
        } else {

            $upload_data = $this->upload->data();
            $upload_data['save_path'] = $file_path . '/' . $upload_data['file_name'];


            $thumbs = $this->config->item($type.'_thumb');
            if ($thumbs) {
            	//print_r($thumbs);
                $this->load->library('image_lib');
                foreach ($thumbs as $key => $thumb) {
                    $thumb_config = array();
                    $thumb_config['image_library'] = 'gd2';
                    $thumb_config['source_image'] = $upload_data['full_path'];
                    $thumb_config['create_thumb'] = false;

                    if (isset($thumb[2]) && $thumb[2] == 1) {
                        $thumb_config['maintain_ratio'] = false;
                    } else {
                        $thumb_config['maintain_ratio'] = TRUE;
                    }


                    $thumb_config['width'] = $thumb[0];
                    $thumb_config['height'] = $thumb[1];
                    $thumb_config['new_image'] = $upload_data['file_path'].$upload_data['file_name'].'_'.$key.'.jpg';
					
					
					if (isset($thumb[3]) && $thumb[3] == 1){
						if(isset($settings['wm_text'])){
							$thumb_config['wm_text'] = $settings['wm_text'];
						}
						if(isset($settings['wm_type'])){
							$thumb_config['wm_type'] = $settings['wm_type'];
						}
						if(isset($settings['wm_overlay_path'])){
							$thumb_config['wm_overlay_path'] = $settings['wm_overlay_path'];
						}
						if(isset($settings['wm_font_path'])){
							$thumb_config['wm_font_path'] = $settings['wm_font_path'];
						}
						if(isset($settings['wm_overlay_path'])){
							$thumb_config['wm_overlay_path'] = FCPATH .'static/img/'.$settings['wm_overlay_path'];
						}
						if(isset($settings['wm_vrt_alignment'])){
							$thumb_config['wm_vrt_alignment'] = $settings['wm_vrt_alignment'];
						}
						if(isset($settings['wm_hor_alignment'])){
							$thumb_config['wm_hor_alignment'] = $settings['wm_hor_alignment'];
						}
						if(isset($settings['wm_hor_offset'])){
							$thumb_config['wm_hor_offset'] = $settings['wm_hor_offset'];
						}
						if(isset($settings['wm_vrt_offset'])){
							$thumb_config['wm_vrt_offset'] = $settings['wm_vrt_offset'];
						}
					}
					
					
					
					//计算等比压缩		
					$image_size = getimagesize($upload_data['full_path']);
					$src_width = $image_size[0];
					$src_height = $image_size[1];
					
					$ratio_w = $src_width/$thumb[0];
					$ratio_h = $src_height/$thumb[1];
					
					if($ratio_w>$ratio_h){
						$thumb_config['width'] = $src_width/$ratio_w;
						$thumb_config['height'] = $src_height/$ratio_w;
					}else{
						$thumb_config['width'] = $src_width/$ratio_h;
						$thumb_config['height'] = $src_height/$ratio_h;
					}
					
					
                    $this->image_lib->initialize($thumb_config);
                    $this->image_lib->resize();
                    
                    $thumb_config['source_image'] = $upload_data['file_path'].$upload_data['file_name'].'_'.$key.'.jpg';
                    $this->image_lib->initialize($thumb_config);

                    if (isset($thumb[3]) && $thumb[3] == 1){
                    	$this->image_lib->watermark();
                    }

                    $this->image_lib->clear();
                }
            }
            /**************************************************************
            [file_name] => 584b66fe8038fccc7a35d5bea82df799dXsQaHPp.jpg
            [file_type] => image/jpeg
            [file_path] => E:/wamp/www/vhosts/alec/1/data/1/ads/201403/
            [full_path] => E:/wamp/www/vhosts/alec/1/data/1/ads/201403/584b66fe8038fccc7a35d5bea82df799dXsQaHPp.jpg
            [raw_name] => 584b66fe8038fccc7a35d5bea82df799dXsQaHPp
            [orig_name] => 584b66fe8038fccc7a35d5bea82df799dXsQaHPp.jpg
            [client_name] => Universe_and_planets_digital_art_wallpaper_albireo.jpg
            [file_ext] => .jpg
            [file_size] => 322.5
            [is_image] => 1
            [image_width] => 1680
            [image_height] => 1050
            [image_type] => jpeg
            [image_size_str] => width="1680" height="1050"
            [save_path] => 1/ads/201403/584b66fe8038fccc7a35d5bea82df799dXsQaHPp.jpg
            ************************************************************************/
            return $upload_data;
        }

    }
	
	protected function save_last_url(){
		$last_url = @$_SERVER['HTTP_REFERER'];
		if(!$last_url)
			$last_url = site_url();
		$this->session->set_userdata('last_url',$last_url);
	}

    protected function get_last_url()
    {
        $service = $this->session->userdata('service');
        $last = $this->session->userdata('last_url');
        $url = ($service?$service:$last);
        if(!$url)
            $url = site_url();
        return $url;
    }
    /*
     * 下个版本去除
     */
    protected function _json($arr){
            echo json_encode($arr);
        exit();
    }
    /*
     * curl下次版本去除
     */
    protected function _curl_file($path){
        $ch = curl_init($path);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_BINARYTRANSFER,true);
        $output = curl_exec($ch);
        return $output;
    }

    /*
     * curl
     */
    protected function _curl_http($path,$printed=false){
        $ch = curl_init($path);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_BINARYTRANSFER,true);
        $output = curl_exec($ch);
        if($printed){
            return $output;
        }
    }
    protected function _curl_http_post($url,$post_data,$printed=false){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        if($printed){
            print_r($output);
        }
    }
    /*
    * 获取文件的名字
    */
    protected function _get_name($file_path){
        $file_name = end(explode("/",$file_path));
        return $file_name;
    }
    /*
    * 获取swf的名字
    */
    protected function _get_swf_name($file_name){
        $name = $this->_change_suffix($file_name,'swf');
        return $name;
    }
    /*
     * 获取pdf的名字
     */
    protected function _get_pdf_name($file_name){
        $name = $this->_change_suffix($file_name,'pdf');
        return $name;
    }

    /*
     * 获取文件的存储路径-》 上传云系统之后淘汰
     */
    protected function _get_path_($file_name,$user_id=false){
        // $file_name = $this->_get_path($file_name);
        if($user_id){
            return $_SERVER['DOCUMENT_ROOT'].'/data/uploads/'.$user_id.'/'.$file_name;
        }else{
            return $_SERVER['DOCUMENT_ROOT'].'/data/uploads/'.$file_name;
        }

    }/**/

    /*
     * 改变文件的后缀
     */
    protected function _change_suffix($file_name,$suffix = 'pdf'){
        $name = $this->_del_suffix($file_name);
        return $name.'.'.$suffix;
    }
    /*
     * 获取文件的后缀名
     */
    protected function _del_suffix($file_name){
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
    /*
     * 获取文件的后缀名
     */
    protected function _get_suffix($file_name){
        return end(explode('.',$file_name));
    }

    /*
     * 获取文件的页数
     */
    protected function  _get_page($file_path,$show=true){
        if(!file_exists($file_path)) return false;
        if(!is_readable($file_path)) return false;
        // 打开文件
        $fp=@fopen($file_path,"r");
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
            if($show){
                echo $max;
            }else{
                return $max;
            }
        }
    }

    /*
     * 获取文件的页数
     */
    protected function  _get_page_by_id($file_id){
        $this->load->model('public/file_base');
        $file = $this->file_base->get_file_by_id($file_id);
        $pdf_path = $this->_get_pdf_name(urldecode($file['file_path']));
        $file_path = $this->_get_path_($pdf_path);
        if(!file_exists($file_path)) return false;
        if(!is_readable($file_path)) return false;
        // 打开文件
        $fp=@fopen($file_path,"r");
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
            return $max;
        }
    }

    /*
     * 生成随机数
     */
    protected function randomString($md5 = false,$nums=15)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $nums; $i++) {
            @$randstring .= $characters[rand(0, strlen($characters))];
        }
        if($md5){
            @$randstring = substr(md5($randstring),0,20);
        }
        return $randstring;
    }

    /*
     * 文件转换接口
     */
    protected function do_convert($file_id,$file_path){
        /*$file_path = FCPATH.$file_path;
        $this->_curl_http('http://127.0.0.1:8090/convert?path='.$file_path.'&id='.$file_id);*/
        return true;
    }
    /*
     * 更新存款信息
     * $order_id 订单号
     * $info 订单信息
     * $company_id 打印店ID
     */
    protected function _source_action($order_id,$info,$company_id){
      //  $this->db->trans_start();
        $document_ids = array();
        $print_nums = array();
        $prices = array();
        $info = json_decode($info,true);
        foreach($info as $val){
            $document_ids = array_merge_recursive($document_ids,array($val['file_id']));
            $print_nums = array_merge_recursive($document_ids,array($val['file_num']));
            $prices = array_merge_recursive($prices,array($val['price']));
        }

        $this->load->model('document/document_model');
        $this->document_model->db->trans_begin();
        $documents = $this->document_model->get_document_by_ids($document_ids);
        $this->load->model('company/company_base');
        $company = $this->company_base->get_company_by_id($company_id);
        $self_sale = floatval($company['self_sale'])/100;  //商家给我们的价格比例
        $time = date('Y-m-d H:i:s',time());
        $total_payment = 0;
        $this->load->model('user/deposit_msg');
        /*
         * 每个文件不同用户
         */
        foreach($documents as $key=>$val){
            $payment = $prices[$key]*$self_sale;  //商家从此文件获取的钱
            $total_payment += $payment;           //商家获取总金额
            $user_id = $val['user_id'];
            $return_user_score = ($prices[$key]-$payment)*0.4;
            $data = array(
                'user_id'   => $user_id,
                'score'    => $return_user_score,
                'source_id' => $order_id,
                'create_time'   =>  $time,
                'actions'   =>  'order',
                'is_true'       =>  1
            );
            //用户表自加  打印数  打印积分
            $this->document_model->update_print_count($val['id'],$print_nums[$key]);
            $this->deposit_msg->update_users_deposit($user_id,$data['score']);
            //存款记录表
            $this->deposit_msg->insert($data);
        }

        /*
         * 更新打印店端信息
         */
        $this->company_base->update_company_payment($company_id,$total_payment);
        $this->load->model('company/company_payment');
        $payment_data = array(
            'company_id'    =>  $company_id,
            'actions'       =>  'order',
            'source_id'     =>  $order_id,
            'create_time'   =>  $time,
            'score'         =>  $total_payment,
            'is_true'       =>  1
        );
        $this->company_payment->insert($payment_data);
        $this->company_payment->db->trans_complete();
    }


}

