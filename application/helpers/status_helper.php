<?php
/**
 * 是否显示
 */
function is_display($status)
{
    if ($status == 1) {
        return array('label' => '显示', 'class' => 'success');
    }

    return array('label' => '不显示', 'class' => 'error');
}
/**
 * 是否搜索
 */
function is_search($status)
{
    if ($status == 1) {
        return array('label' => '搜索', 'class' => 'success');
    }

    return array('label' => '不搜索', 'class' => 'error');
}