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
    <style type="text/css">
        a {
            text-decoration: none;
            color: blue;
        }
    </style>
    <?php mduiHead($lang['controlTitle']); ?>
</head>
<?php mduiBody(); mduiHeader($lang['controlHeader']); mduiMenu(); ?>
<h1 class="mdui-text-color-theme"><?php echo $lang['controlh1']; ?></h1>
<h3 class="mdui-text-color-theme"><?php echo $lang['controlc'] . userGetservername($_REQUEST['serverid'], $db_con) . $lang['controlc1']; ?></h3>
<form name="config" method="get" action="control.php">
    <input style="display: none" type="text" value="<?php echo $_REQUEST['serverid'];?>" name="serverid" />
    <input type="submit" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" value="<?php echo $lang['controlstart']; ?>">

    <a href="<?php echo '?serverid=' . $_REQUEST['serverid'] . '&action=kill'?>"
        class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent"><?php echo $lang['controlstop']; ?></a>
    <br />
    <h3 class="mdui-text-color-theme"><?php echo $lang['controlc2']; ?></h3>

    <label class="mdui-textfield-label"><?php echo $lang['controlc3']; ?></label>
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
        <label class="mdui-textfield-label"><?php echo $lang['controlc4']; ?></label>
        <input class="mdui-textfield-input" type="text" name="more"
            placeholder="Example: -UseBattlEye -servergamelog -ServerRCONOutputTribeLogs -useallavailablecores" />
    </div>
    <input style="display: none" type="text" value="start" name="action" />
</form>
<p>来自<a target="_blank" href="https://bbs.arkpsh.cn">ArkPsh</a>的<a target="_blank" href="https://rcon.arkpsh.cn/">WebRcon</a>（直接填入IP，端口，密码即可）</p>
<iframe style="border: none; width: 100%; height: 700px;" src="https://rcon.arkpsh.cn/"></iframe>
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
