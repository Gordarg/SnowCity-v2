<?php
include_once BASEPATH . 'core/Authentication.php';

if (isset($_POST['Login']))
{
    $data = Authentication::Login(
        $_POST['Username']
        , $_POST['Password']
    );
    if ($data)
    {
        setcookie('USERID', $data['Id'], time() + (86400 * 30), '/');
        setcookie('USERNAME', $data['Username'], time() + (86400 * 30), '/');
        setcookie('ROLE', $data['Role'], time() + (86400 * 30), '/');        
        setcookie('LOGINTOKEN', $data['Token'], time() + (86400 * 30), '/');        
        header('Location: ' . $BASEURL . 'dashboard');
    }
}

//TODO: Handle Messages Globally
// if (isset($_POST['Login']))
//     echo '<div class="message">' . $Translate->Label("احراز هویت ناموفق") . '</div>';
?>
<div class="container">
    <form class="form-signin text-center" method="post">
        <img class="mb-4" src="/docs/4.2/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal"><?php echo Translate::Label("لطفا وارد شوید") ?></h1>
        <label for="inputUsername" class="sr-only"><?php echo Translate::Label("نام کاربری") ?></label>
            <input name="Username" type="text" id="inputUsername" class="form-control" placeholder="<?php echo Translate::Label("نام کاربری") ?>" required autofocus>
        <label for="inputPassword" class="sr-only"><?php echo Translate::Label("کلمه‌ی عبور") ?></label>
            <input name="Password" type="password" id="inputPassword" class="form-control" placeholder="<?php echo Translate::Label("کلمه‌ی عبور") ?>" required>
        <!-- <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"><?php echo Translate::Label("مرا به خاطر بسپار") ?>
            </label>
        </div> -->
        <button name="Login" class="btn btn-lg btn-primary btn-block" type="submit"><?php echo Translate::Label("ورود به سیستم") ?></button>
        <a href="<?php echo $BASEURL ?>" class="btn btn-lg btn-block" ><?php echo Translate::Label("بازگشت") ?></a>
        <p class="mt-5 mb-3 text-muted">Login with Gordafarid! Soon...</p>
    </form>
</div>