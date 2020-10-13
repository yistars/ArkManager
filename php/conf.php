<?php
require_once('config/config.php');
require_once('config/theme.php');
$User->checkLogin();
if (empty($_REQUEST['serverid'])) {
    return '*';
}

if (!empty($_POST['config_content'])) {
    echo $_REQUEST['serverid'] . $_POST['config_content'];
    $User->configAction($_REQUEST['serverid'], 'push', $_POST['config_content'], $_SESSION['userid']);
}
?>
<!doctype html>
<html>

<head>
    <?php mduiHead($lang['edit']) ?>
</head>
<?php mduiBody();
mduiHeader($lang['edit']);
mduiMenu(); ?>
<h1 class="mdui-text-color-theme"><?php echo $lang['edit']; ?></h1>
<form name="conf" method="post" action="conf.php">
    <input type="hidden" style="display: none;" name="serverid" value="<?php echo $_REQUEST['serverid']; ?>" />
    <textarea name="config_content" rows="150" cols="150" style="border: none"><?php $User->configAction($_REQUEST['serverid'], 'get', null, $_SESSION['userid']); ?></textarea>
    <input type="submit" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" value="<?php echo $lang['edit']; ?>">
</form>
<div style="padding: 5px"></div>
</body>

</html>