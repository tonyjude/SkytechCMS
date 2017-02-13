# SkytechCMS
SkytechCMS 居于PHP和MySQL技术开发，可同时使用于Windows、Linux、Unix平台，环境需求如下：

1、Windows 平台：
IIS/Apache + PHP4/PHP5 + MySQL4/5

2、Linux/Unix 平台
Apache + PHP4/PHP5 + MySQL3/4/5 (PHP必须在非安全模式下运行)

建议使用平台：Linux + Apache2.2 + PHP5.3 + MySQL5.0

3、PHP必须环境或启用的系统函数：
allow_url_fopen
GD扩展库
MySQL扩展库
系统函数 —— phpinfo、dir

4、基本目录结构
/
..../web                 系统程序目录[安装时必须有可写入权限]

..../web/css/               系统后台css目录

..../web/images/              系统后台图片目录

..../web/js/               系统后台javascript目录

..../web/doc/               系统操作文档目录

..../web/ueditor/               百度编辑器目录

..../web/upload/               站点文件上传目录

..../web/themes/               站点文件目录， 包括css,images,js...

..../skytech_admin.php?s=index/install     系统安装程序入口

..../web/skytech_admin.php         后台管理登录入口

..../application           应用程序目录

..../library            系统框架文件目录

5、PHP环境容易碰到的不兼容性问题

(1) web目录没写入权限，导致系统session无法使用，这将导致无法登录管理后台（直接表现为验证码不能正常显示）；

(2) php的上传的临时文件夹没设置好或没写入权限，这会导致文件上传的功能无法使用；

(3) 出现莫名的错误，如安装时显示空白，这样能是由于系统没装载mysql扩展导致的。



