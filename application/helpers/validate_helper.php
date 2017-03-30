<?php
/**
 * 验证密码
 *
 * @param $password
 * @param int $min_len
 * @param int $max_len
 * @return array
 */
function is_password($password , $min_len = 6, $max_len = 16){
    $return = array(
        'status' => 1,
        'msg'    => '密码',
    );
    $len = strlen($password);
    if ($len < $min_len || $len > $max_len) {
        $return['status'] = 0;
        $return['msg'] .= '在6 - 16个字符之间，';
    }
    if (!preg_match("/^\w*$/i",$password)) {
        $return['status'] = 0;
        $return['msg'] .= '只能由字母、数字、下划线组成';
    }
    return $return;
}

/**
 * 验证用户名是否只包含字母，数字，下划线，中文
 * @param string $username 要验证的用户名
 * @return boolean
 */
function is_username($username){
    $return = array(
        'status' => true,
        'msg'    => '用户名',
    );
    $username_len = count_str($username);
    if ($username_len < 2 || $username_len > 12) {
        $return['status'] = false;
        $return['msg']   .= '在2 - 12字符之间，';
    }
    if (!preg_match('/^[0-9a-zA-Z_\x{4e00}-\x{9fa5}]+$/u',$username)) {
        $return['status'] = false;
        $return['msg']   .= '只能包含字母、数字、下划线、中文';
    }
    return $return;
}

/**
 * 正则表达式验证email格式
 *
 * @param string $email	所要验证的邮箱地址
 * @return boolean
 */
function is_email($email) {
    $return = array(
        'status' => true,
        'msg'    => '邮箱',
    );
    $email_len = strlen($email);
    if ($email_len < 2) {
        $return['status'] = false;
        $return['msg']    .= '太短，';
    }
    if (!preg_match('#[a-z0-9&\-_.]+@[\w\-_]+([\w\-.]+)?\.[\w\-]+#is', $email)) {
        $return['status'] = false;
        $return['msg']    .= '不合法';
    }
    return  $return;
}
/**
 * 正则表达式验证手机号格式
 *
 * @param string $mobile	
 * @return boolean
 */
function is_mobile($mobile){
	$return = array(
        'status' => true,
        'msg'    => '手机号',
    );
	$mobile_len = strlen($mobile);
	if ($mobile_len != 11) {
        $return['status'] = false;
        $return['msg']    .= '长度不对';
    }
	if(!preg_match("/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/",$mobile)){
		$return['status'] = false;
        $return['msg']    .= '手机号只能是数字';
	}
	return  $return;
}