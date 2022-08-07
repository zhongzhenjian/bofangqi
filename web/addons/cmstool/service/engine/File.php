<?php
/**
 * Created by 老成,技术咨询请加群:348455534
 * Date: 2019/10/22
 * Time: 10:36
 */

namespace addons\cmstool\service\engine;

use  addons\cmstool\service\CollectEngine;

class File extends CollectEngine
{

    public function __construct($collect)
    {
        parent::__construct($collect);
    }

    public function init()
    {
        $this->lock();
        $b=false;
        $arr=scandir(RUNTIME."thread/");
        $md5=md5(serialize($this->collect));
        foreach($arr as $value){
            if(strpos($value,$md5)!==false){
                $nrr=explode(".",$value);
                $id=$nrr[1];
                $b=true;
            }
        }
        if(!$b){
            $urllist=parent::init();
            $id=count($arr)-1;
            $r=array(
                'active'=>[],
                'success'=>[],
                'collect'=>$this->collect,
                'id'=>$id
            );
            $i=0;
            foreach ($urllist as $v){
                if(!in_array($v,$r['active'])){
                    $r['active'][$i]=$v;
                    $i++;
                }
            }
            $filename=RUNTIME."thread/".$md5.".".$id.".json";
            file_put_contents($filename,json_encode($r));
        }
        $this->unlock();
        return $id;
    }

    public function result()
    {
        $queue=json_decode(file_get_contents($this->getFileName()),true);
        return ['active'=>count($queue['active']),'success'=>count($queue['success'])];
    }

    public function shift()
    {
        $this->lock();
        $queue=json_decode(file_get_contents($this->getFileName()),true);
        $url=$this->shiftFile($queue);
        file_put_contents($this->getFileName(),json_encode($queue));
        $this->unlock();
        return $url;
    }

    private function shiftFile(&$queue)
    {
        $data=array_shift($queue['active']);
        foreach ($queue['success'] as $success){
            if($success['url']==$data){
                return $this->shiftFile($queue);
            }
        }
        return $data;
    }

    public function push($urls=[])
    {
        $this->lock();
        $queue=json_decode(file_get_contents($this->getFileName()),true);
        foreach ($urls as $url){
            if(!in_array($url,$queue['active'])){
                array_push($queue['active'],$url);
            }
        }
        file_put_contents($this->getFileName(),json_encode($queue));
        $this->unlock();
    }

    public function finish($data)
    {
        $this->lock();
        $queue=json_decode(file_get_contents($this->getFileName()),true);
        array_push($queue['success'],$data);
        file_put_contents($this->getFileName(),json_encode($queue));
        $this->unlock();
    }

    private function getFileName()
    {
        $md5=md5(serialize($this->collect));
        $arr=scandir(RUNTIME."thread/");
        foreach($arr as $v){
            if(strpos($v,$md5)!==false){
                return RUNTIME."thread/".$v;
            }
        }
        return false;
    }

    public static function getTempList()
    {
        $r=[];
        $path=RUNTIME."thread";
        foreach (scandir($path) as $value){
            if($value=='.' || $value=='..'){
                continue;
            }
            $queue=json_decode(file_get_contents(RUNTIME."thread/".$value),true);
            $r[]=[
                'active'=>count($queue['active']),
                'success'=>count($queue['success']),
                'engine'=>'File',
                'name'=>$queue['collect']['name'],
                'id'=>$queue['id'],
            ];
        }
        return $r;
    }

    public static function getTemp($id)
    {
        $file=self::getTempFileById($id);
        $queue=json_decode(file_get_contents($file),true);
        return $queue['collect'];
    }

    public static function deleteTemp($id)
    {
        $file=self::getTempFileById($id);
        unlink($file);
    }

    //获取在队列中列表
    public static function getActive($id,$offset)
    {
        $file=self::getTempFileById($id);
        $handle=fopen($file, "r");
        $json="";
        while(!feof($handle)){
            $json.=fgets($handle);
        }
        fclose($handle);
        $queue=json_decode($json,true);
        $total=count($queue['active']);
        $rows=[];
        for($i=0;$i<$total;$i++){
            if($i<$offset){
                continue;
            }
            if($i==$offset+10){
                break;
            }
            $data=[
                'id'=>$i+1,
                'url'=>$queue['active'][$i]
            ];
            $rows[]=$data;
        }
        return ['total'=>$total,'rows'=>$rows];
    }

    //获取成功采集列表
    public static function getSuccess($id,$offset)
    {
        $file=self::getTempFileById($id);
        $handle=fopen($file, "r");
        $json="";
        while(!feof($handle)){
            $json.=fgets($handle);
        }
        fclose($handle);
        $queue=json_decode($json,true);
        $total=count($queue['success']);
        $rows=[];
        for($i=0;$i<$total;$i++){
            if($i<$offset){
                continue;
            }
            if($i==$offset+10){
                break;
            }
            $data=$queue['success'][$i];
            $data['id']=$i+1;
            $rows[]=$data;
        }
        return ['total'=>$total,'rows'=>$rows];
    }

    public static function resetTemp($id)
    {
        $file=self::getTempFileById($id);
        $queue=json_decode(file_get_contents($file),true);
        $active=$queue['active'];
        foreach ($queue['success'] as $value){
            if(!in_array($value['url'],$active)){
                array_push($active,$value['url']);
            }
        }
        $r=array(
            'active'=>$active,
            'success'=>[],
            'collect'=>$queue['collect'],
            'id'=>$id
        );
        file_put_contents($file,json_encode($r));
    }

    private static function getTempFileById($id)
    {
        $path=RUNTIME."thread";
        foreach (scandir($path) as $value){
            if($value=='.' || $value=='..'){
                continue;
            }
            $nrr=explode(".",$value);
            if($nrr[1]==$id){
                return RUNTIME."thread/".$value;
            }
        }
    }

}