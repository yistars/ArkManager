<?php
session_start();
require_once('config/config.php');
require_once('config/theme.php');
$User->checkLogin();
if(!empty($_REQUEST['custommap'])) {
    $setmap = $_REQUEST['custommap'];
}else {
    $setmap = $_REQUEST['map'];
}
if ($_REQUEST['action'] == 'start') {
    echo $User->nodeControlserver($_REQUEST['serverid'], $_REQUEST['action'], $_SESSION['userid'], $setmap, $_REQUEST['more']);
}elseif (!empty($_REQUEST['action']) || !empty($_POST['serverid']) || !empty($_REQUEST['map'])) {
    echo $User->nodeControlserver($_REQUEST['serverid'], $_REQUEST['action'], $_SESSION['userid'], $setmap, $_REQUEST['more']);
    return '*';
}
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
    <?php mduiHead($lang['serverconsole']); ?>
</head>
<?php mduiBody();
mduiHeader($lang['console']);
mduiMenu(); ?>
<h1 class="mdui-text-color-theme"><?php echo $lang['controlh1']; ?></h1>
<h3 class="mdui-text-color-theme"><?php echo $lang['doaction'] . $_SESSION['ssname'] = $User->Getservername($_REQUEST['serverid']);?></h3>
<form name="config" method="get" action="control.php">
    <input style="display: none" type="text" value="<?php echo $_REQUEST['serverid']; ?>" name="serverid" />
    <input type="submit" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" value="<?php echo $lang['start']; ?>">

    <span onclick="kill(<?php echo $_REQUEST['serverid']; ?>)" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent"><?php echo $lang['stop']; ?></span>
    <span onclick="update(<?php echo $_REQUEST['serverid']; ?>)" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent"><?php echo $lang['update']; ?></span>
    <br />
    <h3 class="mdui-text-color-theme"><?php echo $lang['start_args']; ?></h3>

    <label class="mdui-textfield-label"><?php echo $lang['select_map']; ?></label>
    <select name="map" class="mdui-select" mdui-select>
        <option value="1">Aberration_P</option>
        <option value="2">Extinction</option>
        <option value="3">Genesis</option>
        <option value="4">Ragnarok</option>
        <option value="5">ScorchedEarth_P</option>
        <option value="6">TheIsland</option>
        <option value="7">TheCenter</option>
        <option value="8">Valguero_P</option>
    </select><?php echo $lang['OrCustomMap']; ?><input type="text" name="custommap" placeholder="<?php echo $lang['likemodmap']; ?>" />
    <div class="mdui-textfield">
        <label class="mdui-textfield-label"><?php echo $lang['more_args']; ?></label>
        <input class="mdui-textfield-input" type="text" name="more" placeholder="Example: -UseBattlEye -servergamelog -ServerRCONOutputTribeLogs -useallavailablecores" />
    </div>
    <input style="display: none" type="text" value="start" name="action" />
</form>
<p>来自<a target="_blank" href="https://bbs.arkpsh.cn">ArkPsh</a>的<a target="_blank" href="https://rcon.arkpsh.cn/">WebRcon</a>（直接填入IP，端口，密码即可）</p>
<iframe style="border: none; width: 100%; height: 700px;" src="https://rcon.arkpsh.cn/"></iframe>
</body>

</html>