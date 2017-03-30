<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 后台主页控制器
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-9-14
 * Time: 下午9:15
 *
 * @class Home
 * @package \modules\m-admin\controllers
 */
class Home extends MY_Site_Manage_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->display('index');
    }
}