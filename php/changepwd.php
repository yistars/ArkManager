<?php
require_once('config/config.php');
require_once('config/theme.php');
$User->checkLogin();
?>
<!DOCTYPE html>
<html>

<head>
    <?php mduiHead($lang['changepwd']); ?>
</head>

    <?php mduiBody(); mduiHeader($lang['changepwd']); mduiMenu();?>
    <form name="reg" method="post" action="changepwd.php">
    <div class="mdui-textfield mdui-textfield-floating-label">
            <i class="mdui-icon material-icons">lock</i>
            <label class="mdui-textfield-label"><?php echo $lang['oldpasswd']; ?></label>
            <input class="mdui-textfield-input" type="password" name="oldpassword" required />
            <div class="mdui-textfield-error"><?php echo $lang['enteroldpasswd']; ?></div>
        </div>

        <div class="mdui-textfield mdui-textfield-floating-label">
            <i class="mdui-icon material-icons">lock</i>
            <label class="mdui-textfield-label"><?php echo $lang['newpasswd']; ?></label>
            <input class="mdui-textfield-input" type="password" name="password" required />
            <div class="mdui-textfield-error"><?php echo $lang['enternewpasswd']; ?></div>
        </div>
        <input name="Submit" type="submit" class="mdui-btn mdui-color-theme-accent mdui-ripple" value="<?php echo $lang['changepwd']; ?>" />
    </form>
    <?php
    // 验证用户输入
    if (!empty($_POST['oldpassword'])||!empty($_POST['password'])) {
        echo $user->Changepassword(md5($_POST['oldpassword']), md5($_POST['password']));
    }
    ?>
</body>

</html>