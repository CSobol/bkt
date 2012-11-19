<?php
define('__ROOT__',dirname(dirname(__FILE__)));
set_include_path(__ROOT__);
require_once('../lib/includes.php');
if(isset ($_GET['uConfirm'])){
    $confirmString = $_GET['uConfirm'];
    $userName = $_GET['uName'];
    $confirmArray = array(':confirmId' => $confirmString, ':uName' => $userName);
    $confirmUser = new dbFactory('write');
    $confirmUser->setQueryString(__CONFIRM_USER_QUERY__);
    $confirmUser->query($confirmArray);
    //User is confirmed. Present them with a log in screen
}else{
    //uh, what are you doing here?
    header('Location:' . $_POST['redirectTo'] . '"');
}
?>
