<?php

namespace app\admin\controller\direct;

use app\common\controller\Backend;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class Bulletname extends Backend
{

    /**
     * Bulletname模型对象
     * @var \app\admin\model\Bulletname
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Bulletname;

    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = input('row/a');
            foreach ($params['content'] as $key => $item) {
                if ($item['name'] == '') {
                    unset($params['content'][$key]);
                }
            }
            $res = $this->model->saveAll($params['content']);
            if ($res) {
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }

        }
        return $this->view->fetch();
    }

}
