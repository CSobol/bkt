<?php

/**
 * Description of userAccountActions
 *
 * @author Chris
 */
class userAccountActions {
    var $errorStatus, $salt, $userName, $password, $eMail;
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
    
    public static function logUserIn($userId, $password){
        
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
        
    }
    public function __construct($userName, $password, $confirmPassword , $eMail){
            switch($password){
                case (strlen($password) < 6);
                    $this->errorStatus = 1;
                break;
                case ($password != $confirmPassword);
                    $this->errorStatus = 2;
                break;
                default;
                    $validEmail = $this->validateEmailAddress($eMail);
                    if ($validEmail == true){
                        $userNameStatus = $this->verifyUserName($userName);
                        if($userNameStatus == 0){
                            $this->userName = $userName;
                            $this->salt = sha1(uniqid());
                            $this->confirmId = sha1(date('mdy'));
                            $this->password = sha1($password.$this->salt);
                            $this->eMail = $eMail;
                        }else{
                            $this->errorStatus = $userNameStatus;
                        }
                    }else{
                        $this->errorStatus = 3;
                    };
                break;
            };
       }
    
}

?>
