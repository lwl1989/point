<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-6
 * Time: 上午11:35
 */

$config = array(
    'file_url'  => array(
        'script_url'    =>  'static/JqueryFileUpload',
        'upload_dir'    =>  'data/uploads/',
        'upload_url'    =>  'data/uploads/'
    ),
    'file_conf'  =>
    array(
        'upload_path'   =>  'data/uploads/',
        'allowed_types' =>  'doc|docx|ppt|pptx|xls|xlsx|txt|pdf',
        'create_pdf_types'  =>  '.doc|.docx|.ppt|.pptx|.xls|.xlsx',
        'max_size'  =>  10 * 1024 * 1024,
        'overwrite' => true,
    ),
    'convert'   =>  array(
        'url'   =>  'http://127.0.0.1:8080/FileUpload/FileUpload',
    ),
    'upload_key'    =>  array(
        'ak'    =>  '23099797',
        'sk'    =>  'db5e2e184797792868880f950af9a074'
    )

);