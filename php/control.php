<?php
session_start();
require_once('config/config.php');
require_once('config/theme.php');
require_once('config/functions.php');
?>
<!doctype html>
<html>

<head>
    <?php mduiHead('控制台') ?>
</head>
<?php mduiBody(); mduiHeader('控制台'); mduiMenu(); ?>
<h1 class="mdui-text-color-theme">服务器控制台</h1>
<h3 class="mdui-text-color-theme">请选择对：<?php echo userGetservername($_REQUEST['serverid'], $db_con); ?>的操作。</h3>
<form name="config" method="get" action="control.php">
    <input style="display: none" type="text" value="<?php echo $_REQUEST['serverid'];?>" name="serverid" />
    <input type="submit" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" value="启动">

    <a href="<?php echo '?serverid=' . $_REQUEST['serverid'] . '&action=kill'?>"
        class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent">停止</a>
    <br />
    <h3 class="mdui-text-color-theme">在启动前请调整以下参数，我们不会保存以下参数。</h3>

    <label class="mdui-textfield-label">选择地图</label>
    <select name="map" class="mdui-select" mdui-select>
        <option value="1">Aberration_P</option>
        <option value="2">Extinction</option>
        <option value="3">Genesis</option>
        <option value="4">Ragnarok</option>
        <option value="5">ScorchedEarth_P</option>
        <option value="6">TheIsland</option>
        <option value="7">TheCenter</option>
        <option value="8">Valguero_P</option>
    </select>
    <div class="mdui-textfield">
        <label class="mdui-textfield-label">额外参数</label>
        <input class="mdui-textfield-input" type="text" name="more"
            placeholder="如：-UseBattlEye -servergamelog -ServerRCONOutputTribeLogs -useallavailablecores" />
    </div>
    <input style="display: none" type="text" value="start" name="action" />
</form>
<?php
    if (!empty($_REQUEST['action'])||!empty($_POST['serverid'])||!empty($_REQUEST['map'])) {
        echo nodeControlserver($_REQUEST['serverid'], $_REQUEST['action'], $_SESSION['userid'], $_REQUEST['map'], $_REQUEST['more'], $db_con);
    }
    if ($_REQUEST['action'] == 'kill') {
        $serverid = $_REQUEST['serverid'];
        // echo "<script>window.location.replace(\"control.php?serverid=$serverid\");</script>";
    }
    ?>
</body>

</html>