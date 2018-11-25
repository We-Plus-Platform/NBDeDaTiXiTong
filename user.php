<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2018/11/25
 * Time: 11:09
 */

require_once 'class/Api1.class.php';
require_once 'class/Api.php';
require_once 'password.php';
$ezhan = new api1($host, $dbname, $user, $pass);
if (Api::isLogin() && isset($_GET['action']))
    switch ($_GET['action']) {
        case 'isFirstLogin':
            {
                $dan["status"] = $ezhan->message($_SESSION["openid"]);
                echo json_encode($dan);
                break;
            }
        case 'saveInfo':
            {
                $pop[0] = $_POST["college"];
                $pop[1] = $_POST["email"];
                $pop[2] = $_POST["name"];
                $pop[3] = $_POST["code"];
                $dan["receive"] = $ezhan->receive(...$pop);
                echo json_encode($dan);
                break;
            }
        case 'getUserCover':
            {
                $dan = $ezhan->cover($_SESSION["openid"]);
                echo json_encode($dan);
                break;
            }
        case 'getBoard':
            {
                $dan["state"] = 1;
                $dan["data"] = $ezhan->board($_SESSION["openid"]);
                echo json_encode($dan);
                break;
            }
        default:
            {
                echo json_encode(array("status"=>false));
            }
    }
else
    echo json_encode(array('error' => "Auth Failed"));
