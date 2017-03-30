<?php
	/*
	 *  生成6位随机数
	 *  @param int pw_length  
	 *
	 *  @return String
	 */
	function rand_pass($pw_length = 6){    	
			$randpwd = '';    
			for ($i = 0; $i < $pw_length; $i++){        
				$randpwd .= chr(mt_rand(48, 57));    
			}    
			return $randpwd;
	}
	