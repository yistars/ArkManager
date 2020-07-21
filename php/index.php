<?php
session_start();
require_once('config/config.php');
require_once('config/theme.php');
?>
<!doctype html>
<html>

<head>
    <?php mduiHead($lang['indexTitle']) ?>
</head>
    <?php mduiBody(); mduiHeader($lang['indexHeader']); mduiMenu(); ?>
    <h1 class="mdui-text-color-theme"><?php echo $lang['indexWelcome']; ?></h1>
    <?php echo $lang['IndexContent']; ?>
    <p>常见问题帮助</p>
            <p>在您的服务器被初始化完成后，请不要急于启动服务器。您应该将到“管理”页面确认一下您的服务器的RCON端口等信息，然后将下列内容复制并通过FTP粘贴到“Saved\Config\WindowsServer”</p>
            <textarea readonly="readonly" rows="10" cols="50" style="border: none">
RCONEnabled=True
RCONPort=管理界面的RCON端口
RCONServerGameLogBuffer=600
ServerPassword=加入服务器时的密码
ServerAdminPassword=服务器管理员密码</textarea>
            <p>我们不建议您擅自更改服务器端口，那样可能造成无法启动服务器，无法连接服务器，服务器被管理员删除/禁用等后果，出现以上问题时我们概不负责，谢谢合作。</p>
</body>

</html>