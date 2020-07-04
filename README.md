# ArkManager
[![Crowdin](https://badges.crowdin.net/arkmanager/localized.svg)](https://translate.yistars.net/)
[![GitHub](https://img.shields.io/github/license/yistars/ArkManager)](./LICENSE)
![GitHub release (latest by date including pre-releases)](https://img.shields.io/github/v/release/yistars/ArkManager?include_prereleases)
![GitHub All Releases](https://img.shields.io/github/downloads/yistars/ArkManager/total)

注意：目前仅支持Windows。后续会支持更多操作系统！

前往我们的论坛：https://f.yistars.net/ 注册并开始预约吧！

## 使用方法
### php 部分
前提：如果您的服务器禁用了php的 `exec` 函数，请解除。如果您的系统没有安装 `curl` ，请安装。

导入 `php/databse.sql` 至你的数据库，并修改 `config/config.php` 中的值。如果你的环境中禁用了 php 的 `exec` 函数，请解除禁用。

为了安全着想，请务必重命名 `php/admin`

上述步骤完成后，打开 http://domain.com/admin ，并输入你设置的密码，添加第一个节点。

请使用定时任务（如crontab等）执行http://domain.com/config/cron.php?key=123456
（请按实际情况修改），时间可以任意，推荐1小时执行一次。

### python 部分
自 `v1.0.0` 开始，将不需要安装 Python3 和依赖库

将程序放在节点服务器上任意位置，运行目录下名为 `main.exe` 的可执行文件即可

首次运行后，将会在程序目录下生成一个名为 `config.yml` 的配置文件，
你可以在其中修改端口、文件路径等内容

### 节点文件部署
```
├── path
│   ├── ExampleServer (用作模板服务器)
│   └── OtherServer (其他服务器，无需自己创建)
│
└── program directory
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
