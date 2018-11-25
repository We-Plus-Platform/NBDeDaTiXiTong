<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2018/11/22
 * Time: 21:33
 */

require_once "Http.php";

class WxGetUserInfo
{
    private $app_id;
    private $app_secret;
    private $code;

    /**
     * WxGetUserInfo constructor.
     * Documentation:https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140842
     * @param $app_id
     * @param $app_secret
     * @param $code
     */
    public function __construct($app_id, $app_secret, $code)
    {
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
        $this->code = $code;
    }

    /**
     * @return int|mixed
     */
    private function getAccessToken()
    {
        $app_id = $this->app_id;
        $app_secret = $this->app_secret;
        $code = $this->code;
        $access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$app_id&secret=$app_secret&code=$code&grant_type=authorization_code";
        try {
            $res = json_decode(Http::httpGet($access_token_url), true);
            return $res;
        } catch (Exception $e) {
            var_dump($e);
        }
        return 0;
    }

    /**
     * @return int|mixed
     */
    public function getUserInfo()
    {
        $res = $this->getAccessToken();
        $access_token = $res['access_token'];
        $openid = $res['openid'];
        $user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
        try {

            $res = json_decode(Http::httpGet($user_info_url), true);
            //  var_dump($res);
            return $res;
        } catch (Exception $e) {
            var_dump($e);
        }
        return 0;
    }
}

