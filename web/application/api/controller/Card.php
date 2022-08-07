<?php


namespace app\api\controller;


use app\common\controller\Api;

class Card extends Api
{
    protected $noNeedLogin = ['*'];

    protected function _initialize()
    {
        $this->model = new \app\admin\model\Card();
    }

    public function index()
    {
        if ( ! $this->request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        };
        $res = $this->model->select();
        $res = collection($res)->toArray();
        $this->success('ok', $res, 200);
    }
}
