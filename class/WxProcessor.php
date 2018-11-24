<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2018/11/24
 * Time: 18:25
 */

require_once "DanDb.php";

class WxProcessor extends DanDb
{
    /**
     * @param $app_id
     * @param $redirect_uri
     * @param $state
     * @return string
     */
    public static function genAuthURL($app_id, $redirect_uri, $state)
    {
        $redirect_uri = urlencode($redirect_uri);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $app_id . "&redirect_uri=" . $redirect_uri . "&response_type=code&scope=snsapi_userinfo&state=" . $state . "#wechat_redirect";
        return $url;
    }

    /**
     * @param $openid
     * @return mixed
     */
    public function isFirstLogin($openid)
    {
        $query = $this->stmt->prepare("SELECT openid FROM ezhan_cxdt.person_info WHERE openid=?");
        $query->bindParam(1, $openid);
        $query->execute();
        return $query->fetch();
    }

    /**
     * @param $res
     * @return bool
     */
    public function saveUserInfo($res)
    {
        if (!$this->isFirstLogin($res['openid'])){
            $query = $this->stmt->prepare("INSERT INTO ezhan_cxdt.person_info (openid, name, imgUrl) VALUES (?,?,?)");
            $query->bindParam(1, $res['openid']);
            $query->bindParam(2, $res['nickname']);
            $query->bindParam(3, $res['headimgurl']);
            return $query->execute();
        }
        else
            return true;
    }
}
