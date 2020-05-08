<?php
session_start();
require_once 'config/config.php';
require_once 'config/theme.php';
require_once 'config/functions.php';
?>
<!doctype html>
<html>

<head>
    <style type="text/css">
    .link:visited {
        color: blue;
    }
    </style>
    <?php mduiHead('用户中心')?>
</head>
<?php mduiBody();
mduiHeader('用户中心');
mduiMenu();
checkLogin($db_con);
?>
<script type="text/javascript">
function time() {
    var vWeek, vWeek_s, vDay;
    vWeek = ["星期天", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"];
    var date = new Date();
    year = date.getFullYear();
    month = date.getMonth() + 1;
    day = date.getDate();
    hours = date.getHours();
    minutes = date.getMinutes();
    seconds = date.getSeconds();
    vWeek_s = date.getDay();
    document.getElementById("time").innerHTML = year + "年" + month + "月" + day + "日" + "\t" + hours + "时" + minutes +
        "分" + seconds + "秒" + "\t" + vWeek[vWeek_s];

};
setInterval("time()", 1000);
// 来自https://www.cnblogs.com/ai10999/p/11449454.html，并作适当修改。
</script>
<h1 class="mdui-text-color-theme">你好，<?php echo $_SESSION['user']; ?>。现在是：<span style="font-size: 27px;"
        class="mdui-text-color-theme" id="time"></span></h1>
<p>您的用户信息如下：</p>
<table>
    <tr>
        <td>
            重置密码：
        </td>
        <td>
            <a href="/changepwd.php" title="重置密码" class="link">重置密码</a>
        </td>
    </tr>
</table>
</body>

</html>