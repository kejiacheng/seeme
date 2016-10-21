<?php

//获取ajax传递过来的值
$login_way = $_POST["login_way"];
$username = $_POST["username"];
$pw = $_POST["pw"];

$conn = new mysqli("localhost","root","");

if($conn->connect_error){
    die("连接失败：" . $conn->connect_error);
}

$conn->set_charset("utf8");

mysqli_select_db($conn,"goods_list");

$result = mysqli_query($conn , "SELECT * FROM $login_way WHERE username='$username'");

while($row = mysqli_fetch_array($result)){
    if($pw === $row['pw']){
        echo "匹配";
    }

}

$conn->close();
//$sql = "SELECT username,pw FROM $login_way";
//
//$result = $conn->query($sql);
//
//if ($result->num_rows > 0) {
//    // 输出每行数据
//    while($row = $result->fetch_assoc()) {
//        echo "<br> username: ". $row["username"]. " - pw: ". $row["pw"];
//    }
//} else {
//    echo "0 个结果";
//}
?>