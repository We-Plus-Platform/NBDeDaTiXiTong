<?php
include "class/Api1.class.php";
include "password.php";
session_start();
if($_POST["openid"]==$_SESSION["openid"])
{
  $ezhan=new api1($host,$dbname,$user,$pass);
  $dan=$ezhan->cover($_POST["openid"]);
  echo json_encode($dan);
}
else {
  $dan["error"]=false;
  echo json_encode($dan);
}
