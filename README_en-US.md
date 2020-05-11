# ArkManager
[![Crowdin](https://badges.crowdin.net/arkmanager/localized.svg)](https://translate.yistars.net/) [![GitHub](https://img.shields.io/github/license/yistars/ArkManager)](./LICENSE) ![GitHub release (latest by date including pre-releases)](https://img.shields.io/github/v/release/yistars/ArkManager?include_prereleases) ![GitHub All Releases](https://img.shields.io/github/downloads/yistars/ArkManager/total)

Co-created by iVampireSP, Bing_Yanchi

The current version is a community version, if there is a bug, you can issue an issue

iVampireSP is responsible for the php part, Bing_Yanchi is responsible for the python part

Note: Currently only supports Windows. We will support more versions later!

Go to our forum: https://f.yistars.net/ Register and start booking!

## Instructions
### php part
Premise: If your server has disabled the exec function of php, please release it.

Import ` php / database.sql ` to your database and modify the values in ` config / config.php `. If the ` exec ` function of php is disabled in your environment, please remove it.

For security reasons, please be sure to rename ` php / admin `

After completing the above steps, open http://domain:port/ admin and enter the password you set to add the first node.

The node requires a Windows system and a Python environment. After configuration, please run ` python http_monitoring.py `, please modify the contents of the files as needed.

### python part
Requirements: Python 3 or above

Put the files in python on the node and run (arbitrary location)

Please modify the path on line 12 of ` http_monitoring.py ` to your node server storage path

### Node file deployment
```
├──path
│ ├── ExampleServer (used as a template server)
│ └── OtherServer (other server, no need to create your own)
```

### Future goals
* FTP function

### Known issues
* The administrator background template problem, but does not affect the use
