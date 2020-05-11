<?php
session_start();
require_once('config/config.php');
require_once('config/theme.php');

?>
<!doctype html>
<html>

<head>
    <?php mduiHead($lang['indexTitle']) ?>
</head>
    <?php mduiBody(); mduiHeader($lang['indexHeader']); mduiMenu(); ?>
    <h1 class="mdui-text-color-theme"><?php echo $lang['indexWelcome']; ?></h1>
    <?php echo $lang['IndexContent']; ?>
</body>

</html>