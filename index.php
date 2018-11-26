<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2018/11/24
 * Time: 11:16
 */

require_once "class/Api.php";
require_once "class/WxProcessor.php";
require_once "wx_config.php";

$cxapi = new Api();

if (Api::isLogin()) {
    header("Location: ../index.html");
} else {
    $url = WxProcessor::genAuthURL($app_id, "http://www.danthology.cn/cxdt/api/login.php", "login");
    header("Location: " . $url);
}
