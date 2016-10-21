<?php

$conn = new mysqli("localhost","root","");

if($conn->connect_error){
    die("连接失败：" . $conn->connect_error);
}

$conn->set_charset("utf8");


$date = array();
$date1 = array();
$json = "";

$page_now = @$_GET['page']?$_GET['page']:1;

$start = ($page_now-1)*10;

mysqli_select_db($conn,"goods_list");

//仓库库存
$sql = "SELECT goodsname,number,CTNS,reg_date FROM goods";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 输出每行数据
    while($row = $result->fetch_assoc()) {
        $date[] = $row;
    }
    $date1[] = $date;
    unset($date);
}

////进货单
//$sql = "SELECT id,goodsname,manufacturer,number,price,people,reg_date FROM buygoods order by id DESC limit $start,10";
//$result = $conn->query($sql);
//
//if ($result->num_rows > 0) {
//    // 输出每行数据
//
//    while($row = $result->fetch_assoc()) {
//        $date[] = $row;
//    }
//    $date1[] = $date;
//    unset($date);
//}


$json = json_encode($date1);
echo $json;


$conn->close();

?>