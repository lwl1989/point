<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-10
 * Time: 下午11:26
 */

class MY_User_Model  extends  MY_Model{

    protected $_user_table = 'users';
    protected $_user_type_table = '';
    protected $_file_table = 'document';
    protected $_file_classify_table = 'document_classify';
    protected $_file_like_table = 'document_like';
    protected $_file_tag_table = 'document_tag';

    function __construct()
    {
        parent::__construct();
        $this->_table_name = $this->_user_table;
    }

    function set_user_type($type)
    {
        $this->_user_type_table = $type;
    }
} 