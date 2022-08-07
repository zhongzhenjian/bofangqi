<?php
/**
 * Created by 老成,技术咨询请加群:348455534
 * Date: 2019/10/15
 * Time: 12:16
 */

namespace app\admin\controller\cmstool;

use app\common\controller\Backend;
use think\Cache;
use addons\cmstool\service\Plagiarism as plagService;

class Plagiarism extends Backend
{

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        return $this->view->fetch("/cmstool/plagiarism");
    }

    public function save()
    {
        $plagdata=$this->request->post("row/a");
        Cache::set("plagiarism",$plagdata);
        $this->success("成功");
    }

    public function run()
    {
        ini_set('max_execution_time','500');
        $data=Cache::get("plagiarism");
        $service=new plagService($data['url'],$data['cookies'],$data['tempfile'],$data['imgcode']);
        while($service->progress()){}
        exit();
    }

    public function openDir()
    {
        if(!function_exists("exec")){
            echo "需要打开exec函数";
            exit();
        }

        if(substr(php_uname(), 0, 7) != "Windows"){
            echo "只支持windows操作系统打开目录";
            exit();
        }
        $data=parse_url(Cache::get("plagiarism")['url'])['host'];
        $path=ROOT_PATH."public".DIRECTORY_SEPARATOR."cmstool".DIRECTORY_SEPARATOR.$data;
        exec("explorer {$path}");
        exit();
    }

}