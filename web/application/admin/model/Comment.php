<?php

namespace app\admin\model;

use think\Model;


class Comment extends Model
{


    // 表名
    protected $name = 'comment';

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

    public function getAvatorImageAttr($value)
    {
        return config('host') . $value;
    }


}
