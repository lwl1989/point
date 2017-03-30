<?php 
/**
 * class company_image
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-11-26
 * Time: 下午8:56
 */

class company_image extends MY_Site_Model
{

    protected $_table_name = 'company_images';

	public function __construct()
	{
		parent::__construct();	
	}



    /**
     * 获取logo
     *
     * @param $company_id
     * @return array
     */
    public function get_logo($company_id)
    {
        $conditions = array(
            'company_id' => $company_id,
            'image_type' => 'logo',
        );
        $order = 'sort_order desc';
        return $this->getOne($conditions, $order);
    }

    public function find_by_company_id($company_id, $mark = '')
    {
        $conditions = array(
            'company_id' => $company_id,
        );

        if ($mark) {
            $conditions['mark'] = $mark;
        }

        $options = array(
            'order' => array('sort_order desc'),
        );

        return $this->fetch_array($conditions, '*', $options);
    }


    //获取某个标签的图片数
    public function get_count_by_tag_id($tag_id)
    {
        $conditions['tag_id'] = $tag_id;

        return $this->fetch_count($conditions);

    }

    protected function self_conditions($conditions)
    {
        if (isset($conditions['tag_id'])) {
            $tag_id = intval($conditions['tag_id']);
            $where = "tags like '{$tag_id},%' or tags like '%,{$tag_id},%' or tags like '%,{$tag_id}' or tags={$tag_id} ";
            $this->db->where($where);

            unset($conditions['tag_id']);
        }

        return $conditions;
    }
    
    /**
     * 撤销图片软删除
     * @param unknown $image_ids
     */
    public function revocation_soft_del($image_ids){
    	$sql = "update {$this->_table_name} set is_del=0 where is_del=1 and id in(.$image_ids.)";
    	$this->db->query($sql);
    }

}