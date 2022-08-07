<?php
namespace addons\cmstool\command;


use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Cache;

define("RUNTIME",dirname(__DIR__)."/"."runtime"."/");

class CollectExec extends Command
{

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('CollectExec')->setDescription('采集启动器');
    }

    protected function execute(Input $input, Output $output)
    {
        $output->info("<p style='text-align: center;font-weight: bolder;'>==========正在启动采集器==========</p>");
        $collect=Cache::get("collect");
        if(!$collect){
            $output->error("<p style='text-align: center;font-weight: bolder;'>==========启动失败，原因是没有获取到采集参数==========</p>");
            exit();
        }
        $engine="addons\\cmstool\\service\\engine\\".$collect['engine'];
        $obj=new $engine($collect);
        while(Cache::get("collect")){
            if(!$obj->run($output)){
                break;
            }
        }
        $output->info("<p style='text-align: center;font-weight: bolder;'>==========采集完成，采集器已停止运行==========</p>");
        Cache::rm("collect");
        exit();
    }
}