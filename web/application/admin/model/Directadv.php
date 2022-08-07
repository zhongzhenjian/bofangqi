<?php

namespace app\admin\model;

use think\Model;


class Directadv extends Model
{


    // 表名
    protected $name = 'direct_adv';

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

    public function getImageTextAttr($name, $data)
    {
        if ( ! preg_match('/^http/', $data['image'])) {
            return config('host') . $data['image'];
        } else {
            return $data['image'];
        }
    }

}
