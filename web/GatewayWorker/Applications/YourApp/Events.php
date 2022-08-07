<?php
require_once('Connection.php');

use GatewayWorker\Lib\Gateway;
use Workerman\Lib\Timer;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events{
    public static $db = null; //数据库实例
    public static $name ='';
    /**
     * 进程启动后初始化数据库连接
     */
    /**
     * 进程启动后初始化数据库连接
     */
    public static function onWorkerStart($worker)
    {
        self::$db = new \Workerman\MySQL\Connection('127.0.0.1', '3306', '154_64_2_4', 'TsWizebMAdNJ77rR', '154_64_2_4');
        self::$name = self::$db->column('SELECT name FROM fa_bullet_name');
        
          if ($worker->id == 0) {
            
               //定时任务
              Timer::add(2, function () {
                  $name = self::$name;
                  $bullet = array('光临房间', '离开房间', '光临房间');
                  $bullet = $bullet[array_rand($bullet)];
                  $name = $name[array_rand($name)];
                  $name != '游客' ? $level = mt_rand(3, 30) : $level = 1;
                  $res = array(
                      'type' => 'add',
                      'name' => $name,
                      'message' => $bullet,
                      'level' => $level
                  );
                  $time = mt_rand(1, 2);
                  usleep($time*10000);
                  Gateway::sendToAll(json_encode($res));
                
              });

          }
          if ($worker->id == 1) {

               //定时任务
              Timer::add(60, function () {
                   //数据库链接
                  $data = array("1_1588736866.jpg", "2_1588736906.jpg", "3_1588736916.jpg", "4_1588736927.jpg", "5_1588736939.jpg", "7_1588737044.jpg", "8_1588737058.jpg", "10_1588737071.jpg", "11_1588737096.jpg", "12_1588737120.jpg", "13_1588737130.jpg", "14_1588737138.jpg", "15_1588737244.jpg", "16_1588737259.jpg", "17_1588737267.jpg", "18_1588737279.jpg", "19_1588737290.jpg", "20_1588737303.jpg", "21_1588740537.jpg", "22_1588740556.jpg", "23_1588740572.jpg", "24_1588740586.jpg", "26_1588741401.jpg", "27_1588741443.jpg", "28_1588741455.jpg", "29_1588741475.jpg", "31_1588741495.jpg", "32_1588741508.jpg", "33_1588741526.jpg", "34_1588741536.jpg", "35_1588741549.jpg", "36_1588741559.jpg", "37_1588741571.jpg", "38_1588741586.jpg", "39_1588741596.jpg", "40_1588741605.jpg", "41_1588741614.jpg", "42_1588741624.jpg", "43_1588741635.jpg", "44_1588741645.jpg", "45_1588741657.jpg", "46_1588741666.jpg", "47_1588741676.jpg", "48_1588741687.jpg", "49_1588741697.jpg", "50_1588741707.jpg");
                  $res = 'http: ht.jssq.tv/mrtx/' . $data[array_rand($data)];
                  $bullet = rand(0, 7);
                  $name = self::$name;
                  $name = $name[array_rand($name)];
                  $name != '游客' ? $level = mt_rand(3, 30) : $level = 1;
                  $res = array(
                      'type' => 'gift',
                      'image' => $res,
                      'name' => $name,
                      'message' => $bullet,
                      'level' => $level,
                      'msg' => '礼物发送成功',
                  );
                  $time = mt_rand(4, 10);
                  usleep($time *1000);
                  Gateway::sendToAll(json_encode($res));
              });

          }
          if ($worker->id == 2) {
               //定时热度
              Timer::add(1, function () {
                  $res = self::$db->query('SELECT room_number,heat FROM fa_direct');
                  foreach ($res as $item) {
                      $res = array(
                          'type' => 'heat',
                          'num' => $item['heat'],
                      );
                      Gateway::sendToGroup($item['room_number'], json_encode($res));
                  }
              });
          }
          if ($worker->id == 3) {

               //定时任务
              Timer::add(5, function () {
                   //数据库链接
                  $bullet = self::$db->single('SELECT text FROM fa_direct_bullet ORDER BY RAND() LIMIT 1');
                  $name = self::$name;
                  $name = $name[array_rand($name)];
                  $name != '游客' ? $level = mt_rand(3, 30) : $level = 1;
                  $res = array(
                      'type' => 'send',
                      'name' => $name,
                      'message' => $bullet,
                      'level' => $level
                  );
                  $time = mt_rand(2, 8);
                  usleep($time*6000);
                  Gateway::sendToAll(json_encode($res));
              });

          }
          
    }

    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 商
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        // 向当前client_id发送数据
        $res = array(
            'type' => 'init',
            'client_id' => $client_id
        );
        Gateway::sendToClient($client_id, json_encode($res));
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     */
    public static function onMessage($client_id, $message)
    {
    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {
    }
}
