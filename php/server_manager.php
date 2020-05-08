<?php
require_once('config/config.php');
require_once('config/theme.php');
require_once('config/functions.php');
?>
<!DOCTYPE html>
<html>

<head>
    <?php mduiHead('Server Manager'); ?>
</head>
<?php mduiBody(); mduiHeader('服务器管理'); mduiMenu(); ?>
<h1 class="mdui-text-color-theme">欢迎使用Server Manager。</h1>
<table class="mdui-table" style="margin-top: 1%">
    <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>端口</th>
            <th>RCON端口</th>
            <th>最大玩家</th>
            <th>节点</th>
            <th>到期日期</th>
            <th>配置文件</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php 
    // 返回当前服务器列表
    echo userListallservers($db_con)
    ?>
    </tbody>
</table>
<?php

?>

</body>

</html>