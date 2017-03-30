<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-2
 * Time: 下午5:25
 */

class order extends  MY_User_Controller{

    protected $user_id;
    public function __construct()
    {
        parent::__construct();
        $this->assign('css_load',array('user_account'));
        $this->load->model('user/user_order');
        $this->user_id = $this->_login_user['user_id'];
        $this->set_layout('main');
        $this->load->helper('order');
        $this->assign('active','order');

    }

    function index($page = 1,$limit = 15){
        $state = $this->input->get('state')?$this->input->get('state'):false;
        $offset = ($page-1)*$limit;
        if($state == 'all'){
            $my_order = $this->user_order->select($this->user_id,0,$limit,$offset);
        }else{
            $my_order = $this->user_order->select($this->user_id,$state,$limit,$offset);
        }

        $this->load->model('public/file_base');
        $this->load->model('document/document_model');
        $i = 0;

        foreach($my_order as $order){
            $message[$i] = json_decode($order['info'],true);
            $j=0;
            $ids = array();
            foreach($message[$i] as $document){
                array_push($ids,$document['file_id']);
            }
            $documents = $this->document_model->get_title_with_page($ids);
            $count = count($documents);
            for($k=0;$k<$count;$k++){
                $message[$i][$k]['title'] = $documents[$k]['title'];
                $message[$i][$k]['page'] = $documents[$k]['page'];
                $message[$i][$k]['score'] = $documents[$k]['score'];
            }


            $my_order[$i]['message'] = $message[$i];
            $i++;
        }
        //var_dump($my_order[2]);
        $count = $this->user_order->get_count_by_user($this->user_id);
        $this->assign('limit',$limit);
        $this->assign('page',$page);
        $this->assign('count',$count);
        $this->assign('my_order',$my_order);
        $this->assign('state',$state);
        $this->assign('head_title', '我的订单 - 我的账号');
        $this->display();
    }
     /*
     *
	 *确认订单
	 */
    function confirm_order(){

        $order_id = trim($this->input->post('order_id'));
        $order_state = $this->user_order->get_state($order_id);
        $order_config = $this->load->config('order');

        if($order_state!=$order_config['state']['printed']){
            $this->json_response(false,array('field'=>'state'),'订单还未打印啊！亲！');
        }

        $result = $this->user_order->confirm($order_id,$this->user_id);
        $order = $this->user_order->get_order_by_id($order_id);
        $this->_source_action($order_id,$order['info'],$order['company_id']);
        if(!$result){
            $this->json_response(false,array(),'确认订单失败，请联系管理员');
        }
        $this->json_response(true,array('field'=>'state'),'确认订单成功');
    }

    /*
     *
     *删除订单
     */
    function del_order($order_id){

        $order_id = trim($order_id);
        $order_state = $this->user_order->get_state($order_id);

        $order_config = $this->load->config('order');

        if($order_state!=$order_config['state']['fail_pay'] or $order_state!=$order_config['state']['place'] or $order_state!=$order_config['state']['user_confirm']){
            $this->json_response(false,array('field'=>'state'),'此类型订单不允许删除');
        }

        $result = $this->user_order->del($order_id,$this->user_id);

        if(!$result){
            $this->json_response(false,array(),'删除订单失败，请联系管理员');
        }
        $this->json_response(true,array('field'=>'state'),'订单删除成功,您可以在回收站内看到它们');
    }

    function details($order_id){
        $order_id = trim($order_id);
        //if()
        $order = $this->user_order->get_order_by_id($order_id);
        /*
         * 文件信息
         * */
        $ids=array();
        $message = json_decode($order['info'],true);
        $this->load->model('document/document_model');
        foreach($message as $document){
            array_push($ids,$document['file_id']);
        }
        $documents = $this->document_model->get_title_with_page($ids);
        $count = count($documents);
        for($i=0;$i<$count;$i++){
            $message[$i]['title'] = $documents[$i]['title'];
            $message[$i]['page'] = $documents[$i]['page'];
        }

        /*
         * 商家信息
         */
      //  echo $order_id['company_id'];
        $this->load->model('company/company_base');
        $company = $this->company_base->get_company_by_id($order['company_id']);


        /*
        * 打印价格
        */
        $this->load->config('print_price',true);
        $charge_default = $this->config->item('print_price');
        if($company['charge']){
            $charge= json_decode($company['charge']);
        }else{
            $charge=$charge_default;
        }

        $i=0;
        foreach($message as $document){
            if(@$document['color']==1){
                if($document['side']==1){
                    $message[$i]['price'] = $charge[$document['size']]['color_one']['base'];
                }
                else
                    $message[$i]['price'] = $charge[$document['size']]['color_two']['base'];
            }else{
             if($document['side']==1)
                    $message[$i]['price'] = $charge[$document['size']]['one']['base'];
                else
                    $message[$i]['price'] = $charge[$document['size']]['two']['base'];
            }
            $i++;
        }


        $this->assign('order_message',$message);
        $this->assign('order',$order);
        $this->assign('company',$company);
        $this->assign('head_title','个人中心 - 订单详情');
        $this->display();


    }
    /*
     * 申请退款页面
     */
    function eligible_refund($order_id=false){
        echo '申请退款页面';
        $this->display();
    }
    /*
     * 退款申请操作
     */
    function  do_eligible_refund(){
        $data =array(
            'user_id'   => $this->user_id,
            'order_id'  => $this->input->post('order_id'),
            'source'    => trim($this->input->post('source')),
            'message'   => trim($this->input->post('message')),
            'images'    => $this->input->post('images')    //图片的ID  3，5,7，9
        );
        $this->load->model('user/eligible_refund');
        $result = $this->eligible_refund->insert($data);
        if($result){
            $this->json_response(true);
        }
        $this->json_response(false);
    }

}
