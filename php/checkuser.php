<?php
// 启用session
session_start();
// 声明变量
$m_username = $_SESSION['user'];
// 查找用户名对应的ID
$sql = "SELECT `id` FROM `users` WHERE `username`='$m_username'";
$result = mysqli_query($db_con,$sql);
if (!mysqli_num_rows($result)){
    header('HTTP/1.1 403 Forbidden');
    echo '<script>window.location.replace("/pages/message.php?message=您没有登录或者不存在该用户。&action=login");</script>';
    session_destroy();
}