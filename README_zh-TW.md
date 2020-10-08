# ArkManager
[![Crowdin](https://badges.crowdin.net/arkmanager/localized.svg)](https://translate.yistars.net/) [![GitHub](https://img.shields.io/github/license/yistars/ArkManager)](./LICENSE) [![GitHub release (latest by date including pre-releases)](https://img.shields.io/github/v/release/yistars/ArkManager?include_prereleases)](https://github.com/yistars/ArkManager/releases/latest) [![GitHub All Releases](https://img.shields.io/github/downloads/yistars/ArkManager/total)](https://github.com/yistars/ArkManager/releases)

* 適用平台：Windows
* 論壇：https://f.yistars.net/
* 本地化：https://translate.yistars.net/

## 使用方法
* [bilibili](https://www.bilibili.com/video/BV1Gk4y1m7cw)

### 面板部分
1. 檢查：你的系統已安裝 `curl`；啟用了 php 的 `exec` 函數。
2. 導入 `php/databse.sql` 至數據庫,並修改 `config/config.php` 中的值。
3. 打開 `http://domain.com/admin` ，輸入你設置的密碼，添加第一個節點。
4. 添加定時任務(如`crontab` 等) 執行`http://domain.com/config/cron.php?key=123456`(根據實際情況修改)，執行時間自定，推荐一小時執行一次。

### 服务器部分
自 `v1.0.0` 开始，将不需要安装 Python3 和依赖库

1. 將程序放在節點服務器上任意位置
2. 運行目錄下名為 `main.exe` 的可執行文件
3. 首次運行將會在程序目錄下生成一個名為 `config.yml` 的配置文件
4. 根據實際情況修改當中的服務器路徑等內容

#### 節點文件部署
```
├── path (服務器路徑)
│   ├── ExampleServer (用作模板服務器)
│   └── OtherServer (其他服務器，無需自己創建)
│
└── program directory (可放置任意位置)
    ├── main.exe (主程序)
    ├── config.yml (配置文件)
    └── ...
```

## 未來目標
* 更加完整的 Wiki
* 网页端修改服务器的配置文件（如：服务器密码，管理员密码，掉落倍率等。）
* 服务端增加语言文件 <details>
<summary>已完成</summary>* ~~FTP 功能~~
* ~~Python 面向对象~~
* ~~节点配置文件独立~~
* ~~更新服务器功能~~
* ~~php 面向对象~~ </details>

## 已知問題
* 管理员后台模板问题，但不影响使用

## 特別感謝
* [Crowdin](https://crowdin.com/)
* [pyftpdlib](https://github.com/giampaolo/pyftpdlib)
* [pyinstaller](https://github.com/pyinstaller/pyinstaller)
* [PHP-Minecraft-Rcon](https://github.com/thedudeguy/PHP-Minecraft-Rcon)
* [Minecraft-RCON](https://github.com/Rauks/Minecraft-RCON)
* [ArkPsh](https://rcon.arkpsh.cn/)


## 捐赠支持
我们也只是个业余爱好者，如果你喜欢，请捐赠让我们做的更好

![捐赠](https://i.loli.net/2020/07/28/6hZBNGrd71LjYeE.jpg)

爱发电：
* Bing_Yanchi： [https://afdian.net/@Bing_Yanchi](https://afdian.net/@Bing_Yanchi)
* iVampireSP： [https://afdian.net/@iVampireSP](https://afdian.net/@iVampireSP)
