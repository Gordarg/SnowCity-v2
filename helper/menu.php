<?php
/* TODO: Remove me */ $parent = realpath(dirname(__FILE__) . '/..');
require_once ($parent . '/core/authentication.php');
use core\authentication;
$authentication = new authentication();
$UserId = $authentication->login();
if ($UserId == null)
{
    echo '<a href="login.php" onclick="w3_close()">' . $functionalitiesInstance->label("ورود") . '</a>';
    return;
}
?>
<a href="profile.php?id=<?= $functionalitiesInstance->ifexistsidx($_SESSION, 'PHP_AUTH_ID') ?>" onclick="w3_close()"><?= $functionalitiesInstance->label("حساب کاربری"); ?></a>
<a href="./login.php?way=bye" onclick="w3_close()"><?= $functionalitiesInstance->label("خروج"); ?></a>
<a href="post.php" onclick="w3_close()"><?= $functionalitiesInstance->label("پست"); ?></a>
<a href="question.php" onclick="w3_close()"><?= $functionalitiesInstance->label("فرم‌ساز"); ?></a>
<a href="tinyfilemanager.php?p=<?=core\config::Url_PATH?>" onclick="w3_close()"><?= $functionalitiesInstance->label("پرونده‌ها"); ?></a>
<a href="box.php" onclick="w3_close()"><?= $functionalitiesInstance->label("جعبه"); ?></a>
<a href="users.php" onclick="w3_close()"><?= $functionalitiesInstance->label("کاربران"); ?></a>