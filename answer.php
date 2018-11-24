<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2018/11/25
 * Time: 0:18
 */

require_once 'class/Api.php';
$cx = new Api();

if (Api::isLogin())
    switch ($_GET['action']) {
        case 'getQuestion':
            {
                echo json_encode($cx->questionPicker());
                break;
            }
        default:
            {
                echo json_encode(array('status' => 404));
            }
    }
else
    echo json_encode(array('status' => "Auth Failed"));
