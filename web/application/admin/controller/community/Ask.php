<?php

namespace app\admin\controller\community;

use app\admin\model\Comment;
use app\common\controller\Backend;
use Exception;
use think\Db;
use think\exception\PDOException;
use think\exception\ValidateException;

/**
 * 社区
 *
 * @icon fa fa-circle-o
 */
class Ask extends Backend
{

    /**
     * Ask模型对象
     * @var \app\admin\model\Ask
     */
    protected $model = null;
    protected $searchFields = 'title';


    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Ask;
        $list = ['待审核', '已通过', '已拒绝'];
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
                    $data = ['tong' => input()['type']];
                }
            }
            $total = $this->model
                ->where('class', 4)
                ->where($data)
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->where('class', 4)
                ->where($data)
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            foreach ($list as $row) {
                $row->visible(['id', 'user_id', 'title', 'name', 'status', 'tong', 'ask_text', 'ask_image']);

            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    public function add()
    {
        return $this->parent_add();
    }

    public function edit($ids = null)
    {
        $req = input();
        $content = \app\admin\model\Answer::where('cid', $req['ids'])->field('text')->select();
        $content ?? '';
        $this->assign('content', $content);
        return parent::edit($ids);
    }

    public function parent_add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");

            if ($params) {
                $params = $this->preExcludeFields($params);
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
                    $all = suiji();
                    $params['name'] = $all['name'];
                    $params['avator_image'] = $all['image'];
                    $params['user_id'] = $all['id'];
//                    $params['fabulous'] = mt_rand(101, 6798);
//                    $params['browse'] = mt_rand(1087, 67985);
                    $params['class'] = 4;
                    $params['tong'] = 1;
                    $params['status'] = 1;
                    $result = $this->model->allowField(true)->insertGetId($params);
                    if (isset(input()['content'])) {
                        $content = input()['content'];
                        $size = count($content);
                        for ($i = 0; $i < $size; $i++) {
                            $all = suiji();
                            $data['name'] = $all['name'];
                            $data['image'] = $all['image'];
                            $data['user_id'] = $all['id'];
                            $data['cid'] = $result;
                            $data['text'] = $content[$i]['text'];
                            $data['tong'] = 1;
                            $data['status'] = 1;
                            $data['create_time'] = date('Y-m-d H:i:s');
                            \app\admin\model\Answer::insert($data);
                        }
                    }
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
}
