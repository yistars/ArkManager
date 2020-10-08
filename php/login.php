<?php
require_once('config/config.php');
require_once('config/theme.php');
// 生成Token，防止跨域
if(empty($_POST['token'])) {
    $_SESSION['form_token'] = mt_rand();
}
// 验证用户登录
if (!empty($_POST['username']) || !empty($_POST['password'])) {
    echo $User->Login($_POST['username'], md5($_POST['password']), $_POST['token']);
    unset($_SESSION['form_token']);
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php mduiHead($lang['login']); ?>
</head>

<?php mduiBody();
mduiHeader($lang['login']);
mduiMenu(); ?>
<form name="login" method="post" action="login.php">
    <div class="mdui-textfield mdui-textfield-floating-label">
        <i class="mdui-icon material-icons">account_circle</i>
        <label class="mdui-textfield-label"><?php echo $lang['username']; ?></label>
        <input class="mdui-textfield-input" name="username" type="text" required maxlength="15" />
        <div class="mdui-textfield-error">
            <?echo $lang['enterusername']; ?>
        </div>
    </div>

    <div class="mdui-textfield mdui-textfield-floating-label">
        <i class="mdui-icon material-icons">lock</i>
        <label class="mdui-textfield-label"><?php echo $lang['password']; ?></label>
        <input class="mdui-textfield-input" type="password" name="password" required />
        <input style="display: none" type="hidden" name="token" value="<?php echo $_SESSION['form_token']; ?>" required />
        <div class="mdui-textfield-error"><?php echo $lang['enterpassword']; ?></div>
    </div>
    <input name="Submit" type="submit" class="mdui-btn mdui-color-theme-accent mdui-ripple" value="<?php echo $lang['login']; ?>" />
</form>
</body>

</html>