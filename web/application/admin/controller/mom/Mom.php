<?php

namespace app\admin\controller\mom;

use app\common\controller\Backend;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class Mom extends Backend
{

    /**
     * Mom模型对象
     * @var \app\admin\model\Mom
     */
    protected $model = null;
    protected $searchFields = 'ip';


    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Mom;
        $list = ['游客', '会员'];
        $this->assign('typeList', $list);

    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


    /**
     * 查看
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = true;
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
                ->with(['user'])
                ->where($data)
                ->where($where)
                ->order('create_time', 'desc')
                ->count();

            $list = $this->model
                ->with(['user'])
                ->where($where)
                ->where($data)
                ->order('create_time', 'desc')
                ->limit($offset, $limit)
                ->select();

//            foreach ($list as $row) {
//
//                $row->getRelation('user')->visible(['username']);
//            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        $yk = 0;
        $vip = 0;
        $yk = $this->model->whereTime('create_time', 'today')->where('class', 0)->count();
        $vip = $this->model->whereTime('create_time', 'today')->where('class', 1)->count();
        $this->view->assign('yk', $yk);
        $this->view->assign('vip', $vip);
        return $this->view->fetch();
    }
}
