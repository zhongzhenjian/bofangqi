<?php

namespace app\admin\controller\video;

use app\admin\model\Comment;
use app\admin\model\Subordinate;
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
class Dvideo extends Backend
{

    /**
     * Dvideo模型对象
     * @var \app\admin\model\Dvideo
     */
    protected $model = null;
    protected $searchFields = 'title';

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Dvideo;

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
                ->with(['subordinate', 'labels','actress','belong'])
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with(['subordinate', 'labels','actress','belong'])
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            foreach ($list as $row) {

                $row->getRelation('subordinate')->visible(['name']);
                $row->getRelation('labels')->visible(['vname']);

            }
            $list = collection($list)->toArray();
//            var_dump($list);
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    public function add()
    {
        //分类
        $classes = ['0'=>'请选择'];
        $name = \app\admin\model\Subordinate::column('name');
        $id = \app\admin\model\Subordinate::column('id');
        for ($i = 0; $i < count($name); $i++) {
            $classes[$id[$i]] = $name[$i];
        }
        $this->assign('class', $classes);
        //标签
        $label = [];
        $name = \app\admin\model\Vlabel::column('vname');
        $id = \app\admin\model\Subordinate::column('id');
        for ($i = 0; $i < count($name); $i++) {
            $label[$id[$i]] = $name[$i];
        }
        $this->assign('label', $label);
        //演员
        $actress = ['0'=>'请选择'];
        $name = \app\admin\model\Actress::column('name');
        $id = \app\admin\model\Actress::column('id');
        for ($i = 0; $i < count($name); $i++) {
            $actress[$id[$i]] = $name[$i];
        }
        $this->assign('actress', $actress);
        $belong = ['0'=>'请选择'];
        $name = \app\admin\model\Belong::column('name');
        $id = \app\admin\model\Belong::column('id');
        for ($i = 0; $i < count($name); $i++) {
            $belong[$id[$i]] = $name[$i];
        }
        $this->assign('belong', $belong);
        return $this->parent_add();
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
//                    $all = suiji();
//                    $params['name'] = $all['name'];
//                    $params['avator_image'] = $all['image'];
                    $params['hits'] = mt_rand(30,199);
                    $params['comments'] = mt_rand(1,19);
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
                            Comment::insert(['name' => $name, 'avator_image' => $photo, 'content' => $comment[$i], 'community_id' => $result, 'class' => 3, 'creat_time' => date('Y-d-m H:i:s')]);
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

    public function edit($ids = null)
    {
        //分类
        $classes = ['0'=>'请选择'];
        $name = \app\admin\model\Subordinate::column('name');
        $id = \app\admin\model\Subordinate::column('id');
        for ($i = 0; $i < count($name); $i++) {
            $classes[$id[$i]] = $name[$i];
        }
        $this->assign('class', $classes);
        //标签
        $label = [];
        $name = \app\admin\model\Vlabel::column('vname');
        $id = \app\admin\model\Subordinate::column('id');
        for ($i = 0; $i < count($name); $i++) {
            $label[$id[$i]] = $name[$i];
        }
        $this->assign('label', $label);
        //演员
        $actress = [];
        $name = \app\admin\model\Actress::column('name');
        $id = \app\admin\model\Actress::column('id');
        for ($i = 0; $i < count($name); $i++) {
            $actress[$id[$i]] = $name[$i];
        }
        $this->assign('actress', $actress);
        $belong = ['0'=>'请选择'];
        $name = \app\admin\model\Belong::column('name');
        $id = \app\admin\model\Belong::column('id');
        for ($i = 0; $i < count($name); $i++) {
            $belong[$id[$i]] = $name[$i];
        }
        $this->assign('belong', $belong);

        $mosaic = ['0'=>'请选择','1'=>'有码','2'=>'无码'];
        $this->assign('mosaic', $mosaic);

        $duration = ['0'=>'请选择','long'=>'长视频','short'=>'短视频'];
        $this->assign('duration', $duration);

        $area = ['0'=>'请选择','TaiWan'=>'台湾','OuMei'=>'欧美','RiBen'=>'日本','GuoChan'=>'国产','HanGuo'=>'韩国'];
        $this->assign('area', $area);

        return parent::edit($ids);
    }

}
