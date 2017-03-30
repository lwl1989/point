<?php 
/**
 * class company_category_attr
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-10-8
 * Time: 下午11:16
 */

class Company_category_attr extends MY_Site_Model
{
    /**
     * @var string
     */
    protected $_table_name = 'company_category_attrs';

	public function __construct()
	{
		parent::__construct();	
	}

    /**
     * @param array $ids
     * @return array
     */
    public function find_by_cate_ids(array $cate_ids)
    {
        $conditions['cate_ids'] = $cate_ids;

        $options = array(
            'order' => array('sort_order desc, cate_id asc'),
        );
        return $this->fetch_array($conditions, '*', $options);
    }

    /**
     * 自定义条件解析
     *
     * @param array $conditions
     * @return array
     */
    protected function self_conditions($conditions)
    {

        $this->db->where('(site_id = 0 or site_id = ' . $this->_site_id.')');

        if (isset($this->_condition_fields['site_id'])) {
            unset($this->_condition_fields['site_id']);
        }

        if (isset($conditions['cate_ids'])) {
            $this->db->where_in('cate_id', $conditions['cate_ids']);
            unset($conditions['cate_ids']);
        }

        return $conditions;
    }
}