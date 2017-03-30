<?php 
/**
 * 默认门户的基础控制器
 *
 * class MY_Portal_Controller
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-11-4
 * Time: 下午10:50
 */

class MY_Portal_Controller extends MY_Controller
{
    public $_site_id;
	protected $error_message=array(
		'10001' =>  array(	'message'	=>	'异常错误',				'field'		=>	'post value'),
		
		'10201'	=>	array(	'message' 	=>	'此邮箱可以用于注册',	'field'		=>	'email'),
		'10202'	=>	array(	'message' 	=>	'此邮箱已经被注册了',	'field'		=>	'email'),
		'10203'	=>	array(	'message' 	=>	'邮箱格式错误',			'field'		=>	'email'),
		'10204' =>  array(	'message'	=>	'此邮箱尚未注册',		'field'		=>	'email'),
		
		'10301'	=>	array(	'message' 	=>	'此手机号可以用于注册',	'field'		=>	'mobile'),
		'10302'	=>	array(	'message' 	=>	'此手机号已经被注册',	'field'		=>	'mobile'),
		'10303'	=>	array(	'message' 	=>	'此手机号格式',			'field'		=>	'mobile'),
		'10304'	=>	array(	'message' 	=>	'此手机号未绑定',		'field'		=>	'mobile'),
		'10305'	=>	array(	'message' 	=>	'手机号正确',			'field'		=>	'mobile'),
		'10306' =>  array(	'message'	=>	'手机号错误',			'field'		=>	'mobile'),
		
		'10401'	=>	array(	'message' 	=>	'验证码正确',			'field'		=>	'verify'),
		'10402'	=>	array(	'message' 	=>	'验证码过期',			'field'		=>	'verify'),
		'10403'	=>	array(	'message' 	=>	'验证码错误',			'field'		=>	'verify'),
		'10404'	=>	array(	'message' 	=>	'请勿在1分钟内反复提交','field'		=>	'verify'),
		'10405'	=>	array(	'message' 	=>	'验证码发送成功',		'field'		=>	'verify'),
		'10406'	=>	array(	'message' 	=>	'发送验证码失败',		'field'		=>	'verify'),
		'10407' =>	array(	'message'	=>	'发送邮件失败',			'field'		=>	'new_pass_key'),
		'10408' =>	array(	'message'	=>	'发送邮件成功',			'field'		=>	''),
						
		'10801'	=>	array(	'message' 	=>	'注册成功',				'field'		=>	''),
		'10802'	=>	array(	'message' 	=>	'注册失败',				'field'		=>	''),
		'10803'	=>	array(	'message' 	=>	'确认密码错误',			'field'		=>	're_password'),
		'10804'	=>	array(	'message' 	=>	'密码格式错误',			'field'		=>	'password'),
		'10808'	=>	array(	'message' 	=>	'修改密码成功',			'field'		=>	'password'),			
		'10809'	=>	array(	'message' 	=>	'修改密码异常错误',		'field'		=>	'password'),

		'10901'	=>  array( 	'message'	=>	'账户激活成功',			'field'		=>	''),
		'10902'	=>  array( 	'message'	=>	'账户激活失败',			'field'		=>	'activate_email_key'),
		'10903'	=>  array( 	'message'	=>	'激活码错误',			'field'		=>	'activate_email_key')
	);
    protected $_login_user=false;
	public function __construct()
	{
		parent::__construct();



        $this->load->helper('my_helper');
        $this->load->helper('static_helper');
        $this->load->helper('image_helper');

        $this->load->helper('text');
        $this->assign('css_load',array('public'));
        $this->assign('static', '/static');
        $this->assign('views_path', $this->get_views_path());

       // $this->_layout = '';
        //加载用户认证库
        $this->load->library('tank_auth');

        $this->_login_user= $this->session->userdata('login_user');

        $this->assign('css_load',array('public','logined'));
	}

    /*
     * 登录验证
     */
	public function auth($type = 'user'){
        if($type=='company'){
            if(!$this->session->userdata('login_user')) {
                $service = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $this->session->set_userdata('service', $service);
                if ($this->controller != 'login') {
                        redirect('company/login');
                }
            }else{
                return true;
            }
        }else
		if(!$this->session->userdata('login_user')){
            $service = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $this->session->set_userdata('service',$service);
            redirect('auth/login');
        }
    }
    /*
     * json形式返回的登录验证  status:9
     */
    function auth_json(){
        if(!$this->session->userdata('login_user')){
            $service = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $this->session->set_userdata('service',$service);
            $this->json_response(9,'','请登录');
        }
    }


    //调用页面前要处理的代码
    /*
     * 页面加载前进行赋值的数据
     */
    protected function before_display()
    {
        if ($this->tank_auth->is_logged_in()) {
            $this->assign('login_user',$this->_login_user);
            $this->assign('logined',1);
            $this->load->model('user/user_model');
            $user = $this->user_model->get_user_by_id($this->_login_user['user_id']);
            $this->assign("user",$user);
            $this->assign("user_id",$this->_login_user['user_id']);
            $this->load->model('document/document_model');
            $this->load->model('user/user_model');
            $statistics = $this->user_model->get_users_num($this->_login_user['user_id']);
            $statistics['document_num'] = $this->document_model->get_document_num($this->_login_user['user_id']);

            $count_message = $this->user_model->get_user_count();
            $count_message['document_count'] =  $this->document_model->count_documents();
            $this->assign('count_message',$count_message);

            $this->assign('statistics',$statistics);
        }else{
            $this->assign('logined',0);
        }

      //  $this->page_header();

    }

    /*
     * 获取完全的路径
     */
    protected function get_full_url() {
        $https = !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') === 0 ||
            !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;
        return
            ($https ? 'https://' : 'http://').
            (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
            (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
                ($https && $_SERVER['SERVER_PORT'] === 443 ||
                $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
            substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }


    /**
     * 分类面板
     *
     * @param bool $showCateTree
     * @return mixed
     */
    protected function categories_panel()
    {
        $this->load->config('data/classifies', true);
        $classify = $this->config->item('data/classifies');
        $this->assign('categories_panel',$classify);
    }

    /**
     * 用户操作积分更新
     *
     * @param $user_id
     * @param $action
     * @return bool 积分是否已更新
     */
    public function user_action($user_id, $action, $data = array())
    {
        if (empty($action)) {
            return false;
        }

        $this->load->config('user_actions');
        $config = $this->config->item($action);

        if (!$config) {
            return false;
        }
        $this->load->model('user/user_action_model');
        //登陆每天只新增一次积分
        if (isset($config['today_first']) && $config['today_first'] == 1) {
            if ($this->user_action_model->today_had_done($user_id, $action)) {
                return false;
            }
        }
        //第一次操作有积分
      /*  if (isset($config['first']) && $config['first'] == 1) {
            if ($this->user_action_model->had_done($user_id, $action)) {
                return false;
            }
        }
        //如果用户操作获取的积分成长值要确认
        if (isset($config['need_confirm']) && $config['need_confirm'] == 1) {
            $is_usefull = 0;
        } else {
            $is_usefull = 1;
        }

        if ($this->user_action_model->add_action(
            $user_id, $action,$config['score'], $config['grow'], $is_usefull, $data)
        ) {
            return $config;
        }
        return false;*/
        //用户操作处理
    }

    /*
     * 重写的json =>错误码
     */
	protected function return_json($error_num,$message='',$url='')
	{
		if($message=='')
			$message=$this->error_message[$error_num]['message'];
		$this->json_response($error_num,array('field' => $this->error_message[$error_num]['field'],'last_url' => $url),$message );
	}


    /*
     * 获取购物车
     */
    protected function  get_cart($user_id = null){
        $cart = $this->session->userdata('cart');
        if(!$user_id){
            if(!$cart){
                return null;
            }else{
                return $cart;
            }
        }else{
            $this->load->model('user_model');
            $message = $this->user_model->get_cart(intval($user_id));
            $arr_file = json_decode($message['file_info'],true);
            if(!$cart)
                return $message;
            $cart = array_merge($cart,$arr_file);

            foreach ($cart as &$row) {
                $row = serialize($row);
            }
            unset($row);

            $cart = array_unique($cart);
            foreach ($cart as &$row) {
                $row = unserialize($row);
            }
            unset($row);

            $result=array();
            $tmp_arr=array();
            foreach ($cart as $row) {
                $tmp_arr[$row['id']][] = $row['num'];
            }

            foreach ($tmp_arr as $sku => $num) {
                $count= count($num);
                $nums = $num[$count-1];
                $result[] =  array('id'=>$sku, 'num'=>$nums);
            }
            return $cart;
        }

    }
	
}