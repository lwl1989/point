<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/5/7
 * Time: 17:32
 */

/*
 * <ul class="pagination">
                    <li><a href="#">上一页</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">下一页</a></li>
                </ul>
 */
function create_pagination($base_url,$page,$limit,$count){
    if(!$count){
        return null;
    }
    $str = '<ul class="pagination">';
    if($page>1){
        $show_page_1 = $page-1;
        $str .= '<li><a href="'.$base_url.$show_page_1.'">上一页</a></li>';
        if($page>2){
            $show_page_2 = $page-2;
            $str .= '<li><a href="'.$base_url.$show_page_2.'">'.$show_page_2.'</a></li>';
        }
        $str .= '<li><a href="'.$base_url.$show_page_1.'">'.$show_page_1.'</a></li>';
    }
    $str .= '<li class="active"><a href="'.$base_url.$page.'">'.$page.'</a></li>';
    if(($page*$limit)<$count){
        $show_page_1 = $page+1;
        $str .= '<li><a href="'.$base_url.$show_page_1.'">'.$show_page_1.'</a></li>';
        if((($page+1)*$limit)<$count){
            $show_page_2 = $page+2;
            $str .= '<li><a href="'.$base_url.$show_page_2.'">'.$show_page_2.'</a></li>';
        }
        $str .= '<li><a href="'.$base_url.$show_page_1.'">下一页</a></li>';
    }
    $str .= '<ul>';
    return $str;
}