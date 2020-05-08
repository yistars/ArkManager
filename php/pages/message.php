<?php
session_start();
require_once('../config/config.php');
require_once('../config/theme.php');
?>
<!doctype html>
<html>

<head>
    <?php mduiHead('提示') ?>
</head>
    <?php mduiBody(); mduiHeader('提示') ; mduiMenu(); ?>
    <h1 class="mdui-text-color-theme"><?php echo htmlspecialchars($_GET['message']);?></h1>
    <?php
    // 调用格式：message.php?&message= &action=back,login,signed
    $user = $_SESSION['user'];
    switch($_GET['action']) {
        // 当action为back时，显示返回按钮，为login时，显示登录和注册，为signed显示为已登录。
        case 'back':
            echo '<button class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" onclick="javascript:history.go(-1)" >返回</button>';
        break;
        case 'login':
            echo '<a href="/login.php" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent">登录</a>';
        break;
        case 'signed':
            echo "欢迎，请在菜单中选择操作。";
        break;
        default:
            echo '未定义的操作。';
    break;
        }
    ?>
</body>

</html>