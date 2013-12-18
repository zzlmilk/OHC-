/* 
 *  医生 诊所 医疗项目 中 使用到的javascript
 * and open the template in the editor.
 */


/**
 * 搜索框  修改js   根据获取的类型
 */
function searchCustom(type, searchId, searchval, locationval, allDisplay) {
    $('#searching').val(type);
    if (allDisplay == "no") {
        pleaseRegisterUrl =  getUrl('Medical/index/PleaseRegister', url);
        PleaseRegister(pleaseRegisterUrl);
        return false;
    }
    if ($("#search_advanced_type").val() == 0) {

        $('#search_text').val(searchval);
        $("#search_text_location").val(locationval);
        $("#search_text_id").val(searchId);
    } else {
        switch (type) {
            case "1":
                $('#doctor_search_text').val(searchval);
                $("#location_search_text").val(locationval);
                break;
            case "2":
                $('#hospital_search_text').val(searchval);
                $("#location_search_text").val(locationval);
                break;
            case "3":
                $('#procedure_search_text').val(searchval);
                $("#location_search_text").val(locationval);
                break;
        }

    }
    // alert($('#doctor_search_text').val());
    $("#location_type").val("2");
    $('#formcode').submit();

}
function doctorLike(review_id, ablelike, type) {
    var visiturl = getUrl('Home/Ajax/reviewlike',url);
    $.get(visiturl, {
        review_id: review_id,
        review_ablelike: ablelike
    }, function(res) {
        var type_array = type.split(':');
        if (res > 0) {
            if (type == 'normal') {
                $('#doctor_like').html('&nbsp;');
            } else if (type_array[0] == 'doctor' && type_array[1] == 'produce') {
                $('#doctor_produce_list_' + type_array[2]).html('&nbsp;');
            }
        }
    });
}
function buttonchange(obj) {
    var page_display = $('#doctor_review_list').css('display');
    if (page_display == 'inline-block') {
        $(obj).css({'text-decoration': "none", 'font-weight': 'normal', "font-size": "16px"});
        $('#doctor_review_list').css('display', 'none');
        $('#doctor_list').css('height', 260);
    } else {
        $(obj).css({'text-decoration': "underline", 'font-weight': 'bold', "font-size": "15px"});
        $('#doctor_review_list').css('display', 'inline-block');
        var Review_height = $("#doctor_review_list").height();
        $('#doctor_list').css('height', 260 + Review_height);
    }
}
function reviewproduceDisplay(key) {
    var display_review = $('#produce_doctor_review_list_like_' + key).css('display');
    if (display_review == 'inline-block') {
        $('#produce_doctor_review_list_like_' + key).css('display', 'none');
    } else {
        $('#produce_doctor_review_list_like_' + key).css('display', 'inline-block');
    }
}
//点击按钮事件
function buttomClick(obj, mouseDownStyle, mouseUpStyle) {
    // alert(obj.val());
    $(obj).mousedown(function() {
        // alert(obj);
        $(this).removeClass(mouseUpStyle);
        $(this).addClass(mouseDownStyle);
    });
    $(obj).mouseup(function() {
        $(this).removeClass(mouseDownStyle);
        $(this).addClass(mouseUpStyle);
    });
    $(obj).hover(function() {
    }, function() {
        $(this).removeClass(mouseDownStyle);
        $(this).addClass(mouseUpStyle);
    });
}

function sortAjax(type, model, location, returnmodel) {
    var AjaxSortUrl = getUrl(model,location);
    var loadingImg = '<img id="loader" src="'+WebsitePublic+'/image/Medical/search/loader/loader1.gif" style=" margin-left: 240px; margin-top: -240px;">';
    $('#doctor_detail_list').html(loadingImg);
    $('#doctor_detail_list').css('width',578);
    $('#doctor_detail_list').css('height',803);
    $.ajax({
        url: AjaxSortUrl,
        async: false,
        type: 'GET',
        data: {
            searching: $("#searching").val(),
            location_type: $("#location_type").val(),
            search_text: $("#search_text").val(),
            search_text_location: $("#search_text_location").val(),
            search_text_location_hidden: $("#search_text_location_hidden").val(),
            search_advanced_type: $("#search_advanced_type").val(),
            doctor_search_text: $("#doctor_search_text").val(),
            hospital_search_text: $("#hospital_search_text").val(),
            procedure_search_text: $("#procedure_search_text").val(),
            location_search_text: $("#location_search_text").val(),
            location_code: $("#location_code").val(),
            search_text_id: $('#search_text_id').val(),
            sort_type: type
        },
        success: function(rdate) {
            successfun(returnmodel, rdate);
        }
    });
}
function successfun(returnmodel, rdate) {
    switch (returnmodel) {
        case 1:
            $("#hospitalList").html(rdate);
            getscore();
            buttomClick(".moreArea div", "moreButtomDown", "moreButtomNomal");
            break;
        case 2:
            $("#ajaxArea").html(rdate);
            getDetailScore();
            break;
        case 3:
            $("#doctor_detail_list").html(rdate);
            buttomClick(".moreArea div", "moreButtomDown", "moreButtomNomal");
            break;
        case 4:
            $("#ajaxfield").html(rdate);
            buttomClick(".doctor_butSty", "doctor_produceButOn", "doctor_produceButOff");
            break;
        case 5:
            $('#produce_doctor').html(rdate);
            break;

    }
}
/**
 * 
 */
function doctorListHeight() {
    $('.doctor_more_list').each(function() {
        var divDocotr = $(this).children('div');
        var divHeight = 0;
        divDocotr.each(function() {
            divHeight += $(this).height();
        })
        divHeight += 60;
        $(this).height(divHeight);
        if (divHeight == 210) {
            var divMoreDoctor = divDocotr.children('.moreButtom');
            divMoreDoctor.css({"margin-top": "4px"});
        }
    })
}