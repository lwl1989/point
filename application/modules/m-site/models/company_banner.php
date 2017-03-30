<?php 
/**
 * class company_banner
 *
 * @author Cavin <csp379@163.com>
 * Date: 13-10-28
 * Time: 上午12:15
 */

class company_banner extends MY_Site_Model
{
    protected $_table_name = 'company_banners';

	public function __construct()
	{
		parent::__construct();	
	}

    public function find_banners($company_id)
    {
        $conditions = array(
            'company_id' => $company_id,
        );

        return $this->fetch_array($conditions);
    }
}