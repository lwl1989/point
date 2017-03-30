<?php 
/**
 * class MY_Lib
 *
 * @author Cavin <csp379@163.com>
 * Date: 14-3-6
 * Time: 上午11:46
 */

class MY_Lib
{
    /**
     * @var MY_Controller
     */
    protected $_ci;

    /**
     * @param array $params
     */
    public function __construct()
    {
        $this->_ci = &get_instance();
    }
}