<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-3-2
 * Time: 下午5:43
 */
class place extends MY_Portal_Controller{

    function __construct(){
        parent::__construct();
    }


    function test(){
        $this->load->config('print_price',true);
        $charge_default = $this->config->item('print_price');
        $type = array();
        foreach($charge_default as $key=>$val){
            array_push($type,$key);
        }
        $A4=array(
            'base'  => '2',
            'sales' => array('num'=>100,'sale'=>'0.95'),
        );
        $A5=array(
            'base'  => '2',
            'sales' => array('num'=>100,'sale'=>'0.95'),
        );
        $charge = array(
            'A4'=>$A4,
            'A5'=>$A5
        );
        $charge = array();
        foreach($type as $val){
            $$val = trim($this->input->post($val));
          /*  if(!$$val){
                $$val = $charge_default[$val];
            }*/
            $charge[$val] = $$val;
        }
        /*array_push($charge,$A4);
        array_push($charge,$A5);*/
        echo '<pre>';
        var_dump($charge);
        /*print_r($charge);
        print_r($charge_default);
        print_r($type);*/
    }
}