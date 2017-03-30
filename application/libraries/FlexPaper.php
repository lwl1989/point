<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无怖(285753421@qq.com)
 * Date: 2015/4/20
 * Time: 22:20
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Flexpaper{

    protected  $configs = array();
    function __construct(){
        $this->ci =& get_instance();
        $this->ci->load->config('flex_paper');
        if(	PHP_OS == "WIN32" || PHP_OS == "WINNT"	)
            $this->configs = $this->ci->config->item('win');
        else
            $this->configs = $this->ci->config->item('nix');
        $this->ci->load->helper("flexpaper");
    }

    public function convert($pdf,$swf)
    {
        $output=array();

        if(strlen($swf)>0)
            $command = $this->configs['cmd.conversion.splitpages'];
        else
            $command = $this->configs['cmd.conversion.singledoc'];

        $command = str_replace("{path.pdf}",$pdf,$command);
        $command = str_replace("{path.swf}",$swf,$command);

        try {
            if (!$this->isNotConverted($pdf)) {
                array_push ($output, utf8_encode("[Converted]"));
                return arrayToString($output);
            }
        } catch (Exception $ex) {
            array_push ($output, "Error," . utf8_encode($ex->getMessage()));
            return arrayToString($output);
        }

        $return_var=0;
        exec($command,$output,$return_var);
        if($return_var==0){
            $s="[Converted]";
        }else{
            $s="Error converting document, make sure the conversion tool is installed and that correct user permissions are applied to the SWF Path directory" ;
        }
        return $s;
    }

    /**
     * Method:isConverted
     */
    public function isNotConverted($pdfFilePath=false)
    {
        /*if (!file_exists($pdfFilePath)) {
            throw new Exception("Document does not exist");
        }*/
        //var_dump(file_exists($pdfFilePath));
    /*    if ($swfFilePath==null) {
            throw new Exception("Document output file name not set");
        } else {
            if (!file_exists($swfFilePath)) {
                return true;
            } else {
                if (filemtime($pdfFilePath)>filemtime($swfFilePath)) return true;
            }
        }*/
        return true;
    }

    public function extractText($swf)
    {
        $output=array();

        try {
            // check for directory traversal & access to non pdf files and absurdely long params
            /*if(	!validSwfParams($this->configManager->getConfig('path.swf') . $doc  . $page . ".swf",$doc,$page) )
                return;
            */
            $command = $this->cofigs['cmd.searching.extracttext'];
            $command = str_replace("{swffile}",$swf,$command);
            $return_var=0;

            exec($command,$output,$return_var);
            if($return_var==0){
                return arrayToString($output);
            }else{
                return "[Error Extracting]";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
}