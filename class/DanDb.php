<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2018/11/24
 * Time: 19:34
 */

require_once "Password.php";

class DanDb extends Password
{
    protected $stmt;

    /**
     * DanDb constructor.
     */
    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';port:3306;charset=utf8';
        try {
            $this->stmt = new PDO($dsn, $this->username, $this->passwd);
        } catch (PDOException $e) {
            echo json_encode(array("Error" => $e->getMessage()));
        }

    }
}
