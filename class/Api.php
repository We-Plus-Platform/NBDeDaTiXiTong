<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2018/11/22
 * Time: 21:43
 */

require_once "DanDb.php";

class Api extends DanDb
{
    /**
     * 判断登录类
     * @return bool
     */
    public static function isLogin()
    {
        if (!session_id()) session_start();
        return isset($_SESSION['openid']);
    }


    /**
     * session 绑定
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
     * 随机抽10道题
     * @return array
     */
    public function questionPicker()
    {
        $query = $this->stmt->prepare("SELECT id,topic,type,content FROM ezhan_cxdt.question ORDER BY RAND() LIMIT 10");
        $query->execute();
        return $query->fetchAll();
    }
}
