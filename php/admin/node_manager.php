<?php
require_once('../config/config.php');
require_once('../config/admin_theme.php');
require_once('checkuser.php');
?>
<!DOCTYPE html>
<html>
<head>
    <?php mduiHead($lang['nodemanager']); ?>
</head>
<?php mduiBody(); mduiHeader($lang['nodemanager']); mduiMenu(); ?>
<h1 class="mdui-text-color-theme"><?php echo $lang['welcome'].$lang['nodemanager']; ?></h1>

<button class="mdui-btn mdui-color-theme-accent mdui-ripple" mdui-dialog="{target: '#addnode'}"><?php echo $lang['add']; ?></button>

<div class="mdui-dialog" id="addnode">
    <form name="addnode" method="post" action="node_manager.php">
        <div class="mdui-dialog-content">
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label"><?php echo $lang['nodename']; ?></label>
                <input class="mdui-textfield-input" name="add-nodename" type="text" />
            </div>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label"><?php echo $lang['ip_and_port']; ?></label>
                <input class="mdui-textfield-input" type="text" name="add-nodeipport" />
            </div>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label">Token</label>
                <input class="mdui-textfield-input" type="text" name="add-nodetoken" />
            </div>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label">FTP Port</label>
                <input class="mdui-textfield-input" type="text" name="add-ftp" />
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
            <th>IP:Port</th>
            <th>FTP <?php echo $lang['port']; ?></th>
            <th>Token</th>
            <th><?php echo $lang['action']; ?></th>
        </tr>
    </thead>
    <tbody>
    <?php 
    // 返回当前节点列表
    echo $Admin->listAllnode();
    ?>
    </tbody>
</table>
<?php
    // 判断登录，防止无中生有
    if (!$_SESSION['admin_login'] == 1) {
        header('Location: /index.php');
        return '*';
    }
    // 接收添加节点数据
    if (!empty($_POST['add-nodename'])||!empty($_POST['add-nodeipport'])||!empty($_POST['add-nodetoken'])) {
        echo $Admin->addNode($_POST['add-nodename'],$_POST['add-nodeipport'], $_POST['add-ftp'], $_POST['add-nodetoken']);
    }
    // 接收删除节点数据
    if (!empty($_REQUEST['del-nodeid'])) {
        echo $Admin->delNode($_REQUEST['del-nodeid']);
    }
?>

</body>

</html>