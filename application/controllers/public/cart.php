<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/25
 * Time: 15:18
 */
class cart extends MY_Portal_Controller{
    protected $user_id;
    function __construct(){
        parent::__construct();
        $this->_login_user = $this->session->userdata('login_user');
        $this->user_id = $this->_login_user['user_id'];
    }

    /*
 * 打印列表,选择商家，提交打印
 */
    function index(){
        $file_info = $this->session->userdata('cart');
        $file_info = json_decode($file_info,true);
        $this->load->model('public/public_company');
        if(count($file_info)>0){
            $i=0;
            $ids=array();
            foreach($file_info as  $file){
                if(!$file['id']){
                    continue;
                }
                $ids[$i]=$file['id'];
                $i++;
            }
            $this->load->model('document/document_model');
            $documents = $this->document_model->get_title_with_page($ids);
            $i=0;
            foreach($documents as $document){
                $file_info[$i]['page'] = $document['page'];
                $file_info[$i]['title'] = $document['title'];
                $file_info[$i]['score'] = $document['score'];
                $i++;
            }
        }
        //var_dump($file_info);
        /*$count = count($documents);
        for($k=0;$k<$count;$k++){
            $message[$i][$k]['title'] = $documents[$k]['title'];
            $message[$i][$k]['page'] = $documents[$k]['page'];
            $message[$i][$k]['score'] = $documents[$k]['score'];
            //var_dump($message);
        }*/
        //var_dump($file_info);
        /*
         * 打印价格
         */
        $this->load->config('print_price',true);
        $charge_default = $this->config->item('print_price');

        //$companies = $this->public_company->entry_company();  //这里可以让商家选择区域
        $companies = $this->public_company->get_company();
        $i=0;
        foreach($companies as $val){
            if($val['charge']){
                $companies[$i]['charge']= json_decode($val['charge']);
            }else{
                $companies[$i]['charge']=$charge_default;
            }
        }
        $this->assign('charge_default',$charge_default);
        $this->assign('company',$companies);
        $this->assign('file_info',$file_info);
        $this->assign('head_title','我的打印');
        $this->display();
    }
    /*
     * 将文件加入打印序列
     * post: file_id,num
     */

    function do_print(){
        $this->auth_json();
        $user_id = $this->user_id;
        if(!$user_id){
            $this->json_response(false);
        }

        $file_id = $this->input->post('file_id');
        $file_num = $this->input->post('file_num');

        $files = array('file_id'=>$file_id,'file_num'=>$file_num);
        $cart = $this->session->userdata('cart');
        $arr_file = json_decode($cart['file_info'],true);
        $count = count($arr_file);
        if($count<1){
            $file_info = array(0=>$files);
        }else{
            $file_info[$count] = $files;
        }
        $file_info = json_encode($file_info);
        /*$cart = array(
            'user_id' => $user_id,
            'file_info' => $file_info
        );*/

        $cart = $this->get_cart($user_id);


        if($this->_login_user){
            $this->load->model('user/user_model');
            $this->user_model->set_cart($user_id,$file_info);
        }
        $this->session->set_userdata('cart',$cart);
    }
    /*
     * 改变购物车
     */
    function do_change_cart(){
        $this->auth_json();
        $file_id = $this->input->post('file_id');
        $file_num = $this->input->post('file_num');
        $title = $this->input->post('title');
        $file_info = $this->session->userdata('cart');
        $file_array = array();
        //var_dump($file_info);
        if($file_info)
        {
            $file_info = json_decode($file_info,true);
            $flag = 0;
            $i = 0;
            foreach($file_info as $file){
                if($file['id']==$file_id){
                    $file_array[$i]['file_num'] = $file['file_num'] + $file_num;
                    $flag=1;
                }else{
                    $file_array[$i]['file_num'] = $file['file_num'];
                }
                $file_array[$i]['id'] = $file['id'];
                $file_array[$i]['title'] = $file['title'];
                $i++;
            }
            if(!$flag){
                $count = count($file_info);
                $file_array[$count]=array('id'=>$file_id,'file_num'=>$file_num,'title'=>$title);
            }
        }else{
            $file_array[0]=array('id'=>$file_id,'file_num'=>$file_num,'title'=>$title);
        }
        $file_info = json_encode($file_array);
        $this->load->model('public/user_cart');
        $this->user_cart->update_cart($this->user_id,$file_info);
        $this->session->set_userdata('cart',$file_info);
        $this->json_response(true);
    }

    /*
     * 下单打印
     * post json
     */
    function do_place(){
        $this->auth_json();
        $order_info =array();
        $file_info = trim($this->input->post('file_info'));
        if(!$file_info){
            $file_info = $this->session->userdata('cart');
        }
        //ajax post json  ->  decode to array
        // or session  $this->session->userdata('cart')
        //explame:   {0:{'id':2,'num':1},1:{'id':3,'num':4}}
        $file_info = json_decode($file_info,true);
        $i = 0;
        $sum = 0;
        $price = 0;
        $sum_page = 0;
        foreach($file_info as $file){
            $sum +=   $file['file_num'];
            $file_info[$i]['price'] = substr($file['price'],0,strlen($file['price'])-3);
            $price += floatval($file['price']);
            $sum_page += $file['page'];
            $i++;
        }
        $order_info['company_id'] = $this->input->post('company_id');
        $order_info['user_id'] = $this->user_id;
        $order_info['info'] = json_encode($file_info);
        $order_info['remarks'] =  $this->input->post('remarks')?$this->input->post('remarks'):'';
        $order_info['sum_num'] = $sum;
        $order_info['price'] = $price;
        $order_info['sum_page'] = $sum_page;
        /*
         *  获取商家的价格
         */
        $this->load->helper('verify');
        $order_info['order_id'] = date("YmdHiS",time()).rand_pass(8);

        $this->load->model('user/order');
        $result = $this->order->insert_order($order_info);
        // echo $this->order->last_query();
        if(!$result){
            $this->json_response(false);
        }
        $this->json_response(true);
    }

    function do_clear($user_id){
        $this->session->set_userdata('cart',null);
        $this->load->model('public/user_cart');
        $this->user_cart->update_cart($user_id,'');
    }
}