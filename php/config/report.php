<?php
function report_data($sitename, $domain, $version)
{
    $path = $_SERVER["DOCUMENT_ROOT"];
    // 判断是否已提交
    if (!file_exists("$path/config/Reported")) {
        // 创建一个新cURL资源
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, 'https://report-data.lo-li.art/report/arkmanager.php');
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        $post_data = array(
            "sitename" => $sitename,
            "domain" => $domain,
            "version" => $version,
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        // 创建文件
        fopen("$path/config/Reported", "w");
    }
}
