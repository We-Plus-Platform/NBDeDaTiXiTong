<?php
include "class/Api1.class.php";
include "password.php";
session_start();
if($_POST["openid"]==$_SESSION["openid"])
{
  $ezhan=new api1($host,$dbname,$user,$pass);
  $pop[0]=$_POST["college"];
  $pop[1]=$_POST["email"];
  $pop[2]=$_POST["real_name"];
  $pop[3]=$_POST["code"];
  $dan["receive"]=$ezhan->receive(...$pop);
  echo json_encode($dan);
}
else {
  $dan["receive"]=false;
  echo json_encode($dan);
}
