<?php

namespace app\admin\model;

use think\Model;


class Relationship extends Model
{


    // 表名
    protected $name = 'relationship';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'datetime';

    // 定义时间戳字段名
    protected $updateTime = false;
    protected $deleteTime = false;
    protected $resultSetType = 'collection';
    // 追加属性
    protected $append = [

    ];


}
