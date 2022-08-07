<?php
/**
 * Created by 老成,技术咨询请加群:348455534
 * Date: 2019/10/22
 * Time: 19:32
 */

namespace addons\cmstool\service\callback;

use addons\cmstool\service\CollectCallback;
use addons\cmstool\service\HttpUtils;

class GirlPage extends CollectCallback
{

    const title="采集妹子图片并保存在/pulic/uploads文件夹";

    public function execResult($result){
        $folder=ROOT_PATH."public/uploads/girl/";
        if(!is_dir($folder)){
            mkdir($folder);
        }
        $body=$result['body'];
        $this->getImg($body,function ($src,$alt){
            if($this->inKeywords($alt)){
                $data=HttpUtils::get($src);
                $shortname=$this->getFileName($src);
                $file=ROOT_PATH."public/uploads/girl/".$shortname;
                if(file_exists($file)){
                    $file=ROOT_PATH."public/uploads/girl/".time().rand(1000,9999).$shortname;
                }
                file_put_contents($file,$data);
                $this->info("成功采集妹子图片:".$alt);
                return "http://www.baidu.com/";
            }
        });
        return true;
    }

    private function inKeywords($alt){
        if(!$alt){
            return false;
        }
        $keywords=['美女','校花','妹子','清纯','可爱','女生','靓女','优雅','气质'];
        foreach ($keywords as $words){
            if(strpos($alt,$words)!==false){
                return true;
            }
        }
        return false;
    }
}