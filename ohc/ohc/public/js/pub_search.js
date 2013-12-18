/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//控制publicheader.html　中　搜索图片效果
$(document).ready(function() {
    $(".search_type li").hover(function() {
        $(this).css({"background": "url(" + WebsitePublic + "/image/Home/Index/dropdown-fly_03.png)"})
    })
    $(".search_type li").mouseout(function() {
        $(this).css({"background": "url(" + WebsitePublic + "/image/Home/Index/list.gif)"})
    })

    $(".search_background").mouseout(function() {
        $(".search_background").css({"background": "url(" + WebsitePublic + "/image/Home/Index/search_ground.gif)"})
    })
    $(".search_background").mousedown(function() {
        $(".search_background").css({"background": "url(" + WebsitePublic + "/image/Home/Index/dropdown_on.png)"})
    })
})
