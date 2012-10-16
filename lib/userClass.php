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
    var $uName, $uId, $profileText, $memberSince, $trophyCase;
    public static function checkIfUserIsLoggedIn(){
        return !!$_SESSION['user'];
    }
    public function __construct($uName, $uId, $profileText = null, $memberSince = null, $trophyCase = array()){
        $this->uName = $uName;
        $this->uId = $uId;
        $this->profileText = $profileText;
        $this->memberSince = $memberSince;
        $this->trophyCase = $trophyCase;
    }
}

?>
