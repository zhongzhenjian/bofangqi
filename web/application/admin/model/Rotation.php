<?php

namespace app\admin\model;

use think\Model;


class Rotation extends Model
{


    // 表名
    protected $name = 'rotation';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'datetime';

    // 定义时间戳字段名
    protected $updateTime = false;
    protected $deleteTime = false;
    protected $resultSetType = 'collection';

    // 追加属性
    protected $append = [
        'image_text'
    ];
    //图片
    public function getImageTextAttr($value,$data)
    {
        return config('host').$data['r_image'];
    }


}
