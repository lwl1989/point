<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
	/*
	 *  发送6位短信验证码
	 *  @param string mobile 
	 *  @param string verify_code
	 *  @param string func
	 *  @param boll flag
	 *
	 *  @return String
	 */
	function send_sms($mobile,$verify_code,$func='register',$flag=true){
		if(!$flag||ENVIRONMENT=="development"){
			/**
			 * 调试环境 查看验证码 tail -f  application/logs/verify.php
			 */
			$CI = & get_instance();
			$CI->load->helper('file');
			write_file('./application/logs/verify.php',$verify_code."\n");
			return true;
		}
		$message=array(
			'register'	=>	'海鸥网注册验证码：'.$verify_code.'，如非本人操作，请忽略本条短信。【海鸥网】',
			'get_pass'	=>	'海鸥网找回密码验证码:'.$verify_code.'，如非本人操作，请忽略本条短信。【海鸥网】'
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://sms-api.luosimao.com/v1/send.json");

		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, TRUE); 
		curl_setopt($ch, CURLOPT_SSLVERSION , 3);

		curl_setopt($ch, CURLOPT_HTTPAUTH , CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD  , 'api:key-b87f2819ac9a8e9598b85d257935ef67');
		//关于key暂时先存放此处，以后将存放到config中


		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array('mobile' => $mobile,'message' => $message[$func]));

		$res = curl_exec( $ch );
		curl_close( $ch );
		$res = json_decode($res,true);
		if($res['error']!=0){
			return false;
		}else{
			return true;
		}
	}
	