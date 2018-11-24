<?php
include "class/Api1.class.php";
include "password.php";
session_start();
$ezhan=new api1($host,$dbname,$user,$pass);
$dan["message"]=$ezhan->message($_POST["openid"]);
echo json_encode($dan);
