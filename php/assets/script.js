var $$ = mdui.JQ;
// 夜间代码 来自https://www.mdui.org/questions/196
// 提前定义好事件
var changeStyle = new CustomEvent('change_style', {
    detail: {}
});
//注册监听器
window.addEventListener('change_style', function(event) {
    $$('body').toggleClass('mdui-theme-layout-dark');
});

function change_style() {
    // 在对应的元素上触发该事件
    if (window.dispatchEvent) {
        window.dispatchEvent(changeStyle);
    } else {
        //ie8兼容
        window.fireEvent(changeStyle);
    }
}
// 夜间代码结束
function showloading() {
    document.getElementById("topload").style.display = "block";

}

function disableload() {
    document.getElementById("topload").style.display = "none";
}

// 停止服务器
function kill(serverid) {
    showloading();
    var xmlhttp;
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            mdui.alert(xmlhttp.responseText);
            disableload();
        }
    }
    xmlhttp.open("GET", `/control.php?action=kill&serverid=${serverid}`, true);
    xmlhttp.send();
}

// 更新服务器
function update(serverid) {
    showloading();
    var xmlhttp;
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            mdui.alert(xmlhttp.responseText);
            disableload();
        }
    }
    xmlhttp.open("GET", `/control.php?action=update&serverid=${serverid}`, true);
    xmlhttp.send();
}