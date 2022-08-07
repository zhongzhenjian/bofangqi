<?php
/**
 * Created by 老成,技术咨询请加群:348455534
 * Date: 2019/10/22
 * Time: 19:32
 */

namespace addons\cmstool\service\callback;

use addons\cmstool\service\CollectCallback;

class SinglePage extends CollectCallback
{

    const title="单网页采集示例";

    public function execResult($result){
        $title=$result['title'];
        //输出日志，可用于调试
        $this->info("这里是标题：".$title);
        $this->info("<p style='text-align: center'>========================================================================</p>");
        $content=$result['content'];
        $this->info("这里是内容,长度是：".mb_strlen($content));
        $this->info("<p style='text-align: center'>========================================================================</p>");
        $p=$result['p'];
        $this->info("下面是内容的段落：");
        $this->info(var_export($p,true));
        $this->info("<p style='text-align: center'>========================================================================</p>");
        $this->info("下面是内容中的图片：");
        $this->getImg($content,function($imgfile,$alt){
            $this->info("这是图片的绝对路径");
            $this->info($imgfile);
            //可以通过返回值替换内容的图片路径，如先下载图片后再返回一个本地的地址
            return $imgfile;
        });
        //返回true将再日志中打印出来，该条记录采集成功
        return true;
    }
}