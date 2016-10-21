<?php

$conn = new mysqli("localhost","root","");

if($conn->connect_error){
    die("连接失败：" . $conn->connect_error);
}

$conn->set_charset("utf8");

mysqli_select_db($conn,"goods_list");

$index = $_POST["index"];


//$index == 0  存货总量add事件
if($index == 0){
    $goodsname = $_POST["goods_name"];
    $number = $_POST["goods_number"];
    $ctns = $_POST["ctns"];

    $result = mysqli_query($conn , "SELECT * FROM goods WHERE goodsname='$goodsname'");

    //当所输类目存在事件
    if($row = mysqli_fetch_array($result)){
        if($goodsname === $row['goodsname']){
            echo "存在";
        }
    //当所输类目不存在事件
    }else{
        $sql = "INSERT INTO goods(goodsname,number,CTNS)
               VALUES('$goodsname','$number','$ctns')";

        $conn->query($sql);
    }
}else if($index == 1){//存货总量删除事件
    $goodsname = $_POST["goods_name"];

    mysqli_query($conn,"DELETE FROM goods WHERE goodsname='$goodsname'");

}else if($index == 2){//进货单add事件

    $goodsname = $_POST["goods_name"];
    $number = $_POST["goods_number"];
    $ctns = $_POST["ctns"];
    $manufacturer = $_POST["manufacturer"];
    $time = $_POST["time"]?$_POST["time"]:date('Ymd',time());
    $price = $_POST["price"];
    $people = $_POST["people"];

    $reg = preg_replace('/^\d{2}/','',$time);
    $id = preg_replace('/\d{2}$/','',$reg);

    $sql="select * from buygoods order by id desc limit 0,1";

    $last_sql = $conn->query($sql);

    $last_num = '';

    while($row = $last_sql->fetch_assoc()){
        $last_num = $row['id'];
    }


    if(!$last_num){
        $id = $id*100+1;
    }else{
        $first_num = preg_replace('/\d{2}$/','',$last_num);
        $last_num = preg_replace('/^\d{4}/','',$last_num);

        if($first_num == $id){
            $last_num = $last_num+1;
            $id *= 100;
            $id +=$last_num;
        }else{
            $id = $id*100+1;
        }
    }

    $sql = "INSERT INTO buygoods(id,goodsname,manufacturer,number,ctns,tm,price,people)
           VALUES('$id','$goodsname','$manufacturer','$number','$ctns','$time','$price','$people')";

    $conn->query($sql);

    //与存货总量关联
    $result = mysqli_query($conn , "SELECT * FROM goods WHERE goodsname='$goodsname'");

    if($row = mysqli_fetch_array($result)){
        $num = $row['number'];
        $all_ctns = $row['CTNS'];

        $num += $number;
        $all_ctns += $ctns;
        mysqli_query($conn,"UPDATE goods SET number=$num,CTNS=$all_ctns WHERE goodsname='$goodsname'");
    }else{//当进货类目在存货总量不存在时则在存货总量表单新增类目
        $sql = "INSERT INTO goods(goodsname,number,CTNS)
       VALUES('$goodsname','$number','$ctns')";

        $conn->query($sql);
    }
}else if($index == 3 ){

    $id = $_POST["id"];

    $result = mysqli_query($conn,"SELECT * FROM buygoods WHERE id = $id");

    while($row = mysqli_fetch_array($result))
    {
        $goodsname = $row['goodsname'];
        $number = $row['number'];
        $ctns = $row['CTNS'];
    }

    mysqli_query($conn,"DELETE FROM buygoods WHERE id='$id'");

    //与存货总量关联
    $result1 = mysqli_query($conn,"SELECT * FROM goods WHERE goodsname = '$goodsname'");

    while($row = mysqli_fetch_array($result1))
    {
        $number_all = $row['number'];
        $ctns_all = $row['CTNS'];
    }

    $number_all -= $number;
    $ctns_all -= $ctns;

    mysqli_query($conn,"UPDATE goods SET number=$number_all,CTNS=$ctns_all WHERE goodsname='$goodsname'");
}else if($index == 4){
    $goodsname = $_POST["goods_name"];
    $number = $_POST["goods_number"];
    $ctns = $_POST["ctns"];
    $manufacturer = $_POST["manufacturer"];
    $time = $_POST["time"]?$_POST["time"]:date('Ymd',time());
    $price = $_POST["price"];
    $people = $_POST["people"];

    $reg = preg_replace('/^\d{2}/','',$time);
    $id = preg_replace('/\d{2}$/','',$reg);

    $sql="select * from salegoods order by id desc limit 0,1";

    $last_sql = $conn->query($sql);

    $last_num = '';

    while($row = $last_sql->fetch_assoc()){
        $last_num = $row['id'];
    }


    if(!$last_num){
        $id = $id*100+1;
    }else{
        $first_num = preg_replace('/\d{2}$/','',$last_num);
        $last_num = preg_replace('/^\d{4}/','',$last_num);

        if($first_num == $id){
            $last_num = $last_num+1;
            $id *= 100;
            $id +=$last_num;
        }else{
            $id = $id*100+1;
        }
    }

    $sql = "INSERT INTO salegoods(id,goodsname,manufacturer,number,CTNS,tm,price,people)
           VALUES('$id','$goodsname','$manufacturer','$number','$ctns','$time','$price','$people')";

    $conn->query($sql);

    //与存货总量关联
    $result = mysqli_query($conn , "SELECT * FROM goods WHERE goodsname='$goodsname'");

    if($row = mysqli_fetch_array($result)){
        $num = $row['number']?$row['number']:0;
        $all_ctns = $row['CTNS']?$row['CTNS']:0;


        $num -= $number;
        $all_ctns -= $ctns;
        mysqli_query($conn,"UPDATE goods SET number=$num,CTNS=$all_ctns WHERE goodsname='$goodsname'");
    }else{//当进货类目在存货总量不存在时则在存货总量表单新增类目
        $sql = "INSERT INTO goods(goodsname,number,CTNS)
       VALUES('$goodsname','-$number','-$ctns')";

        $conn->query($sql);
    }
}else if($index == 5){
    $id = $_POST["id"];

    $result = mysqli_query($conn,"SELECT * FROM salegoods WHERE id = $id");

    while($row = mysqli_fetch_array($result))
    {
        $goodsname = $row['goodsname'];
        $number = $row['number'];
        $ctns = $row['CTNS'];
    }

    mysqli_query($conn,"DELETE FROM salegoods WHERE id='$id'");

    //与存货总量关联
    $result1 = mysqli_query($conn,"SELECT * FROM goods WHERE goodsname = '$goodsname'");

    while($row = mysqli_fetch_array($result1))
    {
        $number_all = $row['number'];
        $ctns_all = $row['CTNS'];
    }

    $number_all += $number;
    $ctns_all += $ctns;

    mysqli_query($conn,"UPDATE goods SET number=$number_all,CTNS=$ctns_all WHERE goodsname='$goodsname'");
}else if($index==6){
    $goodsname = $_POST["goods_name"];
    $number = $_POST["goods_number"];
    $manufacturer = $_POST["manufacturer"];
    $time = $_POST["time"]?$_POST["time"]:date('Ymd',time());
    $price = $_POST["price"];
    $people = $_POST["people"];

    $reg = preg_replace('/^\d{2}/','',$time);
    $id = preg_replace('/\d{2}$/','',$reg);

    $sql="select * from returngoods order by id desc limit 0,1";

    $last_sql = $conn->query($sql);

    $last_num = '';

    while($row = $last_sql->fetch_assoc()){
        $last_num = $row['id'];
    }


    if(!$last_num){
        $id = $id*100+1;
    }else{
        $first_num = preg_replace('/\d{2}$/','',$last_num);
        $last_num = preg_replace('/^\d{4}/','',$last_num);

        if($first_num == $id){
            $last_num = $last_num+1;
            $id *= 100;
            $id +=$last_num;
        }else{
            $id = $id*100+1;
        }
    }

    $sql = "INSERT INTO returngoods(id,goodsname,manufacturer,number,tm,price,people)
           VALUES('$id','$goodsname','$manufacturer','$number','$time','$price','$people')";

    $conn->query($sql);
//    //与存货总量关联
//    $result = mysqli_query($conn , "SELECT * FROM goods WHERE goodsname='$goodsname'");
//
//    if($row = mysqli_fetch_array($result)){
//        $num = $row['number']?$row['number']:0;
//
//
//        $num -= $number;
//        mysqli_query($conn,"UPDATE goods SET number=$num WHERE goodsname='$goodsname'");
//    }else{//当进货类目在存货总量不存在时则在存货总量表单新增类目
//        $sql = "INSERT INTO goods(goodsname,number)
//       VALUES('$goodsname','-$number')";
//
//        $conn->query($sql);
//    }
}else if($index == 7){
    $id = $_POST["id"];

    $result = mysqli_query($conn,"SELECT * FROM returngoods WHERE id = $id");

    while($row = mysqli_fetch_array($result))
    {
        $goodsname = $row['goodsname'];
        $number = $row['number'];
    }

    mysqli_query($conn,"DELETE FROM returngoods WHERE id='$id'");

//    //与存货总量关联
//    $result1 = mysqli_query($conn,"SELECT * FROM goods WHERE goodsname = '$goodsname'");
//
//    while($row = mysqli_fetch_array($result1))
//    {
//        $number_all = $row['number'];
//    }
//
//    $number_all += $number;
//
//    mysqli_query($conn,"UPDATE goods SET number=$number_all WHERE goodsname='$goodsname'");
}else if($index == 8){
    $id = $_POST["id"];
    $price = $_POST["price"];

    mysqli_query($conn,"UPDATE buygoods SET price=$price WHERE id='$id'");
}else if($index == 9){
    $id = $_POST["id"];
    $price = $_POST["price"];

    mysqli_query($conn,"UPDATE salegoods SET price=$price WHERE id='$id'");
}

$conn->close();

?>