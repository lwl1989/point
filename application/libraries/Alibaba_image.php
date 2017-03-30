<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('wanpitu/alimage.class.class.php');


class Alibaba_image {

	private $ak;
	private $sk;

    public function set($key, $val){
        $key = strtolower($key);
        if( array_key_exists( $key, get_class_vars(get_class($this) ) ) ){
            $this->setOption($key, $val);
        }
        return $this;
    }

    private function setOption($key, $val) {
        $this->$key = $val;
    }

    function do_upload($user_id,$savename,$source_file,$namespace="xueba"){
        $image  = new AlibabaImage($this->ak, $this->sk, "TOP");
        $uploadPolicy = new uploadPolicy();
        $uploadPolicy->dir = $user_id;    //
        $uploadPolicy->name = $savename;  // 文件名不/"
        $uploadPolicy->namespace= $namespace;
        $res = $image->upload($source_file, $uploadPolicy, $opts = array());
        return $res;
    }


}
