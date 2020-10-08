<?php
require_once('config/config.php');
require_once('config/theme.php');
$User->checkLogin();
?>
<!doctype html>
<html>

<head>
    <?php mduiHead('FTP') ?>
</head>
<?php mduiBody(); mduiHeader('FTP'); mduiMenu(); ?>
<h1 class="mdui-text-color-theme"><?php echo $lang['filemanager']; ?></h1>

<p><?php echo $lang['ftptip']; ?></p>
<table class="mdui-table" style="margin-top: 1%">
    <thead>
        <tr>
            <th><?php echo $lang['nodedomain']; ?></th>
            <th>ID</th>
            <th><?php echo $lang['username']; ?></th>
            <th><?php echo $lang['password']; ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $User->FTP(DOMAIN, $_SESSION['user']); ?>
    </tbody>
</table>
</body>

</html>