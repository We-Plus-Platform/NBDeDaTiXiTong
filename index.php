<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2018/11/24
 * Time: 11:16
 */

require "class/Api.php";
require "class/WxProcessor.php";

$cxapi = new Api();

if (Api::isLogin()) {
    echo "已登录";
} else {
    $url = WxProcessor::genAuthURL($app_id, "http://www.yf407.cn/cxdt/api/login.php","login");
    header("Location: " . $url);
}
