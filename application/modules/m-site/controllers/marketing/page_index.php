<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-3-6
 * Time: 上午12:17
 */
class page_index extends MY_Site_Manage_Controller{

    function __construct(){
        parent::__construct();
        $this->assign('index_channel','marketing');
        $this->load->model('recommend');

    }

    function index($func = false){

        $this->load->helper('image');
        $this->load->config('recommend');
        $func_config = $this->config->item('func');
        $this->assign('func',$func_config);
        $conditions = array('site_id'=>$this->_site_id);
        if($func)
            $conditions['func'] = $func;
        if($this->input->get('recommend_type')){
            $recommend_source = $this->input->get('recommend_type');
            $recommend = $this->recommend->select_recommend($conditions,$recommend_source);
        }else{
            $recommend = $this->recommend->select_recommend($conditions);
        }
        $this->assign('recommend_source',@$recommend_source);
        $this->assign('items', $recommend);
        $this->display();
    }

    function set_recommend($id = false){
        if($id) {
            $id = intval($id);
            $recommend = $this->recommend->find_one($id);
            $this->assign('recommend',$recommend);
        }

        $this->load->config('recommend');
        $func_config = $this->config->item('func');
        $source_config = $this->config->item('source');

        $this->assign('func',$func_config);
        $this->assign('source',$source_config);

        $this->display();
    }
    function do_set_recommend(){
        $func = trim($this->input->post('func'));
        $source = trim($this->input->post('source'));
        $source_id = intval($this->input->post('source_id'));
        $data = array('func'=>$func,'source'=>$source,'source_id'=>$source_id,'site_id'=>$this->_site_id);
        $result = $this->recommend->insert($data);

        if($result){
            $this->json_response(true);
        }
        $this->json_response(false);
    }
    function do_change_recommend(){
        $id = intval(trim($this->input->post('id')));
        $func = trim($this->input->post('func'));
        $source = trim($this->input->post('source'));
        $source_id = intval($this->input->post('source_id'));
        $data = array('id'=>$id,'func'=>$func,'source'=>$source,'source_id'=>$source_id,'site_id'=>$this->_site_id);
        $result = $this->recommend->update($data,$id);

        if($result){
            $this->json_response(true);
        }
        $this->json_response(false);
    }

    public function generate_config()
    {
        $this->load->config('recommend');
        $source_config = $this->config->item('source');
        $i=0;
        $config = array();
        foreach($source_config as $v){
            if($i==0){
                $config = $this->_get_recommend($v['source']);
            }else{
                $config = array_merge_recursive($config,$this->_get_recommend($v['source']));
            }
            $i++;
        }
      /*  $config = $this->_get_recommend('company_users');
        $config = array_merge_recursive($config,$this->_get_recommend('article'));*/



        $config_name = 'data/recommend_site_' . $this->_site_id;

        $this->config->load($config_name, TRUE);

        $this->config->set_item($config_name, $config);

        $this->config->save($config_name);

        $this->json_response();
    }

    private function _get_recommend($source){
        $conditions = array('site_id'=>$this->_site_id);
        $recommend = $this->recommend->select_recommend($conditions,$source);
        $i = $j = 0;
        $config=array();
        if($recommend && is_array($recommend)){
            foreach($recommend as $val){
                if($val['func']=='index'){
                    $config[$val['func']]['recommend_'.$source][$i] = $val;
                    $i++;
                }
                if($val['func']=='content'){
                    $config[$val['func']]['recommend_'.$source][$j] = $val;
                    $j++;
                }
            }
        }
        return $config;
    }
}