<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2018/11/22
 * Time: 21:33
 */

require "Http.php";
class WxGetUserInfo
{
    private $app_id;
    private $app_secret;
    private $code;

    public function __construct($app_id, $app_secret, $code)
    {
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
        $this->code = $code;
    }

    private function getAccessToken()
    {
        $app_id = $this->app_id;
        $app_secret = $this->app_secret;
        $code = $this->code;
        $access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?app_id=$app_id&secret=$app_secret&code=$code&grant_type=authorization_code";
        try {
            $res = json_decode(Http::httpGet($access_token_url), true);
            return $res;
        } catch (Exception $e) {
            var_dump($e);
        }
        return 0;
    }

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

