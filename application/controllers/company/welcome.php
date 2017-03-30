<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-13
 * Time: 下午12:14
 */

class welcome extends MY_User_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
       // if()
        redirect(site_url('company/account'));
    }
}