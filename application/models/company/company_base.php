<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-4
 * Time: 下午11:20
 */

class  company_base extends MY_User_Model{
    protected $_company_table = 'company_users';
    function __construct(){
        parent::__construct();
    }

    function get_user_by_id($user_id){
       /* $condition = array(
            'user_id' => $user_id
        );
        return $this->getOne($condition);*/
        $this->db->where('user_id',$user_id);
        $query = $this->db->get($this->_company_table);

        if($query->num_rows() == 1)
            return $query->result_array()[0];
        return null;

    }

    function set_address($user_id,$condition){
        foreach($condition as $name => $val){
            $this->db->set($name,$val);
        }
        //$this->db->set('address',$address);
        $this->db->where('user_id',$user_id);
        $this->db->update($this->_company_table);

        return $this->db->affected_rows() > 0;
    }

    function get_company_users($user_id){
        $this->db->where('user_id',$user_id);
        $query = $this->db->get($this->_company_table);
        if($query->num_rows() == 1) return $query->result_array()[0];
        return null;
    }

    function change_charge($company_id,$charge){
        $this->db->where('id',$company_id);
        $this->db->set('charge',$charge);
        $this->db->update($this->_company_table);

        return $this->db->affected_rows() > 0;
    }

    function get_company_by_id($id){
        $this->db->where('id',$id);
        $query = $this->db->get($this->_company_table);
        if($query->num_rows() == 1) return $query->result_array()[0];
        return null;
    }

    function update_company_payment($company_id,$payment,$add=true){
        if($add){
            $this->db->set('available_payment','available_payment+'.$payment,false);
            $this->db->set('payment','payment+'.$payment,false);
        }else{
            $this->db->set('available_payment','available_payment-'.$payment,false);
        }
        $this->db->where('id',$company_id);

        $this->db->update($this->_company_table);
        return $this->db->affected_rows() > 0;
    }

    function judge_payment($company_id,$payment){
        $this->db->select('available_payment');
        $this->db->where('id',$company_id);
        $this->db->limit(1);
        $query = $this->db->get($this->_company_table);
        if($query->num_rows()==1){
            if($payment<=$query->result_array()[0]['payment']){
                return true;
            }
        }
        return false;

    }

    function set_zone($id,$zone_id){
        $this->db->where('id',$id);
        $this->db->set('zone_id',$zone_id);
        $this->db->update($this->_company_table);
        return $this->db->affected_rows() > 0;
    }
}