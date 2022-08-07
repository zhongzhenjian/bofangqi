<?php

namespace app\admin\model;

use app\common\model\Config;
use think\Model;


class Video extends Model
{


    // 表名
    protected $name = 'community';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;
    protected $resultSetType = 'collection';

    // 追加属性
    protected $append = [
        'images_text',
        'video_text',
        'app_text',
        'fl_text',
        'avatar_text',
        'ask_texts'
    ];

    //label
    public function labels()
    {
        return $this->belongsTo('label', 'label', 'id', '', 'left')->setEagerlyType(0);
    }


    public function getVideoTextAttr($video, $data)
    {
        if ( ! preg_match('/^http/', $data['video_image'])) {
            return config('host') . $data['video_image'];
        }
    }

    public function getAppTextAttr($video, $data)
    {
        if ( ! preg_match('/^http/', $data['app_image'])) {
            return config('host') . $data['app_image'];
        }
    }

    public function getFlTextAttr($video, $data)
    {
        if ( ! preg_match('/^http/', $data['fh_image'])) {
            return config('host') . $data['fh_image'];
        }
    }

    public function getFhImageAttr($value)
    {
        return config('host') . $value;

    }

    public function getImagesTextAttr($value, $data)
    {
        $arr = explode(',', $data['images']);
        foreach ($arr as &$item) {
            if ( ! preg_match('/^http/', $item)) {
                $item = config('host') . $item;
            }
        }
        return $arr;
    }

    public function getAvatarTextAttr($value, $data)
    {
        return config('host') . substr($data['avator_image'],20);
    }

    public function getAskTextsAttr($value, $data)
    {
        if ( ! preg_match('/^http/', $data['ask_image'])) {
            return config('host') . $data['ask_image'];
        } else {
            return $data['ask_image'];
        }
    }

    public function publisher()
    {
        return $this->belongsTo('Publisher', 'user_id', 'id', [], 'Left');
    }

    public function getVideoAttr($name)
    {
        $vide_prefix = Config::where('name', 'video_prefix')->value('value');
        if ($vide_prefix != '') {
            return $vide_prefix . substr($name, 24);
        }

        return $name;
    }
    public function getAvatorImageAttr($value, $data)
    {
        return config('host') . substr($data['avator_image'],20);
    }
    


}
