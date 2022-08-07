<?php

namespace app\admin\controller\direct;

use app\common\controller\Backend;
use think\Db;
use think\exception\PDOException;
use think\exception\ValidateException;

/**
 * 直播间
 *
 * @icon fa fa-circle-o
 */
class Direct extends Backend
{

    /**
     * Direct模型对象
     * @var \app\admin\model\Direct
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Direct;
        $this->view->assign("listList", $this->model->getListList());
        $this->view->assign("anchorid", $this->model->getanchorid());
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
            $total = $this->model
                ->with(['anchor', 'directclass'])
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with(['anchor', 'directclass'])
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

//            foreach ($list as $row) {
//
//                $row->getRelation('anchor')->visible(['name', 'image']);
//                $row->getRelation('directclass')->visible(['title']);
//            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);
                $find = \app\admin\model\Direct::where('anchor_id', $params['anchor_id'])->find();
                if ($find) {
                    $this->error('此主播已有直播间,请务重复添加');
                }
                $data = [];
                $params['room_number'] = mt_rand(10000000, 99999999);
                $params['gift'] = mt_rand(1, 30);
                $params['ranking'] = mt_rand(1, 100);
                $params['online'] = mt_rand(1999, 19999);
                if ($params['vip'] == '') {
                    $params['vip'] = mt_rand(1, 20);
                }
                if ($params['guard'] == '') {
                    $params['guard'] = mt_rand(0, 5);
                }
                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                        $this->model->validateFailException(true)->validate($validate);
                    }
                    $result = $this->model->allowField(true)->save($params);
                    //贵宾
                    for ($i = 0; $i < $params['vip']; $i++) {
                        $name = file_get_contents('name.txt');//将整个文件内容读入到一个字符串中
                        $name = json_decode(mb_convert_encoding($name, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                        $name = $name[array_rand($name)];
                        $photo = file_get_contents('photo.txt');//将整个文件内容读入到一个字符串中
                        $photo = json_decode(mb_convert_encoding($photo, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                        $photo = $photo[array_rand($photo)];
                        $data[] = ['direct_id' => $this->model->id, 'name' => $name, 'image' => $photo, 'sex' => mt_rand(0, 1), 'level' => mt_rand(1, 30), 'contribution' => mt_rand(1, 100), 'class' => 0];
                    }
                    //守护
                    for ($i = 0; $i < $params['guard']; $i++) {
                        $name = file_get_contents('name.txt');//将整个文件内容读入到一个字符串中
                        $name = json_decode(mb_convert_encoding($name, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                        $name = $name[array_rand($name)];
                        $photo = file_get_contents('photo.txt');//将整个文件内容读入到一个字符串中
                        $photo = json_decode(mb_convert_encoding($photo, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                        $photo = $photo[array_rand($photo)];
                        $data[] = ['direct_id' => $this->model->id, 'name' => $name, 'image' => $photo, 'sex' => mt_rand(0, 1), 'level' => mt_rand(1, 30), 'contribution' => mt_rand(1, 100), 'class' => 1];
                    }
                    $vip = new \app\admin\model\Vip();
                    $vip->saveAll($data);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were inserted'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }

    //删除
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
                    //删除
                    $follow->where('anchorid', $v->anchor_id)->delete();
                    $count += $v->delete();
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
