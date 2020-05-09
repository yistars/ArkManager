<?php
/*
    该文件是ArkManager的函数文件，请按需修改。如有bug，请立即向我们反馈。
*/

/* 前提部分 */
// 判断用户是否登录或者用户是否存在
function checkLogin($db_con) {
    session_start();
    $userid = $_SESSION['userid'];
    // 通过userid 查找用户是否存在
    $sql = "SELECT `id` FROM `users` WHERE `id`='$userid'";
    $result = mysqli_query($db_con,$sql);
    if (!mysqli_num_rows($result)){
        header('HTTP/1.1 403 Forbidden');
        echo '<script>window.location.replace("/pages/message.php?message=您没有登录或者不存在该用户。&action=login");</script>';
        session_destroy();
    }
}
// POST数据到节点
function curlPost($serverid, $action, $db_con) {
    session_start();
    // 通过$serverid 查找服务器IP和端口及以及对应的节点
    //如果是管理员
    if ($_SESSION['admin_login'] == 1) {
        $sql = "SELECT `id`, `name`, `port`, `rcon_port`, `max_players`, `by_node`, `by_user`, `initialization` FROM `servers` WHERE `id` = $serverid";
    }else {
        $userid = $_SESSION['userid'];
        $sql = "SELECT `id`, `name`, `port`, `rcon_port`, `max_players`, `by_node`, `by_user`, `initialization` FROM `servers` WHERE `id` = $serverid AND `by_user` = $userid";
    }
    $result = mysqli_query($db_con, $sql);
    if (!mysqli_num_rows($result) > 0) {
        return '节点不存在';
    }else {
        while($row = mysqli_fetch_array($result)) {
            $serverid = $row['serverid'];
            $servername = $row['servername'];
            $rcon_port = $row['rcon_port'];
            $maxplayers = $row['maxplayers'];
            $by_node = $row['by_node'];
            $by_user = $row['by_user'];
            $initialization = $row['initialization'];
        }
        $ch = curl_init();
    }
    // 通过$by_node 查找节点的服务器IP和端口及Token
    $sql = "SELECT `ip_port`, `token` FROM `node` WHERE `id` = $by_node";
    $result = mysqli_query($db_con, $sql);
    if (!mysqli_num_rows($result) > 0) {
        return '节点不存在';
    }else {
        while($row = mysqli_fetch_array($result)) {
            $ip_port = $row['ip_port'];
            $token = $row['token'];
        }
    }
    // 筛选action
    switch ($action) {
        // 初始化服务器
        case 'init':
            $args = NULL;
        break;
        case 'start':
            $args = 'Aberration_P?listen?Port=34343?QueryPort=27015?MaxPlayers=70?AllowCrateSpawnsOnTopOfStructures=True -NoBattlEye -servergamelog -ServerRCONOutputTribeLogs -useallavailablecores -usecache -nosteamclient -game -server -log';
    }
    // 玩什么php的curl，直接调用系统
    $shell = "curl \"http://localhost:4444/?token=$token&action=kill&servername=Server1\" -X POST\"";
    exec($shell, $out);
}
/* 管理员功能部分 */

// 管理员：验证管理员密码
function adminLogin($password,$admin_password) {
    if ($password == $admin_password) {
        $_SESSION['admin_login'] = 1;
        echo '<script>window.location.replace("/admin/dash.php");</script>';
    }else {
        header('Location: /pages/message.php?message=密码错误。');
    }
}

// 管理员：添加用户
function adminAdduser($username, $password, $db_con) {
    $username = mysqli_real_escape_string($db_con, $username);
    // 查找用户名是否重复
    $sql = "SELECT `username` FROM `users` WHERE `username` = '$username'";
    $result = mysqli_query($db_con,$sql);
    if (mysqli_num_rows($result) > 0) {
        return '<script>alert("用户名重复，请检查。");</script>';
    }else {
        $sql = "INSERT INTO `users` (`id`, `username`, `password`) VALUES (NULL, '$username', '$password');";
        if (mysqli_query($db_con,$sql)) {
            return '<script>window.location.replace("user_manager.php");</script>';
        }else {
            return '<script>alert("操作数据库失败' . mysqli_error($db_con) . '");</script>';
        }
    }
}

// 管理员：删除用户
function adminDeluser($username, $db_con) {
    $username = mysqli_real_escape_string($db_con, $username);
    $sql = "DELETE FROM `users` WHERE `username` = '$username'";
    if (mysqli_query($db_con,$sql)) {
        return '<script>alert("用户已删除！");</script>';
    }else {
        return '<script>alert("操作数据库失败' . mysqli_error($db_con) . '");</script>';
    }
}
// 管理员：删除用户（通过ID）
function adminDeluserbyid($userid, $db_con) {
    $userid = mysqli_real_escape_string($db_con, $userid);
    $sql = "DELETE FROM `users` WHERE `id` = '$userid'";
    if (mysqli_query($db_con,$sql)) {
        return '<script>window.location.replace("user_manager.php");</script>';
    }else {
        return '<script>alert("操作数据库失败' . mysqli_error($db_con) . '");</script>';
    }
}
// 管理员：列出所有用户
function adminListalluser($db_con) {
    $sql = "SELECT * FROM `users`";
    $result = mysqli_query($db_con,$sql);
    if (!mysqli_num_rows($result) > 0) {
        return '<tr><td colspan="3"><p align="center" style="color: gray">道生一，一生二，二生三，三生万物。</p></td></tr>';
    }else {
        while($row = mysqli_fetch_array($result)) {
            echo 
        '<tr>
            <td>' . 
            $row['id'] . 
            '</td>'. 
            '<td>'.
            $row['username'] . 
            '</td>' .
            '<td>'.
            '<a class="link" href="user_manager.php?del-userid=' . $row['id'] . '">删除</a>' . 
            '</td>'.
        '</tr>'
            ;
        }
    }
}

// 管理员：添加节点
function adminAddnode($nodename, $nodeip, $token, $db_con) {
    $nodename = mysqli_real_escape_string($db_con, $nodename);
    $nodeip = mysqli_real_escape_string($db_con, $nodeip);
    $token = mysqli_real_escape_string($db_con, $token);
    // 查找服务器名是否重复
    $sql = "SELECT `name` FROM `node` WHERE `name` = '$nodename'";
    $result = mysqli_query($db_con,$sql);
    if (mysqli_num_rows($result) > 0) {
        return '<script>alert("节点名重复，请检查。");</script>';
    }else {
        $sql = "INSERT INTO `node` (`id`, `name`, `ip_port`, `token`) VALUES (NULL, '$nodename', '$nodeip', '$token');";
        if (mysqli_query($db_con,$sql)) {
            return '<script>window.location.replace("node_manager.php");</script>';
        }else {
            return '<script>alert("操作数据库失败' . mysqli_error($db_con) . '");</script>';
        }
    }
}
// 管理员：删除节点
function adminDelnode($nodeid, $db_con) {
    $nodeid = mysqli_real_escape_string($db_con,$nodeid);
    $sql = "DELETE FROM `node` WHERE `id` = $nodeid";
    if (mysqli_query($db_con,$sql)) {
        return '<script>window.location.replace("node_manager.php");</script>';
    }else {
        return '<script>alert("操作数据库失败' . mysqli_error($db_con) . '");</script>';
    }
}
// 管理员：列出所有节点
function adminListallnode($db_con) {
    $sql = "SELECT * FROM `node`";
    $result = mysqli_query($db_con,$sql);
    if (!mysqli_num_rows($result) > 0) {
        return '<tr><td colspan="5"><p align="center" style="color: gray">道生一，一生二，二生三，三生万物。</p></td></tr>';
    }else {
        while($row = mysqli_fetch_array($result)) {
            echo 
        '<tr>
            <td>' . 
            $row['id'] . 
            '</td>'. 
            '<td>'.
            $row['name'] . 
            '</td>' . 
            '<td>' . 
            $row['ip_port'] . 
            '</td>' .
            '<td>' . 
            $row['token'] . 
            '</td>' .
            '<td>' .
            '<a class="link" href="node_manager.php?del-nodeid=' . $row['id'] . '">删除</a>' . 
            '</td>'.
            '</tr>'
            ;
        }
    }
}

// 管理员：列出所有节点（select）
function adminListallnodeselect($db_con) {
    $sql = "SELECT `id`, `name` FROM `node`";
    $result = mysqli_query($db_con,$sql);
    if (!mysqli_num_rows($result) > 0) {
        return '<option disabled>没有任何节点</option>';
    }else {
        while($row = mysqli_fetch_array($result)) {
            $nodeid = $row['id'];
            $nodename = $row['name'];
            echo
            "<option value=\"$nodeid\">$nodename</option>";
        }
    }
}

// 管理员：创建服务器
function adminCreateserver($servername, $serverport, $rconport, $query_port, $maxplayers, $by_user, $by_node, $date, $db_con) {
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
    }else {
        // 查找端口是否重复
            $sql = "SELECT `port` FROM `servers` WHERE `port` = '$serverport'";
            $result = mysqli_query($db_con, $sql);
            if (mysqli_num_rows($result) > 0) {
            return '<script>alert("端口重复，请检查。");</script>';
            }else {
                // 查找rcon端口是否重复
                $sql = "SELECT `rcon_port` FROM `servers` WHERE `rcon_port` = '$rconport'";
                $result = mysqli_query($db_con, $sql);
                if (mysqli_num_rows($result) > 0) {
                    return '<script>alert("RCON端口重复，请检查。");</script>';
                }else {
                        // 查找query_port是否重复
                        $sql = "SELECT `query_port` FROM `servers` WHERE `query_port` = '$query_port'";
                        $result = mysqli_query($db_con, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            return '<script>alert("Query端口重复，请检查。");</script>';
                    }else {
                        $sql ="INSERT INTO `servers` (`id`, `name`, `port`, `rcon_port`, `query_port`, `max_players`, `by_node`, `by_user`, `initialization`, `conf`, `date`, `is_expire`, `status`) VALUES (NULL, '$servername', $serverport, $rconport, $query_port, $maxplayers, $by_node, $by_user, NULL, NULL, '$date', 0, 0)";
                        
                        if (mysqli_query($db_con, $sql)) {
                            return '<script>window.location.replace("server_manager.php");</script>';
                    }else {
                        return '<script>alert("操作数据库失败' . mysqli_error($db_con) . '");</script>';
                    }
                }
            }
        }
    }
}

// 管理员：初始化服务器
function adminInitserver($serverid, $db_con) {
    if (!curlPost($serverid, 'init', $db_con)) {
        return '<script>alert("初始化失败");</script>';
    }else {
        return '<script>alert("已开始初始化，请稍后再来查看！");</script>';
    }

}

// 管理员：删除服务器
function adminDelserver($serverid, $db_con) {
    $serverid = mysqli_real_escape_string($db_con, $serverid);
    $sql = "DELETE FROM `servers` WHERE `id` = $serverid";
    if (mysqli_query($db_con,$sql)) {
        return '<script>window.location.replace("server_manager.php");</script>';
    }else {
        return '<script>alert("操作数据库失败' . mysqli_error($db_con) . '");</script>';
    }
}

// 管理员：列出所有服务器
function adminListallserver($db_con) {
    $sql = "SELECT * FROM `servers`";
    $result = mysqli_query($db_con,$sql);
    if (!mysqli_num_rows($result) > 0) {
        return '<tr><td colspan="9"><p align="center" style="color: gray">道生一，一生二，二生三，三生万物。</p></td></tr>';
    }else {
        while($row = mysqli_fetch_array($result)) {
            if (empty($row['date'])) {
                $date = '永久';
            }else {
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
            '</td>'. 
            '<td>'.
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
            '</td>'.
            '</tr>';
        }
    }
}


/* 用户功能部分 */

// 用户登录
function userLogin($username, $password, $db_con) {
    $username = mysqli_real_escape_string($db_con, $username);
    $password = mysqli_real_escape_string($db_con, $password);
    $sql = "SELECT `id`, `username`, `password` FROM `users` WHERE `username`='$username' AND `password` = '$password'";
    $result = mysqli_query($db_con,$sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            if ($password == $row['password']) {
                $_SESSION['user'] = $row['username'];
                $_SESSION['userid'] = $row['id'];
                header('Location: /user.php');
            }else {
                return '<script>alert("密码错误");</script>';
            }
        }
    }else {
        return '<script>alert("用户信息有误");</script>';
    }
}

// 用户注销
function userLogout() {
    session_start();
    session_destroy();
}

// 用户信息（带检测登录）
function userInfo($username, $db_con) {
    
}

// 修改密码 重置密码
function userChangepassword($oldpassword, $newpassword, $db_con) {
    session_start();
    $userid = $_SESSION['userid'];
    $password = mysqli_real_escape_string($db_con, $newpassword);
    $sql = "SELECT `id`, `password` FROM `users` WHERE `id`= $userid";
    $result = mysqli_query($db_con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            if ($oldpassword == $row['password']) {
                $sql = "UPDATE `users` SET `password` = '$password' WHERE `users`.`id` = $userid";
                mysqli_query($db_con, $sql);
                header('Location: /user.php');
            }else {
                return '<script>alert("原密码错误");</script>';
            }
        }
    }else {
        return '<script>alert("用户信息有误");</script>';
    }
}

// 列出用户的所有服务器
function userListallservers($db_con) {
    checkLogin($db_con);
    session_start();
    $nowdate = date('Y-m-d');
    $userid = $_SESSION['userid'];
    $sql = "SELECT * FROM `servers` WHERE `by_user` = $userid";
    $result = mysqli_query($db_con,$sql);
    if (!mysqli_num_rows($result) > 0) {
        return '<tr><td colspan="9"><p align="center" style="color: gray">道生一，一生二，二生三，三生万物。</p></td></tr>';
    }else {
        while($row = mysqli_fetch_array($result)) {
            switch ($row['initialization']) {
                case '':
                    $row['initialization'] = '等待管理员初始化';
                    $con = '<a class="link" href="#">无权限操作</a>';
                    $edit = '<a class="link" href="#">等待初始化</a>';
                break;
                case '1':
                    $row['initialization'] = '初始化中';
                    $con = '<a class="link" href="#">无法操作</a>';
                    $edit = '<a class="link" href="#">等待初始化</a>';
                break;
                case '2':
                    $row['initialization'] = '初始化失败';
                    $con = '<a class="link" href="#">重试。</a>';
                    $edit = '<a class="link" href="#">等待初始化</a>';
                break;
                case '3':
                    $row['initialization'] = '完成';
                    $con = '<a class="link" href="control.php?serverid=' . $row['id'] . '">控制台</a>';
                    $edit = '<a class="link" href="conf.php?id=' . $row['id'] . '">编辑</a>';
                break;
                default:
                    $row['initialization'] = '未知';
                    $con = '<a class="link" href="#">未知</a>';
                    $edit = '<a class="link" href="#">未知</a>';
            break;
            }
            $date = $row['date'];
            if (empty($date)) {
                $serverdate = '永久';
            }elseif(strtotime($nowdate) > strtotime($date)) {
                    $row['initialization'] = '<span style="color: red">服务器已过期</span>';
                    $con = '<a class="link" href="#"><span style="color: red">服务器已过期</span></a>';
                    $edit = '<a class="link" href="#"><span style="color: red">服务器已过期</span></a>';
                    $serverdate = '<span style="color: red">' . $row['date'] . '</span>';
                }else {
                    $serverdate = $row['date'];
                }
            echo 
        '<tr>
            <td>' . 
            $row['id'] . 
            '</td>'. 
            '<td>'.
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
            $edit .
            '</td>' .
            '<td>' .
            $con . 
            '</td>'.
            '</tr>'
            ;
        }
    }
}
// 编辑服务器配置文件
function userEditserverconfig($serverid, $db_con) {
    $userid = $_SESSION['userid'];
    // 检测用户是否有这个服务器
    $sql = "SELECT * FROM `servers` WHERE `id` = $serverid AND `by_user` = $userid";
    $result = mysqli_query($db_con, $sql);
    if (!mysqli_num_rows($result)) {
        header('Location: server_manager.php');
    }else {
        while($row = mysqli_fetch_array($result)) {
            // 如果conf是空的则输出示例conf
            if(empty($row['conf'])) {
                $file = fopen("config/GameUserSettings.ini",'r') or die('无法打开文件。');
                return fread($file,filesize('config/GameUserSettings.ini'));
                fclose($file);
            }else {
                // 否则就输出配置文件并BASE64解码
                return base64_decode($row['conf']);
            }
        }
    }
}

// 提交服务器配置文件
function userSubmitserverconfig($serverid, $conf_content, $db_con) {
    checkLogin($db_con);
    $userid = $_SESSION['userid'];
    $serverid = mysqli_real_escape_string($db_con, $serverid);
    $conf_content = mysqli_real_escape_string($db_con, base64_encode($conf_content));
    // 检测用户是否有这个服务器并判断是否到期
    $sql = "SELECT * FROM `servers` WHERE `id` = $serverid AND `by_user` = $userid";
    $result = mysqli_query($db_con, $sql);
    if (!mysqli_num_rows($result)) {
        //header('Location: server_manager.php');
        echo 1;
    }else {
        // 如果有则提交配置文件并BASE64
            $sql = "UPDATE `servers` SET `conf` = '$conf_content' WHERE `servers`.`id` = $serverid AND `by_user` = $userid";
            if (!mysqli_query($db_con, $sql)) {
                echo '<script>alert("失败。");</script>';
            }else {
                echo '<script>window.location.replace("server_manager.php");</script>';
            }
        }
}
// 列出用户的所有服务器（select）
function userListallserversselect($db_con) {
    checkLogin($db_con);
    session_start();
    $userid = $_SESSION['userid'];
    $sql = "SELECT * FROM `servers` WHERE `by_user` = $userid";
    $result = mysqli_query($db_con,$sql);
    if (!mysqli_num_rows($result) > 0) {
        return "<option disabled>您没有任何服务器。</option>";
    }else {
        while($row = mysqli_fetch_array($result)) {
            $serverid = $row['id'];
            $servername = $row['name'];
            echo "<option value=\"$serverid\">$servername</option>";
        }
    }
}

// 获取服务器名称
function userGetservername($serverid, $db_con) {
    checkLogin($db_con);
    session_start();
    $userid = $_SESSION['userid'];
    $sql = "SELECT * FROM `servers` WHERE `by_user` = $userid AND `id` = $serverid";
    $result = mysqli_query($db_con, $sql);
    if (!mysqli_num_rows($result) > 0) {
        return "未知服务器";
    }else {
        while($row = mysqli_fetch_array($result)) {
            return $row['name'];
        }
    }
}
/* 核心部分：服务器管理 */
// FTP页面部分
function userFTP($db_con, $doamin, $username) {
    $sql = "SELECT `name` FROM `node`";
    $result = mysqli_query($db_con, $sql);
    if (mysqli_num_rows($result)) {
        while($row = mysqli_fetch_array($result)) {
        echo 
            '<tr>' .
            '<td>'.
            $row['name'] . '.' . $doamin. 
            '</td>' . 
            '<td>' . 
            21 . 
            '</td>' .
            '<td>' . 
            $username .
            '</td>' .
            '<td>' . 
            '您的账户密码' . 
            '</td>' .
            '</tr>';
        }
    }else {
        echo '<tr><td colspan="4"><p align="center" style="color: gray">道生一，一生二，二生三，三生万物。</p></td></tr>';
    }
    
}
// 判断服务器是否到期
// {}

// 请求节点，发送并接收配置文件
// 请求节点，启动服务器
function nodeStartserver($serverid, $action, $by_user, $map, $more, $db_con) {
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
                $shell = "curl \"http://$ip_port/?token=$token&action=start&servername=$servername&args=$args\" -X POST\"";
            break;
            // 下面这部分没有用了，因为出了点bug却想暴力解决
            case 'kill':
                $shell = "curl \"http://$ip_port/?token=$token&action=kill&servername=$servername\" -X POST\"";
            break;
            default:
                // 没指令开啥服，安全着想就不开了
        break;
        }
    }
// Valguero_P?listen?Port=34343?QueryPort=27015?MaxPlayers=70?AllowCrateSpawnsOnTopOfStructures=True -UseBattlEye -servergamelog -ServerRCONOutputTribeLogs -useallavailablecores -usecache -nosteamclient -game -server -log
    # $shell = "curl \"http://localhost:4444/?token=123456&action=kill&servername=Server1\" -X POST\"";
    // $shell = "curl \"http://$ip_port/?token=$token&action=kill&servername=Server1\" -X POST\"";
    exec($shell, $out);
    echo $shell;
    return '<script>alert("启动指令已发送，请稍等几分钟后操作");</script>';
}

// 请求节点：停止服务器

/* 其实这部分可以合并到上面的，只不过因为某些原因想暴力解决下 */
function nodeStopserver($servername, $by_user, $by_node, $db_con) {

}