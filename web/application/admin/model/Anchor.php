<?php

namespace app\admin\model;

use think\Model;


class Anchor extends Model
{


    // 表名
    protected $name = 'anchor';

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


    public function getSexList()
    {
        return ['0' => __('Sex 0'), '1' => __('Sex 1')];
    }


    public function getSexTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['sex']) ? $data['sex'] : '');
        $list = $this->getSexList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getImageTextAttr($name, $data)
    {
        if ( ! preg_match('/^http/', $data['image'])) {
            return config('host') . $data['image'];
        } else {
            return $data['image'];
        }
    }

    public function direct()
    {
        return $this->hasOne('Direct', 'anchor_id', 'id', [], 'LEFT');

    }


}
