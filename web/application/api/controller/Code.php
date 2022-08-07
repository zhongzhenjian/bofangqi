<?php


namespace app\api\controller;


use think\Controller;

class Code extends Controller
{
    public static function c_qrcode($data, $filename)
    {
        vendor("phpqrcode.phpqrcode");
        $path = "/code/" . $filename . '.jpg';
        $outfile = ROOT_PATH . 'public' . $path;
        $dir = ROOT_PATH . 'public' . "/code";
        if (!file_exists($dir)) {
            mkdir($dir,0755,true);
        }
        $level = 'L';
        $size =4 ;
        $QRcode = new \QRcode();
        ob_start();
        $QRcode->png($data, $outfile, $level, $size, 2);
        ob_end_clean();
        return $path;
    }
}
