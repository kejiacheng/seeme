window.onload = function(){
    //创建cookie对象
    var CookieUtil = {
        get: function(name){
            var cookieName = encodeURIComponent(name) + "=",
                cookieStart = document.cookie.indexOf(cookieName),
                cookieValue;
            if(cookieStart > -1){
                var cookieEnd = document.cookie.indexOf(";" , cookieStart);
                if(cookieEnd == -1){
                    cookieEnd = document.cookie.length;
                }
                cookieValue = decodeURIComponent(document.cookie.substring(cookieStart + cookieName.length , cookieEnd));
            }
            return cookieValue;
        },

        set: function(name , value , expires , path , domain , secure){
            var cookieText = encodeURIComponent(name) + "=" + encodeURIComponent(value);


            var date = new Date();
            date.setTime(date.getTime() + expires*1000*3600*24);
            cookieText += "; expires=" + date.toGMTString();

            if(path){
                cookieText += "; path=" + path;
            }
            if(domain){
                cookieText += "; domain=" + domain;
            }
            if(secure){
                cookieText += "; secure";
            }
            document.cookie = cookieText;
        },

        unset: function(name , path , domain , secure){
            this.set(name , "" , new Date(0) , path , domain , secure);
        }
    };
    //判断用户是否登录
    if(!CookieUtil.get("登录方式")){
        alert("请用户登录，否则无法进行操作！");
        window.location.href = "index.html";
    }else{
        var username = document.getElementsByClassName("username")[0],
            exit = document.getElementsByClassName("exit")[0];

        //将得到的用户名写入
        username.innerHTML = CookieUtil.get("name");
        var boss = document.getElementsByClassName("boss");
        if(CookieUtil.get("登录方式") == "bossuser"){

        }else{
            for(var z =0;z<boss.length;z++){
                boss[z].style.display = "none";
            }
        }

        var tabs = document.getElementsByClassName("tabs")[0],
            select = tabs.getElementsByClassName("items"),
            content_right = document.getElementsByClassName("content_right")[0],
            selected = content_right.getElementsByClassName("items");

        //创建XMLHttpRequest对象
        function createXMLHttpRequest(){
            var xhr;
            try{
                xhr = new XMLHttpRequest();
            }
            catch(e){
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
            return xhr;
        }

        var xhr = createXMLHttpRequest();

        xhr.open("post","system.php",true);
        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                var json = xhr.responseText;

                    var obj = eval(json);

                    //循环得到数据库中的数据并渲染到库存总量页面中
                    for(var i=0;i<obj[0].length;i++){
                        var content_row = document.createElement("tr"),
                            content_goodsname = document.createElement("th"),
                            content_number = document.createElement("th"),
                            content_ctns = document.createElement("th"),
                            content_time = document.createElement("th");

                        content_goodsname.innerHTML = obj[0][i]["goodsname"];
                        content_number.innerHTML = obj[0][i]["number"];
                        content_ctns.innerHTML = obj[0][i]["CTNS"];
                        content_time.innerHTML = obj[0][i]["reg_date"];

                        var table = selected[0].children[0];
                        var tbody = table.children[0];
                        tbody.appendChild(content_row);
                        content_row.appendChild(content_goodsname);
                        content_row.appendChild(content_number);
                        content_row.appendChild(content_ctns);
                        content_row.appendChild(content_time);
                    }
                    //for(var j=0;j<obj[1].length;j++){
                    //    var content_row_1 = document.createElement("tr"),
                    //        content_id_1 = document.createElement("th"),
                    //        content_goodsname_1 = document.createElement("th"),
                    //        content_number_1 = document.createElement("th"),
                    //        content_manufacturer_1 = document.createElement("th"),
                    //        content_price_1 = document.createElement("th"),
                    //        content_total_price_1 = document.createElement("th"),
                    //        content_people_1 = document.createElement("th"),
                    //        content_time_1 = document.createElement("th");
                    //
                    //    content_price_1.setAttribute("class","boss");
                    //    content_total_price_1.setAttribute("class","boss");
                    //
                    //    content_id_1.innerHTML = obj[1][j]["id"];
                    //    content_goodsname_1.innerHTML = obj[1][j]["goodsname"];
                    //    content_number_1.innerHTML = obj[1][j]["number"];
                    //    content_manufacturer_1.innerHTML = obj[1][j]["manufacturer"];
                    //    content_price_1.innerHTML = obj[1][j]["price"];
                    //    content_total_price_1.innerHTML = (obj[1][j]["price"] * obj[1][j]["number"]).toFixed(2);
                    //    content_people_1.innerHTML = obj[1][j]["people"];
                    //    content_time_1.innerHTML = obj[1][j]["reg_date"];
                    //
                    //    var table_1 = selected[1].children[0];
                    //    var tbody_1 = table_1.children[0];
                    //
                    //    tbody_1.appendChild(content_row_1);
                    //
                    //    content_row_1.appendChild(content_id_1);
                    //    content_row_1.appendChild(content_goodsname_1);
                    //    content_row_1.appendChild(content_manufacturer_1);
                    //    content_row_1.appendChild(content_number_1);
                    //    content_row_1.appendChild(content_price_1);
                    //    content_row_1.appendChild(content_total_price_1);
                    //    content_row_1.appendChild(content_people_1);
                    //    content_row_1.appendChild(content_time_1);
                    //}

            }
        };
        xhr.send();

        ////获得页面总数
        //function page_num(){
        //    var xhr = createXMLHttpRequest();
        //    var page;
        //
        //    xhr.open("post","content.php",true);
        //    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        //    xhr.onreadystatechange = function(){
        //        if(xhr.readyState == 4 && xhr.status == 200){
        //            var reg = /^(<!DOCT)[\s\S]*(<\/html>)/;
        //
        //            x = xhr.responseText;
        //
        //            all_page = x.replace(reg,"");
        //
        //            console.log(all_page);
        //            for(var i=0;i<all_page;i++){
        //                var page = document.createElement("li");
        //                var next_page = document.getElementsByClassName("next_page")[0];
        //                var buygoods = document.getElementsByClassName("buygoods")[0];
        //
        //                //给当前第一页添加class为now_page
        //                if(i == 0){
        //                    page.setAttribute("class","now_page");
        //                }
        //
        //                page.innerHTML = i+1;
        //
        //                buygoods.insertBefore(page,next_page);
        //            }
        //        }
        //    };
        //    xhr.send();
        //}
        //page_num();

        //当点击注销按钮后，清空cookie
        exit.onclick = function(){
            CookieUtil.unset("name");
            CookieUtil.unset("登录方式");
            CookieUtil.unset("pw");
            window.location.href = "index.html";
        };

        //对对象添加siblings方法
        Object.prototype.siblings = function(){
            var _nodes = [],
                elem = this,
                _elem = this;
            while ((_elem = _elem.previousSibling)){
                if(_elem.nodeType === 1){
                    _nodes.push(_elem);

                }
            }
            while ((elem = elem.nextSibling)){
                if(elem.nodeType === 1){
                    _nodes.push(elem);

                }
            }

            return _nodes;
        };

        //var array = select[2].siblings();
        //for(var i = 0;i<array.length;i++){
        //    array[i].style.color = "black";
        //}
        getIndex(select);

        //选项卡事件
        for(var i = 0;i<select.length;i++){
            select[i].onclick = function(){
                var array = this.siblings();

                this.style.color = "blue";

                for(var j=0;j<array.length;j++){
                    array[j].style.color = "black";
                }
                var index = this.index;
                array = selected[index].siblings();

                selected[index].style.display = "table";
                for(var z=0;z<array.length;z++){
                    array[z].style.display = "none";
                }
            };

        }

        //该变量辨别是哪个ajax事件
        var index;

        // 仓库总量事件
        function goods(){
            var add_goods = document.getElementsByClassName("add_goods")[0],
                delete_goods = document.getElementsByClassName("delete_goods")[0],
                goods_name = document.getElementsByClassName("goods_name")[0],
                goods_number = document.getElementsByClassName("goods_number")[0],
                ctns = document.getElementsByClassName("ctns")[0];

            //添加类目事件
            add_goods.onclick = function(){
                var goods_nameValue = goods_name.value;
                var goods_numberValue = goods_number.value;
                var ctnsValue = ctns.value;
                var index = 0;
                if(confirm("类目：" + goods_nameValue + " 存量：" + goods_numberValue + " 箱数：" + ctnsValue)){
                    var xhr = createXMLHttpRequest();


                    xhr.open("post","function.php",true);
                    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function(){
                        if(xhr.readyState == 4 && xhr.status == 200){
                            if("存在" == xhr.responseText){
                                alert("该类目已存在！");
                            }else{
                                history.go(0);
                            }
                        }
                    };
                    xhr.send("goods_name="+goods_nameValue+"&goods_number="+goods_numberValue+ "&ctns="+ctnsValue+"&index="+index);
                }

            };

            //删除类目事件
            delete_goods.onclick = function(){
                var goods_numValue = goods_name.value;
                var index = 1;
                if(confirm("确定要删除类目：" + goods_numValue)){
                    var xhr = createXMLHttpRequest();


                    xhr.open("post","function.php",true);
                    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function(){
                        if(xhr.readyState == 4 && xhr.status == 200){
                            history.go(0)

                        }
                    };
                    xhr.send("goods_name="+goods_numValue+"&index="+index);
                }
            };
        }
        goods();

        //进货单事件
        function buygoods(){
            var add_goods = document.getElementsByClassName("add_goods")[1],
                delete_goods = document.getElementsByClassName("delete_goods")[1],
                up_goods = document.getElementsByClassName("buy_update")[0],
                goods_name = document.getElementsByClassName("goods_name")[1],
                goods_number = document.getElementsByClassName("goods_number")[1],
                ctns = document.getElementsByClassName("ctns")[1],
                manufacturer = document.getElementsByClassName("manufacturer")[0],
                time = document.getElementsByClassName("time")[0],
                price = document.getElementsByClassName("price")[0],
                total_price = document.getElementsByClassName("total_price")[0],
                people = document.getElementsByClassName("people")[0],
                id = document.getElementsByClassName("id")[0];

            //添加进货单事件
            add_goods.onclick = function(){
                var goods_nameValue = goods_name.value,
                    goods_numberValue = goods_number.value,
                    ctnsValue = ctns.value,
                    manufacturerValue = manufacturer.value,
                    timeValue = time.value,
                    priceValue = price.value,
                    peopleValue = CookieUtil.get("name"),
                    index = 2;

                if(confirm("类目：" + goods_nameValue + " 厂家：" + manufacturerValue + " 数量：" + goods_numberValue +" 箱数：" + ctnsValue + " 价格：" + priceValue + " 操作员：" + peopleValue)){

                    var xhr = createXMLHttpRequest();

                    xhr.open("post","function.php",true);
                    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function(){
                        if(xhr.readyState == 4 && xhr.status == 200){
                            //给输入框添加cookie
                            if(CookieUtil.get("进货类目")){
                                var buy_goods = CookieUtil.get("进货类目");
                                var split = buy_goods.split("&");
                                var isture = true;
                                for(var i=0;i<split.length;i++){
                                    if(goods_nameValue == split[i]){
                                        isture = false;
                                    }
                                }
                                if(isture){
                                    buy_goods = buy_goods + "&"+goods_nameValue;
                                }

                            }else{
                                buy_goods = goods_nameValue
                            }

                            CookieUtil.set("进货类目",buy_goods,365);

                            if(CookieUtil.get("进货工厂")){
                                var buy_manufacturer = CookieUtil.get("进货工厂");
                                var split1 = buy_manufacturer.split("&");
                                var isture1 = true;
                                for(var j=0;j<split1.length;j++){
                                    if(manufacturerValue == split1[j]){
                                        isture1 = false;
                                    }
                                }
                                if(isture1){
                                    buy_manufacturer = buy_manufacturer + "&"+manufacturerValue;
                                }

                            }else{
                                buy_manufacturer = manufacturerValue
                            }

                            CookieUtil.set("进货工厂",buy_manufacturer,365);
                            //alert(CookieUtil.get("进货类目"));
                            history.go(0);

                        }
                    };
                    xhr.send("goods_name="+goods_nameValue+"&goods_number="+goods_numberValue+"&ctns="+ctnsValue+"&manufacturer="+manufacturerValue+"&time="+timeValue+"&price="+priceValue+"&people="+peopleValue+"&index="+index);
                }
            };

            //删除进货单事件
            delete_goods.onclick = function(){
                var idValue = id.value,
                    index = 3;

                if(confirm("确定要删除单号：" + idValue)){

                    var xhr = createXMLHttpRequest();

                    xhr.open("post","function.php",true);
                    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function(){
                        if(xhr.readyState == 4 && xhr.status == 200){

                            history.go(0);

                        }
                    };
                    xhr.send("id="+idValue+"&index="+index);
                }

            };

            //更新进货单事件
            up_goods.onclick = function(){
                var up_id = document.getElementsByClassName("up_id")[0],
                    up_price = document.getElementsByClassName("up_price")[0],
                    up_idValue = up_id.value,
                    up_priceValue = up_price.value;
                    index = 8;

                if(confirm("确定要更新价格：" + up_priceValue)){
                    var xhr = createXMLHttpRequest();

                    xhr.open("post","function.php",true);
                    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function(){
                        if(xhr.readyState == 4 && xhr.status == 200){

                            history.go(0);

                        }
                    };
                    xhr.send("id="+up_idValue+"&price="+up_priceValue+"&index="+index);
                }
            }
        }
        buygoods();

        //出货单事件
        function salegoods(){
            var add_goods = document.getElementsByClassName("add_goods")[2],
                delete_goods = document.getElementsByClassName("delete_goods")[2],
                up_goods = document.getElementsByClassName("buy_update")[1],
                goods_name = document.getElementsByClassName("goods_name")[2],
                goods_number = document.getElementsByClassName("goods_number")[2],
                ctns = document.getElementsByClassName("ctns")[2],
                manufacturer = document.getElementsByClassName("manufacturer")[1],
                time = document.getElementsByClassName("time")[1],
                price = document.getElementsByClassName("price")[1],
                total_price = document.getElementsByClassName("total_price")[1],
                people = document.getElementsByClassName("people")[1],
                id = document.getElementsByClassName("id")[1];

            //添加出货单事件
            add_goods.onclick = function(){
                var goods_nameValue = goods_name.value,
                    goods_numberValue = goods_number.value,
                    ctnsValue = ctns.value,
                    manufacturerValue = manufacturer.value,
                    timeValue = time.value,
                    priceValue = price.value,
                    peopleValue = CookieUtil.get("name"),
                    index = 4;

                if(confirm("类目：" + goods_nameValue + " 厂家：" + manufacturerValue + " 数量：" + goods_numberValue + " 箱数：" + ctnsValue + " 价格：" + priceValue + " 操作员：" + peopleValue)){

                    var xhr = createXMLHttpRequest();

                    xhr.open("post","function.php",true);
                    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function(){
                        if(xhr.readyState == 4 && xhr.status == 200){
                            //给输入框添加cookie
                            if(CookieUtil.get("出货类目")){
                                var sale_goods = CookieUtil.get("出货类目");
                                var split = sale_goods.split("&");
                                var isture = true;
                                for(var i=0;i<split.length;i++){
                                    if(goods_nameValue == split[i]){
                                        isture = false;
                                    }
                                }
                                if(isture){
                                    sale_goods = sale_goods + "&"+goods_nameValue;
                                }

                            }else{
                                sale_goods = goods_nameValue
                            }

                            CookieUtil.set("出货类目",sale_goods,365);

                            if(CookieUtil.get("出货工厂")){
                                var sale_manufacturer = CookieUtil.get("出货工厂");
                                var split1 = sale_manufacturer.split("&");
                                var isture1 = true;
                                for(var j=0;j<split1.length;j++){
                                    if(manufacturerValue == split1[j]){
                                        isture1 = false;
                                    }
                                }
                                if(isture1){
                                    sale_manufacturer = sale_manufacturer + "&"+manufacturerValue;
                                }

                            }else{
                                sale_manufacturer = manufacturerValue
                            }

                            CookieUtil.set("出货工厂",sale_manufacturer,365);

                            history.go(0);

                        }
                    };
                    xhr.send("goods_name="+goods_nameValue+"&goods_number="+goods_numberValue+"&ctns="+ctnsValue+"&manufacturer="+manufacturerValue+"&time="+timeValue+"&price="+priceValue+"&people="+peopleValue+"&index="+index);
                }
            };

            //删除出货单事件
            delete_goods.onclick = function(){
                var idValue = id.value,
                    index = 5;

                if(confirm("确定要删除单号：" + idValue)){

                    var xhr = createXMLHttpRequest();

                    xhr.open("post","function.php",true);
                    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function(){
                        if(xhr.readyState == 4 && xhr.status == 200){

                            history.go(0);

                        }
                    };
                    xhr.send("id="+idValue+"&index="+index);
                }

            }

            //更新进货单事件
            up_goods.onclick = function(){
                var up_id = document.getElementsByClassName("up_id")[1],
                    up_price = document.getElementsByClassName("up_price")[1],
                    up_idValue = up_id.value,
                    up_priceValue = up_price.value;
                index = 9;

                if(confirm("确定要更新价格：" + up_priceValue)){
                    var xhr = createXMLHttpRequest();

                    xhr.open("post","function.php",true);
                    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function(){
                        if(xhr.readyState == 4 && xhr.status == 200){

                            history.go(0);

                        }
                    };
                    xhr.send("id="+up_idValue+"&price="+up_priceValue+"&index="+index);
                }
            }
        }
        salegoods();

        //退货单事件
        function returngoods(){
            var add_goods = document.getElementsByClassName("add_goods")[3],
                delete_goods = document.getElementsByClassName("delete_goods")[3],
                goods_name = document.getElementsByClassName("goods_name")[3],
                goods_number = document.getElementsByClassName("goods_number")[3],
                manufacturer = document.getElementsByClassName("manufacturer")[2],
                time = document.getElementsByClassName("time")[2],
                price = document.getElementsByClassName("price")[2],
                total_price = document.getElementsByClassName("total_price")[2],
                people = document.getElementsByClassName("people")[2],
                id = document.getElementsByClassName("id")[2];

            //添加退货单事件
            add_goods.onclick = function(){
                var goods_nameValue = goods_name.value,
                    goods_numberValue = goods_number.value,
                    manufacturerValue = manufacturer.value,
                    timeValue = time.value,
                    priceValue = price.value,
                    peopleValue = CookieUtil.get("name"),
                    index = 6;

                if(confirm("类目：" + goods_nameValue + " 厂家：" + manufacturerValue + " 数量：" + goods_numberValue + " 价格：" + priceValue + " 操作员：" + peopleValue)){

                    var xhr = createXMLHttpRequest();

                    xhr.open("post","function.php",true);
                    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function(){
                        if(xhr.readyState == 4 && xhr.status == 200){
                            if(CookieUtil.get("退货类目")){
                                var return_goods = CookieUtil.get("退货类目");
                                var split = return_goods.split("&");
                                var isture = true;
                                for(var i=0;i<split.length;i++){
                                    if(goods_nameValue == split[i]){
                                        isture = false;
                                    }
                                }
                                if(isture){
                                    return_goods = return_goods + "&"+goods_nameValue;
                                }

                            }else{
                                return_goods = goods_nameValue
                            }

                            CookieUtil.set("退货类目",return_goods,365);

                            if(CookieUtil.get("退货工厂")){
                                var return_manufacturer = CookieUtil.get("退货工厂");
                                var split1 = return_manufacturer.split("&");
                                var isture1 = true;
                                for(var j=0;j<split1.length;j++){
                                    if(manufacturerValue == split1[j]){
                                        isture1 = false;
                                    }
                                }
                                if(isture1){
                                    return_manufacturer = return_manufacturer + "&"+manufacturerValue;
                                }

                            }else{
                                return_manufacturer = manufacturerValue
                            }

                            CookieUtil.set("退货工厂",return_manufacturer,365);

                            history.go(0);

                        }
                    };
                    xhr.send("goods_name="+goods_nameValue+"&goods_number="+goods_numberValue+"&manufacturer="+manufacturerValue+"&time="+timeValue+"&price="+priceValue+"&people="+peopleValue+"&index="+index);
                }
            };

            //删除退货单事件
            delete_goods.onclick = function(){
                var idValue = id.value,
                    index = 7;

                if(confirm("确定要删除单号：" + idValue)){

                    var xhr = createXMLHttpRequest();

                    xhr.open("post","function.php",true);
                    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function(){
                        if(xhr.readyState == 4 && xhr.status == 200){

                            history.go(0);

                        }
                    };
                    xhr.send("id="+idValue+"&index="+index);
                }

            }
        }
        returngoods();
        //console.log(CookieUtil.get("name"));
        //console.log(CookieUtil.get("登录方式"));
        //console.log(CookieUtil.get("pw"));
    }

    var filter_bt = document.getElementsByClassName("filter_bt")[0];
    var filter1_bt = document.getElementsByClassName("filter_bt")[1];

    //筛选功能
    filter_bt.onclick = function filter(){
        var xhr = createXMLHttpRequest();

        var filter_goodsname = document.getElementsByClassName("filter_goodsname")[0],
            filter_manufacturer = document.getElementsByClassName("filter_manufacturer")[0],
            filter_people = document.getElementsByClassName("filter_people")[0],
            filter_time_start =document.getElementsByClassName("filter_time_start")[0],
            filter_time_end = document.getElementsByClassName("filter_time_end")[0];


        filter_goodsnameValue = filter_goodsname.value;
        filter_manufacturerValue = filter_manufacturer.value;
        filter_peopleValue = filter_people.value;
        filter_time_startValue = filter_time_start.value;
        filter_time_endValue = filter_time_end.value;

        if(filter_goodsnameValue){
            filter_goodsnameValue = filter_goodsnameValue.trim();
        }

        if(filter_manufacturerValue){
            filter_manufacturerValue = filter_manufacturerValue.trim();
        }
        if(filter_peopleValue){
            filter_peopleValue = filter_peopleValue.trim();
        }
        if(filter_time_startValue){
            filter_time_startValue = filter_time_startValue.trim();
        }
        if(filter_time_endValue){
            filter_time_endValue = filter_time_endValue.trim();
        }





        xhr.open("post",window.location.href,true);
        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                console.log(xhr.responseText);
                var reg = /(进货单筛选)[\s\S]*(进货单筛选)/;
                var reg1 = /进货单筛选/g;

                var return_text = xhr.responseText;

                var filter_1 = return_text.match(reg);

                filter_2 = filter_1[0].replace(reg1,"");

                //console.log(filter_2);

                window.location.href = filter_2;

            }
        };
        xhr.send("filter_goodsname="+filter_goodsnameValue+"&filter_manufacturer="+filter_manufacturerValue+"&filter_people="+filter_peopleValue+"&filter_time_start="+filter_time_startValue+"&filter_time_end="+filter_time_endValue);

    };

    filter1_bt.onclick = function filter(){
        var xhr = createXMLHttpRequest();

        var filter1_goodsname = document.getElementsByClassName("filter_goodsname")[1],
            filter1_manufacturer = document.getElementsByClassName("filter_manufacturer")[1],
            filter1_people = document.getElementsByClassName("filter_people")[1],
            filter1_time_start =document.getElementsByClassName("filter_time_start")[1],
            filter1_time_end = document.getElementsByClassName("filter_time_end")[1];


        filter1_goodsnameValue = filter1_goodsname.value;
        filter1_manufacturerValue = filter1_manufacturer.value;
        filter1_peopleValue = filter1_people.value;
        filter1_time_startValue = filter1_time_start.value;
        filter1_time_endValue = filter1_time_end.value;

        if(filter1_goodsnameValue){
            filter1_goodsnameValue = filter1_goodsnameValue.trim();
        }

        if(filter1_manufacturerValue){
            filter1_manufacturerValue = filter1_manufacturerValue.trim();
        }
        if(filter1_peopleValue){
            filter1_peopleValue = filter1_peopleValue.trim();
        }
        if(filter1_time_startValue){
            filter1_time_startValue = filter1_time_startValue.trim();
        }
        if(filter1_time_endValue){
            filter1_time_endValue = filter1_time_endValue.trim();
        }





        xhr.open("post",window.location.href,true);
        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){

                var reg = /(出货单筛选)[\s\S]*(出货单筛选)/;
                var reg1 = /出货单筛选/g;

                var return_text = xhr.responseText;

                var filter_1 = return_text.match(reg);

                filter_2 = filter_1[0].replace(reg1,"");

                window.location.href = filter_2;

            }
        };
        xhr.send("filter1_goodsname="+filter1_goodsnameValue+"&filter1_manufacturer="+filter1_manufacturerValue+"&filter1_people="+filter1_peopleValue+"&filter1_time_start="+filter1_time_startValue+"&filter1_time_end="+filter1_time_endValue);

    };

    //if(CookieUtil.get("进货类目")){
    //    var buy_goods = CookieUtil.get("进货类目");
    //    buy_goods = buy_goods + "&"+goods_nameValue;
    //}else{
    //    buy_goods = goods_nameValue
    //}
    //
    //CookieUtil.set("进货类目",buy_goods,365);
    //alert(CookieUtil.get("进货类目"));
    //
    //CookieUtil.get("");
    //获取以前添加过的类目和厂家
    function get_prev(){

        var buy_goods = CookieUtil.get("进货类目");
        var buy_manufacturer = CookieUtil.get("进货工厂");
        var sale_goods = CookieUtil.get("出货类目");
        var sale_manufacturer = CookieUtil.get("出货工厂");
        var return_goods = CookieUtil.get("退货类目");
        var return_manufacturer = CookieUtil.get("退货工厂");

        var goods_name = document.getElementsByClassName("goods_name");
        var manufacturer = document.getElementsByClassName("manufacturer");
        var select_buy_name = document.getElementsByClassName("select_buy_name");

        get_itemValue(buy_goods,select_buy_name[0],"buy_goods_items",goods_name[1]);
        get_itemValue(buy_manufacturer,select_buy_name[1],"buy_manufacturer_items",manufacturer[0]);
        get_itemValue(sale_goods,select_buy_name[2],"sale_goods_items",goods_name[2]);
        get_itemValue(sale_manufacturer,select_buy_name[3],"sale_manufacturer_items",manufacturer[1]);
        get_itemValue(return_goods,select_buy_name[4],"return_goods_items",goods_name[3]);
        get_itemValue(return_manufacturer,select_buy_name[5],"return_manufacturer_items",manufacturer[2]);

        //
        function get_itemValue(cookie,items_box,items_name,input_name){
            //获取cookie值并写入数组
            if(cookie){
                var cookie_array = cookie.split("&");
            }

            var str_0 = "";

            //将cookie中得到值写入
            for(var i=cookie_array.length-1;i>=0;i--){
                str_0 += "<li class='"+items_name+"'>"+cookie_array[i]+"</li>";
            }
            items_box.innerHTML = str_0;

            //进货类目获取焦点事件
            input_name.onfocus = function(){

                items_box.style.display = "block";

            };
            //进货类目失去焦点事件
            input_name.onblur = function(){

                items_box.style.display = "none";

            };

            var items_name = document.getElementsByClassName(items_name);

            for(var j=0;j<items_name.length;j++){
                items_name[j].onclick = function(){
                    input_name.value = this.innerHTML;
                }
            }
        }

    }

    get_prev();

    //给对象赋值索引
    function getIndex(obj){
        for(var i = 0;i<obj.length;i++){
            obj[i].index = i;
        }
    }
};
