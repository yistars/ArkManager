<?php
require_once('config/config.php');
require_once('config/theme.php');
require_once('config/functions.php');
?>
<!DOCTYPE html>
<html>

<head>
    <?php mduiHead('登录'); ?>
</head>

    <?php mduiBody(); mduiHeader('登录') ; mduiMenu(); ?>
    <form name="reg" method="post" action="login.php">
        <div class="mdui-textfield mdui-textfield-floating-label">
            <i class="mdui-icon material-icons">account_circle</i>
            <label class="mdui-textfield-label">用户名</label>
            <input class="mdui-textfield-input" name="username" type="text" required maxlength="15" />
            <div class="mdui-textfield-error">用户名不能为空！</div>
        </div>

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
    if (!empty($_POST['username'])||!empty($_POST['password'])) {
        echo userLogin($_POST['username'], md5($_POST['password']), $db_con);
    }
    ?>
</body>

</html>