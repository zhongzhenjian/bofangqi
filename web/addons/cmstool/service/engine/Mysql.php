<?php
/**
 * Created by 老成,技术咨询请加群:348455534
 * Date: 2019/10/22
 * Time: 10:35
 */

namespace addons\cmstool\service\engine;


use addons\cmstool\service\CollectEngine;

class Mysql extends CollectEngine
{
    private $collctModel;
    private $queueModel;

    public function __construct($collect)
    {
        $this->collctModel=db("cms_collect");
        $this->queueModel=db("cms_collect_queue");
        parent::__construct($collect);
    }

    public function init()
    {
        $this->lock();
        $md5=md5(serialize($this->collect));
        $arr=$this->collctModel->where("md5",$md5)->column("id");
        $id=0;
        if(count($arr)>0){
            $id=$arr[0];
        }
        if($id==0){
            $urllist=parent::init();
            $collect=$this->collect;
            $collect['property']=json_encode($collect['property']);
            $collect['md5']=$md5;
            $id=$this->collctModel->insert($collect,false,true);
            foreach ($urllist as $url){
                $data=[
                    'url'=>$url,
                    'status'=>0,
                    'collect_id'=>$id,
                ];
                $count=$this->queueModel->where("url",$url)->count();
                if($count==0){
                    $this->queueModel->insert($data);
                }
            }
        }
        $this->unlock();
        return $id;
    }

    public function result()
    {
        $collect_id=$this->getId();
        $active=$this->queueModel->where(['collect_id'=>$collect_id,'status'=>0])->count();
        $success=$this->queueModel->where(['collect_id'=>$collect_id,'status'=>1])->count();
        $error=$this->queueModel->where(['collect_id'=>$collect_id,'status'=>-1])->count();
        return ['active'=>$active,'success'=>$error+$success];
    }

    public function shift()
    {
        $this->lock();
        $data=$this->queueModel->where(["collect_id"=>$this->getId(),"status"=>0])->limit(1)->select();
        $url="";
        if(count($data)>0){
            $url=$data[0]['url'];
        }
        $this->unlock();
        return $url;
    }

    public function push($urls=[])
    {
        $this->lock();
        $id=$this->getId();
        foreach ($urls as $url){
            $count=$this->queueModel->where(["collect_id"=>$id,"url"=>$url])->count();
            if($count==0){
                $this->queueModel->insert([
                    'url'=>$url,
                    'status'=>0,
                    'collect_id'=>$id,
                ]);
            }
        }
        $this->unlock();
    }

    public function finish($data)
    {
        $this->lock();
        $this->queueModel->where(["collect_id"=>$this->getId(),"url"=>$data['url']])->update($data);
        $this->unlock();
    }

    private function getId()
    {
        $md5=md5(serialize($this->collect));
        $data=$this->collctModel->where("md5",$md5)->find();
        if($data){
            return $data['id'];
        }
        return 0;
    }

    public static function getTempList()
    {
        $data=db("cms_collect")->select();
        for($i=0;$i<count($data);$i++){
            $id=$data[$i]['id'];
            $data[$i]['active']=db("cms_collect_queue")->where("collect_id=${id} and status=0")->count();
            $data[$i]['success']=db("cms_collect_queue")->where("collect_id=${id} and (status=1 or status=-1)")->count();
        }
        return $data;
    }

    public static function getTemp($id)
    {
        $data=db("cms_collect")->where("id",$id)->find();
        $data['property']=json_decode($data['property'],true);
        return $data;
    }

    public static function deleteTemp($id)
    {
        db("cms_collect_queue")->where("collect_id",$id)->delete();
        db("cms_collect")->where("id",$id)->delete();
    }

    //获取在队列中列表
    public static function getActive($id,$offset)
    {
        $rows=db("cms_collect_queue")->where(['collect_id'=>$id,'status'=>0])->limit($offset,10)->select();
        $total=db("cms_collect_queue")->where(['collect_id'=>$id,'status'=>0])->count();
        return ['total'=>$total,'rows'=>$rows];
    }

    //获取成功采集列表
    public static function getSuccess($id,$offset)
    {
        $where="collect_id=${id} and (status=1 or status=-1)";
        $rows=db("cms_collect_queue")->where($where)->limit($offset,10)->select();
        $total=db("cms_collect_queue")->where($where)->count();
        return ['total'=>$total,'rows'=>$rows];
    }

    public static function resetTemp($id)
    {
        db("cms_collect_queue")->where("collect_id",$id)->update([
            'status'=>0,
            'error'=>null,
            'time'=>null
        ]);
    }

}