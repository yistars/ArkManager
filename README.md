# ArkManager
[![Crowdin](https://badges.crowdin.net/arkmanager/localized.svg)](https://translate.yistars.net/)
[![GitHub](https://img.shields.io/github/license/yistars/ArkManager)](./LICENSE)
![GitHub release (latest by date including pre-releases)](https://img.shields.io/github/v/release/yistars/ArkManager?include_prereleases)
![GitHub All Releases](https://img.shields.io/github/downloads/yistars/ArkManager/total)

* 适用平台：Windows
* 论坛：https://f.yistars.net/

## 使用方法
### 面板部分
1. 检查：你的系统已安装 `curl`，启用了 php 的 `exec` 函数。
2. 导入 `php/databse.sql` 至数据库，并修改 `config/config.php` 中的值。
3. 上述步骤完成后，打开 `http://domain.com/admin` ，并输入你设置的密码，添加第一个节点。
4. 添加定时任务 (如 `crontab` 等) 执行 `http://domain.com/config/cron.php?key=123456`(根据实际情况修改)，执行时间自定，推荐一小时执行一次。

### 服务器部分
自 `v1.0.0` 开始，将不需要安装 Python3 和依赖库

1. 将程序放在节点服务器上任意位置
2. 运行目录下名为 `main.exe` 的可执行文件

若你为首次运行

1. 首次执行程序将会在程序目录下生成一个名为 `config.yml` 的配置文件
2. 根据实际情况修改当中的服务器路径等内容

#### 节点文件部署
```
├── path (服务器路径)
│   ├── ExampleServer (用作模板服务器)
│   └── OtherServer (其他服务器，无需自己创建)
│
└── program directory (可放置任意位置)
    ├── main.exe (主程序)
    ├── config.yml (配置文件)
    └── ...
```

### 未来目标
* ~~FTP 功能~~
* ~~Python 面向对象~~
* ~~节点配置文件独立~~
* Python 输出 logs 文件
* 更新服务器功能
* 更加完整的 Wiki

### 已知问题
* 管理员后台模板问题，但是不影响使用

### 特别鸣谢
* [pyftpdlib](https://github.com/giampaolo/pyftpdlib)
* [pyinstaller](https://github.com/pyinstaller/pyinstaller)
* [PHP-Minecraft-Rcon](https://github.com/thedudeguy/PHP-Minecraft-Rcon)
* [Minecraft-RCON](https://github.com/Rauks/Minecraft-RCON)
* [ARKPSH](https://rcon.arkpsh.cn/)
