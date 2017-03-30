<?php
/**
 * admin模块基础控制器
 * admin模块的所有控制器要继承该控制器
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-9-9
 * Time: 下午9:05
 */
class MY_Admin_Controller extends MY_Controller
{
    protected $_site_id = 0;

    public function __construct()
    {
        parent::__construct();

        $this->assign('static', '/static/m-site/');
        $this->assign('views_path', $this->get_views_path());

        $this->load->helper('status_helper');

    }

    public function get_site_id()
    {
        return $this->_site_id;
    }


}