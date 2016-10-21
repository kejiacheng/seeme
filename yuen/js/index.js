$(function(){
//用户/商家登录切换
    $(".login_box .box_top ul li").click(function(){
        var $_index = $(this).index();
        var $line = $(".login_box .box_top .line");
        $(this).addClass("login_now").siblings().removeClass("login_now");
        if($_index == 0){
            $line.animate({"left":"15.4%"});
        }else{
            $line.animate({"left":"65.5%"});
        }
    });

    //弹出登录框及遮罩层
    $(".login").click(function(){
        $(".shade").css({"display":"block"});
        $(".login_box").css({"display":"block"});
    });

    //关闭登录框及遮罩层
    $(".login_box .login_content .close_login_box").click(function(){
        $(".shade").css({"display":"none"});
        $(".login_box").css({"display":"none"});
    });


    var username = document.getElementsByClassName("username")[0],
        username_img = document.getElementsByClassName("username_img")[0];
        pw = document.getElementsByClassName("pw")[0];
        pw_img = document.getElementsByClassName("pw_img")[0];

    //账户名获取焦点事件
    username.onfocus = function(){
        username_img.style.background = "url('images/input_icons.png') 0 -110px";
    };

    //账户名失去焦点事件
    username.onblur = function(){
        username_img.style.background = "url('images/input_icons.png') 0 -70px";
    };

    //密码获取焦点事件
    pw.onfocus = function(){
        pw_img.style.background = "url('images/input_icons.png') 0 -190px"
    };

    //密码失去焦点事件
    pw.onblur = function(){
        pw_img.style.background = "url('images/input_icons.png') 0 -150px"
    };

    var login_bt = document.getElementsByClassName("login_bt")[0];

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

    if(CookieUtil.get("登录方式")){
        window.location.href="content.php";
    }
    //登录点击事件
    login_bt.onclick = function(){
        //获取登录方式
        var login_way = $(".login_now").prop("id");

        //获取账号名与密码的值
        var usernameValue = username.value,
            pwValue = pw.value;

        var xhr = createXMLHttpRequest();

        xhr.open("post","giveit.php",true);
        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                var tips = document.getElementsByClassName("tips")[0];
                if("匹配" == xhr.responseText){
                    tips.style.color = "black";
                    tips.innerHTML = xhr.responseText;
                    window.location.href="content.php";
                    var expires = 30;//账号密码保存到cookie3天
                    CookieUtil.set("登录方式",login_way,expires);
                    CookieUtil.set("username",usernameValue,expires);
                    CookieUtil.set("pw",pwValue,expires);
                }else{
                    tips.style.color = "red";
                    tips.innerHTML = "账号密码有误，请重新输入";

                }
            }
        };
        xhr.send("login_way="+login_way+"&username="+usernameValue+"&pw="+pwValue);
    };


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
});
