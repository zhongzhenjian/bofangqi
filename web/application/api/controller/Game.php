<?php


namespace app\api\controller;


use app\common\controller\Api;

class Game extends Api
{
    protected $noNeedLogin = ['*'];

    public function game_list()
    {
        $res = \app\admin\model\Game::all();

        $this->success('游戏列表',$res,200);
    }
}
