<?php

namespace app\admin\model;

use think\Model;


class Directfollow extends Model
{


    // 表名
    protected $name = 'direct_follow';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'datetime';

    // 定义时间戳字段名
    protected $deleteTime = false;
    protected $resultSetType = 'collection';

    // 追加属性
    protected $append = [

    ];


    public function anchor()
    {
        return $this->belongsTo('Anchor', 'anchorid', 'id', [], 'LEFT');
    }


    public function user()
    {
        return $this->belongsTo('User', 'userid', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
