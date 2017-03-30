<?php

        
require_once('../alimage.class.class.php');
$ak = 'xxxx';
$sk = 'xxxxxxxxxxxxx';
$image  = new AlibabaImage($ak, $sk, 'TOP' /*, $type, $upload_endpoint, $manage_endpoint*/);

//$res = $image->existsFile('xxxxxx', '/dir', 'block');
//$res = $image->getFile('xxxxxx', '/ddir', 'upload');
//$res = $image->listFiles('xxxxxx', '/test');
//$res = $image->deleteFile('xxxxxx', '/dir', 'block');
//$res = $image->createDir('xxxxxx', '/roodt');
$res = $image->listDirs('xxxxxx', '/roodt');
//$res = $image->existsFolder('xxxxxx', '/droot');
//$res = $image->deleteDir('xxxxxx', '/dir2');

$res = $image->addPts('xxxxxx', '/²âÊÔPOPS', 'qinning.mp4', "avEncode/encodePreset/video-generic-AVC-320x240", true);
//$res = $image->getPts('xxxxxx', '55a95fc2698370fcfcc55e664142a8089c2410c1439e');
var_dump($res);
