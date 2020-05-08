<?php
require_once('../config/config.php');
require_once('../config/admin_theme.php');
require_once('checkuser.php');
require_once('../config/functions.php');
?>
<!DOCTYPE html>
<html>

<head>
    <?php mduiHead('Node Manager'); ?>
</head>
<?php mduiBody(); mduiHeader('集群节点管理'); mduiMenu(); ?>
<h1 class="mdui-text-color-theme">欢迎使用Node Manager。</h1>

<button class="mdui-btn mdui-color-theme-accent mdui-ripple" mdui-dialog="{target: '#addnode'}">添加节点</button>

<div class="mdui-dialog" id="addnode">
    <form name="addnode" method="post" action="node_manager.php">
        <div class="mdui-dialog-content">
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label">节点名称</label>
                <input class="mdui-textfield-input" name="add-nodename" type="text" />
            </div>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label">IP地址与端口（如localhost:1234）</label>
                <input class="mdui-textfield-input" type="text" name="add-nodeipport" />
            </div>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label">Token</label>
                <input class="mdui-textfield-input" type="text" name="add-nodetoken" />
            </div>
        </div>
        <div class="mdui-dialog-actions">
            <span class="mdui-btn mdui-ripple" mdui-dialog-close>取消</span>
            <input type="submit" class="mdui-btn mdui-ripple" value="添加" />
        </div>
    </form>
</div>
<table class="mdui-table" style="margin-top: 1%">
    <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>IP:Port</th>
            <th>Token</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    // 返回当前节点列表
    echo adminListallnode($db_con);
    ?>
    </tbody>
</table>
<?php
    // 接收添加节点数据
    if (!empty($_POST['add-nodename'])||!empty($_POST['add-nodeipport'])||!empty($_POST['add-nodetoken'])) {
        echo adminAddnode($_POST['add-nodename'],$_POST['add-nodeipport'],$_POST['add-nodetoken'],$db_con);
    }
    // 接收删除节点数据
    if (!empty($_REQUEST['del-nodeid'])) {
        echo adminDelnode($_REQUEST['del-nodeid'],$db_con);
    }
?>

</body>

</html>