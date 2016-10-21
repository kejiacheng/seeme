<?php

$conn = new mysqli("localhost","root","");

if($conn->connect_error){
    die("连接失败：" . $conn->connect_error);
}

$conn->set_charset("utf8");

if($conn->query("CREATE DATABASE goods_list CHARSET utf8") === TRUE){
    echo "<br />数据库创建成功";
}else{
    echo "<br />Error creating datebase:" . $conn->error;
}

mysqli_select_db($conn,"goods_list");

if($conn->query("CREATE TABLE bossuser(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    pw VARCHAR(30) NOT NULL,
    reg_date TIMESTAMP
)") === TRUE){
    echo "<br />Table bossuser created successfully";
}else{
    echo "<br />创建数据表错误：" . $conn -> error;
}

if($conn->query("CREATE TABLE staffuser(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    pw VARCHAR(30) NOT NULL,
    reg_date TIMESTAMP
)") === TRUE){
    echo "<br />Table staffuser created successfully";
}else{
    echo "<br />创建数据表错误：" . $conn -> error;
}

if($conn->query("CREATE TABLE goods(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    goodsname VARCHAR(30) NOT NULL,
    number FLOAT(10,2) NOT NULL,
    CTNS DECIMAL NOT NULL,
    reg_date TIMESTAMP
)") === TRUE){
    echo "<br />Table goods created successfully";
}else{
    echo "<br />创建数据表错误：" . $conn -> error;
}

if($conn->query("CREATE TABLE buygoods(
    id INT(8) PRIMARY KEY,
    goodsname VARCHAR(30) NOT NULL,
    manufacturer VARCHAR(30) NOT NULL,
    number FLOAT(10,2) NOT NULL,
    CTNS DECIMAL NOT NULL,
    tm DECIMAL NOT NULL,
    price FLOAT(10,2) NOT NULL,
    people VARCHAR(30) NOT NULL,
    reg_date TIMESTAMP
)") === TRUE){
    echo "<br />Table buygoods created successfully";
}else{
    echo "<br />创建数据表错误：" . $conn -> error;
}

if($conn->query("CREATE TABLE salegoods(
    id INT(8) PRIMARY KEY,
    goodsname VARCHAR(30) NOT NULL,
    manufacturer VARCHAR(30) NOT NULL,
    number FLOAT(10,2) NOT NULL,
    CTNS DECIMAL NOT NULL,
    tm DECIMAL NOT NULL,
    price FLOAT(10,2) NOT NULL,
    people VARCHAR(30) NOT NULL,
    reg_date TIMESTAMP
)") === TRUE){
    echo "<br />Table salegoods created successfully";
}else{
    echo "<br />创建数据表错误：" . $conn -> error;
}
if($conn->query("CREATE TABLE returngoods(
    id INT(8) PRIMARY KEY,
    goodsname VARCHAR(30) NOT NULL,
    manufacturer VARCHAR(30) NOT NULL,
    number FLOAT(10,2) NOT NULL,
    CTNS DECIMAL NOT NULL,
    tm DECIMAL NOT NULL,
    price FLOAT(10,2) NOT NULL,
    people VARCHAR(30) NOT NULL,
    reg_date TIMESTAMP
)") === TRUE){
    echo "<br />Table returngoods created successfully";
}else{
    echo "<br />创建数据表错误：" . $conn -> error;
}
$conn->close();

?>