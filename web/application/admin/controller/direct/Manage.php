<?php

namespace app\admin\controller\direct;

use app\common\controller\Backend;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class Manage extends Backend
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
    
    public function index()
    {
        if ($this->request->isAjax())
        {
            $jiekoumodel = \app\admin\model\Jiekou::where('id', 1)->find();
            //return json($jiekoumodel['pingtai']);
            $list = [];	
      	    if (!empty($jiekoumodel)) {
      	        //begin
      	        $url = $jiekoumodel['pingtai'];
    	        $content = $this->https_request($url);
    	        $result = mb_convert_encoding($content, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
    	        //return json($result);
    	        $jsondata = json_decode($result);
    	        if (isset($jsondata)) {
    	        	
    	        	$result = $jsondata->pingtai;
            		foreach ($result as $k => $v) {
    	            	$list[$k]['address'] = 'detail/index?address='.$v->address.'&title='.$v->title.'&xinimg='.$v->xinimg;
    	           	 	$list[$k]['xinimg'] = $v->xinimg;
    	            	$list[$k]['Number'] = $v->Number;
    	            	$list[$k]['title'] = $v->title;
    	                $list[$k]['level'] = 0;
            		}
    	        }
      	        //end
      	    }
      	    //return json($result);
            $result = array("total" => 1, "rows" => $list);
            return json($result);
            
        }
        return $this->view->fetch();
    }
    
    public function detail($address)
    {
        if ($this->request->isAjax())
        {
            $jiekoumodel = \app\admin\model\Jiekou::where('id', 1)->find();
          	$list = [];	
          	if (!empty($jiekoumodel)) {
            	$url = $jiekoumodel['zhubo'] . $address;
    	        $content = $this->https_request($url);
    	        $result = mb_convert_encoding($content, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
              
            	$result = json_decode($result[1])->zhubo;
    			$xuhao = 1;
            	foreach ($result as $k => $v) {
                	$list[$k]['address'] = $v->address;
              	 	$list[$k]['img'] = $v->img;
                	$list[$k]['title'] = $v->title;
                    $list[$k]['flag'] = 1;
                    $list[$k]['id'] = $k + 1;
                    $list[$k]['roomurl'] = $address;
                    $list[$k]['xuhao'] = $xuhao;
                    
                  
                    $wheretuijian["xuhao"] = $xuhao;
                    $wheretuijian["roomurl"] = $address;
                    // $tuijian = db('zhibo_tuijian')->where($wheretuijian)->where('status',1)->find();
                    // if($tuijian){
                  	 // $list[$k]["is_tuijian"] = 1;
                    // } else {
                  	 // $list[$k]["is_tuijian"] = 0;
                    // }
                    $xuhao++;
            	}
            }
          
          	
          	$result = array("total" => 1, "rows" => $list);
            return json($result);
        }
        return $this->view->fetch();
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
