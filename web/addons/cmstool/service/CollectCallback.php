<?php
/**
 * Created by 老成,技术咨询请加群:348455534
 * Date: 2019/10/22
 * Time: 19:31
 */

namespace addons\cmstool\service;


abstract class CollectCallback
{
    protected $output;

    protected $cookies;

    protected $host;

    protected $path;

    public function __construct($url,$cookies,$output)
    {
        $urlarr = parse_url($url);
        $this->host = $urlarr['scheme'] . "://" . $urlarr['host'] . "/";
        $path = $urlarr['scheme'] . "://" . $urlarr['host'] . $urlarr['path'];
        $this->path = substr($path, 0, strrpos($path, "/")) . "/";
        $this->output=$output;
        $this->cookies=$cookies;
    }

    protected function info($msg)
    {
        $this->output->info("<pre style='color: green;font-size:12px;word-wrap: break-word; white-space: pre-wrap;'>{$msg}</pre>");
    }

    protected function error($msg)
    {
        $this->output->info("<pre style='color: red;font-size:12px;word-wrap: break-word; white-space: pre-wrap;'>{$msg}</pre>");
    }

    public abstract function execResult($result);

    protected function getImg(&$content,$callback)
    {
        $r=[];
        preg_match_all("/<img .+?>/",$content,$matches);
        if(isset($matches[0]) && count($matches[0])>0){
            foreach ($matches[0] as $img){
                $src="";
                $alt="";
                if(($srcindex=strpos($img,"src='"))!==false || ($srcindex=strpos($img,"src=\""))!==false){
                    $src=substr($img,$srcindex+5);
                    $endindex=strpos($src,"'");
                    $endindex=$endindex?$endindex:strpos($src,"\"");
                    $src=substr($src,0,$endindex);
                }
                if(($altindex=strpos($img,"alt='"))!==false || ($altindex=strpos($img,"alt=\""))!==false){
                    $alt=substr($img,$altindex+5);
                    $endindex=strpos($alt,"'");
                    $endindex=$endindex?$endindex:strpos($alt,"\"");
                    $alt=substr($alt,0,$endindex);
                }
                if($src==""){
                    continue;
                }
                $lastimg=$src;
                if(strpos($src,"//")===0){
                    $src="http:".$src;
                }
                if(strpos($src,"/")===0){
                    $src=$this->host.substr($src,1);
                }
                if(strpos($src,"./")===0){
                    $src=$this->path.substr($src,2);
                }
                if(strpos($src,"http")===false){
                    $src=$this->path.$src;
                }
                array_push($r,['src'=>$src,'alt'=>$alt,'last'=>$lastimg]);
            }
        }
        foreach ($r as $v){
            $backurl=$callback($v['src'],$v['alt']);
            if($backurl){
                $content=str_replace($v['last'],$backurl,$content);
            }
        }
    }

    //获取文件名
    protected function getFileName($file){
        $index=strpos($file,"?");
        if($index===false){
            $index=strpos($file,"#");
        }
        if($index===false){
            $index=strpos($file,"|");
        }
        if($index===false){
            return substr($file,strrpos($file, "/")+1);
        }else{
            $file=substr($file,0,$index);
            return substr($file,strrpos($file, "/")+1);
        }
    }

}