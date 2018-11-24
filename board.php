<?php
include "class/Api1.class.php";
include "password.php";
session_start();
$ezhan=new api1($host,$dbname,$user,$pass);
$dan["state"]=1;
$dan["data"]=$ezhan->board($_SESSION["openid"]);
echo json_encode($dan);
