<?php
session_start();
require_once('../config/config.php');
require_once('../config/admin_theme.php');
require_once('checkuser.php');
?>
<!DOCTYPE html>
<html>

<head>
    <?php mduiHead('Renew Server'); ?>
</head>
<?php mduiBody();
mduiHeader('Renew Server');
mduiMenu(); ?>
<h1 class="mdui-text-color-theme">Renew Server</h1>

<form name="renew-server-form" method="get" action="action_renew.php">
    <div class="mdui-textfield">
        <label class="mdui-textfield-label">新的日期，留空则为永久</label>
        <input class="mdui-textfield-input" type="date" name="new-date" />
        <input type="text" name="serverid" style="display: none" value="<?php echo $_REQUEST['serverid']; ?>" /><br />
        <button class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" type="submit" >确定更改</button>
    </div>
</form>

<?php
// 判断登录，防止无中生有
if (!$_SESSION['admin_login'] == 1) {
    header('Location: /index.php');
    return '*';
}
?>

</body>

</html>