# ArkManager
[![Crowdin](https://badges.crowdin.net/arkmanager/localized.svg)](https://translate.yistars.net/)
[![GitHub](https://img.shields.io/github/license/yistars/ArkManager)](./LICENSE)
![GitHub release (latest by date including pre-releases)](https://img.shields.io/github/v/release/yistars/ArkManager?include_prereleases)
![GitHub All Releases](https://img.shields.io/github/downloads/yistars/ArkManager/total)

**警告**
*当前储存库内容为开发中内容，暂不可用，点击[这里](https://github.com/yistars/ArkManager/releases)获取较稳定版本。*

由 iVampireSP, BingYanchi 共同创建

当前版本为社区版本，如有 bug 可以发 issue

iVampireSP 负责 php 部分，BingYanchi 负责 python 部分

注意：目前仅支持Windows。后续会支持更多版本！

前往我们的论坛：https://f.yistars.net/ 注册并开始预约吧！

## 使用方法
### php 部分
前提：如果您的服务器禁用了php的 `exec` 函数，请解除。如果您的系统没有安装 `curl` ，请安装。

导入 `php/databse.sql` 至你的数据库，并修改 `config/config.php` 中的值。如果你的环境中禁用了 php 的 `exec` 函数，请解除禁用。

为了安全着想，请务必重命名 `php/admin`

上述步骤完成后，打开 http://domain:port/admin ，并输入你设置的密码，添加第一个节点。

节点要求Windows系统且安装Python环境，配置完后请运行 `python main.py`。

### python 部分
要求：Python 3 以上

将 python 中的文件放在节点上并运行 (位置随意)

请修改 `config.yml` 的内容以配置相关设置

### 节点文件部署
```
├── path
│   ├── ExampleServer (用作模板服务器)
│   └── OtherServer (其他服务器，无需自己创建)
│
└── python program directory
    ├── main.py (主程序)
    ├── config.yml (配置文件，无需自己创建)
    └── module (模块文件夹)
        ├── http.py (http 模块)
        └── ftp.py (ftp 模块)
```

### 未来目标
* FTP 功能
* Python 面向对象
* 节点配置文件独立

### 已知问题
* 管理员后台模板问题，但是不影响使用
