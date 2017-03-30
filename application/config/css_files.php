<?php

$config = array(
   /* 'common' => array(
        // '/static/lib/base.css', 已经合并进common.css
        '/static/lib/common.min.css',
    ),*/
   
    /**
     * 首页样式
     */
    'index' => '/static/page/index.css',
    'bootstrap' =>  '/static/bootstrap-3.3.2-dist/css/bootstrap.min.css',
    'upload'    =>  array('/static/FileUpload/css/style.css','/static/FileUpload/css/jquery.fileupload.css','/static/FileUpload/css/jquery.fileupload-ui.css','//blueimp.github.io/Gallery/css/blueimp-gallery.min.css'),

    //'public'    =>  array('/static/public/css/bootstrap.css',)
    'public'    =>  '/static/public/css/bootstrap.css',

    'logined'   => '/static/public/css/logined.css',

    'user_account'  => array( '/static/public/css/bootstrap.css','/static/public/css/logined.css',),


    'uploadify' =>  array('/static/lib/uploadify/Huploadify'),


);
