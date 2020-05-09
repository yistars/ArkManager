# ArkManager
[![Crowdin](https://badges.crowdin.net/arkmanager/localized.svg)](https://translate.yistars.net/)
![GitHub](https://img.shields.io/github/license/yistars/ArkManager)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/yistars/ArkManager)
![GitHub All Releases](https://img.shields.io/github/downloads/yistars/ArkManager/total)

由 iVampireSP, Bing_Yanchi 共同创建

当前版本为社区版本，如有 bug 可以发 issue

iVampireSP 负责 php 部分, Bing_Yanchi 负责 python 部分

注意：目前仅支持Windows。我们后续会支持更多版本!

前往我们的论坛：https://f.yistars.net/ 注册并开始预约吧！

更多介绍，尚待补充

## 使用方法
### php 部分
导入 php/databse.sql 至你的数据库，并修改 config/config.php 中的值

### python 部分
要求：Python 3 以上

将 python 中的文件放在节点上并运行 (位置随意)

请修改 ftp_server.py 上 12 行 的路径为你的节点服务器存储路径

### 节点文件部署
```
├── path
│   ├── ExampleServer (用作模板服务器)
│   └── OtherServer (其他服务器，无需自己创建)
```

### 未来目标
* FTP 功能
