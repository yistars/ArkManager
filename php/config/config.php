<?php
// 启用session
session_start();
// 设置数据库的"服务器"，"用户名"，"密码"，"数据库名"。
$db_config = array('localhost', 'ark_local_kawayi', '12345678', 'ark_local_kawayi');
// 创建数据库链接
$db_con = new mysqli($db_config[0], $db_config[1], $db_config[2], $db_config[3]);
$db_con->query("set names utf8");
// 设置数据库编码
// 判断连接（算了算了，不用面向对象了）
if (!$db_con) {
    die("数据库连接出错". mysqli_error($db_con));

}
// 隐藏报错
// error_reporting(E_ALL^E_NOTICE^E_WARNING);

// 站点名称
define( 'SITENAME' , 'Ark');
// 控制面板域名
define( 'DOMAIN' , 'dash.example.com');
// 管理员密码
$admin_password = '123456';
// 监控密钥（服务器到期时会自动停止）
$cron_password = '123456';
// 管理员后台路径
$admin_path = 'admin';
// 语言文件
$lang = 'zh_cn.php';



/* 好了，请不要再编辑了，现在关闭该文件，尽情使用吧! */

if (strpos($_SERVER['PHP_SELF'], $admin_path)) {
    require_once("../i18n/$lang");
}
else {
    require_once("i18n/$lang");
}

// 引入配置文件
require_once('class/Admin.class.php');
require_once('class/User.class.php');
// 实例化并配置数据库
$Admin = new Admin();
$User = new User();
$Admin->db_con = $db_con;
$User->db_con = $db_con;

/* 非常感谢您能使用ArkManager! */