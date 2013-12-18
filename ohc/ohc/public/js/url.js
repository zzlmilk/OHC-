/* 
 * xp  此js主要是通过AJAX 来获取页面的URL地址 以及 AJAX的请求地址
 * path 为获取文件的目录 如Home/Index/index  
 * url 为网站的根域名  
 * params  为传递的参数
 * and open the template in the editor.
 */
//var url = 'http://localhost/ohc';  //设定网址这边的全局变量
var url = 'http://transparentmedicalcare.com';  //设定网址这边的全局变量
function getUrl(path, url) {
	path = path.split('/');
	if (!path[1])
		path[1] = 'Index';
	if (!path[2])
		path[2] = 'index';
	website = url+'?g='+path[0]+'&m='+path[1]+'&a='+path[2];
//	if(params){
//		params = params.join('&');
//		website = website + '&' + params;
//	}
	return website;
        
//           var website = url;
//    website = website + '/' + path;
//    return website;
}
document.onmouseup = function(e)
{
    
    e = window.event ? window.event : e;
    srcE = e.srcElement ? e.srcElement : e.target;
    if($('#search_text_location').val()!=''){
         changeLoction($('#search_text_location'));
    }
    if($('#location_search_text').val()!=''){
        changeLoction($('#location_search_text'));
    }
    if (document.getElementById("search_type") && srcE.id != "search_type" && srcE.id != 'search_background')
    {
        if ($('#search_type').css('display') == 'block') {
            $('#search_type').slideToggle('normal');
        }
    }
    if (document.getElementById("BirthYearCount") && srcE.id != "BirthYearCount" && srcE.id != 'BirthYear' && srcE.id != "Scroll_y_DBMB" && srcE.id != "Scroll_y_Up" && srcE.id != "Scroll_y" && srcE.id != "Scroll_y_Down" && srcE.id != "Scroll_y_Drag")
    {
        if ($('#BirthYearCount').css('display') == 'block') {
            $('#BirthYearCount').toggle();
        }

    }
    if (document.getElementById("RaceEthnicityUL") && srcE.id != "RaceEthnicityUL" && srcE.id != 'RaceEthnicitydiv' && srcE.id != 'BirthYear' && srcE.id != "Scroll_y_DBMB" && srcE.id != "Scroll_y_Up" && srcE.id != "Scroll_y" && srcE.id != "Scroll_y_Down" && srcE.id != "Scroll_y_Drag")
    {
        if ($('#RaceEthnicityUL').css('display') == 'block') {
            $('#RaceEthnicityUL').toggle();
        }

    }
    if (document.getElementById("locationid") && srcE.id != "locationid") {
        if ($('#autocomplete_city').css('display') == 'block') {
            $('#autocomplete_city').hide();
            $('#autocomplete_city').html('');
        }
        if ($('#autocompleteadvanced_city').css('display') == 'block') {
            $('#autocompleteadvanced_city').hide();
            $('#autocompleteadvanced_city').html('');
        }
    }
    if (document.getElementById("procedure_list") && srcE.id != "procedure_list" && srcE.id != "procedure_name" && srcE.id != "procedure_id" && srcE.id != "Scroll_y_DBMB" && srcE.id != "Scroll_y_Up" && srcE.id != "Scroll_y" && srcE.id != "Scroll_y_Down" && srcE.id != "Scroll_y_Drag")
    {
        if ($('#procedure_list').css('display') == 'block') {
            $('#procedure_list').hide();
             $('#rightLine').hide();
        }
    }
    if (document.getElementById("visit_year_list") && srcE.id != "visit_year_list" && srcE.id != "visit_year" && srcE.id != "visit_year_id" && srcE.id != "Scroll_y_DBMB" && srcE.id != "Scroll_y_Up" && srcE.id != "Scroll_y" && srcE.id != "Scroll_y_Down" && srcE.id != "Scroll_y_Drag")
    {
        if ($('#visit_year_list').css('display') == 'block') {
            $('#visit_year_list').hide();
        }
    }
    if (document.getElementById("visit_month_list") && srcE.id != "visit_month_list" && srcE.id != "visit_month_id" && srcE.id != "visit_month" && srcE.id != "Scroll_y_DBMB" && srcE.id != "Scroll_y_Up" && srcE.id != "Scroll_y" && srcE.id != "Scroll_y_Down" && srcE.id != "Scroll_y_Drag")
    {
        if ($('#visit_month_list').css('display') == 'block') {
            $('#visit_month_list').hide();
        }
    }
    $('#race_span1').removeClass('selectScoll');
    $('#race_span1').addClass('NomalScoll');
    $('#race_span').removeClass('selectScoll');
    $('#race_span').addClass('NomalScoll');
}