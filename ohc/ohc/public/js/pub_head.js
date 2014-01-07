/* 
 * publicheader 效果
 * and open the template in the editor.
 */
//my Account

var WebsitePublic;
function setpublic(websitepublic){
     WebsitePublic = websitepublic;
}
$(function(){
    //控制下划线
    $("#signup,#signin,#font_advanced,#signout,#font_MyAccount,#font_WriteAReview").mouseover(function(){
        $(this).css({
            "text-decoration": "underline"
        })
    })
    $("#signup,#signin,#font_advanced,#signout,#font_MyAccount,#font_WriteAReview").mouseout(function(){
        $(this).css({
            "text-decoration": "none"
        })
    })  
    //控制搜索
//        $("#img_search").hover(function(){
//            $("#img_search").attr("src",WebsitePublic+"/image/Home/Index/search_fly_03.png");
//        })
        $("#img_search").mouseout(function(){
            $("#img_search").attr("src",WebsitePublic+"/image/Home/Index/search_03.png");
        })
        $("#img_search").mousedown(function(){
            $("#img_search").attr("src",WebsitePublic+"/image/Home/Index/search_on_03_1.png");
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
        $(this).css('background-color','#1c74cf')
    })
    $(".homespan").mouseout(function(){
        $(this).css('background-color','#0658C8');//
         $(this).removeClass('headerHover');
    })
    $(".homespan").mousedown(function(){
        $(this).addClass('headerHover');
    })
})
