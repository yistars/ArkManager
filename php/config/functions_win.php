<?php
/*
    该文件是ArkManager的函数文件，请按需修改。如有bug，请立即向我们反馈。
    PS: 面向对象在计划中。。。
    该文件为Linux专用。
*/

/* 前提部分 */
// 判断用户是否登录或者用户是否存在
function checkLogin($db_con)
{
    session_start();
    $userid = $_SESSION['userid'];
    // 通过userid 查找用户是否存在
    $sql = "SELECT `id` FROM `users` WHERE `id`='$userid'";
    $result = mysqli_query($db_con, $sql);
    if (!mysqli_num_rows($result)) {
        header('HTTP/1.1 403 Forbidden');
        echo '<script>window.location.replace("/login.php");</script>';
        session_destroy();
    }
}

/* 管理员功能部分 */

// 管理员：验证管理员密码
function adminLogin($password, $admin_password) {
    if ($password == $admin_password) {
        $_SESSION['admin_login'] = 1;
        echo '<script>window.location.replace("/admin/dash.php");</script>';
    } else {
        header('Location: /login.php');
    }
}

// 管理员：添加用户
function adminAdduser($username, $password, $db_con)
{
    $username = mysqli_real_escape_string($db_con, $username);
    // 查找用户名是否重复
    $sql = "SELECT `username` FROM `users` WHERE `username` = '$username'";
    $result = mysqli_query($db_con, $sql);
    if (mysqli_num_rows($result) > 0) {
        return '<script>alert("用户名重复，请检查。");</script>';
    } else {
        $sql = "INSERT INTO `users` (`id`, `username`, `password`) VALUES (NULL, '$username', '$password')";
        if (mysqli_query($db_con, $sql)) {
            return '<script>window.location.replace("user_manager.php");</script>';
        } else {
            return '<script>alert("操作数据库失败' . mysqli_error($db_con) . '");</script>';
        }
    }
}

// 管理员：删除用户
function adminDeluser($username, $db_con)
{
    $username = mysqli_real_escape_string($db_con, $username);
    $sql = "DELETE FROM `users` WHERE `username` = '$username'";
    if (mysqli_query($db_con, $sql)) {
        return '<script>alert("用户已删除！");</script>';
    } else {
        return '<script>alert("操作数据库失败' . mysqli_error($db_con) . '");</script>';
    }
}
// 管理员：删除用户（通过ID）
function adminDeluserbyid($userid, $db_con)
{
    $userid = mysqli_real_escape_string($db_con, $userid);
    $sql = "DELETE FROM `users` WHERE `id` = '$userid'";
    if (mysqli_query($db_con, $sql)) {
        return '<script>window.location.replace("user_manager.php");</script>';
    } else {
        return '<script>alert("操作数据库失败' . mysqli_error($db_con) . '");</script>';
    }
}
// 管理员：列出所有用户
function adminListalluser($db_con)
{
    $sql = "SELECT * FROM `users`";
    $result = mysqli_query($db_con, $sql);
    if (!mysqli_num_rows($result) > 0) {
        return '<tr><td colspan="3"><p align="center" style="color: gray">道生一，一生二，二生三，三生万物。</p></td></tr>';
    } else {
        while ($row = mysqli_fetch_array($result)) {
            echo
                '<tr>
            <td>' .
                    $row['id'] .
                    '</td>' .
                    '<td>' .
                    $row['username'] .
                    '</td>' .
                    '<td>' .
                    '<a class="link" href="user_manager.php?del-userid=' . $row['id'] . '">删除</a>' .
                    '</td>' .
                    '</tr>';
        }
    }
}

// 管理员：添加节点
function adminAddnode($nodename, $nodeip, $ftpport, $token, $db_con)
{
    $nodename = mysqli_real_escape_string($db_con, $nodename);
    $nodeip = mysqli_real_escape_string($db_con, $nodeip);
    $ftpport = mysqli_real_escape_string($db_con, $ftpport);
    $token = mysqli_real_escape_string($db_con, $token);
    // 查找服务器名是否重复
    $sql = "SELECT `name` FROM `node` WHERE `name` = '$nodename'";
    $result = mysqli_query($db_con, $sql);
    if (mysqli_num_rows($result) > 0) {
        return '<script>alert("节点名重复，请检查。");</script>';
    } else {
        $sql = "INSERT INTO `node` (`id`, `name`, `ip_port`, `ftpport`, `token`) VALUES (NULL, '$nodename', '$nodeip', $ftpport, '$token')";
        if (mysqli_query($db_con, $sql)) {
            return '<script>window.location.replace("node_manager.php");</script>';
        } else {
            return '<script>alert("操作数据库失败' . mysqli_error($db_con) . '");</script>';
        }
    }
}
// 管理员：删除节点
function adminDelnode($nodeid, $db_con)
{
    $nodeid = mysqli_real_escape_string($db_con, $nodeid);
    $sql = "DELETE FROM `node` WHERE `id` = $nodeid";
    if (mysqli_query($db_con, $sql)) {
        return '<script>window.location.replace("node_manager.php");</script>';
    } else {
        return '<script>alert("操作数据库失败' . mysqli_error($db_con) . '");</script>';
    }
}
// 管理员：列出所有节点
function adminListallnode($db_con)
{
    $sql = "SELECT * FROM `node`";
    $result = mysqli_query($db_con, $sql);
    if (!mysqli_num_rows($result) > 0) {
        return '<tr><td colspan="5"><p align="center" style="color: gray">道生一，一生二，二生三，三生万物。</p></td></tr>';
    } else {
        while ($row = mysqli_fetch_array($result)) {
            echo
                '<tr>
            <td>' .
                    $row['id'] .
                    '</td>' .
                    '<td>' .
                    $row['name'] .
                    '</td>' .
                    '<td>' .
                    $row['ip_port'] .
                    '</td>' .
                    '<td>' .
                    $row['ftpport'] .
                    '</td>' .
                    '<td>' .
                    $row['token'] .
                    '</td>' .
                    '<td>' .
                    '<a class="link" href="node_manager.php?del-nodeid=' . $row['id'] . '">删除</a>' .
                    '</td>' .
                    '</tr>';
        }
    }
}

// 管理员：列出所有节点（select）
function adminListallnodeselect($db_con)
{
    $sql = "SELECT `id`, `name` FROM `node`";
    $result = mysqli_query($db_con, $sql);
    if (!mysqli_num_rows($result) > 0) {
        return '<option disabled>没有任何节点</option>';
    } else {
        while ($row = mysqli_fetch_array($result)) {
            $nodeid = $row['id'];
            $nodename = $row['name'];
            echo
                "<option value=\"$nodeid\">$nodename</option>";
        }
    }
}

// 管理员：创建服务器
function adminCreateserver($servername, $serverport, $rconport, $query_port, $maxplayers, $by_user, $by_node, $date, $db_con)
{
    $servername = mysqli_real_escape_string($db_con, $servername);
    $serverport = mysqli_real_escape_string($db_con, $serverport);
    $rconport = mysqli_real_escape_string($db_con, $rconport);
    $query_port = mysqli_real_escape_string($db_con, $query_port);
    $maxplayers = mysqli_real_escape_string($db_con, $maxplayers);
    $by_user = mysqli_real_escape_string($db_con, $by_user);
    $by_node = mysqli_real_escape_string($db_con, $by_node);
    $date = mysqli_real_escape_string($db_con, $date);
    // 查找服务器名是否重复
    $sql = "SELECT `name` FROM `servers` WHERE `name` = '$servername'";
    $result = mysqli_query($db_con, $sql);
    if (mysqli_num_rows($result) > 0) {
        return '<script>alert("服务器名重复，请检查。");</script>';
    } else {
        // 查找端口是否重复
        $sql = "SELECT `port` FROM `servers` WHERE `port` = '$serverport'";
        $result = mysqli_query($db_con, $sql);
        if (mysqli_num_rows($result) > 0) {
            return '<script>alert("端口重复，请检查。");</script>';
        } else {
            // 查找rcon端口是否重复
            $sql = "SELECT `rcon_port` FROM `servers` WHERE `rcon_port` = '$rconport'";
            $result = mysqli_query($db_con, $sql);
            if (mysqli_num_rows($result) > 0) {
                return '<script>alert("RCON端口重复，请检查。");</script>';
            } else {
                // 查找query_port是否重复
                $sql = "SELECT `query_port` FROM `servers` WHERE `query_port` = '$query_port'";
                $result = mysqli_query($db_con, $sql);
                if (mysqli_num_rows($result) > 0) {
                    return '<script>alert("Query端口重复，请检查。");</script>';
                } else {
                    $sql = "INSERT INTO `servers` (`id`, `name`, `port`, `rcon_port`, `query_port`, `max_players`, `by_node`, `by_user`, `initialization`, `date`, `is_expire`, `status`) VALUES (NULL, '$servername', $serverport, $rconport, $query_port, $maxplayers, $by_node, $by_user, NULL, '$date', 0, 0)";

                    if (mysqli_query($db_con, $sql)) {
                        return '<script>window.location.replace("server_manager.php");</script>';
                    } else {
                        return '<script>alert("操作数据库失败' . mysqli_error($db_con) . '");</script>';
                    }
                }
            }
        }
    }
}

// 管理员：初始化服务器
function adminInitserver($serverid, $db_con)
{
    // 通过serverid获取属于用户
    $sql = "SELECT `name`, `by_user`, `by_node` FROM `servers` WHERE `id` = $serverid";
    $result = mysqli_query($db_con, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $servername = $row['name'];
        $by_user = $row['by_user'];
        $by_node = $row['by_node'];
    }
    // 获取用户的用户名和密码（md5加密的说~）
    $sql = "SELECT `username`, `password` FROM `users` WHERE `id` = $by_user";
    $result = mysqli_query($db_con, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $username = $row['username'];
        $password = $row['password'];
    }
    // 愣着干啥，通过by_node找节点IP端口
    $sql = "SELECT `ip_port`, `token` FROM `node` WHERE `id` = $by_node";
    $result = mysqli_query($db_con, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ip_port = $row['ip_port'];
        $token = $row['token'];
    }
    $shell = "start /b curl \"http://$ip_port/?token=$token&action=init&servername=$servername\" -X POST";
    exec($shell, $out);
    // 请求节点添加该FTP
    $shell = "curl \"http://$ip_port/?token=$token&action=ftp&type=add&username=$username&password=$password&servername=$servername\" -X POST";
    exec($shell, $out);
    $sql = "UPDATE `servers` SET `initialization` = '3' WHERE `servers`.`id` = $serverid";
    mysqli_query($db_con, $sql);
    return '<script>alert("已经开始初始化，请稍等十几分钟后操作（尽管显示完成）。大致时间由服务器性能和IO决定。");</script>';
}

// 管理员：删除服务器
function adminDelserver($serverid, $db_con)
{
    $serverid = mysqli_real_escape_string($db_con, $serverid);
    // 通过serverid查询服务器属于哪个用户和节点，并获取用户名
    $sql = "SELECT `id` , `by_user`, `by_node` FROM `servers` WHERE `id` = $serverid";
    $result = mysqli_query($db_con, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $r_servername = $row['name'];
        $r_by_user = $row['by_user'];
        $r_by_node = $row['by_node'];
    }
    // 通过r_by_user 获取用户名
    $sql = "SELECT `username` FROM `users` WHERE `id` = $r_by_user";
    $result = mysqli_query($db_con, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $r_username = $row['username'];
    }
    // 愣着干啥，通过by_node找节点IP端口
    $sql = "SELECT `ip_port`, `token` FROM `node` WHERE `id` = $r_by_node";
    $result = mysqli_query($db_con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $ip_port = $row['ip_port'];
            $token = $row['token'];
        }
    }
    // 请求节点删除对应的FTP用户
    $shell = "curl \"http://$ip_port/?token=$token&action=ftp&type=del&username=$r_username&servername=$r_servername\" -X POST";
    exec($shell, $out);

    // 在删除服务器前停止服务器
    $shell = "curl \"http://$ip_port/?token=$token&action=kill&servername=$r_servername\" -X POST";
    if (!exec($shell, $out)) {
        echo 'System Error!';
        return '*';
    }
    // 删除对应节点的目录（如果你希望保留服务器数据，可以注释下面两行）
    $shell = "curl \"http://$ip_port/?token=$token&action=del&servername=$r_servername\" -X POST";
    exec($shell, $out);
    // 执行删除
    $sql = "DELETE FROM `servers` WHERE `id` = $serverid";
    if (mysqli_query($db_con, $sql)) {
        return '<script>window.location.replace("server_manager.php");</script>';
    } else {
        return '<script>alert("操作数据库失败' . mysqli_error($db_con) . '");</script>';
    }
}

// 管理员：列出所有服务器
function adminListallserver($db_con)
{
    $sql = "SELECT * FROM `servers`";
    $result = mysqli_query($db_con, $sql);
    if (!mysqli_num_rows($result) > 0) {
        return '<tr><td colspan="9"><p align="center" style="color: gray">道生一，一生二，二生三，三生万物。</p></td></tr>';
    } else {
        while ($row = mysqli_fetch_array($result)) {
            if (empty($row['date'])) {
                $date = '永久';
            } else {
                $date = $row['date'];
            }
            switch ($row['initialization']) {
                case '':
                    $row['initialization'] = '未初始化';
                    $con = '<a class="link" href="server_manager.php?intl-serverid=' . $row['id'] . '">初始化</a>/<a class="link" href="server_manager.php?del-serverid=' . $row['id'] . '">删除</a>';
                    break;
                case '1':
                    $row['initialization'] = '初始化中';
                    $con = '<a class="link" href="#">无法操作</a>';
                    break;
                case '2':
                    $row['initialization'] = '初始化失败';
                    $con = '<a class="link" href="#">重试。</a>';
                    break;
                case '3':
                    $row['initialization'] = '完成';
                    $con = '<a class="link" href="server_manager.php?del-serverid=' . $row['id'] . '">删除</a>';
                    break;
                default:
                    $row['initialization'] = '未知';
                    $con = '<a class="link" href="#">未知</a>';
                    break;
            }
            if (!empty($row['date'])) {
                $date = $row['date'];
            }
            echo
                '<tr>
            <td>' .
                    $row['id'] .
                    '</td>' .
                    '<td>' .
                    $row['name'] .
                    '</td>' .
                    '<td>' .
                    $row['port'] .
                    '</td>' .
                    '<td>' .
                    $row['rcon_port'] .
                    '</td>' .
                    '<td>' .
                    $row['query_port'] .
                    '</td>' .
                    '<td>' .
                    $row['max_players'] .
                    '</td>' .
                    '<td>' .
                    $row['by_node'] .
                    '</td>' .
                    '<td>' .
                    $row['by_user'] .
                    '</td>' .
                    '<td>' .
                    $date .
                    '</td>' .
                    '<td>' .
                    $row['initialization'] .
                    '</td>' .
                    '<td>' .
                    $con .
                    '</td>' .
                    '</tr>';
        }
    }
}

// 管理员：续费服务器
function adminRenewserver($serverid, $newdate, $db_con) {
    // 自己人，别开枪
    $newdate = mysqli_real_escape_string($db_con, $newdate);
    $sql = "UPDATE `servers` SET `date` = '$newdate' WHERE `servers`.`id` = $serverid";
    if (!mysqli_query($db_con, $sql)) {
        // return '<script>alert("数据库操作失败");</script>';
        // ToDo: $serverid 的问题排查。
        echo '<script>alert("' . mysqli_error($db_con) . '");</script>';
    }
}

/* 用户功能部分 */

// 用户登录
function userLogin($username, $password, $db_con)
{
    $username = mysqli_real_escape_string($db_con, $username);
    $password = mysqli_real_escape_string($db_con, $password);
    $sql = "SELECT `id`, `username`, `password` FROM `users` WHERE `username`='$username' AND `password` = '$password'";
    $result = mysqli_query($db_con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            if ($password == $row['password']) {
                $_SESSION['user'] = $row['username'];
                $_SESSION['userid'] = $row['id'];
                header('Location: /index.php');
            } else {
                return '<script>alert("密码错误");</script>';
            }
        }
    } else {
        return '<script>alert("用户信息有误");</script>';
    }
}

// 用户注销
function userLogout()
{
    session_start();
    session_destroy();
}

// 修改密码 重置密码
function userChangepassword($oldpassword, $newpassword, $db_con)
{
    session_start();
    $userid = $_SESSION['userid'];
    $password = mysqli_real_escape_string($db_con, $newpassword);
    $sql = "SELECT `id`, `password` FROM `users` WHERE `id`= $userid";
    $result = mysqli_query($db_con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            if ($oldpassword == $row['password']) {
                $sql = "UPDATE `users` SET `password` = '$password' WHERE `users`.`id` = $userid";
                mysqli_query($db_con, $sql);
                $_SESSION['password_md5'] = $newpassword;
                header('Location: /index.php');
            } else {
                return '<script>alert("原密码错误");</script>';
            }
        }
    } else {
        return '<script>alert("用户信息有误");</script>';
    }
}

// 列出用户的所有服务器
function userListallservers($db_con)
{
    checkLogin($db_con);
    session_start();
    $nowdate = date('Y-m-d');
    $userid = $_SESSION['userid'];
    $sql = "SELECT * FROM `servers` WHERE `by_user` = $userid";
    $result = mysqli_query($db_con, $sql);
    if (!mysqli_num_rows($result) > 0) {
        return '<tr><td colspan="9"><p align="center" style="color: gray">道生一，一生二，二生三，三生万物。</p></td></tr>';
    } else {
        while ($row = mysqli_fetch_array($result)) {
            switch ($row['initialization']) {
                case '':
                    $row['initialization'] = '等待管理员初始化';
                    $con = '<a class="link" href="#">无权限操作</a>';
                    break;
                case '1':
                    $row['initialization'] = '初始化中';
                    $con = '<a class="link" href="#">无法操作</a>';
                    break;
                case '2':
                    $row['initialization'] = '初始化失败';
                    $con = '<a class="link" href="#">重试。</a>';
                    break;
                case '3':
                    $row['initialization'] = '完成';
                    $con = '<a class="link" href="control.php?serverid=' . $row['id'] . '">控制台</a>';
                    break;
                default:
                    $row['initialization'] = '未知';
                    $con = '<a class="link" href="#">未知</a>';
                    break;
            }
            $date = $row['date'];
            if (empty($date)) {
                $serverdate = '永久';
            } elseif (strtotime($nowdate) > strtotime($date)) {
                $row['initialization'] = '<span style="color: red">服务器已过期</span>';
                $con = '<a class="link" href="#"><span style="color: red">服务器已过期</span></a>';
                $edit = '<a class="link" href="#"><span style="color: red">服务器已过期</span></a>';
                $serverdate = '<span style="color: red">' . $row['date'] . '</span>';
            } else {
                $serverdate = $row['date'];
            }
            echo
                '<tr>
            <td>' .
                    $row['id'] .
                    '</td>' .
                    '<td>' .
                    $row['name'] .
                    '</td>' .
                    '<td>' .
                    $row['port'] .
                    '</td>' .
                    '<td>' .
                    $row['rcon_port'] .
                    '</td>' .
                    '<td>' .
                    $row['max_players'] .
                    '</td>' .
                    '<td>' .
                    $row['by_node'] .
                    '</td>' .
                    '<td>' .
                    $serverdate .
                    '</td>' .
                    '<td>' .
                    $con .
                    '</td>' .
                    '</tr>';
        }
    }
}
// 列出用户的所有服务器（select）
function userListallserversselect($db_con)
{
    checkLogin($db_con);
    session_start();
    $userid = $_SESSION['userid'];
    $sql = "SELECT * FROM `servers` WHERE `by_user` = $userid";
    $result = mysqli_query($db_con, $sql);
    if (!mysqli_num_rows($result) > 0) {
        return "<option disabled>您没有任何服务器。</option>";
    } else {
        while ($row = mysqli_fetch_array($result)) {
            $serverid = $row['id'];
            $servername = $row['name'];
            echo "<option value=\"$serverid\">$servername</option>";
        }
    }
}

// 获取服务器名称
function userGetservername($serverid, $db_con)
{
    checkLogin($db_con);
    session_start();
    $userid = $_SESSION['userid'];
    $sql = "SELECT * FROM `servers` WHERE `by_user` = $userid AND `id` = $serverid";
    $result = mysqli_query($db_con, $sql);
    if (!mysqli_num_rows($result) > 0) {
        return "未知服务器";
    } else {
        while ($row = mysqli_fetch_array($result)) {
            return $row['name'];
        }
    }
}
/* 核心部分：服务器管理 */
// FTP页面部分
function userFTP($db_con, $doamin, $username)
{
    session_start();
    $password_md5 = $_SESSION['password_md5'];
    $sql = "SELECT `name`, `ftpport` FROM `node`";
    $result = mysqli_query($db_con, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            echo
                '<tr>' .
                    '<td>' .
                    $row['name'] . '.' . $doamin .
                    '</td>' .
                    '<td>' .
                    $row['ftpport'] .
                    '</td>' .
                    '<td>' .
                    $username . '-服务器ID' .
                    '</td>' .
                    '<td>' .
                    '您的用户密码。' .
                    '</td>' .
                    '</tr>';
        }
    } else {
        echo '<tr><td colspan="4"><p align="center" style="color: gray">道生一，一生二，二生三，三生万物。</p></td></tr>';
    }
}
// 判断服务器是否到期
// {}

// 请求节点，发送并接收配置文件
// 请求节点，管理服务器
function nodeControlserver($serverid, $action, $by_user, $map, $more, $db_con)
{
    // 判断用户是否拥有该服务器并获取Servername,端口，节点，地图等。
    $sql = "SELECT `name`, `port`, `rcon_port`, `query_port`, `max_players`, `by_node`, `by_user` FROM `servers` WHERE `id` = $serverid AND `by_user` = $by_user";
    $result = mysqli_query($db_con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $servername = $row['name'];
            $port = $row['port'];
            $rcon_port = $row['rcon_port'];
            $query_port = $row['query_port'];
            $max_players = $row['max_players'];
            $query_port = $row['query_port'];
            $by_node = $row['by_node'];
        }
        // 愣着干啥，通过by_node找节点IP端口
        $sql = "SELECT `ip_port`, `token` FROM `node` WHERE `id` = $by_node";
        $result = mysqli_query($db_con, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $ip_port = $row['ip_port'];
                $token = $row['token'];
            }
        }
        // 筛选地图
        switch ($map) {
            case '1':
                $map = 'Aberration_P';
                break;
            case '2':
                $map = 'Extinction';
                break;
            case '3':
                $map = 'Genesis';
                break;
            case '4':
                $map = 'Ragnarok';
                break;
            case '5':
                $map = 'ScorchedEarth_P';
                break;
            case '6':
                $map = 'TheIsland';
                break;
            case '7':
                $map = 'TheCenter';
                break;
            case '8':
                $map = 'Valguero_P';
                break;
            default:
                // 默认就是Aberration_P吧
                $map = 'Aberration_P';
                break;
        }
        // 筛选action
        switch ($action) {
            case 'start':
                $args = base64_encode("$map?listen?Port=$port?QueryPort=$query_port?MaxPlayers=$max_players?$more");
                $shell = "curl \"http://$ip_port/?token=$token&action=start&servername=$servername&args=$args\" -X POST";
                // 判断状态
                $sql = "SELECT `status` FROM `servers` WHERE `id` = $serverid AND `by_user` = $by_user";
                $result = mysqli_query($db_con, $sql);
                if (!mysqli_num_rows($result)) {
                    return '<script>alert("你在无中生有");';
                    return '*';
                } else {
                    while ($row = mysqli_fetch_array($result)) {
                        $status = $row['status'];
                    }
                    if ($status == 1) {
                        return '<script>alert("服务器已经处于运行状态了");';
                        return '*';
                    } else {
                        $sql = "UPDATE `servers` SET `status` = '1' WHERE `servers`.`id` = $serverid AND `by_user` = $by_user";
                        mysqli_query($db_con, $sql);
                    }
                }

                break;
            case 'kill':
                $shell = "curl \"http://$ip_port/?token=$token&action=kill&servername=$servername\" -X POST";
                // 判断状态
                $sql = "SELECT `status` FROM `servers` WHERE `id` = $serverid AND `by_user` = $by_user";
                $result = mysqli_query($db_con, $sql);
                if (!mysqli_num_rows($result)) {
                    return '<script>alert("你在无中生有");';
                    return '*';
                } else {
                    while ($row = mysqli_fetch_array($result)) {
                        $status = $row['status'];
                    }
                    if ($status == 0) {
                    } else {
                        $sql = "UPDATE `servers` SET `status` = '0' WHERE `servers`.`id` = $serverid AND `by_user` = $by_user";
                        mysqli_query($db_con, $sql);
                    }
                }
                break;
            default:
                // 没指令开啥服，安全着想就不开了
                break;
        }
    }
    // Valguero_P?listen?Port=34343?QueryPort=27015?MaxPlayers=70?AllowCrateSpawnsOnTopOfStructures=True -UseBattlEye -servergamelog -ServerRCONOutputTribeLogs -useallavailablecores -usecache -nosteamclient -game -server -log
    # $shell = "curl \"http://localhost:4444/?token=123456&action=kill&servername=Server1\" -X POST\"";
    // $shell = "curl \"http://$ip_port/?token=$token&action=kill&servername=Server1\" -X POST\"";
    if (!exec($shell, $out)) {
        echo 'System Error!';
        return '*';
    }
    return '<script>alert("指令已发送，请稍等几分钟后操作");</script>';
}
