<?php

namespace app\admin\model;

use think\Model;


class Actress extends Model
{


    // 表名
    protected $name = 'actress';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;
    protected $resultSetType = 'collection';

    // 追加属性
    protected $append = [
        'image_text'
    ];

    public function getImageTextAttr($value, $data)
    {
        return config('host') . $data['image'];
    }


}
