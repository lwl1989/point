<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/22
 * Time: 23:00
 */

class wechat extends MY_Portal_Controller{

    protected $config_wechat;
    function __construct(){
        parent::__construct();
        $this->load->config('wechat');
        $this->config_wechat = $this->config->item('wechat');
        $this->load->library('Weixin_action',$this->config_wechat);
    }

    function index(){
        $data = $this->weixin_action->request();
        $this->load->helper('file');
        write_file('./application/logs/wechat.php',$data['Content']."\n");
        if (!empty($data)) {
            $RX_TYPE = trim($data['MsgType']);
            switch($RX_TYPE){
                case "event":
                    $this->event($data);
                    break;
                 case "text":
                     $this->text($data);
                     break;
                default:
                    $this->text(false);
                    break;
            }
        }
    }

    protected function event($data){
        if(!empty($data)){
            switch ($data['Event'])
            {
                case "subscribe":
                    $content = $this->config_wechat['subscribe'];
                    $content .= (!empty($data['EventKey']))?("\n来自二维码场景 ".str_replace("qrscene_","",$data['EventKey'])):"";
                    $this->weixin_action->responseMsg($content,'text');
                    break;
                case "unsubscribe":
                    $content = "取消关注";
                    $this->weixin_action->responseMsg($content,'text');
                    break;
                case "SCAN":
                    $content = "扫描场景 ".$data->EventKey;
                    $this->weixin_action->responseMsg($content,'text');
                    break;
                case "CLICK":
                    $message = $this->get_keyword($data['EventKey']);
                    $this->weixin_action->responseMsg($message[0],$message[1]);
                    break;
                default:
                    $content = "接收到无法解析的词汇噢!".$data['EventKey'];
                    $this->weixin_action->responseMsg($content,'text');
                    break;
            }
        }
        exit;
    }
    private function text($data){
          if($data){
            if($data['Content'] && strlen($data['Content'])<20){
                    //$this->load->library("pinyin");

                    $this->load->model('wechat_hot_model');
                    if($this->wechat_hot_model->exists_key($data['Content'],$data['FromUserName'])<1){
                        $this->wechat_hot_model->insert(array('keyword'=>$data['Content'],'open_id'=>$data['FromUserName']));
                    }
                    $message = $this->get_keyword($data['Content']);
                if(!$message){
                    $this->weixin_action->responseMsg('没有相关的内容噢','text');
                }else{
                    $this->weixin_action->responseMsg($message[0],$message[1]);
                }
            }else{
                $this->weixin_action->responseMsg('没有相关的内容噢','text');
            }
        }else{
              $this->weixin_action->responseMsg('没有相关的内容噢','text');
        }
        exit;
    }

    protected function get_keyword($key){
        $this->load->model('wechat_keyword_model');
        $keywords = $this->wechat_keyword_model->find_by_key($key);
        if($keywords){
            if($keywords['type']==1)
                return array($keywords['source'],'text');
            $message = array();
            $source = json_decode($keywords['source'],true);

            $source = $this->my_sort($source,'sort',SORT_DESC,SORT_NUMERIC);
            $source_fun =array();
            foreach($source as $val){
                $this->load->model('wechats/wechat_'.$val['source']);
                $source_class = 'wechat_'.$val['source'];
                $message = array_merge_recursive($message,array($this->$source_class->get_source_by_id($val['source_id'])));
                $source_fun = array_merge_recursive($source_fun,array($val['source']));
            }
            foreach($message as $key=>$val){
                if(!$source_fun[$key]){
                    $message[$key]['Url'] = $source[$key]['url'];
                    $message[$key]['Title'] = $source[$key]['title'];
                    $message[$key]['PicUrl'] = $source[$key]['picUrl'];
                    $message[$key]['Description'] = $source[$key]['description'];
                    continue;
                }
                if($source_fun[$key]=='notice'){
                    $message[$key]['Url'] = $source[$key]['url']?$source[$key]['url']:site_url('news/show').'/'.$val['id'];
                    $message[$key]['Title'] = $source[$key]['title']?$source[$key]['title']:$val['title'];
                    $message[$key]['PicUrl'] = $source[$key]['picUrl']?$source[$key]['picUrl']:base_url().$val['image'];
                }else{
                    $message[$key]['Url']= $source[$key]['url']?$source[$key]['url']:site_url('product').'/'.$val['id'];
                    $message[$key]['Title'] = $source[$key]['title']?$source[$key]['title']:$val['name'];
                    $message[$key]['PicUrl'] = $source[$key]['picUrl']?$source[$key]['picUrl']:$val['image'];
                }
                $message[$key]['Description'] = $source[$key]['description']?$source[$key]['description']:$val['intro'];

            }
            return array($message,'news');
        }
        return false;
    }

    protected function my_sort($arrays,$sort_key,$sort_order=SORT_ASC,$sort_type=SORT_NUMERIC ){
        if(is_array($arrays)){
            foreach ($arrays as $array){
                if(is_array($array)){
                    $key_arrays[] = $array[$sort_key];
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
        array_multisort($key_arrays,$sort_order,$sort_type,$arrays);
        return $arrays;
    }

    function test(){
        echo sprintf('<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
<Image>
<MediaId><![CDATA[media_id]]></MediaId>
</Image>
</xml>');
    }

 /*   private function transmitNews($newsArray)
    {
        if(!is_array($newsArray)){
            return;
        }
        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
    </item>
";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
</xml>";

        $result = sprintf($xmlTpl, '222', '333', time(), count($newsArray));
        return $result;
    }*/
}