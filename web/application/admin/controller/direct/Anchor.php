<?php

namespace app\admin\controller\direct;

use app\common\controller\Backend;
use think\Db;
use think\exception\PDOException;

/**
 * 主播管理
 *
 * @icon fa fa-anchor
 */
class Anchor extends Backend
{

    /**
     * Anchor模型对象
     * @var \app\admin\model\Anchor
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Anchor;
        $this->view->assign("sexList", $this->model->getSexList());
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    /**
     * 删除
     */
    public function del($ids = "")
    {
        if ($ids) {
            $pk = $this->model->getPk();
            $adminIds = $this->getDataLimitAdminIds();
            if (is_array($adminIds)) {
                $this->model->where($this->dataLimitField, 'in', $adminIds);
            }
            $list = $this->model->where($pk, 'in', $ids)->select();
            $follow = new \app\admin\model\Directfollow();
            $direct = new \app\admin\model\Direct();
            $count = 0;
            Db::startTrans();
            try {
                foreach ($list as $k => $v) {
                    $count += $v->delete();
                    $follow->where('anchorid', $v->id)->delete();
                    $direct->where('anchor_id',$v->id)->delete();
                }
                Db::commit();
            } catch (PDOException $e) {
                Db::rollback();
                $this->error($e->getMessage());
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
            if ($count) {
                $this->success();
            } else {
                $this->error(__('No rows were deleted'));
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }

}
