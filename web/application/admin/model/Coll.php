<?php

namespace app\admin\model;

use think\Model;


class Coll extends Model
{





    // 表名
    protected $name = 'collection';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'datetime';

    // 定义时间戳字段名
    protected $updateTime = false;
    protected $deleteTime = false;
    protected $resultSetType = 'collection';

    // 追加属性
    protected $append = [

    ];










    public function user()
    {
        return $this->belongsTo('User', 'userid', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function video()
    {
        return $this->belongsTo('Dvideo', 'videoid', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
