<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2018/11/25
 * Time: 0:18
 */

require_once 'class/Api.php';
require_once 'class/Api1.class.php';
$cx = new Api();

if (Api::isLogin())
    switch ($_GET['action']) {
        case 'getQuestion':
            {
                echo json_encode($cx->questionPicker());
                break;
            }
        case 'checkAnswer':
            {
                $ezhan=new api1($host,$dbname,$user,$pass);
                $true=$ezhan->check($_POST["id"],$_POST["index"]);//($openid,$id,$answer,$duration)
                $ezhan->update($_SESSION["openid"],$_POST["id"],$true,$_POST["duration"]);
                $dan["answer"]=$true;
                echo json_encode($dan);
                break;
            }
        default:
            {
                echo json_encode(array('status' => 404));
            }
    }
else
    echo json_encode(array('error' => "Auth Failed"));
