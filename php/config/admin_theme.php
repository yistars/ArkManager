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
    </div>
</header>
EOF;
}
function mduiMenu() {
    $username = $_SESSION['user'];
    echo <<<EOF
    <div class="mdui-drawer" id="main-drawer">
        <div class="mdui-list" mdui-collapse="{accordion: true}" style="margin-bottom: 76px;">
        
            <div class="mdui-collapse-item ">
                <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
                    <i class="mdui-list-item-icon mdui-icon material-icons mdui-text-color-blue">near_me</i>
                    <div class="mdui-list-item-content">菜单</div>
                    <i class="mdui-collapse-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
                </div>
                <div class="mdui-collapse-item-body mdui-list">
                    <a href="index.php" class="mdui-list-item mdui-ripple">控制台</a>
                    <a href="user_manager.php" class="mdui-list-item mdui-ripple">用户管理</a>
                    <a href="server_manager.php" class="mdui-list-item mdui-ripple">服务器管理</a>
                    <a href="node_manager.php" class="mdui-list-item mdui-ripple">节点管理</a>
                    <a href="/index.php" class="mdui-list-item mdui-ripple">返回前台</a>
                </div>
            </div>
        </div>
    </div>
EOF;
}
function mduiHead($subtitle) {
    $sitename = SITENAME;
    echo <<<EOF
    <title>$sitename - $subtitle</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="//cdnjs.loli.net/ajax/libs/mdui/0.4.3/css/mdui.min.css" />
    <script src="//cdnjs.loli.net/ajax/libs/mdui/0.4.3/js/mdui.min.js"></script>
    <link rel="icon" href="https://ivampiresp.com/wp-content/uploads/2020/02/cropped-illust_78879291_20200207_181713-32x32.jpg" sizes="32x32" />
    <link rel="icon" href="https://ivampiresp.com/wp-content/uploads/2020/02/cropped-illust_78879291_20200207_181713-192x192.jpg" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://ivampiresp.com/wp-content/uploads/2020/02/cropped-illust_78879291_20200207_181713-180x180.jpg" />
    <style type="text/css">
    .link {
        color: blue;
        text-decoration:none
    }
    </style>
EOF;
}
function mduiBody() {
    echo '<body class="mdui-container-fluid mdui-drawer-body-left mdui-appbar-with-toolbar  mdui-theme-primary-indigo mdui-theme-accent-pink">';
}