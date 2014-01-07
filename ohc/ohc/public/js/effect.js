/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

        var WebsitePublic;
        function setpublic(websitepublic){
             WebsitePublic = websitepublic;
        }
$(document).ready(function(){
    //控制下拉图片
        $(".search_type li").hover(function(){
        $(this).css({"background": "#0E71F9"})
        $(this).css({"color":"#fff"})
        })
        $(".search_type li").mouseout(function(){
            $(this).css({"background": "#fff"})
            $(this).css({"color":"#000"}) 
        }) 
        
       //搜索
//        $("#img_search").hover(function(){
//            $("#img_search").attr("src",WebsitePublic+"/image/Home/Index/search_fly_03.png");
//        })
        $("#img_search").mouseout(function(){
            $("#img_search").attr("src",WebsitePublic+"/image/Home/Index/search_03.png");
        })
        $("#img_search").mousedown(function(){
            $("#img_search").attr("src",WebsitePublic+"/image/Home/Index/search_on_03_1.png");
        })
        //控制下划线
        $("#signup,#signin,#font_advanced,#signout,#font_MyAccount,#font_WriteAReview,#font_cancel,#font_reset").mouseover(function(){
            $(this).css({"text-decoration": "underline"})
            })
        $("#signup,#signin,#font_advanced,#signout,#font_MyAccount,#font_WriteAReview,#font_cancel,#font_reset").mouseout(function(){
            $(this).css({"text-decoration": "none"})
        })
        
        
        //控制图片事件
        $("#img_home").mouseout(function(){
        $("#img_home").attr("src",WebsitePublic+"/image/Home/Index/home.png");
        })
        $("#img_home").mousedown(function(){
        $("#img_home").attr("src",WebsitePublic+"/image/Home/Index/home_on.png");
        })
        
        //导航栏渐变
        $(".homespan").mouseover(function(){
            $(this).css('background-color','#1c74cf');
        })
        $(".homespan").mouseout(function(){
            $(this).css('background-color','#0658C8');
            $(this).removeClass('headerHover');
        })
        $(".homespan").mousedown(function(){
            $(this).addClass('headerHover');
        })
    
        //搜索框
        $("#search_text_location,#search_text").focus(function(){
        //    $("#search_text_location").css({"padding-left":"10px"})
            $(this).addClass('searchTextBox');
        })
         $("#search_text_location,#search_text").blur(function(){
            $(this).removeClass('searchTextBox');
        })

        //search按钮
        $('#advanced_button').mouseover(function(){
            $('#advanced_button').css({"background":"url("+WebsitePublic+"/image/Home/Index/search-button_fly_03.png)"})
        })
        $('#advanced_button').mouseout(function(){
            $('#advanced_button').css({"background":"url("+WebsitePublic+"/image/Home/Index/search-button_advance.png)"})
        })
        $('#advanced_button').mousedown(function(){
            $('#advanced_button').css({"background":"url("+WebsitePublic+"/image/Home/Index/search-button_on_03.png)"})
        })

})
 