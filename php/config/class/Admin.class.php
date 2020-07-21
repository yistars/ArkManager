<?php
/*
 * ArkManager 管理员类文件
 * Author: iVampireSP.com
 * 修改日期：2020/07/19 15:41
 * 别问我为什么还用着过多的面向过程的方法，因为我得适量缩小下工程量（懒）
 **/

class Admin
{
    public $db_con;
    // 管理员：验证管理员密码
    public function Login($password, $admin_password)
    {
        if ($password == $admin_password) {
            $_SESSION['admin_login'] = 1;
            echo '<script>window.location.replace("/admin/dash.php");</script>';
        } else {
            header('Location: /login.php');
        }
    }
    // 管理员：添加用户
    public function addUser($username, $password)
    {
        $username = mysqli_real_escape_string($this->db_con, $username);
        // 查找用户名是否重复
        $sql = "SELECT `username` FROM `users` WHERE `username` = '$username'";
        $result = $this->db_con->query($sql);
        if (mysqli_num_rows($result) > 0) {
            return '<script>alert("用户名重复，请检查。");</script>';
        } else {
            $sql = "INSERT INTO `users` (`id`, `username`, `password`) VALUES (NULL, '$username', '$password')";
            if (mysqli_query($this->db_con, $sql)) {
                return '<script>window.location.replace("user_manager.php");</script>';
            } else {
                return '<script>alert("操作数据库失败' . mysqli_error($this->db_con) . '");</script>';
            }
        }
    }

    // 管理员：删除用户
    public function delUser($username)
    {
        $username = mysqli_real_escape_string($this->db_con, $username);
        $sql = "DELETE FROM `users` WHERE `username` = '$username'";
        if (mysqli_query($this->db_con, $sql)) {
            return '<script>alert("用户已删除！");</script>';
        } else {
            return '<script>alert("操作数据库失败' . mysqli_error($this->db_con) . '");</script>';
        }
    }

    // 管理员：删除用户（通过ID）
    public function delUserbyid($userid)
    {
        $userid = mysqli_real_escape_string($this->db_con, $userid);
        $sql = "DELETE FROM `users` WHERE `id` = '$userid'";
        if (mysqli_query($this->db_con, $sql)) {
            return '<script>window.location.replace("user_manager.php");</script>';
        } else {
            return '<script>alert("操作数据库失败' . mysqli_error($this->db_con) . '");</script>';
        }
    }
    // 管理员：列出所有用户
    public function listAlluser()
    {
        $sql = "SELECT * FROM `users`";
        $result = $this->db_con->query($sql);
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
    public function addNode($nodename, $nodeip, $ftpport, $token)
    {
        $nodename = mysqli_real_escape_string($this->db_con, $nodename);
        $nodeip = mysqli_real_escape_string($this->db_con, $nodeip);
        $ftpport = mysqli_real_escape_string($this->db_con, $ftpport);
        $token = mysqli_real_escape_string($this->db_con, $token);
        // 查找服务器名是否重复
        $sql = "SELECT `name` FROM `node` WHERE `name` = '$nodename'";
        $result = $this->db_con->query($sql);
        if (mysqli_num_rows($result) > 0) {
            return '<script>alert("节点名重复，请检查。");</script>';
        } else {
            $sql = "INSERT INTO `node` (`id`, `name`, `ip_port`, `ftpport`, `token`) VALUES (NULL, '$nodename', '$nodeip', $ftpport, '$token')";
            if (mysqli_query($this->db_con, $sql)) {
                return '<script>window.location.replace("node_manager.php");</script>';
            } else {
                return '<script>alert("操作数据库失败' . mysqli_error($this->db_con) . '");</script>';
            }
        }
    }
    // 管理员：删除节点
    public function delNode($nodeid)
    {
        $nodeid = mysqli_real_escape_string($this->db_con, $nodeid);
        $sql = "DELETE FROM `node` WHERE `id` = $nodeid";
        if (mysqli_query($this->db_con, $sql)) {
            return '<script>window.location.replace("node_manager.php");</script>';
        } else {
            return '<script>alert("操作数据库失败' . mysqli_error($this->db_con) . '");</script>';
        }
    }
    // 管理员：列出所有节点
    public function listAllnode()
    {
        $sql = "SELECT * FROM `node`";
        $result = $this->db_con->query($sql);
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
    public function listallnodeselect()
    {
        $sql = "SELECT `id`, `name` FROM `node`";
        $result = $this->db_con->query($sql);
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
    public function createServer($servername, $serverport, $rconport, $query_port, $maxplayers, $by_user, $by_node, $date)
    {
        $servername = mysqli_real_escape_string($this->db_con, $servername);
        $serverport = mysqli_real_escape_string($this->db_con, $serverport);
        $rconport = mysqli_real_escape_string($this->db_con, $rconport);
        $query_port = mysqli_real_escape_string($this->db_con, $query_port);
        $maxplayers = mysqli_real_escape_string($this->db_con, $maxplayers);
        $by_user = mysqli_real_escape_string($this->db_con, $by_user);
        $by_node = mysqli_real_escape_string($this->db_con, $by_node);
        $date = mysqli_real_escape_string($this->db_con, $date);
        // 查找服务器名是否重复
        $sql = "SELECT `name` FROM `servers` WHERE `name` = '$servername'";
        $result = $this->db_con->query($sql);
        if (mysqli_num_rows($result) > 0) {
            return '<script>alert("服务器名重复，请检查。");</script>';
        } else {
            // 查找端口是否重复
            $sql = "SELECT `port` FROM `servers` WHERE `port` = '$serverport'";
            $result = $this->db_con->query($sql);
            if (mysqli_num_rows($result) > 0) {
                return '<script>alert("端口重复，请检查。");</script>';
            } else {
                // 查找rcon端口是否重复
                $sql = "SELECT `rcon_port` FROM `servers` WHERE `rcon_port` = '$rconport'";
                $result = $this->db_con->query($sql);
                if (mysqli_num_rows($result) > 0) {
                    return '<script>alert("RCON端口重复，请检查。");</script>';
                } else {
                    // 查找query_port是否重复
                    $sql = "SELECT `query_port` FROM `servers` WHERE `query_port` = '$query_port'";
                    $result = $this->db_con->query($sql);
                    if (mysqli_num_rows($result) > 0) {
                        return '<script>alert("Query端口重复，请检查。");</script>';
                    } else {
                        $sql = "INSERT INTO `servers` (`id`, `name`, `port`, `rcon_port`, `query_port`, `max_players`, `by_node`, `by_user`, `initialization`, `date`, `is_expire`, `status`) VALUES (NULL, '$servername', $serverport, $rconport, $query_port, $maxplayers, $by_node, $by_user, NULL, '$date', 0, 0)";

                        if (mysqli_query($this->db_con, $sql)) {
                            return '<script>window.location.replace("server_manager.php");</script>';
                        } else {
                            return '<script>alert("操作数据库失败' . mysqli_error($this->db_con) . '");</script>';
                        }
                    }
                }
            }
        }
    }

    // 管理员：初始化服务器
    public function initServer($serverid)
    {
        // 通过serverid获取属于用户
        $sql = "SELECT `name`, `by_user`, `by_node` FROM `servers` WHERE `id` = $serverid";
        $result = $this->db_con->query($sql);
        while ($row = mysqli_fetch_array($result)) {
            $servername = $row['name'];
            $by_user = $row['by_user'];
            $by_node = $row['by_node'];
        }
        // 获取用户的用户名和密码（md5加密的说~）
        $sql = "SELECT `username`, `password` FROM `users` WHERE `id` = $by_user";
        $result = $this->db_con->query($sql);
        while ($row = mysqli_fetch_array($result)) {
            $username = $row['username'];
            $password = $row['password'];
        }
        // 愣着干啥，通过by_node找节点IP端口
        $sql = "SELECT `ip_port`, `token` FROM `node` WHERE `id` = $by_node";
        $result = $this->db_con->query($sql);
        while ($row = mysqli_fetch_array($result)) {
            $ip_port = $row['ip_port'];
            $token = $row['token'];
        }
        $shell = "nohup curl \"http://$ip_port/?token=$token&action=init&servername=$servername&username=$username-$serverid&password=$password\" -X POST >> /dev/null 2>&1";
        exec($shell, $out);
        // 请求节点添加该FTP
        $shell = "curl \"http://$ip_port/?token=$token&action=ftp&type=add&username=$username&password=$password&servername=$servername\" -X POST";
        exec($shell, $out);
        $sql = "UPDATE `servers` SET `initialization` = '3' WHERE `servers`.`id` = $serverid";
        $this->db_con->query($sql);
        return '<script>alert("已经开始初始化，请稍等十几分钟后操作（尽管显示完成）。大致时间由服务器性能和IO决定。");</script>';
    }

    // 管理员：删除服务器
    public function delServer($serverid)
    {
        $serverid = mysqli_real_escape_string($this->db_con, $serverid);
        // 通过serverid查询服务器属于哪个用户和节点，并获取用户名
        $sql = "SELECT `id`, `name`, `by_user`, `by_node` FROM `servers` WHERE `id` = $serverid";
        $result = $this->db_con->query($sql);
        while ($row = mysqli_fetch_array($result)) {
            $r_servername = $row['name'];
            $r_by_user = $row['by_user'];
            $r_by_node = $row['by_node'];
        }
        // 通过r_by_user 获取用户名
        $sql = "SELECT `username` FROM `users` WHERE `id` = $r_by_user";
        $result = $this->db_con->query($sql);
        while ($row = mysqli_fetch_array($result)) {
            $r_username = $row['username'];
        }
        // 愣着干啥，通过by_node找节点IP端口
        $sql = "SELECT `ip_port`, `token` FROM `node` WHERE `id` = $r_by_node";
        $result = $this->db_con->query($sql);
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
        // 在后台执行：删除对应节点的目录（如果你希望保留服务器数据，可以注释下面两行）
        $shell = "nohup curl \"http://$ip_port/?token=$token&action=del&servername=$r_servername\" -X POST >> /dev/null 2>&1";
        exec($shell, $out);
        // 执行删除
        $sql = "DELETE FROM `servers` WHERE `id` = $serverid";
        if (mysqli_query($this->db_con, $sql)) {
            return '<script>window.location.replace("server_manager.php");</script>';
        } else {
            return '<script>alert("操作数据库失败' . mysqli_error($this->db_con) . '");</script>';
        }
    }

    // 管理员：列出所有服务器
    public function listAllserver()
    {
        $sql = "SELECT * FROM `servers`";
        $result = $this->db_con->query($sql);
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
                $serverid = $row['id'];
                if (empty($row['date'])) {
                    $date = '<a style="color: blue; text-decoration: none;" href="renew_server.php?serverid=' . $serverid . '">' . '永久' . '</a>';
                } else {
                    $date = '<a style="color: blue; text-decoration: none;" href="renew_server.php?serverid=' . $serverid . '">' . $row['date'] . '</a>';
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
    public function renewServer($serverid, $newdate)
    {
        // 自己人，别开枪
        $newdate = mysqli_real_escape_string($this->db_con, $newdate);
        $sql = "UPDATE `servers` SET `date` = '$newdate' WHERE `servers`.`id` = $serverid";
        if (!mysqli_query($this->db_con, $sql)) {
            // return '<script>alert("数据库操作失败");</script>';
            // ToDo: $serverid 的问题排查。
            echo '<script>alert("' . mysqli_error($this->db_con) . '");</script>';
        }
    }

    
}
