<?php
require_once('config/config.php');
require_once('config/theme.php');
$User->checkLogin();
?>
<!DOCTYPE html>
<html>

<head>
    <?php mduiHead($lang['changepwdTitle']); ?>
</head>

    <?php mduiBody(); mduiHeader($lang['indexHeader']); mduiMenu();?>
    <form name="reg" method="post" action="changepwd.php">
    <div class="mdui-textfield mdui-textfield-floating-label">
            <i class="mdui-icon material-icons">lock</i>
            <label class="mdui-textfield-label"><?php echo $lang['changepwdoldPassword']; ?></label>
            <input class="mdui-textfield-input" type="password" name="oldpassword" required />
            <div class="mdui-textfield-error"><?php echo $lang['changepwdoldPasswordtip']; ?></div>
        </div>

        <div class="mdui-textfield mdui-textfield-floating-label">
            <i class="mdui-icon material-icons">lock</i>
            <label class="mdui-textfield-label"><?php echo $lang['changepwdnewPassword']; ?></label>
            <input class="mdui-textfield-input" type="password" name="password" required />
            <div class="mdui-textfield-error"><?php echo $lang['changepwdnewPasswordtip']; ?></div>
        </div>
        <input name="Submit" type="submit" class="mdui-btn mdui-color-theme-accent mdui-ripple" value="确认" />
    </form>
    <?php
    // 验证用户输入
    if (!empty($_POST['oldpassword'])||!empty($_POST['password'])) {
        echo $user->Changepassword(md5($_POST['oldpassword']), md5($_POST['password']));
    }
    ?>
</body>

</html>