<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-7
 * Time: 下午1:51
 */

class company extends  MY_Portal_Controller
{
    protected $EARTH_RADIUS = 6378.137;
    function __construct(){
        parent::__construct();
        $this->_login_user = $this->session->userdata('login_user');
    }

    /*
     * 列出周围商家
     * $lng $lat 地图返回的值
     */
    function entry($lng,$lat){
        $this->load->model('public/public_company');
        $point = $this->_returnSquarePoint($lng,$lat);
        $company = $this->public_company->entry_company($point);
        /*$this->assign('company',$company);
        $this->display();*/
        if($company)
            $data = array('state'=>true,'msg'=>$company);
        else
            $data = array('state'=>false);
        $this->_json($data);
    }

    private function _returnSquarePoint($lng, $lat,$distance = 1){

        $d_lng =  2 * asin(sin($distance / (2 * EARTH_RADIUS)) / cos(deg2rad($lat)));
        $d_lng = rad2deg($d_lng);

        $d_lat = $distance/$this->EARTH_RADIUS;
        $d_lat = rad2deg($d_lat);

        return array(
            'left-top'=>array('lat'=>$lat + $d_lat,'lng'=>$lng-$d_lng),
            'right-top'=>array('lat'=>$lat + $d_lat, 'lng'=>$lng + $d_lng),
            'left-bottom'=>array('lat'=>$lat - $d_lat, 'lng'=>$lng - $d_lng),
            'right-bottom'=>array('lat'=>$lat - $d_lat, 'lng'=>$lng + $d_lng)
        );
    }
}