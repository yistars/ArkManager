<?php
session_start();
require_once('config/config.php');
require_once('config/theme.php');
require_once('config/functions.php');
?>
<!doctype html>
<html>

<head>
    <?php mduiHead('FTP') ?>
</head>
<?php mduiBody(); mduiHeader('FTP'); mduiMenu(); ?>
<h1 class="mdui-text-color-theme">FTP文件管理</h1>

<p>您可以用FTP协议来快速管理服务器上的文件。</p>
<table class="mdui-table" style="margin-top: 1%">
    <thead>
        <tr>
            <th>节点域名</th>
            <th>FTP端口</th>
            <th>用户名</th>
            <th>密码</th>
        </tr>
    </thead>
    <tbody>
        <?php userFTP($db_con, DOMAIN, $_SESSION['user']); ?>
    </tbody>
</table>
</body>

</html>