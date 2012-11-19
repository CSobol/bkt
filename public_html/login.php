<?php
define('__ROOT__',dirname(dirname(__FILE__)));
set_include_path(__ROOT__);
require_once('../lib/includes.php');
if(!empty($_POST['uname'])){
    //login submitted! Let's process that shit!
    $uName = strtolower($_POST['uname']);
    $password = $_POST['password'];                
    userAccountActions::logUserIn($uName, $password);
    if(!empty($_POST['redirectTo'])){
        header('Location:' . $_POST['redirectTo'] . '"');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <?php
        if(!empty($_SESSION['user'])){
            print_r($_SESSION['user']);
        }
        ?>
        <form method="post" action="/login.php?returnTo=<?php echo curPageURL(); ?>">
            <input type="text" placeholder="e.g. email@example.com" name="uname"><input name="password" type="password" placeholder="password"/>
            <input type="submit" value="loginSubmit"/>
        </form>
    </body>
</html>