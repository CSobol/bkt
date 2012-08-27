<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of userClass
 *
 * @author Chris
 */
class userClass {
    public static function checkIfUserIsLoggedIn(){
        return !!$_SESSION['user'];
    }
    //put your code here
}

?>
