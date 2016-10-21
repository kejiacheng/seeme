
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="style/reset.css">
    <link rel="stylesheet" href="style/system.css">
    <script src="js/system.js"></script>
</head>
<body>
<div id="top">
    <span class="system_name">杭州宇恩科技气柱袋管理系统</span>
    <p class="user_inf"><a class="username"></a><i class="exit">注销</i></p>
</div>
<div id="system_content">
    <div class="content_left">
        <div class="tabs">
            <a class="items select_now">仓库存量</a>
            <a class="items">进货单</a>
            <a class="items">出货单</a>
            <a class="items">退货单</a>
        </div>
    </div>
    <div class="content_right">
        <div class="items show_now">
            <table>
                <tr>
                    <th>类目</th>
                    <th>存货</th>
                    <th>箱数</th>
                    <th>最后更新时间</th>
                </tr>
            </table>
            <div class="add_delete">
                <input type="text" class="goods_name" placeholder="类目"/>
                <input type="text" class="goods_number" placeholder="存货" />
                <input type="text" class="ctns" placeholder="箱数" />
                <span class="add_goods">添加</span>
                <span class="delete_goods">删除</span>
            </div>
        </div>
        <div class="items">
            <table>
                <tr>
                    <th>进货单号</th>
                    <th>类目</th>
                    <th>厂家</th>
                    <th>数量</th>
                    <th>箱数</th>
                    <th class="boss">价格</th>
                    <th class="boss">总价</th>
                    <th>操作员</th>
                    <th>时间</th>
                </tr>
                <?php
                $conn = new mysqli("localhost","root","");

                $conn->set_charset("utf8");

                mysqli_select_db($conn,"goods_list");

                $page_now = @$_GET['page']?$_GET['page']:1;
                $page1_now = @$_GET['page1']?$_GET['page1']:1;
                $page2_now = @$_GET['page2']?$_GET['page2']:1;
                $filter_goodsname = @$_GET['filter_goodsname']?$_GET['filter_goodsname']:'error';
                $filter_manufacturer = @$_GET['filter_manufacturer']?$_GET['filter_manufacturer']:'error';
                $filter_people = @$_GET['filter_people']?$_GET['filter_people']:'error';
                $filter_time_start = @$_GET['filter_time_start']?$_GET['filter_time_start']:'error';
                $filter_time_end = @$_GET['filter_time_end']?$_GET['filter_time_end']:'error';
                $filter1_goodsname = @$_GET['filter1_goodsname']?$_GET['filter1_goodsname']:'error';
                $filter1_manufacturer = @$_GET['filter1_manufacturer']?$_GET['filter1_manufacturer']:'error';
                $filter1_people = @$_GET['filter1_people']?$_GET['filter1_people']:'error';
                $filter1_time_start = @$_GET['filter1_time_start']?$_GET['filter1_time_start']:'error';
                $filter1_time_end = @$_GET['filter1_time_end']?$_GET['filter1_time_end']:'error';

                $startposit = ($page_now-1)*10;

                $content = "";

                $filter = "";

                if($filter_goodsname != 'error'||$filter_manufacturer != 'error'||$filter_people != 'error'||$filter_time_start != 'error'||$filter_time_end != 'error'){
                    $filter .= "WHERE ";
                }

                if($filter_goodsname != 'error'){
                    $filter .= "goodsname='$filter_goodsname'";
                }
                if($filter_manufacturer != 'error'){
                    if($filter == "WHERE "){
                        $filter .= "manufacturer='$filter_manufacturer'";
                    }else{
                        $filter .= " AND manufacturer='$filter_manufacturer'";
                    }

                }
                if($filter_people != 'error'){
                    if($filter == "WHERE "){
                        $filter .= "people='$filter_people'";
                    }else{
                        $filter .= " AND people='$filter_people'";
                    }

                }
                if($filter_time_start != 'error'){
                    if($filter == "WHERE "){
                        $filter .= "tm>=$filter_time_start";
                    }else{
                        $filter .= " AND tm>=$filter_time_start";
                    }

                }
                if($filter_time_end != 'error'){
                    if($filter == "WHERE "){
                        $filter .= "tm<=$filter_time_end";
                    }else{
                        $filter .= " AND tm<=$filter_time_end";
                    }

                }

                $sql = "SELECT id,goodsname,manufacturer,number,CTNS,price,people,tm FROM buygoods $filter order by id DESC limit $startposit,10";

                $result = $conn->query($sql);

                if($result){
                    if ($result->num_rows > 0) {
                    // 输出每行数据

                    while($row = $result->fetch_assoc()) {
                        $id = $row['id'];
                        $goodsname = $row['goodsname'];
                        $manufacturer = $row['manufacturer'];
                        $number = $row['number'];
                        $ctns = $row['CTNS'];
                        $price = $row['price'];
                        $total_price = $number * $price;
                        $people = $row['people'];
                        $reg_date = $row['tm'];

                        $content .= "<tr><th>$id</th><th>$goodsname</th><th>$manufacturer</th><th>$number</th><th>$ctns</th><th class='boss'>$price</th><th class='boss'>$total_price</th><th>$people</th><th>$reg_date</th></tr>";
                    }

                }
                }
                echo $content;
                ?>
            </table>
            <ul class="buygoods">

                <?php

                $conn = new mysqli("localhost","root","");

                $conn->set_charset("utf8");

                mysqli_select_db($conn,"goods_list");

                $sql = "SELECT id,goodsname,manufacturer,number,CTNS,price,people,tm FROM buygoods $filter order by id DESC";;

                $result = $conn->query($sql);

                $row = $result->num_rows;

                $page = ceil($row / 10);

                $page_str = "";

                if($page_now == 1){
                    $page_str .= "<a class='home_page disable' href='javascript:void(0);'>首页</a><a class='prev_page disable'href='javascript:void(0);'>上一页</a>";
                }else{
                    $page_str .= "<a class='home_page' href='".$_SERVER['PHP_SELF']."?page=1&page1=".$page1_now."&page2=$page2_now&filter_goodsname=$filter_goodsname&filter_manufacturer=$filter_manufacturer&filter_people=$filter_people&filter_time_start=$filter_time_start&filter_time_end=$filter_time_end&filter1_goodsname=$filter1_goodsname&filter1_manufacturer=$filter1_manufacturer&filter1_people=$filter1_people&filter1_time_start=$filter1_time_start&filter1_time_end=$filter1_time_end'>首页</a><a class='prev_page'href='".$_SERVER['PHP_SELF']."?page=" .($page_now-1). "&page1=$page1_now&page2=$page2_now&filter_goodsname=$filter_goodsname&filter_manufacturer=$filter_manufacturer&filter_people=$filter_people&filter_time_start=$filter_time_start&filter_time_end=$filter_time_end&filter1_goodsname=$filter1_goodsname&filter1_manufacturer=$filter1_manufacturer&filter1_people=$filter1_people&filter1_time_start=$filter1_time_start&filter1_time_end=$filter1_time_end'>上一页</a>";
                }


                $show_page = 9;

                $page_offset = ($show_page-1) / 2;

                if($page > $show_page){
                    if($page_now > $page_offset+1){
                        $page_str .= " ... ";
                    }
                }

                $start = 1;
                $end = $page;

                if($page_now>$page_offset){
                    $start = $page_now - $page_offset;
                    $end = $page >$page_now + $page_offset?$page_now + $page_offset:$page;
                }else{
                    $start = 1;
                    $end = $page >$show_page?$show_page:$page;
                }

                if($page_now+$page_offset>$page){
                    $start = $start -($page_now+$page_offset-$end);
                    $end = $page;
                }
                if($page<$show_page){
                    $start = 1;
                    $end = $page;
                }

                for($i = $start;$i <= $end;$i++){
                    if($page_now == $i){
                        $page_str .= "<a class='now_page' href='".$_SERVER['PHP_SELF'] ."?page=" .$i ."&page1=$page1_now&page2=$page2_now&filter_goodsname=$filter_goodsname&filter_manufacturer=$filter_manufacturer&filter_people=$filter_people&filter_time_start=$filter_time_start&filter_time_end=$filter_time_end&filter1_goodsname=$filter1_goodsname&filter1_manufacturer=$filter1_manufacturer&filter1_people=$filter1_people&filter1_time_start=$filter1_time_start&filter1_time_end=$filter1_time_end'>$i</a>";
                    }else{
                        $page_str .= "<a href='".$_SERVER['PHP_SELF'] ."?page=" .$i ."&page1=$page1_now&page2=$page2_now&filter_goodsname=$filter_goodsname&filter_manufacturer=$filter_manufacturer&filter_people=$filter_people&filter_time_start=$filter_time_start&filter_time_end=$filter_time_end&filter1_goodsname=$filter1_goodsname&filter1_manufacturer=$filter1_manufacturer&filter1_people=$filter1_people&filter1_time_start=$filter1_time_start&filter1_time_end=$filter1_time_end'>$i</a>";
                    }
                }

                if($page > $show_page){
                    if($page_now + $page_offset < $page){
                        $page_str .= " ... ";
                    }
                }


                if($page_now == ($page==0?1:$page)){
                    $page_str .= "<a class='next_page disable' href='javascript:void(0);'>下一页</a><a class='last_page disable' href='javascript:void(0);'>尾页</a>";
                }else{
                    $page_str .= "<a class='next_page' href='" .$_SERVER['PHP_SELF'] . "?page=" .($page_now+1) . "&page1=$page1_now&page2=$page2_now&filter_goodsname=$filter_goodsname&filter_manufacturer=$filter_manufacturer&filter_people=$filter_people&filter_time_start=$filter_time_start&filter_time_end=$filter_time_end&filter1_goodsname=$filter1_goodsname&filter1_manufacturer=$filter1_manufacturer&filter1_people=$filter1_people&filter1_time_start=$filter1_time_start&filter1_time_end=$filter1_time_end'>下一页</a><a class='last_page' href='" .$_SERVER['PHP_SELF'] ."?page=" .($page==0?1:$page). "&page1=$page1_now&page2=$page2_now&filter_goodsname=$filter_goodsname&filter_manufacturer=$filter_manufacturer&filter_people=$filter_people&filter_time_start=$filter_time_start&filter_time_end=$filter_time_end&filter1_goodsname=$filter1_goodsname&filter1_manufacturer=$filter1_manufacturer&filter1_people=$filter1_people&filter1_time_start=$filter1_time_start&filter1_time_end=$filter1_time_end'>尾页</a>";
                }

//
                echo $page_str;

                ?>


            </ul>
            <div class="add_delete">
                <div class="select">
                    <input type="text" class="goods_name qq" placeholder="类目"/>
                    <div class="select_buy_name">

                    </div>
                </div>
                <div class="select">
                    <input type="text" class="manufacturer" placeholder="厂家"/>
                    <div class="select_buy_name">

                    </div>
                </div>
                <input type="text" class="goods_number" placeholder="数量"/>
                <input type="text" class="ctns" placeholder="箱数"/>
                <input type="text" class="price boss" placeholder="价格"/>
                <input type="text" class="time" placeholder="时间(可以不填)"/>
<!--                <input type="text" class="people" placeholder="操作员"/>-->
                <span class="add_goods">添加</span>
                <br>
                    <input type="text" class="up_id boss" placeholder="单号"/>
                    <input type="text" class="up_price boss" placeholder="价格"/>
                    <span class="buy_update boss">更新</span>
                <br>
                <input type="text" class="id" placeholder="单号"/>
                <span class="delete_goods">删除</span>
            </div>
            <div class="filter">
                <p>筛选</p>
                <?php
                    echo "<a class='cancel' href='".$_SERVER["PHP_SELF"] . "?page=1&page1=$page1_now&page2=$page2_now&filter1_goodsname=$filter1_goodsname&filter1_manufacturer=$filter1_manufacturer&filter1_people=$filter1_people&filter1_time_start=$filter1_time_start&filter1_time_end=$filter1_time_end"."'>取消筛选</a>"
                ?>
<!--                <a class="cancel" href="content.php">初始页</a>-->
                <span>类目</span><input type="text" class="filter_goodsname" placeholder="类目"/><br>
                <span>厂家</span><input type="text" class="filter_manufacturer" placeholder="厂家"/><br>
                <span>操作员</span><input type="text" class="filter_people" placeholder="操作员"/><br>
                <span>时间</span><input type="text" class="filter_time_start" placeholder="起始时间"/>&nbsp<input type="text" class="filter_time_end" placeholder="结束时间"/><br>
                <a class="filter_bt">提交</a>
                <?php

                $filter_goodsname = @$_POST['filter_goodsname']?$_POST['filter_goodsname']:"error";
                $filter_manufacturer = @$_POST['filter_manufacturer']?$_POST['filter_manufacturer']:"error";
                $filter_people = @$_POST['filter_people']?$_POST['filter_people']:"error";
                $filter_time_start = @$_POST['filter_time_start']?$_POST['filter_time_start']:"error";
                $filter_time_end = @$_POST['filter_time_end']?$_POST['filter_time_end']:"error";
//                $filter1_goodsname = @$_GET['filter1_goodsname']?$_GET['filter1_goodsname']:"error";
//                $filter1_manufacturer = @$_GET['filter1_manufacturer']?$_GET['filter1_manufacturer']:"error";
//                $filter1_people = @$_GET['filter1_people']?$_GET['filter1_people']:"error";
//                $filter1_time_start = @$_GET['filter1_time_start']?$_GET['filter1_time_start']:"error";
//                $filter1_time_end = @$_GET['filter1_time_end']?$_GET['filter1_time_end']:"error";

//                $filter1_manufacturer = $_GET['manufacturer'];
//
//                echo $filter1_manufacturer;
//                        echo "<a class='filter_bt'>提交</a>"
//                    echo "<a class='filter_bt' href='".$_SERVER["PHP_SELF"]."?type=$filter_goodsname'>提交</a>";
                echo "<i class='disappear'>进货单筛选" . $_SERVER["PHP_SELF"] . "?filter_goodsname=$filter_goodsname&filter_manufacturer=$filter_manufacturer&filter_people=$filter_people&filter_time_start=$filter_time_start&filter_time_end=$filter_time_end&filter1_goodsname=$filter1_goodsname&filter1_manufacturer=$filter1_manufacturer&filter1_people=$filter1_people&filter1_time_start=$filter1_time_start&filter1_time_end=$filter1_time_end" . "进货单筛选</i>";
                ?>
            </div>
        </div>
        <div class="items">
            <table>
                <tr>
                    <th>出货单号</th>
                    <th>类目</th>
                    <th>厂家</th>
                    <th>数量</th>
                    <th>箱数</th>
                    <th class="boss">价格</th>
                    <th class="boss">总价</th>
                    <th>操作员</th>
                    <th>时间</th>
                </tr>
                <?php

                $conn = new mysqli("localhost","root","");

                $conn->set_charset("utf8");

                mysqli_select_db($conn,"goods_list");
                $filter_goodsname = @$_GET['filter_goodsname']?$_GET['filter_goodsname']:'error';
                $filter_manufacturer = @$_GET['filter_manufacturer']?$_GET['filter_manufacturer']:'error';
                $filter_people = @$_GET['filter_people']?$_GET['filter_people']:'error';
                $filter_time_start = @$_GET['filter_time_start']?$_GET['filter_time_start']:'error';
                $filter_time_end = @$_GET['filter_time_end']?$_GET['filter_time_end']:'error';
                $filter1_goodsname = @$_GET['filter1_goodsname']?$_GET['filter1_goodsname']:'error';
                $filter1_manufacturer = @$_GET['filter1_manufacturer']?$_GET['filter1_manufacturer']:'error';
                $filter1_people = @$_GET['filter1_people']?$_GET['filter1_people']:'error';
                $filter1_time_start = @$_GET['filter1_time_start']?$_GET['filter1_time_start']:'error';
                $filter1_time_end = @$_GET['filter1_time_end']?$_GET['filter1_time_end']:'error';


                $startposit = ($page1_now-1)*10;

                $content = "";

                $filter1 = "";

                if($filter1_goodsname != 'error'||$filter1_manufacturer != 'error'||$filter1_people != 'error'||$filter1_time_start != 'error'||$filter1_time_end != 'error'){
                    $filter1 .= "WHERE ";
                }

                if($filter1_goodsname != 'error'){
                    $filter1 .= "goodsname='$filter1_goodsname'";
                }
                if($filter1_manufacturer != 'error'){
                    if($filter1 == "WHERE "){
                        $filter1 .= "manufacturer='$filter1_manufacturer'";
                    }else{
                        $filter1 .= " AND manufacturer='$filter1_manufacturer'";
                    }

                }
                if($filter1_people != 'error'){
                    if($filter1 == "WHERE "){
                        $filter1 .= "people='$filter1_people'";
                    }else{
                        $filter1 .= " AND people='$filter1_people'";
                    }

                }
                if($filter1_time_start != 'error'){
                    if($filter1 == "WHERE "){
                        $filter1 .= "tm>=$filter1_time_start";
                    }else{
                        $filter1 .= " AND tm>=$filter1_time_start";
                    }

                }
                if($filter1_time_end != 'error'){
                    if($filter1 == "WHERE "){
                        $filter1 .= "tm<=$filter1_time_end";
                    }else{
                        $filter1 .= " AND tm<=$filter1_time_end";
                    }

                }

                $sql = "SELECT id,goodsname,manufacturer,number,CTNS,price,people,tm FROM salegoods $filter1 order by id DESC limit $startposit,10";

                $result = $conn->query($sql);

                if($result){
                    if ($result->num_rows > 0) {
                        // 输出每行数据

                        while($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            $goodsname = $row['goodsname'];
                            $manufacturer = $row['manufacturer'];
                            $number = $row['number'];
                            $ctns = $row['CTNS'];
                            $price = $row['price'];
                            $total_price = $number * $price;
                            $people = $row['people'];
                            $reg_date = $row['tm'];

                            $content .= "<tr><th>$id</th><th>$goodsname</th><th>$manufacturer</th><th>$number</th><th>$ctns</th><th class='boss'>$price</th><th class='boss'>$total_price</th><th>$people</th><th>$reg_date</th></tr>";
                        }

                    }
                }

                echo $content;
                ?>
            </table>
            <ul class="salegoods">

                <?php

                $conn = new mysqli("localhost","root","");

                $conn->set_charset("utf8");

                mysqli_select_db($conn,"goods_list");

                $sql = "SELECT id,goodsname,manufacturer,number,CTNS,price,people,tm FROM salegoods $filter1 order by id DESC";

                $result = $conn->query($sql);

                $row = $result->num_rows;

                $page = ceil($row / 10);

                $page_str = "";

                if($page1_now == 1){
                    $page_str .= "<a class='home_page disable' href='javascript:void(0);'>首页</a><a class='prev_page disable'href='javascript:void(0);'>上一页</a>";
                }else{
                    $page_str .= "<a class='home_page' href='".$_SERVER['PHP_SELF']."?page=$page_now&page1=1&page2=$page2_now&filter_goodsname=$filter_goodsname&filter_manufacturer=$filter_manufacturer&filter_people=$filter_people&filter_time_start=$filter_time_start&filter_time_end=$filter_time_end&filter1_goodsname=$filter1_goodsname&filter1_manufacturer=$filter1_manufacturer&filter1_people=$filter1_people&filter1_time_start=$filter1_time_start&filter1_time_end=$filter1_time_end'>首页</a><a class='prev_page'href='".$_SERVER['PHP_SELF']."?page=$page_now&page1=" .($page1_now-1). "&page2=$page2_now&filter_goodsname=$filter_goodsname&filter_manufacturer=$filter_manufacturer&filter_people=$filter_people&filter_time_start=$filter_time_start&filter_time_end=$filter_time_end&filter1_goodsname=$filter1_goodsname&filter1_manufacturer=$filter1_manufacturer&filter1_people=$filter1_people&filter1_time_start=$filter1_time_start&filter1_time_end=$filter1_time_end'>上一页</a>";
                }


                $show_page = 9;

                $page_offset = ($show_page-1) / 2;

                if($page > $show_page){
                    if($page1_now > $page_offset+1){
                        $page_str .= " ... ";
                    }
                }

                $start = 1;
                $end = $page;

                if($page1_now>$page_offset){
                    $start = $page1_now - $page_offset;
                    $end = $page >$page1_now + $page_offset?$page1_now + $page_offset:$page;
                }else{
                    $start = 1;
                    $end = $page >$show_page?$show_page:$page;
                }

                if($page1_now+$page_offset>$page){
                    $start = $start -($page1_now+$page_offset-$end);
                    $end = $page;
                }
                if($page<$show_page){
                    $start = 1;
                    $end = $page;
                }

                for($i = $start;$i <= $end;$i++){
                    if($page1_now == $i){
                        $page_str .= "<a class='now_page' href='".$_SERVER['PHP_SELF'] ."?page=$page_now&page1=" .$i ."&page2=$page2_now&filter_goodsname=$filter_goodsname&filter_manufacturer=$filter_manufacturer&filter_people=$filter_people&filter_time_start=$filter_time_start&filter_time_end=$filter_time_end&filter1_goodsname=$filter1_goodsname&filter1_manufacturer=$filter1_manufacturer&filter1_people=$filter1_people&filter1_time_start=$filter1_time_start&filter1_time_end=$filter1_time_end'>$i</a>";
                    }else{
                        $page_str .= "<a href='".$_SERVER['PHP_SELF'] ."?page=$page_now&page1=" .$i ."&page2=$page2_now&filter_goodsname=$filter_goodsname&filter_manufacturer=$filter_manufacturer&filter_people=$filter_people&filter_time_start=$filter_time_start&filter_time_end=$filter_time_end&filter1_goodsname=$filter1_goodsname&filter1_manufacturer=$filter1_manufacturer&filter1_people=$filter1_people&filter1_time_start=$filter1_time_start&filter1_time_end=$filter1_time_end'>$i</a>";
                    }


                }

                if($page > $show_page){
                    if($page1_now + $page_offset < $page){
                        $page_str .= " ... ";
                    }
                }

                if($page1_now == ($page == 0?1:$page)){
                    $page_str .= "<a class='next_page disable' href='javascript:void(0);'>下一页</a><a class='last_page disable' href='javascript:void(0);'>尾页</a>";
                }else{
                    $page_str .= "<a class='next_page' href='" .$_SERVER['PHP_SELF'] . "?page=$page_now&page1=" .($page1_now+1) . "&page2=$page2_now&filter_goodsname=$filter_goodsname&filter_manufacturer=$filter_manufacturer&filter_people=$filter_people&filter_time_start=$filter_time_start&filter_time_end=$filter_time_end&filter1_goodsname=$filter1_goodsname&filter1_manufacturer=$filter1_manufacturer&filter1_people=$filter1_people&filter1_time_start=$filter1_time_start&filter1_time_end=$filter1_time_end'>下一页</a><a class='last_page' href='" .$_SERVER['PHP_SELF'] ."?page=$page_now&page1=" .($page==0?1:$page). "&page2=$page2_now&filter_goodsname=$filter_goodsname&filter_manufacturer=$filter_manufacturer&filter_people=$filter_people&filter_time_start=$filter_time_start&filter_time_end=$filter_time_end&filter1_goodsname=$filter1_goodsname&filter1_manufacturer=$filter1_manufacturer&filter1_people=$filter1_people&filter1_time_start=$filter1_time_start&filter1_time_end=$filter1_time_end'>尾页</a>";
                }


                echo $page_str;

                ?>


            </ul>
            <div class="add_delete">
                <div class="select">
                    <input type="text" class="goods_name" placeholder="类目"/>
                    <div class="select_buy_name">

                    </div>
                </div>
                <div class="select">
                    <input type="text" class="manufacturer" placeholder="厂家"/>
                    <div class="select_buy_name">

                    </div>
                </div>

                <input type="text" class="goods_number" placeholder="数量"/>
                <input type="text" class="ctns" placeholder="箱数"/>
                <input type="text" class="price boss" placeholder="价格"/>
                <input type="text" class="time" placeholder="时间(可以不填)"/>
                <!--                <input type="text" class="people" placeholder="操作员"/>-->
                <span class="add_goods">添加</span>
                <br>
                <input type="text" class="up_id boss" placeholder="单号"/>
                <input type="text" class="up_price boss" placeholder="价格"/>
                <span class="buy_update boss">更新</span>
                </br>
                <input type="text" class="id" placeholder="单号"/>
                <span class="delete_goods">删除</span>
            </div>
            <div class="filter">
                <p>筛选</p>
                <?php
                    echo "<a class='cancel' href='".$_SERVER["PHP_SELF"] . "?page=$page_now&page1=1&page2=$page2_now&filter_goodsname=$filter_goodsname&filter_manufacturer=$filter_manufacturer&filter_people=$filter_people&filter_time_start=$filter_time_start&filter_time_end=$filter_time_end"."'>取消筛选</a>"
                ?>
<!--                <a class="cancel" href="content.php">初始页</a>-->
                <span>类目</span><input type="text" class="filter_goodsname" placeholder="类目"/><br>
                <span>厂家</span><input type="text" class="filter_manufacturer" placeholder="厂家"/><br>
                <span>操作员</span><input type="text" class="filter_people" placeholder="操作员"/><br>
                <span>时间</span><input type="text" class="filter_time_start" placeholder="起始时间"/>&nbsp<input type="text" class="filter_time_end" placeholder="结束时间"/><br>
                <a class="filter_bt">提交</a>
                <?php

                $filter_goodsname = @$_GET['filter_goodsname']?$_GET['filter_goodsname']:"error";
                $filter_manufacturer = @$_GET['filter_manufacturer']?$_GET['filter_manufacturer']:"error";
                $filter_people = @$_GET['filter_people']?$_GET['filter_people']:"error";
                $filter_time_start = @$_GET['filter_time_start']?$_GET['filter_time_start']:"error";
                $filter_time_end = @$_GET['filter_time_end']?$_GET['filter_time_end']:"error";
                $filter1_goodsname = @$_POST['filter1_goodsname']?$_POST['filter1_goodsname']:"error";
                $filter1_manufacturer = @$_POST['filter1_manufacturer']?$_POST['filter1_manufacturer']:"error";
                $filter1_people = @$_POST['filter1_people']?$_POST['filter1_people']:"error";
                $filter1_time_start = @$_POST['filter1_time_start']?$_POST['filter1_time_start']:"error";
                $filter1_time_end = @$_POST['filter1_time_end']?$_POST['filter1_time_end']:"error";

                //                        echo "<a class='filter_bt'>提交</a>"
                //                    echo "<a class='filter_bt' href='".$_SERVER["PHP_SELF"]."?type=$filter_goodsname'>提交</a>";
                echo "<i class='disappear'>出货单筛选" . $_SERVER["PHP_SELF"] . "?filter_goodsname=$filter_goodsname&filter_manufacturer=$filter_manufacturer&filter_people=$filter_people&filter_time_start=$filter_time_start&filter_time_end=$filter_time_end&filter1_goodsname=$filter1_goodsname&filter1_manufacturer=$filter1_manufacturer&filter1_people=$filter1_people&filter1_time_start=$filter1_time_start&filter1_time_end=$filter1_time_end" . "出货单筛选</i>";
                ?>
            </div>
        </div>
        <div class="items">
            <table>
                <tr>
                    <th>退货单号</th>
                    <th>类目</th>
                    <th>厂家</th>
                    <th>数量</th>
                    <th class="boss">价格</th>
                    <th class="boss">总价</th>
                    <th>操作员</th>
                    <th>时间</th>
                </tr>
                <?php

                $conn = new mysqli("localhost","root","");

                $conn->set_charset("utf8");

                mysqli_select_db($conn,"goods_list");

                $startposit = ($page2_now-1)*10;

                $content = "";

                $sql = "SELECT id,goodsname,manufacturer,number,price,people,tm FROM returngoods order by id DESC limit $startposit,10";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // 输出每行数据

                    while($row = $result->fetch_assoc()) {
                        $id = $row['id'];
                        $goodsname = $row['goodsname'];
                        $manufacturer = $row['manufacturer'];
                        $number = $row['number'];
                        $price = $row['price'];
                        $total_price = $number * $price;
                        $people = $row['people'];
                        $reg_date = $row['tm'];

                        $content .= "<tr><th>$id</th><th>$goodsname</th><th>$manufacturer</th><th>$number</th><th class='boss'>$price</th><th class='boss'>$total_price</th><th>$people</th><th>$reg_date</th></tr>";
                    }

                }
                echo $content;
                ?>
            </table>
            <ul class="returngoods">

                <?php

                $conn = new mysqli("localhost","root","");

                $conn->set_charset("utf8");

                mysqli_select_db($conn,"goods_list");

                $sql = "SELECT goodsname FROM returngoods";

                $result = $conn->query($sql);

                $row = $result->num_rows;

                $page = ceil($row / 10);

                $page_str = "";

                if($page2_now == 1){
                    $page_str .= "<a class='home_page disable' href='javascript:void(0);'>首页</a><a class='prev_page disable'href='javascript:void(0);'>上一页</a>";
                }else{
                    $page_str .= "<a class='home_page' href='".$_SERVER['PHP_SELF']."?page=$page_now&page1=$page1_now&page2=1'>首页</a><a class='prev_page'href='".$_SERVER['PHP_SELF']."?page=$page_now&page1=$page1_now&page2=".($page2_now-1)."'>上一页</a>";
                }


                $show_page = 9;

                $page_offset = ($show_page-1) / 2;

                if($page > $show_page){
                    if($page2_now > $page_offset+1){
                        $page_str .= " ... ";
                    }
                }

                $start = 1;
                $end = $page;

                if($page2_now>$page_offset){
                    $start = $page2_now - $page_offset;
                    $end = $page >$page2_now + $page_offset?$page2_now + $page_offset:$page;
                }else{
                    $start = 1;
                    $end = $page >$show_page?$show_page:$page;
                }

                if($page2_now+$page_offset>$page){
                    $start = $start -($page2_now+$page_offset-$end);
                    $end = $page;
                }
                if($page<$show_page){
                    $start = 1;
                    $end = $page;
                }

                for($i = $start;$i <= $end;$i++){
                    if($page2_now == $i){
                        $page_str .= "<a class='now_page' href='".$_SERVER['PHP_SELF'] ."?page=$page_now&page1=$page1_now&page2=$i'>$i</a>";
                    }else{
                        $page_str .= "<a href='".$_SERVER['PHP_SELF'] ."?page=$page_now&page1=$page1_now&page2=$i'>$i</a>";
                    }


                }

                if($page > $show_page){
                    if($page2_now + $page_offset < $page){
                        $page_str .= " ... ";
                    }
                }

                if($page2_now == ($page == 0?1:$page)){
                    $page_str .= "<a class='next_page disable' href='javascript:void(0);'>下一页</a><a class='last_page disable' href='javascript:void(0);'>尾页</a>";
                }else{
                    $page_str .= "<a class='next_page' href='" .$_SERVER['PHP_SELF'] . "?page=$page_now&page1=$page1_now&page2=".($page2_now+1)."'>下一页</a><a class='last_page' href='" .$_SERVER['PHP_SELF'] ."?page=$page_now&page1=$page1_now&page2=".($page==0?1:$page)."'>尾页</a>";
                }

                //
                echo $page_str;

                ?>


            </ul>
            <div class="add_delete">
                <div class="select">
                    <input type="text" class="goods_name" placeholder="类目"/>
                    <div class="select_buy_name">

                    </div>
                </div>
                <div class="select">
                    <input type="text" class="manufacturer" placeholder="厂家"/>
                    <div class="select_buy_name">

                    </div>
                </div>
                <input type="text" class="goods_number" placeholder="数量"/>
                <input type="text" class="price boss" placeholder="价格"/>
                <input type="text" class="time" placeholder="时间(可以不填)"/>
                <!--                <input type="text" class="people" placeholder="操作员"/>-->
                <span class="add_goods">添加</span>
                </br>
                <input type="text" class="id" placeholder="单号"/>
                <span class="delete_goods">删除</span>
            </div>
        </div>
    </div>
</div>
<div id="footer">
    <span>盗版必究，只是说说</span>
    <p>杭州宇恩科技有限公司</p>
</div>

</body>
</html>
