<?php

namespace app\admin\model;

use think\Model;


class Publisher extends Model
{


    // 表名
    protected $name = 'publisher';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;
    protected $resultSetType = 'collection';

    // 追加属性
    protected $append = [

    ];

    public function getImageAttr($value)
    {
        return config('host') . $value;
    }


}
