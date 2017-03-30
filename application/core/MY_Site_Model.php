<?php
/**
 * class MY_Site_Model
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-9-30
 * Time: 下午5:13
 */

class MY_Site_Model extends MY_Model
{

    /**
     * 当前分站id，0为总管理平台id
     *
     * @var int
     */
    protected $_site_id;

    /**
     * @var 查询是失败时错误提示语
     */
    private $_error_msg;

    /**
     * @var string
     */
    protected $_table_name = '';

    public function __construct()
    {
        parent::__construct();

        if ($this->db->field_exists('is_del', $this->_table_name)) {
            $this->_condition_fields['is_del'] = 0;
        }
        if ($this->db->field_exists('is_display', $this->_table_name)) {
            $this->_condition_fields['is_display'] = 1;
        }

        $this->_site_id = 1;

    //    $this->_condition_fields['site_id'] = $this->_site_id;
    }

    /**
     * 设置错误信息错误提示语
     * @param $msg
     */
    protected function set_error_msg($msg)
    {
        $this->_error_msg = $msg;
    }

    /**
     * @return mixed
     */
    public function get_error_msg()
    {
        return $this->_error_msg;
    }
    /**
     * Get username
     *
     * @return	string
     */
    function get_username()
    {
        $user = $this->_CI->session->userdata('login_user');
        if (!$user) {
            return '';
        }
        return $user['username'];
    }



    /**
     * @param $site_id
     */
    /*public function set_site_id($site_id)
    {
        $this->_site_id = $site_id;
    }*/
}