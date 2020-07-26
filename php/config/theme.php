<?php
function mduiHeader($subtitle) {
    $sitename = SITENAME;
    echo <<<EOF
    <header class="mdui-appbar mdui-appbar-fixed">
    <div class="mdui-toolbar mdui-color-theme">
        <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white"
            mdui-drawer="{target: '#main-drawer', swipe: true}"><i class="mdui-icon material-icons">menu</i></span>
        <a href="/index.php" class="mdui-typo-headline mdui-hidden-xs">$sitename</a>
        <a href="." class="mdui-typo-title">$subtitle</a>
        <span onclick="change_style()" style="position: absolute; right: 5px; border-radius: 100%" mdui-tooltip="{content: '日夜配色', position: 'bottom'}" class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white"><i class="mdui-icon material-icons">&#xe3a9;</i></span>
    </div>
    <div id="topload" style="display: none; position: absolute; buttom: 10px;" class="mdui-progress">
        <div class="mdui-progress-indeterminate"></div>
    </div>
</header>
EOF;
}
function mduiMenu() {
    $username = $_SESSION['user'];
    echo <<<EOF
    <div class="mdui-drawer" id="main-drawer">
        <div class="mdui-list" mdui-collapse="{accordion: true}" style="margin-bottom: 76px;">
            <div class="mdui-collapse-item" id="menu">
                <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
                    <i class="mdui-list-item-icon mdui-icon material-icons mdui-text-color-blue">near_me</i>
                    <div class="mdui-list-item-content">菜单</div>
                    <i class="mdui-collapse-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
                </div>
                <div class="mdui-collapse-item-body mdui-list">
                    <a href="/index.php" class="mdui-list-item mdui-ripple">首页</a>
                    <a href="/server_manager.php" class="mdui-list-item mdui-ripple">管理</a>
                    <a href="/ftp.php" class="mdui-list-item mdui-ripple">FTP</a>
                    <a href="/changepwd.php" class="mdui-list-item mdui-ripple">密码</a>
                </div>
            </div>
        </div>
    </div>
EOF;
}
function mduiHead($title) {
    $sitename = SITENAME;
    echo <<<EOF
    <title>$sitename - $title</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="//cdnjs.loli.net/ajax/libs/mdui/0.4.3/css/mdui.min.css" />
    <script src="//cdnjs.loli.net/ajax/libs/mdui/0.4.3/js/mdui.min.js"></script>
    <link rel="icon" href="https://ivampiresp.com/wp-content/uploads/2020/02/cropped-illust_78879291_20200207_181713-32x32.jpg" sizes="32x32" />
    <link rel="icon" href="https://ivampiresp.com/wp-content/uploads/2020/02/cropped-illust_78879291_20200207_181713-192x192.jpg" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://ivampiresp.com/wp-content/uploads/2020/02/cropped-illust_78879291_20200207_181713-180x180.jpg" />
    <link rel="stylesheet" type="text/css" href="/assets/style.css" />
EOF;
}
function mduiBody() {
    echo '<body class="mdui-container mdui-drawer-body-left mdui-appbar-with-toolbar  mdui-theme-primary-indigo mdui-theme-accent-pink"><script type="text/javascript" src="/assets/script.js"></script>
    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>';
}