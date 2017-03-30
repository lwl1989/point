<?php

	 function encrypt_mobile($mobile){
		$new_mobile =substr($mobile,0,3);
		$new_mobile.=substr($mobile,7,4);
		return $new_mobile;
	}
	
	 function encrypt_email($email){
		$array = explode('@',$email);
		$new_email = substr($array[0],0,3);
		$new_email.= '***@'.$array[1];
		return $new_email;
	}