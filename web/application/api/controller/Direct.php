<?php

namespace app\api\controller;

use app\admin\model\Directclass;
use app\common\controller\Api;
use app\common\model\Config;
use think\Request;
use think\db;

class Direct extends Api
{
    protected $noNeedLogin = ['*'];

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('请求方式错误', '', 100);
        }
        $param = $request->post();
        //直播间显示
        if($param['class']=='1'){
            $res = \app\admin\model\Direct::with('directclass,anchor')->where(['switch' => 1])->order('online desc')->page($param['current'], $param['every'])->select();
        }else{
        $res = \app\admin\model\Direct::with('directclass,anchor')->where(['switch' => 1, 'list' => $param['class']])->order('online desc')->page($param['current'], $param['every'])->select();
            
        }
        $this->result('直播间列表', $res, 200);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function direct_list()
    {
        //直播间分类
        $res = Directclass::select()->toArray();
        $this->result('直播间列表', $res, 200);
    }

    /**
     * 保存新建的资源
     *
     * @param \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param int $id
     * @return \think\Response
     */
    public function read($id)
    {
        //直播间详情
        $res = \app\admin\model\Direct::with('anchor,directclass,vips,guards')->find($id);
        $this->result('直播间详情', $res, 200);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param int $id
     * @return \think\Response
     */
    public function edit()
    {
        //
        $res = \app\admin\model\Direct::select()->toArray();
        foreach ($res as $key => &$item) {
            //在线人数修改
            $size = mt_rand(50, 150);
            $algorithm = mt_rand(0, 01);//0 减 1 加
            if ($item['online'] >= $size) {
                if ($algorithm == '0') {
                    $item['online'] = bcsub($item['online'], $size);
                } else {
                    $item['online'] = bcadd($item['online'], $size);
                }
            }
            //热度修改
            $size = mt_rand(1, 10);
            $item['heat'] = bcadd($item['heat'], $size);
            unset($item['list_text']);
            unset($item['direct_image_text']);
        }
        $direct = new \app\admin\model\Direct();
        $direct->saveAll($res);
    }

    /**
     * 保存更新的资源
     *
     * @param \think\Request $request
     * @param int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //随机加减
        //0减 1加
        $type = mt_rand(0, 1);
        $size = mt_rand(5, 10);
        if ($type == 0) {
            $res = \app\admin\model\Direct::where('id', $id)->setDec('online', $size);
        } else {
            $res = \app\admin\model\Direct::where('id', $id)->setInc('online', $size);
        }
        if($res){
            $this->success('成功','',200);
        }else{
            $this->error('失败','',100);
        }
    }

    /**
     * 删除指定资源
     *
     * @param int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }

    /*
     * 直播间文案
     *
     * */
    public function copywriting()
    {
        //
        $res = Config::where('name', 'direct')->value('value');
        $this->result('直播间文案', $res, 200);
    }
    
    public function autoexecute() {
        
        $jiekoudata = \app\admin\model\Jiekou::where('id', 1)->find();
		$data = db::table('fa_direct')->Distinct(true)->field('roomurl')->select();
		//return json($data);
		foreach ($data as $kroom => $vroom){
			$zbarray=array();//直播名称数组
	        $dic = array();//直播名称对应序号
	        $modelarray = array();
	        $zburl = $jiekoudata['zhubo'] . $vroom["roomurl"];//直播房间的数据地址
	        $content = $this->https_request($zburl);
    	    $zbresult = mb_convert_encoding($content, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
	        //$zbresult = \HttpCurl::request($zburl, 'get', []);
	        //return json(isset(json_decode($zbresult[1])->zhubo));
	        //该房间是否有数据,没有则取消该房间所有推荐
	        if(isset(json_decode($zbresult)->zhubo) == false){
	        	//db('zhibo_tuijian')->where('roomurl', $vroom["roomurl"])->update(['status'=>0]);
	        	db::table('fa_direct')->where('roomurl', $vroom["roomurl"])->update(['status'=>1]);
	        } else {
	        	$zbresult = json_decode($zbresult)->zhubo;
				$xuhao = 1;
				foreach ($zbresult as $k => $v) {
				    if(!in_array($v->title,$zbarray)){
				        array_push($zbarray,$v->title);
				        $dic[$xuhao] = $v->title;
				        $modelarray[$xuhao] = $v;
				        $xuhao++;
				    }
		    	}
		    	//return json($dic);
				$tuijianlist = db::table('fa_direct')->where('roomurl', $vroom["roomurl"])->select();//当前表里的主播列表
				foreach ($tuijianlist as $k1 => $v1){
					$url = $v1["direct_url"];
					$zhuboid = $v1["anchor_id"];//当前表里的主播id
				// 	$zhubomodel = db::table('fa_anchor')->where('id', $zhuboid)->find();
				// 	$zhuboname = $zhubomodel['name'];
					
					//序号在当前获取的播放列表里是否存在
					if(!isset($modelarray[$v1["xuhao"]])){
					    //如果不存在 状态改为不推荐
					    db::table('fa_direct')->where('roomurl', $vroom["roomurl"])->where('xuhao', $v1["xuhao"])->update(['status'=>1]);
					} else {
					    //如果存在
					    $newmodel = $modelarray[$v1["xuhao"]];
					    db::table('fa_direct')->where('roomurl', $vroom["roomurl"])->where('xuhao', $v1["xuhao"])->update(['direct_image'=>$newmodel->img,'direct_url'=>$newmodel->address,'update_time' => date("Y-m-d H:i:s"),'status'=>0]);
									
						db::table('fa_anchor')->where('roomurl', $vroom["roomurl"])->where('xuhao', $v1["xuhao"])->update(['name'=>$newmodel->title,'image'=>$newmodel->img,'update_time' => date("Y-m-d H:i:s")]);
					}
				}
	        }
	        
		}
		return json(1);
    }
    
    // 模拟 http 请求
  function https_request($url,$data = null)
  {
      // php curl 发起get或者post请求
      // curl 初始化
     $curl = curl_init();    // curl 设置
     curl_setopt($curl, CURLOPT_URL, $url);
     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);  // 校验证书节点
     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);// 校验证书主机
 
     // 判断 $data get  or post
     if ( !empty($data) ) {
         curl_setopt($curl, CURLOPT_POST, 1);
         curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
     }
 
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  // 以文件流的形式 把参数返回进来
     // 如果这一行 不写你就收不到 返回值
 
     // 执行
     $res = curl_exec($curl);
     curl_close($curl);
     return $res;
 
 }
    
}
