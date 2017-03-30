<?php 
/**
 * class company_category_attr_value
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-10-27
 * Time: 上午1:06
 */

class company_category_attr_value extends MY_Site_Model
{
    protected $_table_name = 'company_category_attr_values';

	public function __construct()
	{
		parent::__construct();
        $this->_condition_fields = array();
	}

    public function save_attrs($company_id, $attrs)
    {
        $this->batch_delete(array('company_id' => $company_id));

        $this->batch_save($attrs);

        return true;
    }
}
