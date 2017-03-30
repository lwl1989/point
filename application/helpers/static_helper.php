<?php

function load_css_files($load = array()){

    $CI =& get_instance();
    $CI->config->load('css_files',TRUE);
    $files = $CI->config->item('css_files');

    $files_html="";

    if (!empty($load)) {
        foreach ($files as $key => $css) {
       
            if (in_array($key, $load)) {

                if (is_array($css)) {
                    foreach ($css as $file) {
                        $files_html .= "<link rel='stylesheet' type='text/css' href='".$file."' />";
                    }
                } elseif (!empty($css)) {
                    $files_html .= "<link rel='stylesheet' type='text/css' href='".$css."' />";
                }

            }
        }
    }
    return $files_html;
}

function load_js_files($load = array()){

    $CI =& get_instance();
    //加载系统配置敏感词库
    $CI->config->load('js_files',TRUE);
    $files = $CI->config->item('js_files');

    $files_html="";


    if (!empty($load)) {
        foreach ($files as $key => $js) {

            if (in_array($key, $load)) {

                if (is_array($js)) {
                    foreach ($js as $file) {
                        $files_html .= "<script type='text/javascript' src='".$file."'></script>";
                    }
                } elseif (!empty($js)) {
                    $files_html .= "<script type='text/javascript' src='".$js."'></script>";
                }

            }
        }
    }
    return $files_html;
}
