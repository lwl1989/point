<?php 
/**
 *
 *
 * class zone
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-9-30
 * Time: 下午4:50
 */

class zone extends MY_Site_Model
{
    /**
     * @var string
     */
    protected $_table_name = 'zones';

    public function __construct()
    {
        parent::__construct();
    }
    function find_all(){
        $this->db->select('id,name');
        $this->db->where('is_del',0);
        $this->db->where('site_id',1);
      //  $this->db->order('sort_order','desc');
        $query = $this->db->get($this->_table_name);
        return $query->result_array();
    }
    /**
     * 更具父节点查找列表
     *
     * @param $p_id
     * @return array
     */
    public function find_by_p_id($p_id)
    {
        $condition = array('p_id' => $p_id);

        $options = array(
            'order' => array('sort_order desc'),
        );

        return $this->fetch_array($condition, '*', $options);

    }

    /**
     * 统计直接子节点的数量
     *
     * @param int $id     父级id
     * @param int $is_del 是否删除
     * @return int
     */
    public function count_child($id, $is_del = 0)
    {
        $conditions = array(
            'p_id' => $id,
            'is_del' => $is_del,
        );

        return $this->fetch_count($conditions);
    }

    /**
     * 自定义条件解析
     *
     * @param array $conditions
     * @return array
     */
    protected function self_conditions($conditions)
    {
        if (!isset($conditions['site_id'])) {
             $this->db->where('site_id', $this->_site_id);
        }

        return $conditions;
    }
}