<?php


namespace app\api\controller;

use app\common\controller\Api;
use app\common\model\Config;
use think\Request;

class Yk extends Api
{
    protected $noNeedLogin = ['*'];

    public function _initialize()
    {
        $this->model = new \app\admin\model\Yk();
    }

    //app游客
    public function app(Request $request)
    {
        $req = $request->post();
        if ( ! isset($req['code']) || $req['code'] == '') {
            $this->error('ＣＯＤＥ 不能为空');
        }
        $set = Config::where('name', 'ykc')->whereOr('name', 'tvideo')->select();
        $set = collection($set)->toArray();
        $req['class'] = '0';
        $req['tgkcs'] = $set[0]['value'];
        $req['gkcs'] = $set[1]['value'];
        $req['photo'] = '/mrtx/'.$this->suiji();
        $res = $this->model->save($req);
        $find = $this->model->where('code',$req['code'])->find();
        if ($res) {
            $this->success('游客登陆成功',$find,200);
        }
    }

    //H5
    public function pc(Request $request)
    {
        $set = Config::where('name', 'ykc')->whereOr('name', 'tvideo')->select();
        $set = collection($set)->toArray();
        $req = array(
            'photo'=>'/mrtx/'.$this->suiji(),
            'class' => 1,
            'tgkcs' => $set[0]['value'],
            'gkcs' => $set[1]['value'],
            'code' => uniqid()
        );
        $res = $this->model->save($req);
        $find = $this->model->where('code',$req['code'])->find();
        if ($res) {
            $this->success('游客登陆成功', $find, 200);
        }
    }

    //减少观看次数
    public function del(Request $request)
    {
        $allowall = Config::where('name', 'allowfree')->value('value');
        if ($allowall == '1') {
            //次数全部免费
            $this->success('ok', '', 200);
        }
        $req = $request->post();
        $yk = $this->model->where(['code' => $req['code']])->find();
        if ($req['class'] == 0) {
            if ($yk['gkcs'] != 0) {
                $res = $this->model->where(['code' => $req['code']])->setDec('gkcs', 1);
            } else {
                $this->error('次数已用完', [], 100);
            }
        } else {
            if ($yk['tgkcs'] != 0) {
                $res = $this->model->where(['code' => $req['code']])->setDec('tgkcs', 1);
            } else {
                $this->error('小视频的次数已用完', [], 100);
            }
        }
        if ($res) {
            $this->success('成功', $req['code'], 200);

        }
    }

    public function suiji()
    {
        $data = array("1_1588736866.jpg", "2_1588736906.jpg", "3_1588736916.jpg", "4_1588736927.jpg", "5_1588736939.jpg", "7_1588737044.jpg", "8_1588737058.jpg", "10_1588737071.jpg", "11_1588737096.jpg", "12_1588737120.jpg", "13_1588737130.jpg", "14_1588737138.jpg", "15_1588737244.jpg", "16_1588737259.jpg", "17_1588737267.jpg", "18_1588737279.jpg", "19_1588737290.jpg", "20_1588737303.jpg", "21_1588740537.jpg", "22_1588740556.jpg", "23_1588740572.jpg", "24_1588740586.jpg", "26_1588741401.jpg", "27_1588741443.jpg", "28_1588741455.jpg", "29_1588741475.jpg", "31_1588741495.jpg", "32_1588741508.jpg", "33_1588741526.jpg", "34_1588741536.jpg", "35_1588741549.jpg", "36_1588741559.jpg", "37_1588741571.jpg", "38_1588741586.jpg", "39_1588741596.jpg", "40_1588741605.jpg", "41_1588741614.jpg", "42_1588741624.jpg", "43_1588741635.jpg", "44_1588741645.jpg", "45_1588741657.jpg", "46_1588741666.jpg", "47_1588741676.jpg", "48_1588741687.jpg", "49_1588741697.jpg", "50_1588741707.jpg");
        $res = $data[array_rand($data)];
        return $res;
    }

}
