<?php

namespace addons\cmstool;

use app\common\library\Menu;
use think\Addons;

/**
 * 插件
 */
class Cmstool extends Addons
{

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        $menu = [
            [
                'name'    => 'cmstool',
                'title'   => 'CMS工具',
                'icon'    => 'fa fa-file-text-o',
                'remark'  => 'CMS文章采集，仿站等',
                'sublist' => [
                    [
                        'name' => 'cmstool/plagiarism',
                        'icon'    => 'fa fa-chain',
                        'title' => 'CMS仿站',
                        'sublist' => [
                            ['name'=>'cmstool/plagiarism/index','title'=>'查看']
                        ]
                    ],
                    [
                        'name' => 'cmstool/collect',
                        'icon'    => 'fa fa-external-link',
                        'title' => 'CMS采集',
                        'sublist' => [
                            ['name'=>'cmstool/collect/index','title'=>'查看']
                        ]
                    ]
                ]
            ]
        ];
        Menu::create($menu);
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        Menu::delete('cmstool');
        return true;
    }

    /**
     * 插件启用方法
     */
    public function enable()
    {
        Menu::enable('cmstool');
    }

    /**
     * 插件禁用方法
     */
    public function disable()
    {
        Menu::disable('cmstool');
    }

    /**
     * 实现钩子方法
     * @return mixed
     */
    public function testhook($param)
    {
        // 调用钩子时候的参数信息
        print_r($param);
        // 当前插件的配置信息，配置信息存在当前目录的config.php文件中，见下方
        print_r($this->getConfig());
        // 可以返回模板，模板文件默认读取的为插件目录中的文件。模板名不能为空！
        //return $this->fetch('view/info');
    }

}
