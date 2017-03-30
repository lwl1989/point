<?php 
/**
 * class business_circle
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-10-9
 * Time: 下午10:42
 */

class business_circle extends MY_Site_Model
{
    /**
     * @var string
     */
    protected $_table_name = 'business_circles';

    public function __construct()
    {
        parent::__construct();
    }


    public function find_by_zone_id($zone_id)
    {
        $conditions = array('zone_id' => $zone_id);

        $options = array(
            'order' => array('sort_order desc'),
        );

        return $this->fetch_array($conditions, '*', $options);

    }
}