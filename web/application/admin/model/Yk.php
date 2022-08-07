<?php

namespace app\admin\model;

use think\Model;


class Yk extends Model
{


    // 表名
    protected $name = 'yk';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'datetime';

    // 定义时间戳字段名
    protected $updateTime = false;
    protected $deleteTime = false;
    // 追加属性
    protected $append = [

    ];

    public function getPhotoAttr($value)
    {
        return config('host') . $value;
    }

}
