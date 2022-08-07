<?php

namespace app\admin\model;

use think\Model;


class Edition extends Model
{


    // 表名
    protected $name = 'edition';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'file_text'
    ];

    //版本
    public function getFileTextAttr($vlaue, $data)
    {
        return config('host') . $data['file'];
    }


}
