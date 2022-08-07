<?php

namespace app\admin\controller\comment;

use app\common\controller\Backend;
use think\db;

/**
 *
 *
 * @icon fa fa-comment
 */
class Comment extends Backend
{

    /**
     * Comment模型对象
     * @var \app\admin\model\Comment
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Comment;

    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->where($where)
                ->where('status', 1)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->where($where)
                ->where('status', 1)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    public function add()
    {
        /* 
         if ($this->request->isPost()) {
             $res = '';
             $res2 = '';
             if (isset(input()['comments']) && ! empty(input()['comments'])) {
                 $name = input()['comments'];
                 $if = file_get_contents('name.txt');
                 if ($if) {
                     $if = json_decode($if, true);
                     $str = json_encode(array_merge($if, $name));
                     $res = file_put_contents('name.txt', $str);
                 } else {
                     $name = json_encode($name);
                     $res = file_put_contents('name.txt', $name);
                 }
             }
             if (isset(input()['photo']) && ! empty(input()['photo'])) {
                 $photo = explode(',', input()['photo']);
                 $if2 = file_get_contents('photo.txt');
                 if ($if2) {
                     $if2 = json_decode($if2, true);
                     $str2 = json_encode(array_merge($if2, $photo));
                     $res2 = file_put_contents('photo.txt', $str2);
                 } else {
                     $photo = json_encode($photo);
                     $res2 = file_put_contents('photo.txt', $photo);
                 }
             }
             if ($res || $res2) {
                 $this->success('添加成功');
             } else {
                 $this->error('未添加');
             }
         }
         return $this->fetch();
         */
        if ($this->request->isPost()) {
            $comments = input()['comments'];
            foreach ($comments as $item) {
                db::table('fa_text')->insert(['class' => input()['class'], 'text' => $item]);
            }
            $this->success('成功');
        }
        return $this->fetch();

    }

    public function tong()
    {
        $id = input('ids');
        $tong = input('tong');
        $find = $this->model->where('id', $id)->find();
        if ($find['tong'] == '1') {
            return json(['code' => 2, 'msg' => '审核已通过,不能进行操作']);
        }
        if ($find['tong'] == '2') {
            return json(['code' => 2, 'msg' => '审核已通过,不能进行操作']);
        }
        if ($find['tong'] == '0' && $tong == '1') {
            $update = $this->model->where('id', $id)->update(['tong' => $tong]);
            if ($update) {
                return json(['code' => 1, 'msg' => '审核已通过']);
            } else {
                return json(['code' => 2, 'msg' => '系统错误']);

            }
        }
        if ($find['tong'] == '0' && $tong == '2') {
            $update = $this->model->where('id', $id)->update(['tong' => $tong]);
            if ($update) {
                return json(['code' => 1, 'msg' => '审核已拒绝']);
            } else {
                return json(['code' => 2, 'msg' => '系统错误']);

            }
        }
    }

}
