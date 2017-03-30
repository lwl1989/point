<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/20
 * Time: 22:23
 */

$config['win'] = array(

     "cmd.conversion.singledoc" => 'C:\SWFTools\pdf2swf.exe {path.pdf} -o {path.swf} -f -T 9 -t -s storeallcharacters',
     "cmd.conversion.splitpages" => 'C:\SWFTools\pdf2swf.exe {path.pdf} -o {path.swf} -f -T 9 -t -s storeallcharacters -s linknameurl',
     "cmd.searching.extracttext" => 'C:\SWFTools\swfstrings.exe {path.swf}'

);

$config["nix"] = array(


          "cmd.conversion.singledoc" => '/usr/local/swf/bin/pdf2swf {path.pdf} -o {path.swf} -f -T 9 -t -s storeallcharacters',
          "cmd.conversion.splitpages" => '/usr/local/swf/bin/pdf2swf {path.pdf} -o {path.swf} -f -T 9 -t -s storeallcharacters -s linknameurl',
          "cmd.searching.extracttext" => '/usr/local/swf/bin/swfstrings {path.swf}'

);