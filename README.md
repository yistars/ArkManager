# Server_Monitor
A Server Monitor By PHP

## 必读
监控界面阅读顺序：从右到左
最左边是最新的时间，最右边的最旧的时间

为了防止数据库占用过大，监控程序会自动清理超过`10`条以上的数据，但是我们还是建议你挂一个监控以便在特定的时间清除所有配置。

## 安装
将所有文件上传到你的Web服务器对应的根目录下，在`config.php`中配置数据库信息和清除时的`Token`。

## 监控
挂一个`Cron`来每隔一段时间（最好一星期）访问一次url
https://your_server_address/clear.php?token=your_token
将`your_server_address`改为你的服务器的`URL`,`your_token`改为你在`config.php`设置的`Token`。

## 接口
`Get`&`Post`均可以：
https://your_server_address/update.php?type=update&servername=服务器名称&cpu=CPU占用率（不包含百分号）&mem=内存占用率（不包含百分号）

## 安装客户端

1. Linux
   ```bash
        #!bin/bash
        cpu=`top -b -n1 | fgrep "Cpu(s)" | tail -1 | awk -F'id,' '{split($1, vs, ","); v=vs[length(vs)]; sub(/\s+/, "", v);sub(/\s+/, "", v); printf "%d", 100-v;}'`
        #echo $cpu

        mem_used_persent=`free -m | awk -F '[ :]+' 'NR==2{printf "%d", ($2-$7)/$2*100}'`
        #echo $mem_used_persent

        curl `"https://your_server_address/update.php?type=update&servername=`hostname`&cpu=$cpu&mem=$mem_used_persent"`
        echo 'Submit success!'
   ```
   你可以将上述脚本保存为一个`sh`文件，并赋予权限，定时执行。
   将`your_server_address`改为你的服务器的URL。

2. 通用（依赖`Python3`）
   这是一个`Python`写的监控程序，由冰砚炽编写。在此表示非常感谢！
   
   https://github.com/yistars/Monitor-For-lo-li.art
   打开并克隆上方仓库，一定要查阅`Readme`文件！
   
3. Windows
   https://github.com/yistars/Monitor-For-lo-li.art
   请到上方网址的`Release`界面下载，其中附带了一个`Windows`版的监控程序

## iVampireSP.com
[前往页面](https://ivampiresp.com/2020/12/08/%e7%ae%80%e6%98%93%e7%9a%84%e6%9c%8d%e5%8a%a1%e5%99%a8%e7%9b%91%e6%8e%a7%e7%a8%8b%e5%ba%8f%ef%bc%9aserver-monitor.html)

## Bing_Yanchi
[前往博客](https://www.yistars.cn)
