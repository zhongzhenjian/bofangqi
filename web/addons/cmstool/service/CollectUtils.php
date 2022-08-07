<?php
/**
 * Created by 老成,技术咨询请加群:348455534
 * Date: 2019/10/21
 * Time: 15:43
 */

namespace addons\cmstool\service;


class CollectUtils
{
    public static function start($thread)
    {
        $ds=DIRECTORY_SEPARATOR;
        $arr=require APP_PATH."command.php";
        $t="";
        $b=false;
        foreach ($arr as $v){
            $t.="\"".$v."\",";
            if($v=='addons\\cmstool\\command\\CollectExec'){
                $b=true;
                break;
            }
        }
        if(!$b){
            $t.="\"addons\\cmstool\\command\\CollectExec\"";
            $str="<?php return [$t];?>";
            file_put_contents(APP_PATH."command.php",$str);
        }
        $phppath=$_SERVER['PHPRC'].$ds."php";
        $command=dirname($_SERVER['DOCUMENT_ROOT']).$ds."addons".$ds."cmstool".$ds."think CollectExec";
        $logpath=dirname($_SERVER['DOCUMENT_ROOT']).$ds."addons".$ds."cmstool".$ds."runtime".$ds."log.txt";
        $cmd=$phppath." ".$command." > ".$logpath;
        for ($i=0;$i<$thread;$i++){
            if (substr(php_uname(), 0, 7) == "Windows"){
                pclose(popen("start /B ". $cmd, "r"));
            }
            else {
                exec($cmd . " > /dev/null &");
            }
        }
    }

    public static function write($msg){
        if(strlen($msg)==0){
            return;
        }
        $div="<pre style='color: green;font-size:12px;word-wrap: break-word; white-space: pre-wrap;'>{$msg}</pre>";
        $div.="<script>document.body.scrollTop = document.body.scrollHeight;</script>";
        $len=strlen($div);
        if($len<1024*4){
            $div=$div.str_repeat(" ",1024*4-$len);
        }
        echo $div;
        ob_flush();
        flush();
    }

}