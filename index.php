<?php
session_start();
require_once('config/config.php');
require_once('config/theme.php');

?>
<!doctype html>
<html>

<head>
    <?php mduiHead('首页') ?>
</head>
    <?php mduiBody(); mduiHeader('控制面板'); mduiMenu(); ?>
    <h1 class="mdui-text-color-theme">欢迎使用Ark服务器控制面板</h1>

    <p>请从左侧菜单选择操作。</p>
</body>

</html>