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
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        
        <input placeholder="example@email.com" type="text" name="email"/>
        <input type="submit" name="forgotpwd" value="submit">
        <?php
        // put your code here
        if(isset ($_POST['forgotpwd'])){
            $newConfirmId = userAccountActions::generateConfirmationId();
            $email = strtolower(strip_tags($_POST['email']));
            $changeUserConfirmId = new dbFactory('write');
            $SQL = "UPDATE
                        tblUsers
                    SET
                        confirmId = :confirmationId
                    WHERE
                        LOWER(emailAddress) = :email";
            $changeUserConfirmId->setQueryString($SQL);
            $changeUserConfirmId->query(array(':confirmationId' => $newConfirmId, ':email' => $email));
        }
        ?>
    </body>
</html>
