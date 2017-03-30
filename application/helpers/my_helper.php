<?php

/*function my_var($var)
{
    if (isset($var) && $var !== null)
        return $var;
    return false;
}*/

/**
 * 'icon_class' => '',
 *  'name' => '川湘菜',
 * 'type' => 'link',//cate | link
 * 'cate_id' => 0,
 *  'url' => 'hiioo.com',
 * 'target' => '_self',//_blank | _self
 *
 * @param $cate
 */
function build_cates_panel_url($cate)
{
    if ($cate['type'] == 'link') {
        $url = $cate['url'];
    } else {
        $url = '#'.$cate['cate_id'];
    }

    if ($cate['target'] == '_blank') {
        $target = '_blank';
    } else {
        $target = '_self';
    }

    return "<a href=\"{$url}\" target=\"{$target}\">{$cate['name']}</a>";

}

//输出文本
function echo_txt($txt)
{
    echo $txt;
}
//格式化得分
function format_score($score)
{
    return number_format($score/10, 1);
}

/**
 * 根据u_id获取用户的头像
 *
 * @param int $u_id
 */
function user_avatar($u_id , $type = 'middle'){
    $u_id = abs(intval($u_id));
    $u_id = sprintf("%09d", $u_id);
    $dir1 = substr($u_id, 0, 3);
    $dir2 = substr($u_id, 3, 2);
    $dir3 = substr($u_id, 5, 2);
    $dir = 'data/avatars/'.$dir1.'/'.$dir2.'/'.$dir3.'/';
    if (!is_dir(FCPATH.$dir)) {
        _mkdir(FCPATH.$dir);
    }
    $file_name = substr($u_id, -2).'_avatar';
    $default_name = $file_name.'_default.png';
    $res = array();
    $res['dir'] = FCPATH.$dir;
	//var_dump(file_exists(FCPATH.$dir.'/'.$default_name));
    if(file_exists(FCPATH.$dir.'/'.$default_name)) {
        $res['default'] = '/'.$dir.'/'.$default_name;
        $res['middle']  = '/'.$dir.'/'.$file_name.'_middle.png';
        $res['small']  = '/'.$dir.'/'.$file_name.'_small.png';

    }else {
        $res['default'] = '/static/img/default_avatar.png';
        $res['middle']  = '/static/img/default_avatar.png';
        $res['small']  = '/static/img/default_avatar.png';
    }
    if ($type != '') {
        return $res[$type];
    }
    return $res;
}

function company_cate_name($cate_id)
{
    $CI = & get_instance();

    $site_id = $CI->get_site_id();

    $config_name = 'data/company_categories.site_' . $site_id;

    $CI->config->load($config_name, TRUE);
    $cates =  $CI->config->item($config_name);

    if (isset($cates[$cate_id]))
        return $cates[$cate_id];

    return '未知';
}

function is_company_open($open_str_time)
{
   
    $open_time=explode('-',$open_str_time);
    $open=strtotime(date("Y-m-d",time()).' '.$open_time[0]);
    $end=strtotime(date("Y-m-d",time()).' '.$open_time[1]); 
    if(time()>$open && time()<$end)
        return true;
}

function zone_name($zone_id)
{
    $CI = & get_instance();

    $site_id = $CI->get_site_id();

    $config_name = 'data/zones.site_' . $site_id;

    $CI->config->load($config_name, TRUE);
    $zones =  $CI->config->item($config_name);

    if (isset($zones[$zone_id]))
        return $zones[$zone_id];

    return '未知';
}

/**
 *
 * 商圈名称
 *
 * @param int $circle_id
 *
 * @return string
 */
function business_circle_name($circle_id)
{
    $CI = & get_instance();

    $site_id = $CI->get_site_id();

    $config_name = 'data/business_circles.site_' . $site_id;

    $CI->config->load($config_name, TRUE);
    $circles =  $CI->config->item($config_name);

    if (isset($circles[$circle_id]))
        return $circles[$circle_id];

    return '未知';


}

function _mkdir($absolute_path, $mode = 0777)
{
    if (is_dir($absolute_path))
    {
        return true;
    }

    $root_path      = FCPATH;
    $relative_path  = str_replace($root_path, '', $absolute_path);
    $each_path      = explode('/', $relative_path);
    $cur_path       = $root_path; // 当前循环处理的路径
    foreach ($each_path as $path)
    {
        if ($path)
        {
            $cur_path = $cur_path . '/' . $path;
            if (!is_dir($cur_path))
            {
                if (@mkdir($cur_path, $mode))
                {
                    fclose(fopen($cur_path . '/index.htm', 'w'));
                }
                else
                {
                    return false;
                }
            }
        }
    }

    return true;
}

/**
 * 统计字符的个数，现只支持utf-8字符统计
 *
 * @param string $string 要统计的字符
 * @param string $code 字符编码
 * @return int 字符的个数
 */
function count_str($string , $code = 'UTF-8'){
    if ($code == 'UTF-8') {
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa, $string, $t_string);
        return count($t_string[0]);
    }
}
/**
 * 截取字符串
 *
 * @param string $string
 * @param int $sublen
 * @param int $start = 0
 * @param string $code = 'UTF-8'
 * @return string
 */
function cut_str($string, $sublen, $start = 0, $code = 'UTF-8'){
    if($code == 'UTF-8') {
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa, $string, $t_string);

        if(count($t_string[0]) - $start > $sublen)
            return join('', array_slice($t_string[0], $start, $sublen))."...";

        return join('', array_slice($t_string[0], $start, $sublen));
    }
    else {
        $start = $start*2;
        $sublen = $sublen*2;
        $strlen = strlen($string);
        $tmpstr = '';

        for($i=0; $i< $strlen; $i++){
            if($i>=$start && $i< ($start+$sublen)){
                if(ord(substr($string, $i, 1))>129) {
                    $tmpstr.= substr($string, $i, 2);
                }
                else {
                    $tmpstr.= substr($string, $i, 1);
                }
            }
            if(ord(substr($string, $i, 1))>129)
                $i++;
        }
        if(strlen($tmpstr)< $strlen ) $tmpstr.= "...";
        return $tmpstr;
    }
}

/**
 * 解析get的值，get值存在就删除，不存在就删除
 *
 * @param array $params
 * @return array
 */
function parse_gets_val($params = [])
{
    if ($params){

        $ci = & get_instance();
        $gets = $ci->input->get();
        if ($gets) {
           foreach ($gets as $key => $get) {
                if ('' == $get) {
                    unset($gets[$key]);
                }
           }
        }

        foreach($params as $key => $val) {

            if (isset($gets[$key])) {
                $values = explode(',', $gets[$key]);
                $values = array_unique($values);

                $k = array_search($val, $values);
                if ($k === false) {
                    array_push($values, $val);
                } else {
                    unset($values[$k]);
                }

                if ($values) {
                    $params[$key] = join(',', $values);
                } else {
                    $params[$key] = '';
                }
            }
        }
    }

    return $params;
}

/**
 * 添加get参数值
 *
 * @param array $params
 * @return array
 */
function add_gets_val($params = [])
{
    if ($params){

        $ci = & get_instance();
        $gets = $ci->input->get();

        foreach($params as $key => $val) {
            if (isset($gets[$key])) {
                $values = explode(',', $gets[$key]);
                $values = array_unique($values);

                array_push($values, $val);
                $params[$key] = join(',', $values);
            }
        }
    }

    return $params;

}

/**
 * 删除get参数值
 *
 * @param array $params
 * @return array
 */
function del_gets_val($params = [])
{
    if ($params){

        $ci = & get_instance();
        $gets = $ci->input->get();

        foreach($params as $key => $val) {

            if (isset($gets[$key])) {
                $values = explode(',', $gets[$key]);
                $values = array_unique($values);

                foreach ($values as $k=> $value) {
                    if ($value == $val) {
                        unset($values[$k]);
                    }
                }

                if ($values) {
                    $params[$key] = join(',', $values);
                } else {
                    $params[$key] = '';
                }
            }
        }
    }

    return $params;

}

/**
 * 构造url查询参数
 *
 * @param array $params
 * @return string
 */
function url_query($params = [], $uri = '')
{
    $ci = & get_instance();
    $gets = $ci->input->get();
    unset($gets['page']);
    $str = '?';
    if ($params) {
        foreach ($params as $key => $val) {
            if ('' === $val) {
                unset($gets[$key]);
            } else {
                $gets[$key] = $val;
            }
        }
    }

    if ($gets) {
        $i = 0;
        foreach ($gets as $key => $val) {
            if ($i == 0) {
                $str .= $key . '=' .$val;
            } else {
                $str .= '&' . $key . '=' .$val;
            }
            $i++;
        }
    }

    if ($uri == '') {
        $uri = $ci->uri->uri_string();
    }
    $url = site_url($uri);

    return $url.$str;

}