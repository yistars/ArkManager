<?php
require_once('../config/config.php');
require_once('../config/admin_theme.php');
require_once('checkuser.php');
?>
<!DOCTYPE html>
<html>

<head>
    <?php mduiHead($lang['dashboard']); ?>
</head>
<?php mduiBody(); mduiHeader($lang['dashboard']); mduiMenu(); ?>
<h1 class="mdui-text-color-theme"><?php echo $lang['quickadduser']; ?></h1>
<form name="adduser" method="post" action="dash.php">
    <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label"><?php echo $lang['username']; ?></label>
        <input class="mdui-textfield-input" type="text" name="add-username" required />
    </div>
    <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label"><?php echo $lang['password']; ?></label>
        <input class="mdui-textfield-input" type="password" name="add-password" required />
    </div>
    <input type="submit" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" value="<?php echo $lang['quickadduser']; ?>" />
</form>
<?php
    // 接收添加用户数据
    if (!empty($_POST['add-username'])||!empty($_POST['add-password'])) {
        echo $Admin->addUser($_POST['add-username'],md5($_POST['add-password']));
    }
?>
<h1 class="mdui-text-color-theme"><?php echo $lang['quickdeluser']; ?></h1>
<form name="deluser" method="post" action="dash.php">
    <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label"><?php echo $lang['username']; ?></label>
        <input class="mdui-textfield-input" type="text" name="del-username" required />
    </div>
    <input type="submit" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" value="<?php echo $lang['quickdeluser']; ?>" />
</form>
<?php
    // 接收删除用户数据
    if (!empty($_POST['del-username'])) {
        echo $Admin->delUser($_POST['del-username']);
    }
?>
</body>

</html>