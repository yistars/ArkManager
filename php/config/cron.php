<?php
require_once('config.php');
if (!$_REQUEST['key'] == $cron_password) {
    return '*';
}else {
    $sql = "SELECT `id`, `date` FROM `servers`";
    $result = mysqli_query($db_con, $sql);
    if (!mysqli_num_rows($result)) {
        return '*';
    }else {
        while ($rows = mysqli_fetch_array($result)) {
            $nowdate = date('Y-m-d');
            $id = $rows['id'];
            $date = $rows['date'];
            if(empty($date)) { // 如果date是空（永久），则不执行任何操作。
                return '*';
            }elseif (strtotime($nowdate) > strtotime($date)) { // 如果现在的时间比数据库中的时间大，则服务器到期
                $sql = "UPDATE `servers` SET `is_expire` = 1 WHERE `servers`.`id` = $id";
                mysqli_query($db_con, $sql);
                echo mysqli_error($db_con);
            }elseif(strtotime($nowdate) < strtotime($date)) { // 如果现在的时间比数据库中的小，则没有到期
                $sql = "UPDATE `servers` SET `is_expire` = 0 WHERE `servers`.`id` = $id";
                mysqli_query($db_con, $sql);
                echo mysqli_error($db_con);
            }
        }
    }
}
