<?php
require_once 'core/init.php';
require_once 'core/functionalities.php';
require_once $parent . '/semi-orm/Users.php';
require_once $parent . '/semi-orm/Users.php';
use orm\Users;
if(isset($_POST["btn"]))
{
    $conn  = $db->open();
    $User = new Users($conn);
    $User->Insert([
        ["Username", "'" . mysqli_real_escape_string($conn, $_POST['username']) . "'"],
        ["Password", "'" . mysqli_real_escape_string($conn, $_POST['password']) . "'"],
    ]);
    header("Location: " . $npath . '/login.php');
}
include_once ('master/public-header.php');
?>
<form action="register.php" method="post" >
    <h1><?= $Translate->Label("عضویت"); ?></h1>

    <label for="username"><?= $Translate->Label("نام کاربری"); ?></label>
    <input type="text" name="username" required>
    
    <label for="password"><?= $Translate->Label("کلمه‌ی عبور"); ?></label>
    <input type="password" name="password" required>
    
    <button type="submit" name="btn" ><?= $Translate->Label("عضویت"); ?></button>
    <a href="index.php"><?= $Translate->Label("انصراف"); ?></a>
</form>

<?php include_once ('master/public-footer.php'); ?> 