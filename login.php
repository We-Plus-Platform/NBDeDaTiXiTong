<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2018/11/24
 * Time: 18:41
 */

require "class/WxGetUserInfo.php";
require "class/WxProcessor.php";
require "class/Api.php";

global $app_id;
global $app_secret;

$code = $_GET['code'];
$state = $_GET["state"];

$user_opt = new WxProcessor();
$info_getter = new WxGetUserInfo($app_id, $app_secret, $code);

$res = $info_getter->getUserInfo();

if ($user_opt->saveUserInfo($res)) {
    Api::login($res['openid']);
    header('Location: index.php');
}
