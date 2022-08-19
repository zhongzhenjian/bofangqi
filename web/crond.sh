#!/bin/sh
PATH=/usr/local/php/bin:/opt/someApp/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin # 将php路径加入都临时变量中
cd /www/wwwroot/xixi.putao.com/web/  # 进入项目的根目录下，保证可以运行php think的命令
php think Test # 执行在Test.php设定的名称