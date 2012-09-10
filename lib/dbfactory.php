<?php
/**
 * Description of dbfactory
 *
 * @author Chris
 */
class dbFactory {
    private $con, $accessLevel, $dbhost = __DB_HOST__, $dbname = __DB_NAME__, $dbuser, $dbpass, $queryObject, $queryString, $queryResult;
    //put your code here
    public function __construct($accessLevel) {
        switch ($accessLevel) {
            case 'read':
                $this->dbuser = __DB_USER_READ__;
                $this->dbpass = __DB_PASSWORD_READ__;
                break;
            case 'write':
                $this->dbuser = __DB_USER_WRITE__;
                $this->dbpass = __DB_PASSWORD_WRITE__;
                break;
            case 'alter':
                $this->dbuser = __DB_USER_ALTER__;
                $this->dbpass = __DB_PASSWORD_ALTER__;
            default:
                $this->dbuser = __DB_USER_READ__;
                $this->dbpass = __DB_PASSWORD_READ__;
                break;
        }
        $this->con = new PDO("mysql:host=".$this->dbhost.";dbname=".$this->dbname,$this->dbuser,  $this->dbpass);
    }
    function setQueryString($queryString){
        $this->queryString = $queryString;
    }
    function query($queryParams = false){
        $this->queryObject = $this->con->prepare($this->queryString);
        if($queryParams){
            foreach ($queryParams as $key => $value) {
                $this->queryObject->bindValue($key, $value);
            }
        }
        $this->queryResult = $this->queryObject->execute();
        print_r($this->queryResult);
    }
}

?>
