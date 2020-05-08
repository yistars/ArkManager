$(document).ready(function(){

  $("#txtCommand").bind("enterKey",function(e){
    sendCommand($("#txtCommand").val());
  });

  $("#txtCommand").keyup(function(e){
    if(e.keyCode == 13){
      $(this).trigger("enterKey");
      $(this).val("");
    }
  });

  $("#btnSend").click(function(){
    if($("#txtCommand").val() != ""){
      $("#btnSend").prop("disabled", true);
    }
    sendCommand($("#txtCommand").val());
  });

  $("#btnClearLog").click(function() {
    $("#groupConsole").empty();
    alertInfo("已清除控制台。");
  });
  
  var autocompleteCommands = [
      "achievement give *",
    ].sort();;
  $("#txtCommand").autocomplete({
    source: autocompleteCommands,
    appendTo: "#txtCommandResults",
    open: function() {
      var position = $("#txtCommandResults").position(),
          left = position.left, 
          top = position.top,
          width = $("#txtCommand").width(),
          height = $("#txtCommandResults > ul").height();
      $("#txtCommandResults > ul")
        .css({
          left: left + "px",
          top: top - height - 4 + "px",
          width: 43 + width + "px"
        });
    }
  });
});

function logMsg(msg, sep, cls){
  var date = new Date(), 
      datetime = 
        ("0" + date.getDate()).slice(-2) + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + date.getFullYear() + " @ " +
        ("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2) + ":" + ("0" + date.getSeconds()).slice(-2);
  $("#groupConsole")
    .append("<li class=\"list-group-item list-group-item-" + cls + "\"><span class=\"pull-right label label-" + cls + "\">" + datetime + "</span><strong>" + sep + "</strong> " + msg + "<div class=\"clearfix\"></div></li>");
  $("#btnSend").prop("disabled", false);
  // Clear old logs
  var logItemSize = $("#groupConsole li").size();
  if(logItemSize > 50){
    $("#groupConsole li:first").remove();
  }
  // Scroll down
  if($("#chkAutoScroll").is(":checked")){
    $("#consoleContent .panel-body").scrollTop($("#groupConsole").get(0).scrollHeight);
  }
}
function logSuccess(log){
  logMsg(log, "<", "success");
}
function logInfo(log){
  logMsg(log, "<", "info");
}
function logWarning(log){
  logMsg(log, "<", "warning");
}
function logDanger(log){
  logMsg(log, "<", "danger");
}

function alertMsg(msg, cls){
  $("#alertMessage").fadeOut("slow", function(){
    $("#alertMessage").attr("class", "alert alert-"+cls);
    $("#alertMessage").html(msg);
    $("#alertMessage").fadeIn("slow", function(){});
  });
}
function alertSuccess(msg){
  alertMsg(msg, "success");
}
function alertInfo(msg){
  alertMsg(msg, "info");
}
function alertWarning(msg){
  alertMsg(msg, "warning");
}
function alertDanger(msg){
  alertMsg(msg, "danger");
}

function sendCommand(command){
  if (command == "") {
    alertDanger("命令丢失。");
    return;
  }
  logMsg(command, ">", "success");
  $.post("rcon/index.php", { cmd: command })
    .done(function(json){
      if(json.status){
        if(json.status == 'success' && json.response && json.command){
          if(json.response.indexOf("Unknown command") != -1){
            alertDanger("未知命令 : " + json.command); 
            logDanger(json.response);
          }
          else if(json.response.indexOf("Usage") != -1){
            alertWarning(json.response); 
            logWarning(json.response);
          }
          else{
            alertSuccess("发送成功。");
            logInfo(json.response);
          }
        }
        else if(json.status == 'error' && json.error){
          alertDanger(json.error); 
          logDanger(json.error);
        }
        else{
          alertDanger("Malformed RCON api response"); 
          logDanger("Malformed RCON api response");
        }
      }
      else{
        alertDanger("RCON API错误：没有状态码返回。"); 
        logDanger("RCON API错误：没有状态码返回。");
      }
    })
    .fail(function() {
      alertDanger("RCON错误。");
      logDanger("RCON错误。");
    });
}
