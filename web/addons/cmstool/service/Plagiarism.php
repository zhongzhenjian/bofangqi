<?php
/**
 * Created by 老成,技术咨询请加群:348455534
 * Date: 2019/10/19
 * Time: 11:36
 */

namespace addons\cmstool\service;

function endsWith($str,$needs){
    return strrpos($str,$needs)===strlen($str)-strlen($needs);
}

function getFileNameLong($file){
    $index=strpos($file,"?");
    if($index===false){
        $index=strpos($file,"#");
    }
    if($index===false){
        $index=strpos($file,"|");
    }
    if($index===false) {
        return substr($file,strrpos($file, "/")+1);
    }else {
        $file=substr($file,0,$index);
        return getFileNameLong($file);
    }
}

function getFileNameShort($file){
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

class Plagiarism
{
    const DS = DIRECTORY_SEPARATOR;
    private $url;
    private $host;
    private $path;
    private $cookies;
    private $template;
    private $statics;
    private $imgcode = [];
    private $act = 0;
    private $content = "";
    private $css = [];
    private $js = [];
    private $img = [];
    private $fonts = [];
    private $num = 0;

    private $finish=[];

    public function __construct($url, $cookies, $tempfile, $imgcode = "img[src]")
    {
        $this->url = $url;
        $urlarr = parse_url($url);
        $this->host = $urlarr['scheme'] . "://" . $urlarr['host'] . "/";
        $path = $urlarr['scheme'] . "://" . $urlarr['host'] . $urlarr['path'];
        $this->path = substr($path, 0, strrpos($path, "/")) . "/";
        $this->template = ROOT_PATH . "public" . DS . "cmstool" . DS . $urlarr['host'] . DS . $tempfile;
        $this->statics = ROOT_PATH . "public" . DS . "cmstool" . DS . $urlarr['host'] . DS;
        $this->cookies = $cookies;
        $this->imgcode = explode(",", $imgcode);
        !file_exists($this->statics)?mkdir($this->statics,"775",true):'';
        !file_exists($this->statics."css")?mkdir($this->statics."css","775",true):'';
        !file_exists($this->statics."js")?mkdir($this->statics."js","775",true):'';
        !file_exists($this->statics."images")?mkdir($this->statics."images","775",true):'';

        $this->finish=[
            'host'=>$urlarr['host'],
            'tempfile'=>$tempfile,
        ];
    }

    private function getContent()
    {
        $this->msg("=====正在读取网页内容=====",true);
        try {
            $this->content = HttpUtils::get($this->url, $this->cookies);
            if($this->content=='' || strpos($this->content,"<html")===false || strpos($this->content,"<head")===false || strpos($this->content,"<body")===false){
                $this->error("读取网页失败，内容为空或者不是网页" );
            }
            $this->content=$this->backgroundUrl($this->content,$this->path,true);
            $this->content=preg_replace("/charset=\".+\"/","charset=\"utf-8\"",$this->content);
        } catch (\Exception $e) {
            $this->error("读取网页失败，原因：" . $e->getMessage());
            exit();
        }
    }

    private function parseCss()
    {
        $this->msg("=====正在解析css文件=====",true);
        $html=new HtmlParse($this->content);
        $cssArr=$html->find("link[rel=stylesheet]");
        foreach ($cssArr as $css){
            $str=$css->getAttr("href");
            if(strpos($str,",")!=false){
                $this->css=array_merge($this->css,explode(",",$str));
            }else{
                array_push($this->css,$str);
            }
        }
        $this->css=array_map(function ($v){
            $res=trim($v);
            if(strpos($res,"//")===0){
                $res="http:".$res;
            }
            if(strpos($res,"/")===0){
                $res=$this->host.substr($res,1);
            }
            if(strpos($res,"./")===0){
                $res=$this->path.substr($res,2);
            }
            if(strpos($res,"http")===false){
                $res=$this->path.$res;
            }
            $this->content=str_replace($v,"css/".getFileNameLong($res),$this->content);
            return $res;
        },$this->css);
    }

    private function parseJs()
    {
        $this->msg("=====正在解析js文件=====",true);
        $html=new HtmlParse($this->content);
        $jsArr=$html->find("script[src]");
        foreach ($jsArr as $js){
            $str=$js->getAttr("src");
            if(strpos($str,",")!=false){
                $this->js=array_merge($this->js,explode(",",$str));
            }else{
                array_push($this->js,$str);
            }
        }
        $this->js=array_map(function ($v){
            $res=trim($v);
            if(strpos($res,"//")===0){
                $res="http:".$res;
            }
            if(strpos($res,"/")===0){
                $res=$this->host.substr($res,1);
            }
            if(strpos($res,"./")===0){
                $res=$this->path.substr($res,2);
            }
            if(strpos($res,"http")===false){
                $res=$this->path.$res;
            }
            $this->content=str_replace($v,"js/".getFileNameLong($res),$this->content);
            return $res;
        },$this->js);
    }

    private function parseImg()
    {
        $this->msg("=====正在解析图片文件=====",true);
        $html=new HtmlParse($this->content);
        foreach ($this->imgcode as $tag){
            $imgArr=$html->find($tag);
            foreach ($imgArr as $is){
                $imgtag=substr($tag,strpos($tag,"[")+1);
                $imgtag=substr($imgtag,0,-1);
                $v=trim($is->getAttr($imgtag));
                $res=$v;
                if(strpos($res,"//")===0){
                    $res="http:".$res;
                }
                if(strpos($res,"/")===0){
                    $res=$this->host.substr($res,1);
                }
                if(strpos($res,"./")===0){
                    $res=$this->path.substr($res,2);
                }
                if(strpos($res,"http")===false){
                    $res=$this->path.$res;
                }
                $this->content=str_replace($v,"images/".getFileNameLong($res),$this->content);
                array_push($this->img,$res);
            }
        }
    }

    private function writeCss()
    {
        $this->msg("=====正在写入css文件=====",true);
        foreach ($this->css as $css){
            $this->num++;
            $path=substr($css,0,strrpos($css,"/"))."/";
            $filename=$this->statics."css".DS.getFileNameShort($css);
            if(file_exists($filename)){
                continue;
            }
            try{
                $cssstr=HttpUtils::get($css,$this->cookies);
                if($cssstr==""){
                    $this->error("获取“{$css}”失败，内容为空" );
                    continue;
                }
                $cssstr=$this->backgroundUrl($cssstr,$path,false);
                $cssstr=mb_convert_encoding($cssstr,'UTF-8','UTF-8,GBK,GB2312,BIG5');
                file_put_contents($filename,$cssstr);
                $this->msg("写入：{$css}");
            }catch (\Exception $e){
                $this->error("获取“{$css}”失败，原因：" . $e->getMessage());
                continue;
            }
        }
    }

    private function writeJs()
    {
        $this->msg("=====正在写入js文件=====",true);
        foreach ($this->js as $js){
            $this->num++;
            $filename=$this->statics."js".DS.getFileNameShort($js);
            if(!endsWith($filename,".js")){
                $filename=$filename.".js";
            }
            if(file_exists($filename)){
                continue;
            }
            try{
                $jsstr=HttpUtils::get($js,$this->cookies);
                if($jsstr==""){
                    $this->error("获取“{$js}”失败，内容为空" );
                    continue;
                }
                $jsstr=mb_convert_encoding($jsstr,'UTF-8','UTF-8,GBK,GB2312,BIG5');
                file_put_contents($filename,$jsstr);
                $this->msg("写入：{$js}");
            }catch (\Exception $e){
                $this->error("获取“{$js}”失败，原因：" . $e->getMessage());
                continue;
            }
        }
    }

    private function writeFonts()
    {
        $this->msg("=====正在写入字体文件=====",true);
        if(count($this->fonts)>0 && !file_exists($this->statics."fonts")){
            mkdir($this->statics."fonts","775",true);
        }
        foreach ($this->fonts as $fonts){
            $this->num++;
            $filename=$this->statics."fonts".DS.getFileNameShort($fonts);
            if(file_exists($filename)){
                continue;
            }
            try{
                $fontstr=HttpUtils::get($fonts,$this->cookies);
                if($fontstr==""){
                    $this->error("获取“{$fonts}”失败，内容为空" );
                    continue;
                }
                file_put_contents($filename,$fontstr);
                $this->msg("写入：{$fonts}");
            }catch (\Exception $e){
                $this->error("获取“{$fonts}”失败，原因：" . $e->getMessage());
                continue;
            }
        }
    }

    private function writeImg()
    {
        $this->msg("=====正在写入图片文件=====",true);
        foreach ($this->img as $img){
            $this->num++;
            $filename=$this->statics."images".DS.getFileNameShort($img);
            if(strpos($img,"http")!==0){
               continue;
            }
            if(file_exists($filename)){
                continue;
            }
            try{
                $imgstr=HttpUtils::get($img,$this->cookies);
                if($imgstr==""){
                    $this->error("获取“{$img}”失败，内容为空" );
                    continue;
                }
                file_put_contents($filename,$imgstr);
                $this->msg("写入：{$img}");
            }catch (\Exception $e){
                $this->error("获取“{$img}”失败，原因：" . $e->getMessage());
                continue;
            }
        }
    }

    private function createTemp()
    {
        $this->msg("=====正在写入模板文件=====",true);
        $str=mb_convert_encoding($this->content,'UTF-8','UTF-8,GBK,GB2312,BIG5');
        file_put_contents($this->template,$str);
    }

    private function backgroundUrl($content,$path,$tempfile=false)
    {
        $preg="/url\\(.*?\\)/";
        preg_match_all($preg,$content,$matches);
        if(isset($matches[0]) && is_array($matches[0])){
            foreach ($matches[0] as $value){
                $group=$value;
                $group=substr($group,strpos($group,"(")+1);
                $group=substr($group,0,-1);
                if(strpos($group,"\"")===0 && endsWith($group,"\"")){
                    $group=substr($group,1,-1);
                }
                if(strpos($group,"'")===0 && endsWith($group,"'")){
                    $group=substr($group,1,-1);
                }
                $group=strpos($group,"?")!==false?substr($group,0,strpos($group,"?")):$group;
                if(endsWith($group,".png") || endsWith($group,".jpg") || endsWith($group,".jpeg") || endsWith($group,".gif")|| endsWith($group,".bmp")) {
                    if(strpos($group,"//")===0){
                        $group="http:".$group;
                    }
                    if(strpos($group,"/")===0){
                        $group=$this->host.substr($group,1);
                    }
                    if(strpos($group,"./")===0){
                        $group=$path.substr($group,2);
                    }
                    if(strpos($group,"http")===false){
                        $group=$path.$group;
                    }
                    array_push($this->img,$group);
                    if($tempfile) {
                        $content=str_replace($value,"url(images/".getFileNameLong($group).")",$content);
                    }else {
                        $content=str_replace($value,"url(../images/".getFileNameLong($group).")",$content);
                    }
                }
                if( endsWith($group,".eot") ||
                    endsWith($group,".otf") ||
                    endsWith($group,".fon") ||
                    endsWith($group,".font")||
                    endsWith($group,".ttf") ||
                    endsWith($group,".ttc") ||
                    endsWith($group,".svg") ||
                    endsWith($group,".woff")||
                    endsWith($group,".woff2")
                ) {
                    if(strpos($group,"//")===0){
                        $group="http:".$group;
                    }
                    if(strpos($group,"/")===0){
                        $group=$this->host.substr($group,1);
                    }
                    if(strpos($group,"./")===0){
                        $group=$path.substr($group,2);
                    }
                    if(strpos($group,"http")===false){
                        $group=$path.$group;
                    }
                    array_push($this->fonts,$group);
                    $content=str_replace($value,"url('../fonts/".getFileNameLong($group)."')",$content);
                }

            }
        }
        return $content;
    }

    private function writeButton()
    {
        $host=$this->finish['host'];
        $tempfile=$this->finish['tempfile'];
        $this->msg("=====仿站完成=====",true);
        echo
        <<<EOF
        <style>
            .footer{
                text-align: center;
                margin: 30px 0;             
            }
            .btn {
                box-shadow: none;
                border: 1px solid transparent;
                background-color: #f4f4f4;
                color: #444;
                border-color: #ddd;
                display: inline-block;
                margin-bottom: 0;
                font-weight: normal;
                text-align: center;
                vertical-align: middle;
                touch-action: manipulation;
                cursor: pointer;
                border: 1px solid transparent;
                white-space: nowrap;
                padding: 6px 12px;
                font-size: 12px;
                line-height: 1.42857143;
                border-radius: 3px;
                user-select: none;
                text-decoration: none;
            }
        </style>
        <div class="footer">
            <a class="btn" target="_blank" href='/cmstool/{$host}/{$tempfile}'>查看网页</a>
            <a class="btn" href='javascript:openDir();' style='margin-left: 30px;'>打开目录</a>
        </div>
        <script>
            function openDir() {
                 var xmlhttp=new XMLHttpRequest();
                 xmlhttp.open("GET","openDir");
                 xmlhttp.send();
                 xmlhttp.onreadystatechange=function(){
                    if(xmlhttp.readyState==4 && xmlhttp.status==200){
                        if(xmlhttp.responseText.length>0){
                             alert(xmlhttp.responseText);
                        }                   
                    }
                 }
            }
            document.body.scrollTop = document.body.scrollHeight;
        </script>
EOF;
    }

    public function progress()
    {
        switch ($this->act) {
            case 0:
                $this->getContent();
                break;
            case 1:
                $this->parseCss();
                break;
            case 2:
                $this->parseJs();
                break;
            case 3:
                $this->parseImg();
                break;
            case 4:
                $this->writeCss();
                break;
            case 5:
                $this->writeJs();
                break;
            case 6:
                $this->writeFonts();
                break;
            case 7:
                $this->writeImg();
                break;
            case 8:
                $this->createTemp();
                break;
            case 9:
                $this->writeButton();
                break;
        }
        $this->act++;
        if ($this->act == 10) {
            return false;
        }
        return true;
    }

    private function msg($str,$center=false)
    {
        $persent=0;
        if($this->num>0){
            $persent=round($this->num*100/(count($this->css)+count($this->img)+count($this->fonts)+count($this->js)));
        }
        if($center){
            $p="<p style='margin:20px 0;font-weight:bolder;color: green;font-size:12px;text-align: center;'>{$str}</p>";
        }else{
            $p="<p style='color: green;margin:5px 0;font-size:12px;'>{$str}</p>";
        }
        $p.="<script>parent.document.getElementById(\"jindu\").innerHTML=\"".$persent."%\";document.body.scrollTop = document.body.scrollHeight;</script>";
        echo $this->conpad($p);
        ob_flush();
        flush();
    }

    private function error($str)
    {
        $p="<p style='color: red;margin:5px 0;font-size:12px;'>{$str}</p>";
        echo $this->conpad($p);
        ob_flush();
        flush();
    }

    private function conpad($str)
    {
        $len=strlen($str);
        $r=str_repeat(" ",1024*4-$len);
        return $str.$r;
    }
}