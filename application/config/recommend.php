<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/10
 * Time: 18:51
 */
$config['func'] = array(
        0   =>  array(
                'func'=>    'index',
                'func_cn'   =>  '首页推荐'
        ),
        1   =>  array(
                'func'=>    'content',
                'func_cn'   =>  '内容推荐'
        )
);


$config['source'] = array(
    1=>array(
         'source'=> 'company_users','source_cn'=> '公司'
     )
    ,2=>array(
          'source'=>'article','source_cn'=>'文章'
     )
/*    ,3=>array(
     'source'=>'wedding',
     'source_cn'=> '婚礼'
    )*/
);