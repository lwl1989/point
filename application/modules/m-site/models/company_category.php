<?php
/**
 * class company_category
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-9-25
 * Time: 下午12:50
 */

require_once(APPPATH . 'models/company/category_model.php');

class Company_category extends Category_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取分类属性
     *
     * @param $id
     */
    public function get_attrs($id)
    {
        $cate = $this->get($id);

        if (!$cate) {
            return false;
        }
        if ($cate['path'] != '/') {
            $path = trim($cate['path'], '/');
            $cate_ids = explode('/', $path);
        } else {
            $cate_ids = [];
        }
        array_push($cate_ids, $id);
        $this->_CI->load->model('company_category_attr');

        $attrs = $this->_CI->company_category_attr->find_by_cate_ids($cate_ids);

        $return = array();

        foreach ($attrs as $attr) {
            $return[$attr['id']] = $attr;
        }
        unset($attrs);

        return $return;
    }

    /**
     * @return array
     */
    public function find_all()
    {
        $cates = $this->fetch_array();
        $return = array();

        foreach ($cates as $cate) {
            $return[$cate['id']] = $cate;
        }

        return $return;
    }
}