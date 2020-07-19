<?php
require_once('../config/config.php');
require_once('../config/admin_theme.php');
if ($_SESSION['admin_login'] == 1) {
    header('Location: dash.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php mduiHead($lang['adminLogintitle']); ?>
</head>
    <?php mduiBody(); mduiHeader($lang['adminLoginheader']) ; mduiMenu(); ?>
    <form name="login" method="post" action="index.php">
        <div class="mdui-textfield mdui-textfield-floating-label">
            <i class="mdui-icon material-icons">lock</i>
            <label class="mdui-textfield-label"><?php $lang['adminLoginpassword']; ?></label>
            <input class="mdui-textfield-input" type="password" name="password" required />
            <div class="mdui-textfield-error"><?php $lang['adminLoginpasswordtip']; ?></div>
        </div>
        <input name="Submit" type="submit" class="mdui-btn mdui-color-theme-accent mdui-ripple" value="确认" />
    </form>
    <?php
    // 验证用户登录
    if (!empty($_POST['password'])) {
    $Admin->Login($_POST['password'], $admin_password);
    }
    ?>
</body>

</html>