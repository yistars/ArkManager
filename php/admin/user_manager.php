<?php
require_once('../config/config.php');
require_once('../config/admin_theme.php');
require_once('checkuser.php');
require_once('../config/functions.php');
?>
<!DOCTYPE html>
<html>

<head>
    <?php mduiHead($lang['adminUsermanagertitle']); ?>
</head>
<?php mduiBody(); mduiHeader($lang['adminUsermanagerheader']); mduiMenu(); ?>
<h1 class="mdui-text-color-theme"><?php echo $lang['adminUsermanagerT1']; ?></h1>

<button class="mdui-btn mdui-color-theme-accent mdui-ripple" mdui-dialog="{target: '#adduser'}"><?php echo $lang['adminUsermanagerT9']; ?></button>

<div class="mdui-dialog" id="adduser">
    <form name="addnode" method="post" action="user_manager.php">
        <div class="mdui-dialog-content">
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label"><?php echo $lang['adminUsermanagerT2']; ?></label>
                <input class="mdui-textfield-input" name="add-username" type="text" />
            </div>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label"><?php echo $lang['adminUsermanagerT3']; ?></label>
                <input class="mdui-textfield-input" type="password" name="add-password" />
            </div>
        </div>
        <div class="mdui-dialog-actions">
            <span class="mdui-btn mdui-ripple" mdui-dialog-close><?php echo $lang['adminUsermanagerT4']; ?></span>
            <input type="submit" class="mdui-btn mdui-ripple" value="<?php echo $lang['adminUsermanagerT5']; ?>" />
        </div>
    </form>
</div>
<table class="mdui-table" style="margin-top: 1%">
    <thead>
        <tr>
            <th><?php echo $lang['adminUsermanagerT6']; ?></th>
            <th><?php echo $lang['adminUsermanagerT7']; ?></th>
            <th><?php echo $lang['adminUsermanagerT8']; ?></th>
        </tr>
    </thead>
    <tbody>
    <?php 
    // 返回当前用户列表
    echo adminListalluser($db_con);
    ?>
    </tbody>
</table>
<?php   
    // 判断登录，防止无中生有
    if (!$_SESSION['admin_login'] == 1) {
        header('Location: /index.php');
        return '*';
    }
    // 接收添加用户数据
    if (!empty($_POST['add-username'])||!empty($_POST['add-password'])) {
        echo adminAdduser($_POST['add-username'],md5($_POST['add-password']),$db_con);
    }
    // 接收删除用户数据
    if (!empty($_REQUEST['del-userid'])) {
        echo adminDeluserbyid($_REQUEST['del-userid'],$db_con);
    }
?>

</body>

</html>