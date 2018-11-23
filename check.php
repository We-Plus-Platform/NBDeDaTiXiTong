<?php
include "Api1.class.php";
include "password.php";
session_start();
if($_POST["openid"]==$_SESSION["openid"])
{
  $ezhan=new api1($host,$dbname,$user,$pass);
  $ture=$ezhan->check($_POST["id"],$_POST["index"]);//($openid,$id,$answer,$duration)
  $ezhan->update($_POST["openid"],$_POST["id"],$ture,$_POST["duration"]);
  $dan["answer"]=$ture;
  return json_encode($dan);
}
