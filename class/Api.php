<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2018/11/22
 * Time: 21:43
 */

require "Db.php";
//登录
//抽题

class Api extends Db
{
    /**
     * @return bool
     */
    public static function isLogin()
    {
        session_start();
        return isset($_SESSION['openid']);
    }


    /**
     * @param $openid
     * @return bool
     */
    public static function login($openid)
    {
        session_start();
        $_SESSION['openid'] = $openid;
        return true;
    }

    /**
     * @return array
     */
    public function questionPicker()
    {
        $query = $this->stmt->prepare("SELECT id,topic,type,content FROM ezhan_cxdt.question ORDER BY RAND() LIMIT 10");
        $query->execute();
        return $query->fetchAll();
    }
}


