<?php
session_start();
require_once('../config/config.php');
require_once('../config/admin_theme.php');
require_once('checkuser.php');
?>
<!DOCTYPE html>
<html>

<head>
    <?php mduiHead($lang['sever_manager']); ?>
</head>
<?php mduiBody(); mduiHeader($lang['sever_manager']); mduiMenu(); ?>
<h1 class="mdui-text-color-theme"><?php echo $lang['sever_manager']; ?></h1>

<button class="mdui-btn mdui-color-theme-accent mdui-ripple" mdui-dialog="{target: '#createserver'}"><?php echo $lang['create_server']; ?></button>

<div class="mdui-dialog" id="createserver">
    <form name="addnode" method="post" action="server_manager.php">
        <div class="mdui-dialog-content">
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label"><?php echo $lang['server_name_tip']; ?></label>
                <input class="mdui-textfield-input" name="add-servername" type="text" />
            </div>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label"><?php echo $lang['port']; ?></label>
                <input class="mdui-textfield-input" type="text" name="add-serverport" />
            </div>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label"><?php echo $lang['rcon_port_tip']; ?></label>
                <input class="mdui-textfield-input" type="text" name="add-rconport" />
            </div>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label"><?php echo $lang['query_port_tip']; ?></label>
                <input class="mdui-textfield-input" type="text" name="add-queryport" />
            </div>
            <div class="mdui-p-t-5">
                <label class="mdui-textfield-label"><?php echo $lang['maxplayers']; ?></label>
                <label class="mdui-slider mdui-slider-discrete">
                    <input type="range" step="1" min="0" max="200" name="add-maxplayers" />
                </label>
            </div>
            <label class="mdui-textfield-label"><?php echo $lang['node']; ?></label>
            <select class="mdui-select" name="add-bynode" mdui-select>
                <?php echo $Admin->Listallnodeselect(); ?>
            </select>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label"><?php echo $lang['by_user']; ?></label>
                <input class="mdui-textfield-input" type="text" name="add-byuser" />
            </div>
            <div class="mdui-textfield">
                <label class="mdui-textfield-label"><?php echo $lang['exp_date']; ?></label>
                <input class="mdui-textfield-input" type="date" name="add-date" />
            </div>
        </div>
        <div class="mdui-dialog-actions">
            <span class="mdui-btn mdui-ripple" mdui-dialog-close><?php echo $lang['cancel']; ?></span>
            <input type="submit" class="mdui-btn mdui-ripple" value="<?php echo $lang['confirm']; ?>" />
        </div>
    </form>
</div>
<table class="mdui-table" style="margin-top: 1%">
    <thead>
        <tr>
            <th>ID</th>
            <th><?php echo $lang['name']; ?></th>
            <th><?php echo $lang['port']; ?></th>
            <th><?php echo $lang['rcon_port']; ?></th>
            <th><?php echo $lang['query_port']; ?></th>
            <th><?php echo $lang['maxplayers']; ?></th>
            <th><?php echo $lang['node']; ?></th>
            <th><?php echo $lang['by_user']; ?></th>
            <th><?php echo $lang['exp_date']; ?></th>
            <th><?php echo $lang['init']; ?></th>
            <th><?php echo $lang['action']; ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        // 返回当前服务器列表
        $Admin->Listallserver();
        ?>
    </tbody>
</table>
<?php
    // 判断登录，防止无中生有
    if (!$_SESSION['admin_login'] == 1) {
        header('Location: /index.php');
        return '*';
    }
    // 接收创建服务器数据
    if (!empty($_POST['add-servername'])||!empty($_POST['add-serverport'])||!empty($_POST['add-rconport'])||!empty($_POST['add-maxplayers'])||!empty($_POST['add-queryport'])||!empty($_POST['add-bynode'])||!empty($_POST['add-byuser'])) {
        echo $Admin->createServer($_POST['add-servername'], $_POST['add-serverport'], $_POST['add-rconport'], $_POST['add-queryport'], $_POST['add-maxplayers'], $_POST['add-byuser'], $_POST['add-bynode'], $_POST['add-date']);
    }
    // 接收删除服务器数据
    if (!empty($_REQUEST['del-serverid'])) {
        echo $Admin->delServer($_REQUEST['del-serverid']);
    }
    // 接收初始化服务器数据
    if (!empty($_REQUEST['intl-serverid'])) {
        echo $Admin->initServer($_REQUEST['intl-serverid']);
        echo '<script>window.location.replace("server_manager.php");</script>';
    }
?>

</body>

</html>