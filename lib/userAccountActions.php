<?php

/**
 * Description of userAccountActions
 *
 * @author Chris
 */
class userAccountActions {
    var $errorStatus, $salt, $userName, $password, $eMail, $tempUserObj;
    private static $hashAlgo = '$2a';
    private static $hashCost = '$10';
    public static function validateUserName($userId) {
        $dataConnection = new dbFactory('write');
        $validName = preg_match('/^[a-zA-Z0-9]{3,50}$/', $userName);
        if($validName){
            include('dbconnect.php');
            $SQL = "SELECT
                        COUNT(*)
                        as count
                    FROM
                        tblUsers
                    WHERE
                        username=:username";
            $q = $conn->prepare($SQL);
            $q->execute(array(':username' => $userName));
            while($r = $q->fetch()){
                if($r['count'] > 0){
                    return 5;
                }else{
                  return 0;
                };
            }
        }else{
            return 4;
        }
    }
    //END checkIfUserExists
    public static function startSession($regenerate = false){
        session_name("Bukt");
        session_start();
        if($regenerate){
            session_regenerate_id();
        }
    }
    public static function authenticatePassword($password, $passHash, $salt){
        return $passHash == self::hashPassword($password, $salt);
    }
    public static function logUserIn($userId, $password){
        //grab user from database
        $loginDataBase = new dbFactory('read');
        $SQL = 'SELECT
                    userName,
                    userId,
                    passHash,
                    passSalt,
                    userProfileBlurb,
                    userRegistered
                FROM
                    tblUsers
                WHERE
                    LOWER(userName)= :userName
                OR
                    LOWER(emailAddress) = :uName';
        $loginDataBase->setQueryString($SQL);
        $userObject = $loginDataBase->query(array(':userName' => $userId, ':uName' => $userId));
        if ($userObject){
            //see if hashes match
            $loginSuccess = self::authenticatePassword($password, $userObject['passHash'], $userObject['passSalt']);
            if($loginSuccess){
                self::startSession(true);
                $userArray = array("userId" => $userObject['userId'], "userName" => $userObject['userName'], "userPermission" => $userObject['userPermission']);
                $_SESSION['user'] = $userArray;
                return true;
            }else{
                return false;
            }
        }else{
            //No username found
            return false;
        }
        
        
    }
    //END logUserIn
    
    public static function logUserOut($userId){
        
    }
    //END logUserOut
    
    public static function getUserBucketList($userId){
        
    }
    //END getUserBucketList
    function validateEmailAddress($email){
        $isValid = true;
        $atIndex = strrpos($email, "@");
        if (is_bool($atIndex) && !$atIndex)
        {
          $isValid = false;
        }
        else
        {
          $domain = substr($email, $atIndex+1);
          $local = substr($email, 0, $atIndex);
          $localLen = strlen($local);
          $domainLen = strlen($domain);
          //Begin Validation Checks
          if ($localLen < 1 || $localLen > 64)
          {
             // local part length exceeded
             $isValid = false;
          }
          else if ($domainLen < 1 || $domainLen > 255)
          {
             // domain part length exceeded
             $isValid = false;
          }
          else if ($local[0] == '.' || $local[$localLen-1] == '.')
          {
             // local part starts or ends with '.'
             $isValid = false;
          }
          else if (preg_match('/\\.\\./', $local))
          {
             // local part has two consecutive dots
             $isValid = false;
          }
          else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
          {
             // character not valid in domain part
             $isValid = false;
          }
          else if (preg_match('/\\.\\./', $domain))
          {
             // domain part has two consecutive dots
             $isValid = false;
          }
          else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))){
             // character not valid in local part unless 
             // local part is quoted
             if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))){
                $isValid = false;
             }
          }
          if ($isValid && !(checkdnsrr($domain,"MX") || 
        ↪checkdnsrr($domain,"A")))
          {
             // domain not found in DNS
             $isValid = false;
          }
          //END validation checks
        }
            return $isValid;
        }
        //END validateEmailAddress
    function verifyUserName($userName){
        //ensure userName is alphanumeric only
        if (preg_match('/^[a-z0-9]{4,64}$/i', $userName)) {
            return true;
        } else {
            return false;
        }
    }
    public function hashPassword($password, $salt){
        return crypt($password,  
                    self::$hashAlgo .  
                    self::$hashCost .  
                    '$' . $salt);  
    }
    public static function generateSalt(){
        return substr(sha1(mt_rand()),0,22);
    }
    public function __construct($userName, $password, $confirmPassword , $eMail){
            switch($password){
                case (strlen($password) < 6);
                    //password not long enough
                    $this->errorStatus = 1;
                break;
                case ($password != $confirmPassword);
                    //password and confirmation don't match
                    $this->errorStatus = 2;
                break;
                default;
                    $validEmail = $this->validateEmailAddress($eMail);
                    if ($validEmail == true){
                        $userNameStatus = $this->verifyUserName($userName);
                        if($userNameStatus){
                            $this->userName = $userName;
                            $this->salt = $this->generateSalt();
                            $this->confirmId = sha1(date('mdy'));
                            $this->password = $this->hashPassword($password, $this->salt);
                            $this->eMail = $eMail;
                        }else{
                            //username isn't alphanumeric
                            $this->errorStatus = 3;
                        }
                    }else{
                        //email address invalid
                        $this->errorStatus = 4;
                    };
                break;
            };
       }
    
}

?>
