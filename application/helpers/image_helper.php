<?php
function get_banner_url($file)
{
    return base_url('/data/banners/'.$file);
}


function get_company_small_image($file_url)
{
    $file_url = trim($file_url);
    if ($file_url) {
        return '/data/'.$file_url.'_small.jpg';
    }
    return '/static/img/default.jpg_small.jpg';
}
function get_company_middle_image($file_url)
{
    $file_url = trim($file_url);
    if ($file_url) {
        return '/data/'.$file_url.'_middle.jpg';
    }
    return '/static/img/default.jpg_middle.jpg';
}
function get_company_big_image($file_url)
{
    $file_url = trim($file_url);
    if ($file_url) {
        return '/data/'.$file_url.'_big.jpg';
    }
    return '/static/img/default.jpg_big.jpg';
}
function get_company_origin_image($file_url)
{
    $file_url = trim($file_url);
    if ($file_url) {
        return '/data/'.$file_url;
    }
    return '/static/img/default.jpg';
}


function real_del_image($file_url)
{
    $real_file = FCPATH . 'data/'.$file_url;
    if (is_file($real_file)) {
        unlink($real_file);
    }
    $real_file = FCPATH . 'data/'.'_small.jpg';
    if (is_file($real_file)) {
        unlink($real_file);
    }
    $real_file = FCPATH . 'data/'.'_middle.jpg';
    if (is_file($real_file)) {
        unlink($real_file);
    }
    $real_file = FCPATH . 'data/'.'_big.jpg';
    if (is_file($real_file)) {
        unlink($real_file);
    }
}