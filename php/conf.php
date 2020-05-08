<?php
session_start();
require_once('config/config.php');
require_once('config/theme.php');
require_once('config/functions.php');
checkLogin($db_con);
$serverid = mysqli_real_escape_string($db_con, $_REQUEST['id']);
if (empty($_REQUEST['id'])) {
    header('Location: server_manager.php');
}
?>
<!doctype html>
<html>

<head>
    <?php mduiHead('配置文件') ?>
</head>
<?php mduiBody(); mduiHeader('更改服务器的配置文件'); mduiMenu(); ?>
<h1 class="mdui-text-color-theme">更改GameUserSettings.ini，请编辑后确认您的选择。</h1>
<form name="conf" method="post" action="conf.php">
    <div class="mdui-textfield">
        <textarea class="mdui-textfield-input" rows="40" name="conf"
            placeholder="请填入配置文件。。。"><?php echo userEditserverconfig($serverid, $db_con); ?></textarea>
    </div>
    <label class="mdui-textfield-label">确认服务器</label>
    <select class="mdui-select" name="serverid" mdui-select>
        <option value="NULL" selected>请确认选择的服务器</option>
        <?php echo userListallserversselect($db_con); ?>
    </select>
    <input type="submit" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" value="提交" />
</form>
<div style="margin-top: 30%;"></div>
<?php 
    if(!empty($_POST['conf'])||!empty($_POST['serverid'])) {
        userSubmitserverconfig($_POST['serverid'], $_POST['conf'], $db_con);
    }
?>
</body>

</html>