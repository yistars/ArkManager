<?php
require_once('config/config.php');
require_once('config/theme.php');
$User->checkLogin();
?>
<!DOCTYPE html>
<html>

<head>
    <?php mduiHead('Server Manager'); ?>
</head>
<?php mduiBody(); mduiHeader('Server Manager'); mduiMenu(); ?>
<h1 class="mdui-text-color-theme">Server Manager。</h1>
<table class="mdui-table" style="margin-top: 1%">
    <thead>
        <tr>
            <th>ID</th>
            <th><?php echo $lang['name']; ?></th>
            <th><?php echo $lang['port']; ?></th>
            <th><?php echo $lang['rcon_port']; ?></th>
            <th><?php echo $lang['maxplayers']; ?></th>
            <th><?php echo $lang['node']; ?></th>
            <th><?php echo $lang['exp_date']; ?></th>
            <th><?php echo $lang['action']; ?></th>
        </tr>
    </thead>
    <tbody>
    <?php 
        // 返回当前服务器列表
        echo $User->Listallservers();
    ?>
    </tbody>
</table>
<?php

?>

</body>

</html>