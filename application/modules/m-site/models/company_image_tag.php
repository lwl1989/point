<?php 
/**
 * class company_image_tag
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-11-23
 * Time: 下午11:41
 */

class company_image_tag extends MY_Site_Model
{
    /**
     * @var string
     */
    protected $_table_name = 'company_image_tags';

	public function __construct()
	{
		parent::__construct();	
	}

    public function find_by_company_id($company_id)
    {
        $conditions = array('company_id' => $company_id);

        $options = array(
            'order' => array('sort_order desc'),
        );

        return $this->fetch_array($conditions, '*', $options);

    }


    /**
     * 更新企业的tag，count数据
     *
     * @param $company_id
     */
    public function updateCount($company_id)
    {
        $tags = $this->find_by_company_id($company_id);

        $this->fetch_count();
        $this->load->model('company_image');

        foreach ($tags as $tag) {
            $count = $this->company_image->get_count_by_tag_id($tag['id']);
            //var_dump($this->db->last_query());
            $tag['count'] = $count;
            $this->update($tag);
            //var_dump($this->db->last_query());
        }

        return true;

    }



}