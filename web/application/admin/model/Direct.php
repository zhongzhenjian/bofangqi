<?php

namespace app\admin\model;

use think\Model;


class Direct extends Model
{


    // 表名
    protected $name = 'direct';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;
    protected $resultSetType = 'collection';
    // 追加属性
    protected $append = [
        'list_text',
        'direct_image_text'
    ];


    public function getListList()
    {
        $data = ['0' => '请选择'];
        $res = Directclass::select()->toArray();
        foreach ($res as $v) {
            $data[$v['id']] = $v['title'];
        }
        return $data;
    }

    public function getanchorid()
    {
        $data = ['0' => '请选择'];
        $res = Anchor::select()->toArray();
        foreach ($res as $v) {
            $data[$v['id']] = $v['name'];
        }
        return $data;
    }

    public function getListTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['list']) ? $data['list'] : '');
        $list = $this->getListList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getDirectImageTextAttr($name, $data)
    {
        if ( ! preg_match('/^http/', $data['direct_image'])) {
            return config('host') . $data['direct_image'];
        } else {
            return $data['direct_image'];
        }
    }


    public function anchor()
    {
        return $this->belongsTo('Anchor', 'anchor_id', 'id', [], 'LEFT');
    }


    public function directclass()
    {
        return $this->belongsTo('Directclass', 'list', 'id', [], 'LEFT');
    }

    public function vips()
    {
        return $this->hasMany('Vip', 'direct_id', 'id')->where('class',0);
    }
    public function guards()
    {
        return $this->hasMany('Vip', 'direct_id', 'id')->where('class',1);
    }
}
