��˻���linux  nginx1.6  mysql5.6  php7.0 

��̨�
����TPα��̬������Ŀ¼/public 
TPα��̬�������� ��Ȼ��APP����ʾ���汾ʧ��

�ϴ���վ���򵽱���   Ȼ���ѹ

/application/database.php����ļ��޸���վ���ݿ�

/GatewayWorker/Applications/YourApp/Events.php����ļ�����������������ݿ�����
--------------------------------------------------------

����������������ý̳̣�
1��PHP 7.2��װ��չ��ionCube��fileinfo��opcache��redis��Swoole��Swoole4��
2����������ȫ����ӷ���8282�˿ڣ��˶˿���ҪΪWorkerman����������˿ڣ��粻����8282���ж˿ڣ�APPֱ�����޷������������������
3������PHP���ú�����/server/php/70/etc/php.ini ����disable_functions =����������滻Ϊ passthru, exec, system, putenv, chroot, chgrp, chown, shell_exec, popen, proc_open, pcntl_exec, ini_alter, ini_restore, dl, openlog, syslog, readlink, symlink, popepassthru, pcntl_waitpid, pcntl_wifexited,pcntl_wifstopped, pcntl_wifsignaled, pcntl_wifcontinued, pcntl_wexitstatus, pcntl_wtermsig, pcntl_wstopsig, pcntl_get_last_error, pcntl_strerror, pcntl_sigprocmask, pcntl_sigwaitinfo, pcntl_sigtimedwait, pcntl_exec, pcntl_getpriority, pcntl_setpriority, imap_open, apache_setenv
                                  ��ֱ����php.ini�ļ�����ɾ��pcntl_fork,
4������������������ php start.php start��ʹ�õ���ģʽ�������ն˹رպ�workerman����֮�رղ��˳���
                                      php start.php start -d��ʹ���ػ������������ն˹رպ�workerman������̨�������У�����������������Ҫ����������
                           ֹͣ�� php start.php stop
                           ������ php start.php restart
                     ƽ�������� php start.php reload
               �鿴����״̬�� php start.php status

�ն����룺cd /www/wwwroot/�������/GatewayWorker
                php start.php start
workerman����״̬��     php start.php status
������������������������������� ���������������
composer require endroid/qr-code --ignore-platform-reqs
composer install --ignore-platform-reqs

/application/config.php    'host'=>'�ĳ��������'   
�����޸ĳ����Լ�������
ע�⣺application/config.php    'host'=>'�ĳ��������'  �˴���������ꡱ���Ҫ����"/"�����̨"��������" "��Ƶ�б�"�û�ͷ����ʾ
---------------------------------------------------------
H5��ҳ�ˡ���Ա���ġ����߿ͷ������޸ĵ�ַ��/public/h5/static/js/pages-mine-zaixian.d0a46305.js
�޸� {attrs:{src:"�˴���д������߿ͷ�ҳ���ַ"}})]
���H5��ת��ַ�޸ģ�/public/H5/static/js/index.d9c3f4b6.js      $url="https://www.baidu.com/" ��������滻�����Լ��ĺ�̨����

�޸����߿ͷ����ݿ����ӣ�/public/kefu/php/config/parameters.php
���߿ͷ�ϵͳ��½��̨��ַ���������/kefu/php/app.php?login
���߿ͷ���̨��¼�˺ţ�123456@qq.com ���룺123456
WAP�˽������ӣ��������/kefu/php/app.php?widget-test

��̨�Ľ���  ���������/chaoguan.php/index/login
��¼�˻���admin  ���룺admin777
H5��ҳ�ˣ�����/h5����


���������´��ע������

�����õ�
HBuilder X 
�ٶ�����һ��  Ȼ��ע���¼���Լ����˻�

�򿪺����ļ�  ����  �ӱ���Ŀ¼����

main.js����ļ��޸ķ���������
Vue.prototype.$url = 'https://www.baidu.com/'  ��15��  �޸�Ϊ����վ��ַ
Vue.prototype.$websockerurl = "ws://103.167.180.101:8282"��16���޸�Ϊ��������IP��ע�⣺������IP��ַ�������Ҫ����8282������Wokerman����������˿ڣ�


manifest.json����ļ����޸�ͼ�����ȵ�
ע�⵼����Ŀ��  �����������    uni-appӦ�ñ�ʶ������»�ȡ
Ȼ���ٵ��APPԭ�����  ���¹���Ѷ����Ƶ�����������Ѹ����Ƶ��������һ���˺�99Ԫ��

�Լ��޸ĺú�   �������
�ƴ���ͱ��ش��������   ���ش��Ҫ���û���   ����������

APP��ͨ��Ա�Զ���ת�����߿ͷ����ӣ����߿ͷ����Ӻ�̨���ã�
��Ƶ����ҳ�����Ͻ�ˮӡ�޸ģ�HbuilderX���ļ�����139.png�滻����
ֱ����ɼ�Ĭ�ϱ������֣��磺XX�������޸ģ�/application/admin/controller/direct/Detail.php
����������ʱ�ı���ͼƬ�޸ĵ�ַ��/uploads/tuiguang/5a.png
��̨������Ƶ����ʧ��ԭ��ϵͳ����-APP����-��Ƶǰ��޸��£�һ������²����鿪����
ϵͳ����-��Ƶǰ������ ��ʱ�����޸�������Ƶ��URL��ַǰꡣ���ʵ�������ݿⲥ��URLǰ�δ�޸ģ������Ļ�������ϵQQ��394112252��
----------------------------------------------------------------------
���������滻���ݿ���������ʾ������ͷ����ʾ����������Ҽ��鿴ͼƬ��ַ���ں�����һ����Ӧ���ļ��У�����ͼƬ����Ӧ�ļ��м���
���磻�Ҽ�ͼƬ��ַΪhttps://www.baidu.com/xz2.monster/uploads/�Ǿ���������xz2.monster������ļ��м���


����֧���������ã�application/api/controller/Order��֧������ַ��https://bufpay.com/��
$postFields['secret'] = '6a2d15ad90394b4cb6a08b7a7e74aeee';���޸ĳ���bufpay��ƽ̨��Կ������������Ҫ�޸�
$url = 'https://bufpay.com/api/pay/98112';�������ġ�98112���޸ĳ���bufpay��ƽ̨aid������������Ҫ�޸�

------------------------------------------------------------------------

��̵̳��˾ͽ����ˣ�