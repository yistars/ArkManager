<?php
session_start();
require_once('../config/config.php');
require_once('checkuser.php');
require_once('../config/functions.php');
// 接收续费服务器数据
$serverid = $_REQUEST['serverid'];
echo adminRenewserver($serverid, $_REQUEST['new-date'], $db_con);
echo '<script>window.location.replace("server_manager.php");</script>';