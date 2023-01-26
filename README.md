后端环境linux  nginx1.6  mysql5.6  php7.0 

后台搭建
设置TP伪静态，运行目录/public 
TP伪静态必须设置 不然打开APP会提示检测版本失败

上传网站程序到宝塔   然后解压

/application/database.php这个文件修改网站数据库

/GatewayWorker/Applications/YourApp/Events.php这个文件改聊天服务器的数据库连接
--------------------------------------------------------

启动聊天服务器设置教程：
1：PHP 7.2安装扩展（ionCube、fileinfo、opcache、redis、Swoole、Swoole4）
2：宝塔“安全”添加放行8282端口（此端口主要为Workerman聊天服务器端口，如不设置8282放行端口，APP直播间无法连接聊天服务器！）
3：配置PHP禁用函数：/server/php/70/etc/php.ini 搜索disable_functions =后面的内容替换为 passthru, exec, system, putenv, chroot, chgrp, chown, shell_exec, popen, proc_open, pcntl_exec, ini_alter, ini_restore, dl, openlog, syslog, readlink, symlink, popepassthru, pcntl_waitpid, pcntl_wifexited,pcntl_wifstopped, pcntl_wifsignaled, pcntl_wifcontinued, pcntl_wexitstatus, pcntl_wtermsig, pcntl_wstopsig, pcntl_get_last_error, pcntl_strerror, pcntl_sigprocmask, pcntl_sigwaitinfo, pcntl_sigtimedwait, pcntl_exec, pcntl_getpriority, pcntl_setpriority, imap_open, apache_setenv
                                  或直接在php.ini文件里面删除pcntl_fork,
4：启动聊天服务器命令： php start.php start（使用调试模式启动，终端关闭后workerman会随之关闭并退出）
                                      php start.php start -d（使用守护进程启动，终端关闭后workerman继续后台正常运行，但重启服务器后需要重新启动）
                           停止： php start.php stop
                           重启： php start.php restart
                     平滑重启： php start.php reload
               查看运行状态： php start.php status

终端输入：cd /www/wwwroot/你的域名/GatewayWorker
                php start.php start
workerman运行状态：     php start.php status
重启服务器后必须重新输入启动命令 启动聊天服务器！
composer require endroid/qr-code --ignore-platform-reqs
composer install --ignore-platform-reqs

/application/config.php    'host'=>'改成你的域名'   
域名修改成你自己的域名
注意：application/config.php    'host'=>'改成你的域名'  此处的域名后辍必须要加上"/"否则后台"社区管理" "视频列表"用户头像不显示
---------------------------------------------------------
H5网页端“会员中心”在线客服链接修改地址：/public/h5/static/js/pages-mine-zaixian.d0a46305.js
修改 {attrs:{src:"此处填写你的在线客服页面地址"}})]
后端H5跳转地址修改：/public/H5/static/js/index.d9c3f4b6.js      $url="https://www.baidu.com/" 这个域名替换成你自己的后台域名

修改在线客服数据库连接：/public/kefu/php/config/parameters.php
在线客服系统登陆后台地址：你的域名/kefu/php/app.php?login
在线客服后台登录账号：123456@qq.com 密码：123456
WAP端进入链接：你的域名/kefu/php/app.php?widget-test

后台的进入  域名后面加/chaoguan.php/index/login
登录账户：admin  密码：admin777
H5网页端：域名/h5进入


接下来讲下打包注意事项

工具用到
HBuilder X 
百度下载一个  然后注册登录你自己的账户

打开后点击文件  导入  从本地目录导入

main.js这个文件修改服务器链接
Vue.prototype.$url = 'https://www.baidu.com/'  第15行  修改为你网站地址
Vue.prototype.$websockerurl = "ws://103.167.180.101:8282"第16行修改为您服务器IP（注意：服务器IP地址后面必须要加上8282，这是Wokerman聊天服务器端口）


manifest.json这个文件是修改图标插件等等
注意导入项目后  点击基础配置    uni-app应用标识点击重新获取
然后再点击APP原生插件  重新购买讯课视频播放器插件；迅课视频播放器（一个账号99元）

自己修改好后   点击发行
云打包和本地打包都可以   本地打包要配置环境   这样就行了

APP开通会员自动跳转至在线客服链接（在线客服链接后台设置）
视频播放页面右上角水印修改：HbuilderX多文件搜索139.png替换即可
直播间采集默认标题文字（如：XX社区）修改：/application/admin/controller/direct/Detail.php
生成邀请码时的背景图片修改地址：/uploads/tuiguang/5a.png
后台加添视频播放失败原因：系统设置-APP设置-视频前辍修改下（一般情况下不建议开启）
系统配置-视频前辍这个是 临时批量修改设置视频流URL地址前辍，但实际上数据库播放URL前辍未修改（不懂的话可以联系QQ：394112252）
----------------------------------------------------------------------
批量搜索替换数据库域名后不显示发布者头像不显示解决方法：右键查看图片地址，在后端添加一个对应的文件夹，复制图片到对应文件夹即可
列如；右键图片地址为https://www.baidu.com/xz2.monster/uploads/那就重命名“xz2.monster”这个文件夹即可


在线支付渠道设置：application/api/controller/Order（支付商网址：https://bufpay.com/）
$postFields['secret'] = '6a2d15ad90394b4cb6a08b7a7e74aeee';（修改成你bufpay的平台密钥）共有三处需要修改
$url = 'https://bufpay.com/api/pay/98112';（最后面的“98112”修改成你bufpay的平台aid）共有三处需要修改

------------------------------------------------------------------------

搭建教程到此就结束了！