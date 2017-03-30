<?php
/**
 *
 *
 * class MY_City_Manage_Controller
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-9-28
 * Time: 下午4:31
 */

class MY_Site_Manage_Controller extends MY_Controller
{

    /**
     * @var int
     */
    protected $_site_id;

    /**
     * 分站管理员
     *
     * @var array
     */
    protected $site_admin;

    /**
     * @var Tank_auth
     */
    public $tank_auth;

    /**
     * @var resource_acl_model
     */
    public $resource_acl_model;

    public function __construct()
    {
        parent::__construct();

        //解析站点信息
        $site = $this->parse_site();
        $this->_site_id = 1;//$site['id'];

        $this->assign('static', '/static/m-site/');
        $this->assign('views_path', $this->get_views_path());

        $this->load->helper('file_helper');
        $this->load->helper('status_helper');
        $this->load->helper('enum_helper');
        $this->load->helper('image');

        //用户认证
        $this->load->library('tank_auth');

        $this->auth();

    }

    protected function auth()
    {
        $this->site_admin = $this->session->userdata('site_admin');
        if ($this->controller != 'login') {
            if (!$this->site_admin) {
                redirect('m-site/login');
            }
          $mapper = include dirname(__FILE__) . '/../modules/m-site/resource_mapper.php';

                $menus = $mapper['menus'];


            $this->assign('menus', $menus);
            $this->assign('site_admin', $this->site_admin);
            $this->assign('index_channel','system');
        }
    }

    public function get_site_id()
    {
        return $this->_site_id;
    }


}