<?php

namespace app\admin\controller\adv;

use app\common\controller\Backend;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class Other extends Backend
{

    /**
     * Other模型对象
     * @var \app\admin\model\Other
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Other;
        $list = ['视频播放前五秒', '公告后广告', 'app启动广告','小视频'];
       //$list = ['视频播放前五秒', '公告后广告', 'app启动广告','小视频','会员中心广告'];
        $this->assign('typeList', $list);

    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = false;
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $data = [];
            if (isset(input()['type'])) {
                if (input()['type'] == 'all') {
                    $data = [];
                } else {
                    $data = ['class' => input()['type']];
                }
            }
            $total = $this->model
                ->where($data)
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->where($data)
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            foreach ($list as $row) {
                $row->visible(['id', 'url', 'image', 'class', 'create_time']);

            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

}
