<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-24
 * Time: 下午10:51
 */
class company extends MY_Api_Controller{
    function __construct(){
        parent::__construct();
    }

    function get_company_by_point($lat=0,$lng=0,$point_size=1){
        $this->load->model('public/public_company');
        $point = array(
            'right-bottom'  =>  array('lng'=>$lng-$point_size,'lat'=>$lat-$point_size),
            'left-top'      =>  array('lng'=>$lng+$point_size,'lat'=>$lat+$point_size),
        );
        $result = $this->public_company->entry_company($point);
        $this->json_response(true,$result,'获取成功');
    }

    function get_company_by_zone($zone_id){
        $this->load->model('public/public_company');
        $result = $this->public_company->get_company($zone_id);
        $this->json_response(true,$result,'获取成功');
    }


    function get_price($company_id,$size,$side,$num=1){
        $this->load->model('company/company_base');
        $this->load->config('print_price',true);
        $charge_default = $this->config->item('print_price');
        $sale = floatval(1);
        $company = $this->company_base->get_company_by_id($company_id);
            if($company['charge']){
                $company['charge']= json_decode($company['charge']);
            }else{
                $company['charge']=$charge_default;
        }
        if(isset($company['charge'][$size][$side]['sale']) && count($company['charge'][$size][$side]['sale'])>0){
            foreach($company['charge'][$size][$side]['sale'] as $val){
                if($num>$val['num']){
                    if($num<$val['num']){
                        break;
                    }
                    $sale = $val['sale'];
                }
            }
        }
        $price = floatval($company['charge'][$size][$side]['base'])*$sale;
        $price_array = array(
            'price'=>$price,
            'num'=>$num,
            'sale'=>$sale,
            'total'=>$price*$num*$sale
        );
        $this->json_response(true,$price_array,'获取成功');
    }

}