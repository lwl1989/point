<?php
/**
 * 公司分类属性类型枚举
 *
 * @param string $key
 */
function company_cate_attr_types($key = '')
{
    $types = array(
        'input' => '短文本',
        'text' => '长文本',
        //'bool' => 'bool类型',
        'checkbox' => '多选',
        'radio' => '单选',
        'select' => '单选下拉选择'
    );

    if (isset($types[$key])) {
        return $types[$key];
    }
    return $types;
}

function link_target($key = '')
{
    $types = array(
        '_blank' => '新页面',
        '_self' => '当前页面',
    );
    if (isset($types[$key])) {
        return $types[$key];
    }
    return $types;
}

function menu_group($key = '')
{
    $groups = array(
        'none' => '不分组',
        'root' => '根级组',
        'level-1' => '第一分组',
        'level-2' => '第二分组',
        'level-3' => '第三分组',
        'level-4' => '第四分组',
    );
    if (isset($groups[$key])) {
        return $groups[$key];
    }
    return $groups;
}