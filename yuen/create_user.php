<?php
$conn = new mysqli("localhost","root","");

if($conn->connect_error){
    die("连接失败：" . $conn->connect_error);
}

$conn->set_charset("utf8");

mysqli_select_db($conn,"goods_list");

//$sql = "INSERT INTO staffuser(username,pw)
//       VALUES('员工账号3','123456')";
//$sql = "INSERT INTO bossuser(username,pw)
//       VALUES('老板账号','123456')";
//$sql = "INSERT INTO goods(goodsname,number)
//       VALUES('G1','13323456')";

$sql = "INSERT INTO buygoods(goodsname,manufacturer,number,price,people)
       VALUES('G18','是他','88888818','5.24','还有谁')";
if($conn->query($sql) === TRUE){
    echo "<br />新纪录插入成功";
}else{
    echo "<br />Error:" . $sql . $conn->error;
}

$conn->close();
?>