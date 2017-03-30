<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/10
 * Time: 15:04
 */

class eligible_refund extends MY_Model{

    function __construct()
    {
        parent::__construct();
        $this->_table_name = 'eligible_refund';
    }

}