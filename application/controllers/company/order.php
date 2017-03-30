<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-2
 * Time: 下午5:42
 */
 /*订单信息*/
class order extends MY_Company_Controller{


    function __construct(){
        parent::__construct();
        $this->load->model('company/company_order');
        $this->load->helper('pagination_user');
        $this->load->helper('order');
    }

    function index($page = 1){
        $state = $this->input->get('status')?$this->input->get('status'):1;
        $offset = ($page-1)*10;
        $order_list = $this->company_order->get_order_by_id($this->company_id,$order_by = 'id',$state,10, $offset);
        $count =$this->company_order->get_order_count_by_id($this->company_id,$state);
        $pagination = create_pagination('/company/order/index/',$page,10,$count);
        //var_dump($order_list);
        $i=0;
        $this->load->model('public/file_base');
        $this->load->model('document/document_model');
        foreach($order_list as $order){
            $message[$i] = json_decode($order['info'],true);
            $ids = array();
            foreach($message[$i] as $document){
                //array_push($ids,$document['file_id']);
                $ids[] = $document['file_id'];
            }
            $documents = $this->document_model->get_title_with_page($ids);
            $count = count($documents);
            for($k=0;$k<$count;$k++){
                $message[$i][$k]['title'] = $documents[$k]['title'];
                $message[$i][$k]['page'] = $documents[$k]['page'];
                $message[$i][$k]['score'] = $documents[$k]['score'];
            }


            $order_list[$i]['message'] = $message[$i];
            $i++;
        }
        $this->assign('pagination',$pagination);
        $this->assign('orders',$order_list);
        $this->assign('head_title','商家中心 - 订单中心');
        $this->assign('state',$state);
        $this->display();
    }

    function del($order_id){
        echo "company can't do this method";
    }

    /*
     * 打印完成订单
     */
    function complete($order_id){
        $result =  $this->company_order->complete($this->company_id,$order_id);
        if(!$result){
            $this->json_response(false);
        }
        $this->json_response(true);
    }

    /*
     * 订单详情
     */
    function show(){
        $message = trim($this->input->post('info'));
        $this->load->model('public/file_base');
        foreach(array_keys($message) as $id)
        {
            array_push($ids,$id);
        }
        $document_list = $this->file_base->get_file_by_id($ids);
        $this->json_response(true,$document_list);
    }




}