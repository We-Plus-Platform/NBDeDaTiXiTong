<?php

class api1{
  var $host;
  var $user;
  var $pass;
  var $dbname;
  var $dbh;
  function __construct( $par1, $par2, $par3,$par4)//数据库连接 构造函数
  {
      $this->host = $par1;
      $this->dbname = $par2;
      $this->user = $par3;
      $this->pass = $par4;
      $dsn="mysql:host=$this->host;dbname=$this->dbname";
      try {
          $this->dbh = new PDO($dsn, $this->user, $this->pass);
      } catch (PDOException $e) {
          print "Error!: " . $e->getMessage() . "<br/>";
          die();
      }
  }
  function check($id,$index)//校验正确
  {
    $stmt = $this->dbh->prepare("SELECT answer,type FROM question where id = ?");
    $stmt->bindParam(1, $id);
    if ($stmt->execute())//判断是否有这道题
    {
      while ($row = $stmt->fetch())
      {
        if($row["type"]=="single")//判断 题类型
        {
            return $row["answer"]==$index[0];
        }
        else//多选
        {
          $answer=json_decode($row["answer"],true);
          //$index=json_decode($index);
          $i=0;
          if(count($answer)==count($index))
          {
            while($index[$i])//多选校验
            {
              if($answer[$i]!=$index[$i]||isset($index[$i])==false||isset($answer[$i])==false)
              {
                return false;
              }
              $i++;
            }
            return true;
          }
          else
          {
            return false;
          }
        }
      }
    }
    else {
      return false;
    }
    return true;
  }
  function isdo($openid)//查询今日答了几题
  {
    $stmt = $this->dbh->prepare("SELECT count(openid) as total FROM log where openid = ? and time = ?");
    $time=date("Ymd");
    $stmt->bindParam(1, $openid);
    $stmt->bindParam(2, $time);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row["total"];
  }
  function update($openid,$id,$answer,$duration)//更新积分信息
  {
    $isdo=$this->isdo($openid);
    $time=date("Ymd");
    if($isdo>=10)//判断是否答满10道
    {
      return false;
    }
    else
    {
      //记录答题信息
      $dan = $this->dbh->prepare("INSERT INTO log (openid,question_id,is_correct,duration,time) VALUES (?, ?,?,?,?)");
      $dan->bindParam(1, $openid);
      $dan->bindParam(2, $id);
      $dan->bindParam(3, $answer);
      $dan->bindParam(4, $duration);
      $dan->bindParam(5, $time);
      $dan->execute();
      if($answer==true)
      {//加分
        $dan2=$this->dbh->prepare("SELECT num FROM person_info where openid = ?");
        $dan2->bindParam(1, $openid);
        $dan2->execute();
        $row2 = $dan2->fetch();
        $score=$row2["num"]+10;

        $dan3=$this->dbh->prepare("UPDATE person_info SET num=? where openid=?");
        $dan3->bindParam(1, $score);
        $dan3->bindParam(2, $openid);
        $dan3->execute();
      }
      return true;
    }
  }
  function cover($openid)//获取个人信息
  {
    $stmt = $this->dbh->prepare("SELECT imgUrl,num,college FROM person_info where openid = ?");
    $stmt->bindParam(1, $openid);
    $stmt->execute();
    $row = $stmt->fetch();
    $imgUrl=$row["imgUrl"];
    $score=$row["num"];
    $college=$row["college"];
    //查询此人有几天参与答题
    $dan=$this->dbh->prepare("SELECT count(*) as total FROM (select count(*) from log where openid=? group by time) as table1");
    $dan->bindParam(1, $openid);
    $dan->execute();
    $row = $dan->fetch();
    $day=$row["total"];

    $chance=$this->isdo($openid);//今日是否答题
    if($chance>=10)
    {
      $isdo=0;
    }
    else {
      $isdo=1;
    }

    $data["imgUrl"]=$imgUrl;
    $data["score"]=$score;
    $data["college"]=$college;
    $data["day"]=$day;
    $data["isdo"]=$isdo;
    return $data;
  }
  function receive($college,$email,$real_name,$code)//写入个人信息
  {
    $dan = $this->dbh->prepare("UPDATE person_info SET college=?,email=?,real_name=?,code=? WHERE openid='$_SESSION[openid]'");
    $dan->bindParam(1, $college);
    $dan->bindParam(2, $email);
    $dan->bindParam(3, $real_name);
    $dan->bindParam(4, $code);
    $exe=$dan->execute();
    return $exe;
  }
  function message($openid)//验证信息是否填完
  {
    $stmt = $this->dbh->prepare("SELECT code FROM person_info where openid = ?");
    $stmt->bindParam(1, $openid);
    $stmt->execute();
    $row = $stmt->fetch();
    if($row["code"])
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  function board($openid)//排行榜
  {
    $stmt = $this->dbh->prepare("SELECT name,imgUrl,num,college,openid FROM person_info order by num DESC");
    $stmt->execute();
    $i=0;
    while($row = $stmt->fetch())
    {
        $dan[$i]["name"]=$row["name"];
        $dan[$i]["imgUrl"]=$row["imgUrl"];
        $dan[$i]["score"]=$row["num"];
        $dan[$i]["college"]=$row["college"];
        if($openid==$row["openid"])
        {
          $dan[$i]["isUser"]=1;
        }
        else
        {
          $dan[$i]["isUser"]=0;
        }
        $i++;
    }
    if(isset($dan))
        return $dan;
    else
      return [];
  }
}
