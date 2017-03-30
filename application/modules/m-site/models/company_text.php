<?php 
/**
 * class company_text
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-10-27
 * Time: 上午12:47
 */

class company_text extends MY_Site_Model
{
    /**
     * @var string
     */
    protected $_table_name = 'company_texts';

	public function __construct()
	{
		parent::__construct();
        $this->_condition_fields = array();
	}

    /**
     * 根据company_id 获取一条记录，如果没记录先初始化一条记录
     *
     * @param $company_id
     * @return array
     */
    public function get_or_init($company_id)
    {

        $conditions = array('company_id' => $company_id);
        $text = $this->getOne($conditions);
        if ($text) {
            return $text;
        }

        $text = array(
            'site_id' => $this->_site_id,
            'company_id' => $company_id,
            'intro' => '',
            'traffic' => '',
            'general_feeling' => '',
            'recommended_reason' => '',
            'attrs' => serialize([]),
        );
        $id = $this->insert($text);

        $text['id'] = $id;
        return $text;
    }

    public function save_text($company_id, $data)
    {
        $conditions = array('company_id' => $company_id);
        $company = $this->getOne($conditions);

        if ($company) {
            $id = $this->update($data, $company['id']);
        } else {
            $id = $this->insert($data);
        }

        return $id;

    }


    public function get_attrs($company_id)
    {
        $conditions = array('company_id' => $company_id);
        $company = $this->getOne($conditions);

        if (!$company) {
            return false;
        }

        $attrs = $company['attrs'];

        return unserialize($attrs);
    }
}