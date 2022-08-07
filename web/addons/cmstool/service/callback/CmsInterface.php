<?php
/**
 * Created by 老成,技术咨询请加群:348455534
 * Date: 2019/10/22
 * Time: 19:32
 */

namespace addons\cmstool\service\callback;

use addons\cmstool\service\CollectCallback;
use addons\cmstool\service\HttpUtils;
use app\admin\model\cms\Archives;


class CmsInterface extends CollectCallback
{
    const title="实现cms采集的接口并插入数据到数据库";

    public function execResult($result){
        $model=new Archives();
        //这里是标题
        $row=[];
        $row['title']=$result['title'];
        $row['channel_id']=$result['channel_id'];
        //这里是内容,如果是多个标签将返回数组
        $row['content']=$result['content'] ;
        //获取段落中的图片
        $this->getImg($content,function($src,$alt){
            try{
                //下载图片到本地
                $data=HttpUtils::get($src,$this->cookies);
                $filename=ROOT_PATH."public/uploads/".$this->getFileName($src);
                //文件存在或者下载成功的情况下返回本地路径，这里检测文件是否存在的方法并不严谨
                $filepath="/uploads/".$this->getFileName($src);
                if(file_exists($filename)){
                    return $filepath;
                }
                file_put_contents($filename,$data);
                return $filepath;
            }catch (\Exception $e){
                //下载失败的情况下返回原路径
                return $src;
            }
        });
        $model->allowField(true)->save($row);
        return true;
    }
}