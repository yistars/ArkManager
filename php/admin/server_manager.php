<?php
session_start();
require_once('../config/config.php');
require_once('../config/admin_theme.php');
require_once('checkuser.php');
require_once('../config/functions.php');
?>
<!DOCTYPE html>
<html>

<head>
    <?php mduiHead('Server Manager'); ?>
</head>
<?php mduiBody(); mduiHeader('服务器管理'); mduiMenu(); ?>
<h1 class="mdui-text-color-theme">欢迎使用Server Manager。</h1>

<button class="mdui-btn mdui-color-theme-accent mdui-ripple" mdui-dialog="{target: '#createserver'}">创建服务器</button>

<div class="mdui-dialog" id="createserver">
    <form name="addnode" method="post" action="server_manager.php">
        <div class="mdui-dialog-content">
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label">服务器名称</label>
                <input class="mdui-textfield-input" name="add-servername" type="text" />
            </div>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label">端口</label>
                <input class="mdui-textfield-input" type="text" name="add-serverport" />
            </div>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label">RCON端口(ARK的输出比较那个啥，所以只能用RCON。)</label>
                <input class="mdui-textfield-input" type="text" name="add-rconport" />
            </div>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label">Query端口(与Steam通信的端口)</label>
                <input class="mdui-textfield-input" type="text" name="add-queryport" />
            </div>
            <div class="mdui-p-t-5">
                <label class="mdui-textfield-label">最大玩家数量</label>
                <label class="mdui-slider mdui-slider-discrete">
                    <input type="range" step="1" min="0" max="200" name="add-maxplayers" />
                </label>
            </div>
            <label class="mdui-textfield-label">属于节点</label>
            <select class="mdui-select" name="add-bynode" mdui-select>
                <?php echo adminListallnodeselect($db_con); ?>
            </select>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label">属于用户(填写用户ID)</label>
                <input class="mdui-textfield-input" type="text" name="add-byuser" />
            </div>
            <div class="mdui-textfield">
                <label class="mdui-textfield-label">到期日期(不填则不会到期)</label>
                <input class="mdui-textfield-input" type="date" name="add-date" />
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
            <th>端口</th>
            <th>RCON端口</th>
            <th>Query端口</th>
            <th>最大玩家</th>
            <th>节点</th>
            <th>属于用户</th>
            <th>到期日期</th>
            <th>初始化</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php 
    // 返回当前服务器列表
        adminListallserver($db_con);
    ?>
    </tbody>
</table>
<?php
    // 接收创建服务器数据
    if (!empty($_POST['add-servername'])||!empty($_POST['add-serverport'])||!empty($_POST['add-rconport'])||!empty($_POST['add-maxplayers'])||!empty($_POST['add-queryport'])||!empty($_POST['add-bynode'])||!empty($_POST['add-byuser'])) {
        echo adminCreateserver($_POST['add-servername'], $_POST['add-serverport'], $_POST['add-rconport'], $_POST['add-queryport'], $_POST['add-maxplayers'], $_POST['add-byuser'], $_POST['add-bynode'], $_POST['add-date'], $db_con);
    }
    // 接收删除服务器数据
    if (!empty($_REQUEST['del-serverid'])) {
        echo adminDelserver($_REQUEST['del-serverid'], $db_con);
    }
    // 接收初始化服务器数据
    if (!empty($_REQUEST['intl-serverid'])) {
        echo adminInitserver($_REQUEST['intl-serverid'], $_SESSION['userid'], $db_con);
    }
?>

</body>

</html>