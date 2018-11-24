<?php
include "class/Api1.class.php";
include "password.php";
session_start();
if(isset($_SESSION["openid"]))
{
  $ezhan=new api1($host,$dbname,$user,$pass);
  $true=$ezhan->check($_POST["id"],$_POST["index"]);//($openid,$id,$answer,$duration)
  $ezhan->update($_SESSION["openid"],$_POST["id"],$true,$_POST["duration"]);
  $dan["answer"]=$true;
  echo json_encode($dan);
}
else {
  $dan["answer"]=false;
  echo json_encode($dan);
}
