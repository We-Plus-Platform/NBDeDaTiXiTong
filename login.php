<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2018/11/24
 * Time: 18:41
 */

require_once "class/WxGetUserInfo.php";
require_once "class/WxProcessor.php";
require_once "class/Api.php";
require_once "wx_config.php";

$code = $_GET['code'];
$state = $_GET["state"];

$user_opt = new WxProcessor();
$info_getter = new WxGetUserInfo($app_id, $app_secret, $code);

$res = $info_getter->getUserInfo();

if ($user_opt->saveUserInfo($res)) {
    Api::login($res['openid']);
    header('Location: index.php');
}
