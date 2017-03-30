<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array (
    //企业图片设置
    'company_image_logo' => array(
        'file_path' => 'companies',
        'allowed_types' => 'jpg|jpeg|gif|png',
        'max_size' => 1*1024*1024,
        'max_width' => 0,
        'max_height' => 0,
    ),
    'company_image_logo_thumb' => array(
        //w , h, 是否是严格宽高
        'small' => array(
            100, 100, 1
        )
    ),
    'company_image_2w_code' => array(
        'file_path' => 'companies',
        'allowed_types' => 'jpg|jpeg|gif|png',
        'max_size' => 1*1024*1024,
        'max_width' => 0,
        'max_height' => 0,
    ),
    'company_image_2w_code_thumb' => array(
        //w , h, 是否是严格宽高
        'small' => array(
            100, 100, 1
        )
    ),
    //企业封面设置
    'company_image_cover' => array(
        'file_path' => 'companies',
        'allowed_types' => 'jpg|jpeg|gif|png',
        'max_size' => 2*1024*1024,
        'max_width' => 0,
        'max_height' => 0,
        
    ),
    'company_image_cover_thumb' => array(
        //w , h, 是否是严格宽高,是否加水印
        'small' => array(
            180, 110, 1,0
        ),
        'middle' => array(
            360, 220, 0,0
        ),
        'big' => array(
            600, 600,0,1
        ),
    ),
    //企业相册
    'company_image_album' => array(
        'file_path' => 'companies',
        'allowed_types' => 'jpg|jpeg|gif|png',
        'max_size' => 2*1024*1024,
        'max_width' => 0,
        'max_height' => 0,
        'wm_type'=>'overlay',
        'wm_vrt_alignment'=>'B',
        'wm_overlay_path'=>'Watermark.png',
        'wm_hor_offset'=>10,
        'wm_vrt_offset'=>10
        
    ),
    'company_image_album_thumb' => array(
        //w , h, 是否是严格宽高,是否加水印
        'small' => array(
            100, 100, 1
        ),
        'middle' => array(
            360, 360,0
        ),
        'big' => array(
            600, 600,0,1
        ),
    ),
    //广告图片
    'ad' => array(
        'file_path' => 'ads',
        'allowed_types' => 'jpg|jpeg|gif|png',
        'max_size' => 1*1024*1024,
        'max_width' => 0,
        'max_height' => 0,
    ),
    'ad_thumb' => array(
        //w , h, 是否是严格宽高
        'small' => array(
            50, 50, 1
        )
    ),
	//菜品图片
	'cookbook_image' => array(
		'file_path' => 'cookbooks',
		'allowed_types' => 'jpg|jpeg|gif|png',
		'max_size' => 1*1024*1024,
		'max_width' => 0,
		'max_height' => 0,
		'wm_type'=>'overlay',
		'wm_vrt_alignment'=>'B',
		'wm_overlay_path'=>'Watermark.png',
		'wm_hor_offset'=>10,
		'wm_vrt_offset'=>10
	),
	'cookbook_image_thumb' => array(
		//w , h, 是否是严格宽高,是否加水印
		'small' => array(
				100, 100, 1,0
		),
		'middle' => array(
				360, 220, 0,0
		),
		'big' => array(
				600, 600,0,1
		),
	),
	//积分商城图片
	'jmall_gift_detail' => array(
		'file_path' => 'jmallgift',
		'allowed_types' => 'jpg|jpeg|gif|png',
		'max_size' => 2*1024*1024,
		'max_width' => 0,
		'max_height' => 0,
		'wm_type'=>'overlay',
		'wm_vrt_alignment'=>'B',
		'wm_overlay_path'=>'Watermark.png',
		'wm_hor_offset'=>10,
		'wm_vrt_offset'=>10
	),
	'jmall_gift_detail_thumb' => array(
		//w , h, 是否是严格宽高,是否加水印
		'small' => array(
				100, 100, 1, 0
		),
		'middle' => array(
				400, 250, 1, 0
		),
		'big' => array(
				600, 600, 0, 1
		),
	),
);