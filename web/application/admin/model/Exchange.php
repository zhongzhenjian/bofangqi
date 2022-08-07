<?php

namespace app\admin\model;

use think\Model;


class Exchange extends Model
{





    // 表名
    protected $name = 'exchange';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'class_text',
        'list_text'
    ];



    public function getClassList()
    {
        return ['0' => __('Class 0'), '1' => __('Class 1'), '2' => __('Class 2')];
    }

    public function getListList()
    {
        return ['0' => __('List 0'), '1' => __('List 1')];
    }


    public function getClassTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['class']) ? $data['class'] : '');
        $list = $this->getClassList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getListTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['list']) ? $data['list'] : '');
        $list = $this->getListList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function user()
    {
        return $this->belongsTo('User', 'userid', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
