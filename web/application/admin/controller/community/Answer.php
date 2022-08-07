<?php

namespace app\admin\controller\community;

use app\admin\model\Comment;
use app\common\controller\Backend;
use Exception;
use think\Db;
use think\exception\PDOException;
use think\exception\ValidateException;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class Answer extends Backend
{

    /**
     * Answer模型对象
     * @var \app\admin\model\Answer
     */
    protected $model = null;
    protected $searchFields = 'text';


    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Answer;
        $list = ['待审核', '已通过', '已拒绝'];
        $this->assign('typeList', $list);
        $ask = [];
        $name = \app\admin\model\Ask::where('class',4)->column('title');
        $id = \app\admin\model\Ask::where('class',4)->column('id');
        for ($i = 0; $i < count($name); $i++) {
            $ask[$id[$i]] = $name[$i];
        }
        $this->assign('ask', $ask);


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
                    $data = ['tong' => input()['type']];
                }
            }
            $total = $this->model
                ->with(['community'])
                ->where($where)
                ->where($data)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with(['community'])
                ->where($where)
                ->where($data)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            foreach ($list as $row) {
                $row->visible(['id','name', 'image', 'text', 'tong', 'status', 'cid', 'user_id', 'create_time']);
                $row->visible(['community']);
                $row->getRelation('community')->visible(['title', 'ask_image']);
            }
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
                    $params['fabulous'] = mt_rand(101,6798);
                    $params['browse'] = mt_rand(1087,67985);
                    $result = $this->model->allowField(true)->insertGetId($params);
                    if (config('site.auto_comment') && isset(input()['comments'])) {
                        $comment = input()['comments'];
                        $size = count($comment);
                        for ($i = 0; $i < $size; $i++) {
                            $name = file_get_contents('name.txt');//将整个文件内容读入到一个字符串中
                            $name = json_decode(mb_convert_encoding($name, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                            $name = $name[array_rand($name)];
                            $photo = file_get_contents('photo.txt');//将整个文件内容读入到一个字符串中
                            $photo = json_decode(mb_convert_encoding($photo, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                            $photo = $photo[array_rand($photo)];
                            Comment::insert(['name' => $name, 'avator_image' => $photo, 'content' => $comment[$i], 'community_id' => $result, 'class' => 2,'tong'=>1, 'creat_time' => date('Y-d-m H:i:s'),'zd'=>1,'level'=>mt_rand(0,2)]);
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
                return json(['code' => 1, 'msg' => '审核已通过，请刷新！']);
            } else {
                return json(['code' => 2, 'msg' => '系统错误']);

            }
        }
        if ($find['tong'] == '0' && $tong == '2') {
            $update = $this->model->where('id', $id)->update(['tong' => $tong]);
            if ($update) {
                return json(['code' => 1, 'msg' => '审核已拒绝，请刷新！']);
            } else {
                return json(['code' => 2, 'msg' => '系统错误']);

            }
        }
    }
}
