<?php
/*
 * ArkManager 用户类文件
 * Author: iVampireSP.com
 * 修改日期：2020/07/19 15:41
 * 
 **/
class User
{
    public $db_con;
    // 判断用户是否登录或者用户是否存在
    public function checkLogin()
    {
        $userid = $_SESSION['userid'];
        // 通过userid 查找用户是否存在
        $sql = "SELECT `id` FROM `users` WHERE `id`='$userid'";
        $result = $this->db_con->query($sql);
        if (!mysqli_num_rows($result)) {
            header('HTTP/1.1 403 Forbidden');
            echo '<script>window.location.replace("/login.php");</script>';
            session_destroy();
        }
    }
    /* 用户功能部分 */

    // 用户登录
    public function Login($username, $password, $form_token)
    {
        if ($form_token == $_SESSION['form_token']) {
            unset($_SESSION['form_token']);
        } else {
            echo $form_token;
            unset($_SESSION['form_token']);
            return '<script>alert("It maybe CORS, Please reload page.");</script>';
            return '*';
        }
        $username = mysqli_real_escape_string($this->db_con, $username);
        $password = mysqli_real_escape_string($this->db_con, $password);
        $sql = "SELECT `id`, `username`, `password` FROM `users` WHERE `username`='$username' AND `password` = '$password'";
        $result = $this->db_con->query($sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if ($password == $row['password']) {
                    unset($_SESSION['form_token']);
                    $_SESSION['user'] = $row['username'];
                    $_SESSION['userid'] = $row['id'];
                    header('Location: server_manager.php');
                } else {
                    $_SESSION['form_token'] = mt_rand();
                    return '<script>alert("Password wrong.");</script>';
                }
            }
        } else {
            $_SESSION['form_token'] = mt_rand();
            return '<script>alert("User info wrong.");</script>';
        }
    }

    // 用户注销
    public function Logout()
    {
        session_start();
        session_destroy();
    }

    // 修改密码 重置密码
    public function Changepassword($oldpassword, $newpassword)
    {
        session_start();
        $userid = $_SESSION['userid'];
        $password = mysqli_real_escape_string($this->db_con, $newpassword);
        $sql = "SELECT `id`, `password` FROM `users` WHERE `id`= $userid";
        $result = $this->db_con->query($sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if ($oldpassword == $row['password']) {
                    $sql = "UPDATE `users` SET `password` = '$password' WHERE `users`.`id` = $userid";
                    $this->db_con->query($sql);
                    header('Location: /index.php');
                } else {
                    return '<script>alert("Old Password wrong.");</script>';
                }
            }
        } else {
            return '<script>alert("User Info Wrong.");</script>';
        }
    }

    // 列出用户的所有服务器
    public function Listallservers()
    {
        $this->checkLogin();
        $nowdate = date('Y-m-d');
        $userid = $_SESSION['userid'];
        $sql = "SELECT * FROM `servers` WHERE `by_user` = $userid";
        $result = $this->db_con->query($sql);
        if (!mysqli_num_rows($result) > 0) {
            return '<tr><td colspan="9"><p align="center" style="color: gray">Empty</p></td></tr>';
        } else {
            while ($row = mysqli_fetch_array($result)) {
                switch ($row['initialization']) {
                    case '':
                        $row['initialization'] = 'Waiting for Admin init.';
                        $con = '<a class="link" href="#">Forbidden.</a>';
                        break;
                    case '1':
                        $row['initialization'] = 'Initing...';
                        $con = '<a class="link" href="#">Forbidden.</a>';
                        break;
                    case '2':
                        $row['initialization'] = 'Failed';
                        $con = '<a class="link" href="#">Retry。</a>';
                        break;
                    case '3':
                        $row['initialization'] = 'Done';
                        $con = '<a class="link" href="control.php?serverid=' . $row['id'] . '">Console</a>';
                        break;
                    default:
                        $row['initialization'] = 'Unknown';
                        $con = '<a class="link" href="#">Unknown</a>';
                        break;
                }
                $date = $row['date'];
                if (empty($date)) {
                    $serverdate = 'Forever';
                } elseif (strtotime($nowdate) > strtotime($date)) {
                    $row['initialization'] = '<span style="color: red">Expired</span>';
                    $con = '<a class="link" href="#"><span style="color: red">Expired</span></a>';
                    $edit = '<a class="link" href="#"><span style="color: red">Expired</span></a>';
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
    public function Listallserversselect()
    {
        $this->checkLogin();
        session_start();
        $userid = $_SESSION['userid'];
        $sql = "SELECT * FROM `servers` WHERE `by_user` = $userid";
        $result = $this->db_con->query($sql);
        if (!mysqli_num_rows($result) > 0) {
            return "<option disabled>Empty List.</option>";
        } else {
            while ($row = mysqli_fetch_array($result)) {
                $serverid = $row['id'];
                $servername = $row['name'];
                echo "<option value=\"$serverid\">$servername</option>";
            }
        }
    }

    // 获取服务器名称
    public function Getservername($serverid)
    {
        $this->checkLogin();
        session_start();
        $userid = $_SESSION['userid'];
        $sql = "SELECT * FROM `servers` WHERE `by_user` = $userid AND `id` = $serverid";
        $result = $this->db_con->query($sql);
        if (!mysqli_num_rows($result) > 0) {
            return "Unknown Server";
        } else {
            while ($row = mysqli_fetch_array($result)) {
                return $row['name'];
            }
        }
    }
    /* 核心部分：服务器管理 */
    // FTP页面部分
    public function FTP($doamin, $username)
    {
        session_start();
        $password_md5 = $_SESSION['password_md5'];
        $sql = "SELECT `name`, `ftpport` FROM `node`";
        $result = $this->db_con->query($sql);
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
                    $username . '-Server ID' .
                    '</td>' .
                    '<td>' .
                    'Your Password' .
                    '</td>' .
                    '</tr>';
            }
        } else {
            echo '<tr><td colspan="4"><p align="center" style="color: gray">Empty.</p></td></tr>';
        }
    }

    // 请求节点，发送并接收配置文件
    public function configAction($serverid, $action, $data, $by_user)
    {
        // 转义
        $serverid = mysqli_escape_string($this->db_con, $serverid);
        $action = mysqli_escape_string($this->db_con, $action);
        $data = base64_encode($data);
        $by_user = mysqli_real_escape_string($this->db_con, $by_user);
        // 判断用户是否拥有该服务器并获取Servername,端口，节点，地图等。
        $sql = "SELECT `name`, `port`, `rcon_port`, `query_port`, `max_players`, `by_node`, `by_user` FROM `servers` WHERE `id` = $serverid AND `by_user` = $by_user";
        $result = $this->db_con->query($sql);
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
            $result = $this->db_con->query($sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $ip_port = $row['ip_port'];
                    $token = $row['token'];
                }
            }

            // 筛选action来选择操作。
            switch ($action) {
                case 'get':
                    // 拉取
                    $file_content = file_get_contents("http://$ip_port/?token=$token&action=GUS&file=GameUserSettings.ini&type=pull");
                    if (empty($file_content)) {
                        $file_content = 'Unable to pull config file!';
                    }
                    echo $file_content;
                    break;

                case 'push':
                    // 提交配置文件
                    // $file_content = file_get_contents("http://$ip_port/?token=$token&action=GUS&file=GameUserSettings.ini&type=pull&data=$data");
                    $shell = "curl \"http://$ip_port/?token=$token&action=GUS&file=GameUserSettings.ini&type=push&data=$data\" -X POST";
                    exec($shell, $out);
                    echo '<script>alert("Push Success!");</script>';
                    break;

                default:
                    // ？
                    echo 'Something wrong.';
                    break;
            }
        }
    }



    // 请求节点，管理服务器
    public function nodeControlserver($serverid, $action, $by_user, $map, $more)
    {
        // ToDo 检测$more 是否含有违规字符，如&
        if (strstr($more, '&')) {
            echo '有违规字符: &，请更正。';
            exit;
        }
        
        $serverid = mysqli_real_escape_string($this->db_con, $serverid);
        $by_user = mysqli_real_escape_string($this->db_con, $by_user);
        // 判断用户是否拥有该服务器并获取Servername,端口，节点，地图等。
        $sql = "SELECT `name`, `port`, `rcon_port`, `query_port`, `max_players`, `by_node`, `by_user` FROM `servers` WHERE `id` = $serverid AND `by_user` = $by_user";
        $result = $this->db_con->query($sql);
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
            $result = $this->db_con->query($sql);
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
                    $ssname = $_SESSION['ssname'];
                    $args = base64_encode("$map?listen?Port=$port?QueryPort=$query_port?MaxPlayers=$max_players?SessionName=$ssname $more -server -log");
                    $shell = "curl \"http://$ip_port/?token=$token&action=start&servername=$servername&args=$args\" -X POST"; // ToDo 更换启动方式
                    // 判断状态
                    $sql = "SELECT `status` FROM `servers` WHERE `id` = $serverid AND `by_user` = $by_user";
                    $result = $this->db_con->query($sql);
                    if (!mysqli_num_rows($result)) {
                        echo '<script>alert("Undefined");</script>';
                        return '*';
                    } else {
                        while ($row = mysqli_fetch_array($result)) {
                            $status = $row['status'];
                        }
                        if ($status == 1) {
                            echo '<script>alert("服务器已经启动了。");</script>';
                            return '*';
                        } else {
                            echo '<script>alert("服务器正在启动中。");</script>';
                            $sql = "UPDATE `servers` SET `status` = '1' WHERE `servers`.`id` = $serverid AND `by_user` = $by_user";
                            $this->db_con->query($sql);
                        }
                    }
                    break;
                case 'kill':
                    $shell = "curl \"http://$ip_port/?token=$token&action=kill&servername=$servername\" -X POST";
                    // 判断状态
                    $sql = "SELECT `status` FROM `servers` WHERE `id` = $serverid AND `by_user` = $by_user";
                    $result = $this->db_con->query($sql);
                    if (!mysqli_num_rows($result)) {
                        echo 'Undefined';
                        return '*';
                    } else {
                        while ($row = mysqli_fetch_array($result)) {
                            $status = $row['status'];
                        }
                        if ($status == 0) {
                            echo 'Server already stopped.';
                        } else {
                            echo 'Server was stopping...';
                            $sql = "UPDATE `servers` SET `status` = '0' WHERE `servers`.`id` = $serverid AND `by_user` = $by_user";
                            $this->db_con->query($sql);
                        }
                    }
                    break;
                case 'update':
                    $shell = "curl \"http://$ip_port/?token=$token&action=update&servername=$servername\" -X POST";
                    // 判断状态
                    $sql = "SELECT `status` FROM `servers` WHERE `id` = $serverid AND `by_user` = $by_user";
                    $result = $this->db_con->query($sql);
                    if (!mysqli_num_rows($result)) {
                        echo 'Undefined';
                        return '*';
                    } else {
                        while ($row = mysqli_fetch_array($result)) {
                            $status = $row['status'];
                        }
                        if ($status == 0) {
                            echo 'Server Updating, Do not send command or control server!';
                        } else {
                            echo 'Server should be stopped.';
                            return '*';
                        }
                    }
                    break;
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
    }
}
