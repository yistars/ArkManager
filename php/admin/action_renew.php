<?php
session_start();
require_once('../config/config.php');
require_once('checkuser.php');
// 接收续费服务器数据
$serverid = $_REQUEST['serverid'];
echo $Admin->renewServer($serverid, $_REQUEST['new-date']);
echo '<script>window.location.replace("server_manager.php");</script>';