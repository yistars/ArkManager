# ArkManager
[![Crowdin](https://badges.crowdin.net/arkmanager/localized.svg)](https://translate.yistars.net/) [![GitHub](https://img.shields.io/github/license/yistars/ArkManager)](./LICENSE) [![GitHub release (latest by date including pre-releases)](https://img.shields.io/github/v/release/yistars/ArkManager?include_prereleases)](https://github.com/yistars/ArkManager/releases/latest) [![GitHub All Releases](https://img.shields.io/github/downloads/yistars/ArkManager/total)](https://github.com/yistars/ArkManager/releases)

* 適用平台：Windows
* 論壇：https://f.yistars.net/
* 本地化：https://translate.yistars.net/

## 使用方法
### 面板部分
1. 檢查：你的系統已安裝 `curl`；啟用了 php 的 `exec` 函數。
2. 導入 `php/databse.sql` 至數據庫,並修改 `config/config.php` 中的值。
3. 打開 `http://domain.com/admin` ，輸入你設置的密碼，添加第一個節點。
4. 添加定時任務(如`crontab` 等) 執行`http://domain.com/config/cron.php?key=123456`(根據實際情況修改)，執行時間自定，推荐一小時執行一次。

### 服务器部分
自 `v1.0.0` 開始，將不需要安裝 Python3 和依賴庫

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
* ~~FTP 功能~~
* ~~Python 面向對象~~
* ~~節點配置文件獨立~~
* Python 輸出 logs 文件
* 更新服務器功能
* Python 增加 debug 接口
* 更加完整的 Wiki

## 已知問題
* 管理員後台模板問題，但不影響使用

## 特別感謝
* [Crowdin](https://crowdin.com/)
* [pyftpdlib](https://github.com/giampaolo/pyftpdlib)
* [pyinstaller](https://github.com/pyinstaller/pyinstaller)
* [PHP-Minecraft-Rcon](https://github.com/thedudeguy/PHP-Minecraft-Rcon)
* [Minecraft-RCON](https://github.com/Rauks/Minecraft-RCON)
* [ArkPsh](https://rcon.arkpsh.cn/)


<!--
<details>
<summary>点击展开</summary>
</details>
-->