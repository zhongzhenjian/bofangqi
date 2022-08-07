<?php
/**
 * Created by 老成,技术咨询请加群:348455534
 * Date: 2019/10/22
 * Time: 10:38
 */

namespace addons\cmstool\service;


function endsWith($str,$needs){
    return strrpos($str,$needs)===strlen($str)-strlen($needs);
}

function startWith($str,$needs){
    return strpos($str,$needs)===0;
}

function getmicrotime(){
    $time=microtime();
    return substr($time,10)+substr($time,0,5);
}

abstract class CollectEngine
{

    protected $collect;

    public function __construct($collect)
    {
        $this->collect=$collect;
    }

    //初始化
    protected function init(){
        $r=[];
        if($this->collect['type']==1){
            array_push($r,$this->collect['url']);
        }
        if($this->collect['type']==2 || $this->collect['type']==4){
            $html=HttpUtils::get($this->collect['url'],$this->collect['cookies']);
            if($html!='' && strpos($html,"<html")!==false && strpos($html,"<head")!==false && strpos($html,"<body")!==false){
                $r=$this->getPregA($this->collect['url'],$html,$this->collect['preg']);
            }
        }
        if($this->collect['type']==3){
            $preg=$this->collect['preg'];
            for($i=$this->collect['begin'];$i<=$this->collect['end'];$i++){
                $url="";
                if(strpos($preg,"{序号}")!==false){
                    $url=str_replace("{序号}",$i,$preg);
                }
                if(strpos($preg,"\\d+")!==false){
                    $url=str_replace("\\d+",$i,$preg);
                }
                if($url){
                    array_push($r,$url);
                }
            }
        }
        return $r;
    }

    protected function getPregA($url,$content,$preg)
    {
        $urlarr = parse_url($url);
        $host = $urlarr['scheme'] . "://" . $urlarr['host'] . "/";
        $path = $urlarr['scheme'] . "://" . $urlarr['host'] . $urlarr['path'];
        $path = substr($path, 0, strrpos($path, "/")) . "/";
        $urlArr=[];
        $html=new HtmlParse($content);
        $arr=$html->find("a[href]");
        $preg=str_replace("/","\\/",$preg);
        foreach ($arr as $a){
            $str=$a->getAttr("href");
            if(preg_match("/{$preg}/",$str)){
                $res=$str;
                if(strpos($res,"//")===0){
                    $res="http:".$res;
                }
                if(strpos($res,"/")===0){
                    $res=$host.substr($res,1);
                }
                if(strpos($res,"./")===0){
                    $res=$path.substr($res,2);
                }
                if(strpos($res,"http")===false){
                    $res=$path.$res;
                }
                array_push($urlArr,$res);
            }
        }
        return $urlArr;
    }

    //获取采集结果
    public abstract function result();

    //采集出队
    public abstract function shift();

    //采集入队
    public abstract function push($urls=[]);

    //采集完成
    public abstract function finish($data);

    //获取模板列表
    public static abstract function getTempList();

    //获取模板
    public static abstract function getTemp($id);

    //删除模板
    public static abstract function deleteTemp($id);

    //获取在队列中列表
    public static abstract function getActive($id,$page);

    //获取成功采集列表
    public static abstract function getSuccess($id,$page);

    //重置
    public static abstract function resetTemp($id);

    public function run($output)
    {
        $url=$this->shift();
        if($url){
            $begin=getmicrotime();
            $finish=[
                'url'=>$url,
            ];
            if(!$this->getAndParseHtml($url,$output,$error)){
                $finish['status']=-1;
                $finish['time']=(string)round(getmicrotime()-$begin,3);
                $finish['error']=$error;
                $this->finish($finish);
                return true;
            }
            $finish['status']=1;
            $finish['time']=(string)round(getmicrotime()-$begin,3);
            $this->finish($finish);
            return true;
        }
        return false;
    }

    protected function getAndParseHtml($url,$output,&$error)
    {
        try{
            $html=HttpUtils::get($url,$this->collect['cookies']);
            if($html=='' || strpos($html,"<html")===false || strpos($html,"<head")===false || strpos($html,"<body")===false){
                $error="读取网页失败，内容为空或者不是网页" ;
                return false;
            }
            $htmlobj=new HtmlParse($html);
            $r=[];
            foreach ($this->collect['property'] as $property){
                if(startWith($property['value'],"/") && endsWith($property['value'],"/")){
                    $preg=substr($property['value'],1,-1);
                    $elements=$htmlobj->find($preg);
                    if(count($elements)==0){
                        $r[$property['key']]="";
                    }
                    if(count($elements)==1){
                        $r[$property['key']]=$elements[0]->innerHtml();
                    }
                    if(count($elements)>1){
                        for ($i=0;$i<count($elements);$i++){
                            $inner=$elements[$i]->innerHtml();
                            $r[$property['key']][$i]=$inner;
                        }
                    }
                }else{
                    $r[$property['key']]=$property['value'];
                }
            }
            $class="addons\\cmstool\\service\\callback\\".$this->collect['callback'];

            $obj=new $class($url,$this->collect['cookies'],$output);
            $success=$obj->execResult($r);
            if($success){
                $output->info("<pre style='color: green;font-size:12px;word-wrap: break-word; white-space: pre-wrap;'>{$url}，采集成功</pre>");
            }
            //爬虫模式，获取html内的所有链接，并放到队列中去
            if($this->collect['type']==4){
                $r=$this->getPregA($url,$html,$this->collect['preg']);
                $this->push($r);
            }
        }catch (\Exception $e){
            $error="错误：".basename($e->getFile())."，".$e->getLine()."行：".$e->getMessage();
            $output->info("<pre style='color: red;font-size:12px;word-wrap: break-word; white-space: pre-wrap;'>{$error}</pre>");
            return false;
        }
        return true;
    }

    protected function lock()
    {
        $lockfile=RUNTIME."lock.txt";
        //设置超时时间，避免死锁
        $timeout=0;
        while(file_exists($lockfile)){
            $timeout++;
            if($timeout>=15){
                break;
            }
            sleep(1);
        }
        file_put_contents($lockfile,1);
    }

    protected function unlock()
    {
        $lockfile=RUNTIME."lock.txt";
        if(file_exists($lockfile)){
            unlink($lockfile);
        }
    }
}