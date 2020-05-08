<?php
// 启用session
session_start();
if (!$_SESSION['admin_login'] == 1) {
    header('Location: /pages/message.php?message=你在干什么？？？');
}