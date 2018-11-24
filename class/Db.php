<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2018/11/24
 * Time: 19:34
 */

require "Password.php";


class Db extends Password
{
    protected $stmt;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';port:3306;charset=utf8';
        $this->stmt = new PDO($dsn, $this->username, $this->passwd);
    }
}
