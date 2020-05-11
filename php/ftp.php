<?php
session_start();
require_once('config/config.php');
require_once('config/theme.php');
require_once('config/functions.php');
checkLogin($db_con);
?>
<!doctype html>
<html>

<head>
    <?php mduiHead($lang['ftpTitle']) ?>
</head>
<?php mduiBody(); mduiHeader($lang['ftpHeader']); mduiMenu(); ?>
<h1 class="mdui-text-color-theme"><?php echo $lang['ftpT1']; ?></h1>

<p><?php echo $lang['ftpT2']; ?></p>
<table class="mdui-table" style="margin-top: 1%">
    <thead>
        <tr>
            <th><?php echo $lang['ftpT3']; ?></th>
            <th><?php echo $lang['ftpT4']; ?></th>
            <th><?php echo $lang['ftpT5']; ?></th>
            <th><?php echo $lang['ftpT6']; ?></th>
        </tr>
    </thead>
    <tbody>
        <?php userFTP($db_con, DOMAIN, $_SESSION['user']); ?>
    </tbody>
</table>
</body>

</html>