<?php

namespace app\admin\model;

use think\Model;


class Answer extends Model
{





    // 表名
    protected $name = 'answer';

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










    public function community()
    {
        return $this->belongsTo('Community', 'cid', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
