<?php

namespace app\admin\controller\direct;

use app\common\controller\Backend;
use think\db;
/**
 *
 *
 * @icon fa fa-circle-o
 */
class Detail extends Backend
{

    /**
     * Directclass模型对象
     * @var \app\admin\model\Directclass
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        //$this->model = new \app\admin\model\Manage;

    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    
    // public function index()
    // {
    //     if ($this->request->isAjax())
    //     {
    //         $jiekoumodel = \app\admin\model\Jiekou::where('id', 1)->find();
    //         //return json($jiekoumodel['pingtai']);
    //         $list = [];	
    //   	    if (!empty($jiekoumodel)) {
    //   	        //begin
    //   	        $url = $jiekoumodel['pingtai'];
    // 	        $content = $this->https_request($url);
    // 	        $result = mb_convert_encoding($content, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
    // 	        //return json($result);
    // 	        $jsondata = json_decode($result);
    // 	        if (isset($jsondata)) {
    	        	
    // 	        	$result = $jsondata->pingtai;
    //         		foreach ($result as $k => $v) {
    // 	            	$list[$k]['address'] = 'manage/detail/address/'.$v->address;
    // 	           	 	$list[$k]['xinimg'] = $v->xinimg;
    // 	            	$list[$k]['Number'] = $v->Number;
    // 	            	$list[$k]['title'] = $v->title;
    // 	                $list[$k]['level'] = 0;
    //         		}
    // 	        }
    //   	        //end
    //   	    }
    //   	    //return json($result);
    //         $result = array("total" => 1, "rows" => $list);
    //         return json($result);
            
    //     }
    //     return $this->view->fetch();
    // }
    
    public function index()
    {
        $address = $_GET['address'];
        $housename = $_GET['title'];
        $houseimg = $_GET['xinimg'];
        if ($this->request->isAjax())
        {
            $jiekoumodel = \app\admin\model\Jiekou::where('id', 1)->find();
            $jieximodel = \app\admin\model\Jiexi::where('id', 1)->find();
          	$list = [];	
          	if (!empty($jiekoumodel)) {
            	$url = $jiekoumodel['zhubo'] . $address;
            	if(!strripos($url,".txt")){
            	    $url = $url.".txt";
            	}
    	        $content = $this->https_request($url);
    	        $result = mb_convert_encoding($content, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
              
            	$jsondata = json_decode($result)->zhubo;
            	
    			$xuhao = 1;
            	foreach ($jsondata as $k => $v) {
                	$list[$k]['address'] = $jieximodel['jiexi_url'].$v->address;
              	 	$list[$k]['img'] = $v->img;
                	$list[$k]['title'] = $v->title;
                    $list[$k]['flag'] = 1;
                    $list[$k]['id'] = $k + 1;
                    $list[$k]['roomurl'] = $address;
                    $list[$k]['xuhao'] = $xuhao;
                    $list[$k]["housename"] = $housename;
                    $list[$k]["houseimg"] = $houseimg;
                    
                    $is_tuijian = 0;//0未推荐 1已推荐
                    $zhuboid = 0;
                    //查询主播是否存在
                    $wherezhubo["roomurl"] = $address;
                    $wherezhubo["xuhao"] = $xuhao;
                    $zhubomodel = \app\admin\model\Anchor::where($wherezhubo)->find();
                    if($zhubomodel){
                        $zhuboid = $zhubomodel['id'];
                        
                        $wheretuijian["anchor_id"] = $zhuboid;
                        //$wheretuijian["direct_name"] = $housename;
                        $directmodel = \app\admin\model\Direct::where($wheretuijian)->find();
                        if($directmodel){
                            $is_tuijian = 1;
                        }
                    }
                    $list[$k]["is_tuijian"] = $is_tuijian;

                    $xuhao++;
            	}
            }
          
          	
          	$result = array("total" => 1, "rows" => $list);
            return json($result);
        }
        return $this->view->fetch();
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
					
					
					
					
					
				// 	//播放地址无效 要替换
				// 	if($this->is_null($url) == false){
						
				// 		if(!isset($modelarray[$v1["xuhao"]])){
				// 			//db('zhibo_tuijian')->where('roomurl', $vroom["roomurl"])->where('xuhao', $v1["xuhao"])->update(['status'=>0]);
				// 			db::table('fa_direct')->where('roomurl', $vroom["roomurl"])->where('xuhao', $v1["xuhao"])->update(['status'=>1]);
				// 		} else {
				// 			$newmodel = $modelarray[$v1["xuhao"]];
				// 	/*		if(strpos($newmodel->address,"pull")){
				// 				db('zhibo_tuijian')->where('roomurl', $vroom["roomurl"])->where('xuhao', $v1["xuhao"])->update(['status'=>0]);
				// 			} else {*/
				// 				if(!$this->is_null($newmodel->address) == false){
				// 					//db('zhibo_tuijian')->where('roomurl', $vroom["roomurl"])->where('xuhao', $v1["xuhao"])->update(['status'=>0]);
				// 					db::table('fa_direct')->where('roomurl', $vroom["roomurl"])->where('xuhao', $v1["xuhao"])->update(['status'=>1]);
				// 				} else {
									
									
				// 					db::table('fa_direct')->where('roomurl', $vroom["roomurl"])->where('xuhao', $v1["xuhao"])->update(['direct_image'=>$newmodel->img,'direct_url'=>$newmodel->address,'status'=>0]);
									
				// 					db::table('fa_anchor')->where('roomurl', $vroom["roomurl"])->where('xuhao', $v1["xuhao"])->update(['name'=>$newmodel->title,'image'=>$newmodel->img]);
				// 				}
								
				// 		//	}
				// 		}
		        		
				// 	} else {
				// 		//return json($url);
				// 		db::table('fa_direct')->where('roomurl', $vroom["roomurl"])->where('xuhao', $v1["xuhao"])->update(['status'=>0]);
				// 	}
				}
	        }
	        
		}
		return json(1);
    }
    
    //rtmp转http
  	private function rtmp4http($url){
    	return $url = "http".trim($url,"rtmp").".m3u8";
    }
    
    //判断当前主播是否下播
  	function is_null($url){
  		//$url = 'http://pull.ml29gc.top:81/7813fce77071fbe5d5a50048feb23d73';
      	if(stripos($url,"rtmp") !== false){
        	$url = $this->rtmp4http($url);
        }
		$ch = curl_init(); 
		$timeout = 10; 
		curl_setopt ($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_HEADER, 1); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
		$contents = curl_exec($ch);
      	$rest = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
      	//return json($rest);
      	if($rest == 404 || $rest == 0 || $rest == 302){
        	return 0;
        }else{
        	return 1;
        }
  	}
    
    
    
    
    public function canceltuijian(){
        $title = input('title');//主播名称
        $housename = input('housename');//房间名称
        $houseimg = input('houseimg');//房间封面
        $img = input('img');//主播封面
        $address = input('address');//主播播放地址
        $roomurl = input('roomurl');//房间地址
        $xuhao = input('xuhao');//序号
        
        $zhuboid = 0;
        //查询主播是否存在
        $wherezhubo["roomurl"] = $roomurl;
        $wherezhubo["xuhao"] = $xuhao;
        $zhubomodel = \app\admin\model\Anchor::where($wherezhubo)->find();
        if($zhubomodel){
            $zhuboid = $zhubomodel['id'];
            
            $wheretuijian["anchor_id"] = $zhuboid;
            //$wheretuijian["direct_name"] = $housename;
            $directmodel = \app\admin\model\Direct::where($wheretuijian)->find();
            if($directmodel){
                db::table('fa_direct')->where('id', $directmodel['id'])->delete();
                return json(['code' => 2, 'msg' => '取消推荐成功']);
            } else {
                return json(['code' => 2, 'msg' => '该主播还没推荐，先推荐']);
            }
        } else {
            return json(['code' => 2, 'msg' => '该主播还没推荐，先推荐']);
        }

    }
    
    public function tuijian(){
        $title = input('title');//主播名称
        $housename = input('housename');//房间名称
        $houseimg = input('houseimg');//房间封面
        $img = input('img');//主播封面
        $address = input('address');//主播播放地址
        //return json(['code' => 2, 'msg' => $address]);
        $address_split = explode('=', $address)[1];
        //return json(['code' => 2, 'msg' => $address_split]);
        $roomurl = input('roomurl');//房间地址
        $xuhao = input('xuhao');//序号
        
        $is_tuijian = 0;//0未推荐 1已推荐
        $zhuboid = 0;
        //查询主播是否存在
        $wherezhubo["roomurl"] = $roomurl;
        $wherezhubo["xuhao"] = $xuhao;
        $zhubomodel = \app\admin\model\Anchor::where($wherezhubo)->find();
        if($zhubomodel){
            $zhuboid = $zhubomodel['id'];
            
            $wheretuijian["anchor_id"] = $zhuboid;
            //$wheretuijian["direct_name"] = $housename;
            $directmodel = \app\admin\model\Direct::where($wheretuijian)->find();
            if($directmodel){
                $is_tuijian = 1;
            }
        }
        
        if($is_tuijian == 1){
            return json(['code' => 2, 'msg' => '该主播已经推荐过，请勿重复推荐']);
        } else{
            //return json(['code' => 2, 'msg' => '没有']);
            $room_number = mt_rand(10000000, 99999999);
            $gift = mt_rand(1, 30);
            $ranking = mt_rand(1, 100);
            $vip = mt_rand(1, 20);
            $guard = mt_rand(0, 5);
            $heat = mt_rand(1, 60000);
            $online = mt_rand(1999, 19999);
            
            $anchor_id = 9999;
            $list = 1;
            $direct_name = '花堂直播';
            $direct_image = $img;
            $direct_url = $address_split;
            //$room_name = $housename;
            $create_time = date("Y-m-d H:i:s");
            $update_time = date("Y-m-d H:i:s");
            
            
            
            if(!$zhubomodel){
                //添加主播信息
                $zhuboid = db::table('fa_anchor')->insertGetId(['name' => $title,'sex' => 0,'image' => $img,'level' => 1,'content' => '个人简介','fans' => mt_rand(1, 50000),'create_time' => $create_time,'update_time' => $update_time,'roomurl' => $roomurl,'xuhao' => $xuhao]);
                //$addzhubomodel = \app\admin\model\Anchor::where('name', $title)->find();
                //$zhuboid = $addzhubomodel['id'];
            } 
            
            
            $id = db::table('fa_direct')->insertGetId(['anchor_id' => $zhuboid,'room_number' => $room_number,'gift' => $gift,'ranking' => $ranking,'vip' => $vip,'guard' => $guard,'heat' => $heat,'online' => $online,'list' => $list,'direct_name' => $direct_name,'direct_image' => $direct_image,'direct_url' => $direct_url,'switch' => 1,'create_time' => $create_time,'update_time' => $update_time,'roomurl' => $roomurl,'xuhao' => $xuhao,'status' => 0]);
            if($id){
                for ($i = 0; $i < $vip; $i++) {
                        $name = file_get_contents('name.txt');//将整个文件内容读入到一个字符串中
                        $name = json_decode(mb_convert_encoding($name, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                        $name = $name[array_rand($name)];
                        $photo = file_get_contents('photo.txt');//将整个文件内容读入到一个字符串中
                        $photo = json_decode(mb_convert_encoding($photo, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                        $photo = $photo[array_rand($photo)];
                        $data[] = ['direct_id' => $id, 'name' => $name, 'image' => $photo, 'sex' => mt_rand(0, 1), 'level' => mt_rand(1, 30), 'contribution' => mt_rand(1, 100), 'class' => 0];
                    }
                    //守护
                    for ($i = 0; $i < $guard; $i++) {
                        $name = file_get_contents('name.txt');//将整个文件内容读入到一个字符串中
                        $name = json_decode(mb_convert_encoding($name, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                        $name = $name[array_rand($name)];
                        $photo = file_get_contents('photo.txt');//将整个文件内容读入到一个字符串中
                        $photo = json_decode(mb_convert_encoding($photo, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                        $photo = $photo[array_rand($photo)];
                        $data[] = ['direct_id' => $id, 'name' => $name, 'image' => $photo, 'sex' => mt_rand(0, 1), 'level' => mt_rand(1, 30), 'contribution' => mt_rand(1, 100), 'class' => 1];
                    }
                    $vip = new \app\admin\model\Vip();
                    $vip->saveAll($data);
        }
            
            return json(['code' => 2, 'msg' => '推荐成功']);
        }
        
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
