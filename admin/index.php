<?php
require_once('../config/config.php');
require_once('../config/admin_theme.php');
require_once('../config/functions.php');
if ($_SESSION['admin_login'] == 1) {
    header('Location: dash.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php mduiHead('后台管理'); ?>
</head>
    <?php mduiBody(); mduiHeader('后台登陆') ; mduiMenu(); ?>
    <form name="login" method="post" action="index.php">
        <div class="mdui-textfield mdui-textfield-floating-label">
            <i class="mdui-icon material-icons">lock</i>
            <label class="mdui-textfield-label">密码</label>
            <input class="mdui-textfield-input" type="password" name="password" required />
            <div class="mdui-textfield-error">请输入密码！</div>
        </div>
        <input name="Submit" type="submit" class="mdui-btn mdui-color-theme-accent mdui-ripple" value="确认" />
    </form>
    <?php
    // 验证用户登录
    if (!empty($_POST['password'])) {
    adminLogin($_POST['password'],$admin_password);
    }
    ?>
</body>

</html>