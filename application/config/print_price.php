<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/24
 * Time: 23:20
 */

$config=array(
    'A3'    =>  array(
        /*
         * 打印单面
         */
        'one'   =>  array(
           'base'  =>  '0.2',
           'sales'  => array(
               0    =>  array('num'=>100,'sale'=>'0.9')
           )
        ),
        /*
         * 双面
         */
        'two'  =>  array(
            'base'  =>  '0.3',
            'sales' =>  array()
        ),
        /*
         * 彩印单面
         */
        'color_one' =>  array(
            'base'  =>  '2.0',
            'sales' =>  array()
        ),
        /*
         * 彩印双面
         */
        'color_two' =>  array(
            'base'  =>  '3.0',
            'sales' =>  array()
        )
    ),
    'A4'   =>  array(
         'one'   =>  array(
             'base'  =>  '0.1',
             'sales' =>  array()
         ),
         'two'  =>  array(
             'base'  =>  '0.1',
             'sales' =>  array()
         ),

         'color_one' =>  array(
             'base'  =>  '1.0',
             'sales' =>  array()
         ),
         'color_two' =>  array(
             'base'  =>  '1.0',
             'sales' =>  array()
         )
    ),
    'B5'    =>  array(
        'one'   =>  array(
            'base'  =>  '0.05',
            'sales' =>  array()

        ),
        'two'  =>  array(
            'base'  =>  '0.08',
            'sales' =>  array()
        ),
        'color_one' =>  array(
            'base'  =>  '0.5',
            'sales' =>  array()
        ),
        'color_two' =>  array(
            'base'  =>  '0.8',
            'sales' =>  array()
        ),
    ),
    'B4'    =>  array(
        'one'   =>  array(
            'base'  =>  '0.2',
            'sales' =>  array()
        ),
        'two'  =>  array(
            'base'  =>  '0.2',
            'sales' =>  array()
        ),
        'color_one' =>  array(
            'base'  =>  '2.0',
            'sales' =>  array()
        ),
        'color_two' =>  array(
            'base'  =>  '2.0',
            'sales' =>  array()
        )
    )

);