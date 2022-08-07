<?php
/**
 * Created by 老成,技术咨询请加群:348455534
 * Date: 2019/10/18
 * Time: 14:41
 */

namespace app\admin\controller\cmstool;

use app\common\controller\Backend;
use think\Cache;
use addons\cmstool\service\CollectUtils;
use addons\cmstool\service\HttpUtils;

define("RUNTIME",ROOT_PATH."/addons/cmstool/runtime/");


class Collect extends Backend
{
    protected $model = null;

    public function index($engine='',$id=0)
    {
        $path=ROOT_PATH."addons/cmstool/service/callback/*.php";
        $callback=[];
        foreach (glob($path) as $value){
            $classname=substr(basename($value),0,-4);
            $namespace="addons\\cmstool\\service\\callback\\".$classname;
            $callback[]=[
                'name'=>$classname,
                'title'=>$namespace::title,
            ];
        }
        $this->view->assign("callback",$callback);
        if($engine && $id){
            //通过设置缓存来查看日志
            Cache::set("last_collect",['id'=>$id,'engine'=>$engine]);
            $class="addons\\cmstool\\service\\engine\\".$engine;
            $temp=$class::getTemp($id);
            $temp['property']=json_encode($temp['property']);
            $this->view->assign("temp",$temp);
        }else{
            $this->view->assign("temp",[
                'name'=>'',
                'type'=>3,
                'url'=>'',
                'begin'=>1,
                'end'=>100,
                'preg'=>'',
                'thread'=>1,
                'engine'=>'File',
                'callback'=>'CmsInterface',
                'cookies'=>'',
                'property'=>'[]',
            ]);
        }
        return $this->view->fetch("/cmstool/collect");
    }

    public function start()
    {
        ini_set('max_execution_time','3600');
        $data=$this->request->post("row/a");
        if(!function_exists("exec")){
            $this->error("需要打开exec函数");
        }
        $collect=Cache::get("collect");
        if($collect || !isset($data['name'])){
            $this->error("采集正在运行，请不要重复提交");
        }
        $data['name']=trim($data['name']);
        $data['url']=trim($data['url']);
        $data['preg']=trim($data['preg']);
        $type=$data['type'];
        $url=$data['url'];
        $cookies=$data['cookies'];
        $preg=$data['preg'];
        if($type==1 || $type==2 || $type==4) {
            $str=($type==4)?'起始地址':'网页地址';
            try{
                $content=HttpUtils::get($url,$cookies);
                if($content=='' || strpos($content,"<html")===false || strpos($content,"<head")===false || strpos($content,"<body")===false){
                    $this->error("{$str}无法获取到内容");
                }
            }catch (\Exception $e){
                $this->error("{$str}无法访问，请检查后再重新提交");
            }
        }
        if($type==3) {
            if(strpos($preg,"http")===false || (strpos($preg,"\\d+")===false && strpos($preg,"{序号}")===false)){
                $this->error("url表达式格式不对");
            }
            $begin=(int)$data['begin'];
            $end=(int)$data['end'];
            if($begin>=$end){
                $this->error("序号填写有误");
            }
		}
		if(!isset($data['pkey']) || !isset($data['pvalue'])){
            $this->error("属性不能为空");
        }
        $property=[];
        for($i=0;$i<count($data['pkey']);$i++){
            $property[$i]=[
                'key'=>$data['pkey'][$i],
                'value'=>$data['pvalue'][$i],
            ];
        }
        $data['property']=$property;
        unset($data['pkey']);
        unset($data['pvalue']);
        //初始化采集引擎
        $engine="addons\\cmstool\\service\\engine\\".$data['engine'];
        $id=(new $engine($data))->init();
        //通过设置缓存来查看日志
        Cache::set("last_collect",['id'=>$id,'engine'=>$data['engine']]);
        //删除历史日志
        $logpath=RUNTIME."log.txt";
        if(file_exists($logpath)){
            unlink($logpath);
        }
        //启动采集进程
        Cache::set("collect",$data);
        CollectUtils::start($data['thread']);
        $this->success("","","采集正在启动，请稍等");
    }

    public function stop()
    {
        $collect=Cache::get("collect");
        if(!$collect){
            $this->error("你特么逗我，老子还没开始");
        }
        Cache::set("collect","");
        $engine="addons\\cmstool\\service\\engine\\".$collect['engine'];
        $result=(new $engine($collect))->result();
        $success=$result['success'];
        $active=$result['active'];
        $this->success("","","采集已经停止，当前队列中剩余{$active}条，采集完成{$success}条数据");
    }

    public function temp()
    {
        if($this->request->isAjax()){
            $fileengine="addons\\cmstool\\service\\engine\\File";
            $r1=$fileengine::getTempList();
            $mysqlengine="addons\\cmstool\\service\\engine\\Mysql";
            $r2=$mysqlengine::getTempList();
            $rows=array_merge($r1,$r2);
            $result = array("total" => count($rows), "rows" => $rows);
            return json($result);
        }
        return $this->view->fetch("/cmstool/temp");
    }

    public function active()
    {
        $last=Cache::get("last_collect");
        if(!$last){
            return json(['total'=>0,'rows'=>[]]);
        }
        $offset=$this->request->get("offset");
        $fileengine="addons\\cmstool\\service\\engine\\".$last['engine'];
        $result=$fileengine::getActive($last['id'],$offset);
        return json($result);
    }

    public function _success()
    {
        $last=Cache::get("last_collect");
        if(!$last){
            return json(['total'=>0,'rows'=>[]]);
        }
        $offset=$this->request->get("offset");
        $fileengine="addons\\cmstool\\service\\engine\\".$last['engine'];
        $result=$fileengine::getSuccess($last['id'],$offset);
        return json($result);
    }

    public function delete($engine='',$id=0)
    {
        $collect=Cache::get("collect");
        if($collect){
            $this->error("采集正在进行，不能执行删除操作");
        }
        $fileengine="addons\\cmstool\\service\\engine\\".$engine;
        $fileengine::deleteTemp($id);
        $this->success("删除成功");
    }

    public function reset($engine='',$id=0)
    {
        $collect=Cache::get("collect");
        if($collect){
            $this->error("采集正在进行，不能执行重置操作");
        }
        $fileengine="addons\\cmstool\\service\\engine\\".$engine;
        $fileengine::resetTemp($id);
        $this->success("重置成功");
    }

    public function queueview()
    {
        return $this->view->fetch("/cmstool/queueview");
    }

    public function log()
    {
        ini_set('max_execution_time','3600');
        $index=0;
        $logpath=RUNTIME."log.txt";
        $timeout=0;
        while(file_exists($logpath)){
            $file=fopen($logpath, "r");
            $msg='';
            fseek($file,$index);
            while(!feof($file)){
                $p=fgets($file);
                $index+=strlen($p);
                $msg.=$p;
            }
            fclose($file);
            if(strlen($msg)>0){
                $div="{$msg}";
                $div.="<script>document.body.scrollTop = document.body.scrollHeight;</script>";
                $len=strlen($div);
                if($len<1024*4){
                    $div=$div.str_repeat(" ",1024*4-$len);
                }
                echo $div;
                ob_flush();
                flush();
            }else{
                $timeout++;
                //日志超时，停止显示
                if($timeout>=10){
                    Cache::set("collect","");
                    echo "<p style='text-align: center;font-weight: bolder;'>==========采集异常导致超时，请检查runtime/log/目录下的cli日志==========</p>";
                    echo "<script>parent.stopCollect();</script>";
                    exit();
                }
            }
            if(!Cache::get("collect")){
                echo "<script>parent.stopCollect();</script>";
                exit();
            }
            sleep(1);
        }
        exit();
    }
}