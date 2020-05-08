<?php
require_once('config/config.php');
require_once('config/theme.php');
require_once('config/functions.php');
?>
<!DOCTYPE html>
<html>

<head>
    <?php mduiHead('重置密码'); ?>
</head>

    <?php mduiBody(); mduiHeader('重置密码'); mduiMenu(); checkLogin($db_con); ?>
    <form name="reg" method="post" action="changepwd.php">
    <div class="mdui-textfield mdui-textfield-floating-label">
            <i class="mdui-icon material-icons">lock</i>
            <label class="mdui-textfield-label">原密码</label>
            <input class="mdui-textfield-input" type="password" name="oldpassword" required />
            <div class="mdui-textfield-error">请输入原密码！</div>
        </div>

        <div class="mdui-textfield mdui-textfield-floating-label">
            <i class="mdui-icon material-icons">lock</i>
            <label class="mdui-textfield-label">新密码</label>
            <input class="mdui-textfield-input" type="password" name="password" required />
            <div class="mdui-textfield-error">请输入新密码！</div>
        </div>
        <input name="Submit" type="submit" class="mdui-btn mdui-color-theme-accent mdui-ripple" value="确认" />
    </form>
    <?php
    // 验证用户输入
    if (!empty($_POST['oldpassword'])||!empty($_POST['password'])) {
        echo userChangepassword(md5($_POST['oldpassword']), md5($_POST['password']), $db_con);
    }
    ?>
</body>

</html>