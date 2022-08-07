<?php
/**
 * Created by 老成,技术咨询请加群:348455534
 * Date: 2019/10/22
 * Time: 19:32
 */

namespace addons\cmstool\service\callback;

use addons\cmstool\service\CollectCallback;

class SortPage extends CollectCallback
{

    const title="排序模式测试方法";

    public function execResult($result){
        $this->info(var_export($result,true));
        return true;
    }
}