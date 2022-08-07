<?php

namespace app\admin\model;

use think\Model;


class Adv extends Model
{


    // 表名
    protected $name = 'adv';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'datetime';

    // 定义时间戳字段名
    protected $updateTime = false;
    protected $deleteTime = false;
    protected $resultSetType = 'collection';

    // 追加属性
    protected $append = [
        'image_text',
        'avatar_image_text'
    ];

    //图片
    public function getImageTextAttr($value, $data)
    {
        if ( ! preg_match('/^http/', $data['image'])) {
            return config('host') . $data['image'];
        } else {
            return $data['image'];
        }

    }

    public function getAvatarImageTextAttr($value, $data)
    {
        if ( ! preg_match('/^http/', $data['avatar_image'])) {
            return config('host') . $data['avatar_image'];
        } else {
            return $data['avatar_image'];
        }

    }

}
