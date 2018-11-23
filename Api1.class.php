<?php

class api1{
  var $host;
  var $user;
  var $pass;
  var $dbname;
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
    if ($stmt->execute())
    {
      while ($row = $stmt->fetch())
      {
        if($row["type"]=="single")
        {
          if($row["answer"]==$index)
          {
            return ture;
          }
          else
          {
            return false;
          }
        }
        else
        {
          $answer=json_decode($row["answer"],true);
          $index=json_decode($index);
          $i=0;
          while($answer[$i])
          {
            if($answer[$i]!=$index[$i])
            {
              return false;
            }
            $i++;
          }
          return ture;
        }
      }
    }
  }
  function isdo($openid)//查询今日答了几题
  {
    $stmt = $this->dbh->prepare("SELECT count(openid) as total FROM log where openid = ? and time = ?");
    $stmt->bindParam(1, $openid);
    $stmt->bindParam(2, $time);
    $time=date("Ymd");
    $stmt->execute();
    $row = $stmt->fetch();
    return $row["total"];
  }
  function update($openid,$id,$answer,$duration)//更新积分信息
  {
    $isdo=$this->isdo($openid);
    $time=date("Ymd");
    if($isdo>=10)
    {
      return false;
    }
    else
    {
      $dan = $this->dbh->prepare("INSERT INTO log (openid,id,ture,duration,time) VALUES (?, ?,?,?,?)");
      $dan->bindParam(1, $openid);
      $dan->bindParam(2, $id);
      $dan->bindParam(3, $answer);
      $dan->bindParam(4, $duration);
      $dan->bindParam(5, $time);
      $dan->execute();
      if($answer==ture)
      {
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
      return ture;
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

    $dan=$this->dbh->prepare("SELECT count(*) as total FROM (select count(*) from log where openid=? group by time) as table1");
    $dan->bindParam(1, $openid);
    $dan->execute();
    $row = $dan->fetch();
    $day=$row["total"];

    $chance=$this->isdo($openid);
    if($chance>=10)
    {
      $isdo=0;
    }
    else {
      $isdo=1;
    }

    $dan["imgUrl"]=$imgUrl;
    $dan["score"]=$score;
    $dan["college"]=$college;
    $dan["day"]=$day;
    $dan["isdo"]=$isdo;
    return $dan;
  }
}
?>
