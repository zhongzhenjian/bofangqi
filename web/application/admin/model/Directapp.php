<?php

namespace app\admin\model;

use think\Model;


class Directapp extends Model
{


    // 表名
    protected $name = 'direct_app';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'datetime';
    protected $resultSetType = 'collection';

    // 定义时间戳字段
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'create_time_text', 'image_text'
    ];


    public function getCreateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['create_time']) ? $data['create_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setCreateTimeAttr($value)
    {
        return $value === '' ? null : ($value && ! is_numeric($value) ? strtotime($value) : $value);
    }

    public function getImageTextAttr($name, $data)
    {
        if ( ! preg_match('/^http/', $data['image'])) {
            return config('host') . $data['image'];
        } else {
            return $data['image'];
        }
    }


}
