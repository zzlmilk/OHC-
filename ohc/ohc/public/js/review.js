/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var review_error = new Array('Please enter a valid name of a procedure', 'Please enter a valid zip code', 'Please enter a zip code', 'Please enter a valid state name', 'Please enter a state'
        , 'Please enter a valid city name', 'Please enter a city', 'Please enter the firstname of the doctor', 'Please enter the lastname of the doctor ', 'Please enter the name of an institution'
        , 'Please enter the visit date', 'Please fill in either the zip code or the city', 'Please enter a number for the cost', 'Please read the terms of service'
        , 'Zip code must be a  number', 'Zip code must be a 5-digit number', 'The review must be 10000 characters at maxinum', 'Please enter the year of the visit', 'Please enter the month of the visit'
        , 'commect is not null', 'The visiting year and month you entered are not valid');
var error_state = '';
var checkreiewvalue = 0;
var review_month = new Array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
/**
 * 星星 选择
 */
function hoverList(obj) {
    $(obj).hover(function() {
        // alert("a");
        $(this).removeClass('listliNomal');
        $(this).addClass('listliOn');
    }, function() {
        $(this).removeClass('listliOn');
        $(this).addClass('listliNomal');
    }
    );
}
$(function() {
    hoverList("#BirthYearCount li");
    hoverList("#RaceEthnicityUL li");
    hoverList("#procedure_list li");
    hoverList("#visit_year_list li");
    hoverList("#visit_month_list li");
    $(".rate_div span").mouseover(function() {
        var rate = $(this).attr('rate');
        var field = $(this).attr('field');
        checkingRate(field, rate);
    })
    $(".rate_div span").mouseout(function() {
        var field = $(this).attr('field');
        var val = $('#' + field).val();
        if (val >= 1) {
            checkingRate(field, val);
        } else {
            $('#rate_div_' + field + ' span ').removeClass('checkstart');
            $('#rate_div_' + field + ' span ').addClass('start');
        }
    })
    function checkingRate(field, rate) {
        for (var i = 1; i <= 5; i++) {
            if (i <= rate) {
                $('#rate_' + i + '_' + field).removeClass('start');
                $('#rate_' + i + '_' + field).addClass('checkstart');
            } else {
                $('#rate_' + i + '_' + field).removeClass('checkstart');
                $('#rate_' + i + '_' + field).addClass('start');
            }

        }
    }


})
function costselectclass(value) {
    var name = '';
    if (value == 0) {
        name = 'costno';
        $('#costcheckyes').removeClass('checkedselectreview');
        $('#costcheckyes').addClass('selectreview');
        $('#costcheckno').removeClass('selectreview');
        $('#costcheckno').addClass('checkedselectreview');
    } else {
        name = 'costyes';
        $('#costcheckyes').removeClass('selectreview');
        $('#costcheckyes').addClass('checkedselectreview');
        $('#costcheckno').removeClass('checkedselectreview');
        $('#costcheckno').addClass('selectreview');
    }
    $('#costselect').val(value);
    $('.costdiv').css('display', 'none');
    $('#' + name).css('display', 'block');
}
function checkedrate(name, value) {
    $('#' + name).val(value);
}
function listscroll(scrolldiv) {
    if ($('#' + scrolldiv).css('display') == 'block') {
        $('#' + scrolldiv).hide()
        $('#rightLine').hide();
    } else {
        $('#' + scrolldiv).show();
        if (scrolldiv == 'procedure_list') {
            $('#rightLine').show();
        }

    }
}
function checkagree(checkval, obj) {
    if (checkval == 0) {  // 0 为 未选中
        $(obj).removeClass('read');
        $(obj).addClass('checkread');
        $('#agree').val(1);
    } else {
        $(obj).removeClass('checkread');
        $(obj).addClass('read');
        $('#agree').val(0);
    }
}

function reviewprocedures(procedures_name, divname) {
    if(procedures_name != 'Others'){
        $('#othersTextDiv').hide();
    }
    $('#' + divname).html(procedures_name);
    $('#procedures_val').val(procedures_name);
    $('#procedure_list').hide();
    $('#rightLine').hide();
}
function reviewyear(year, divname) {
    $('#' + divname).html(year);
    $('#year_val').val(year);
    $('#visit_year_list').hide();
}
function reviewmonth(month, divname) {
    $('#' + divname).html(review_month[month-1]);
    $('#month_val').val(month);
    $('#visit_month_list').hide();
}
/**
 *  验证处方名称 邮编  州  城市 医生fristname lastname  诊所名称  访问年份 星级评分  付费提问  评论
 */
function  reviewsubmit() {

    error_state = '';
    var checkprocedures = $('#procedures_val').val();
    var zip_code = $('#zip_code').val();
    var state = $('#state').val();
    var city = $('#city').val();
    var doctor_frist_name = $('#doctors_frist_name').val();
    var doctor_last_name = $('#doctors_last_name').val();
    var hospital_name = $('#hospitals_name').val();
    var visit_year = $('#year_val').val();
    var visit_month = $('#month_val').val();
    var agree = $('#agree').val();
    var commect = $('#commect_review').val();
    var ajax = 0;
    //验证处方名称
    if (checkprocedures == '') {
        error_state += '<p>' + review_error[0] + '</p>';
        checkreiewvalue = 1;
    }
    else {
        if (checkreiewvalue != 1) {
            checkreiewvalue = 0;
        }
    }
    //验证 州 城市 和 邮编  如果 州  城市  和 邮编 都没有填写 提示2个任意选择一个
    if (state == '' && city == '' && zip_code == '') {
        error_state += '<p>' + review_error[11] + '</p>';
        checkreiewvalue = 1;
    }
    else {
        if (checkreiewvalue != 1) {
            checkreiewvalue = 0;
        }
    }
    //如果 邮编没有填写  州和 城市 任意填写 一个。。  之后判断 州和城市 只有其中空了一个
    if ((city != '' || state != '') && zip_code == '') {
        if (city == '') {
            error_state += '<p>' + review_error[6] + '</p>';
            checkreiewvalue = 1;
        }
        if (state == '') {
            error_state += '<p>' + review_error[4] + '</p>';
            checkreiewvalue = 1;
        }
        if (state != '' && city != '') {
            ajax = 1;
        }
    }
    //如果邮编填写   则判断 邮编是否大于5位 
    if (zip_code != '') {
        if (isNaN(zip_code)) {
            checkreiewvalue = 1;
            error_state += '<p>' + review_error[15] + '</p>';
        } else {
            if (zip_code.length > 5) {
                checkreiewvalue = 1;
                error_state += '<p>' + review_error[16] + '</p>';
            } else {
                ajax = 1;
            }
        }
    }
    //如果符合 邮编小于5位  则  进入ajax 验证 判断  州 邮编  城市 是否在城市列表中 有正确的值
    if (ajax == 1) {
        /**
         * 2013-8-1 by zxp
         * 地点验证 more 跳转过来时 不验证地点信息
         */
        if ($("#IsBack").val() != "yes") {
            checkreviewlocation(zip_code, state, city);
        }
    }
    //验证 医生填写的名称

    if (doctor_frist_name == '') {
        error_state += '<p>' + review_error[7] + '</p>';
        checkreiewvalue = 1;
    }
    else {
        if (checkreiewvalue != 1) {
            checkreiewvalue = 0;
        }
    }
    if (doctor_last_name == '') {
        error_state += '<p>' + review_error[8] + '</p>';
        checkreiewvalue = 1;
    }
    else {
        if (checkreiewvalue != 1) {
            checkreiewvalue = 0;
        }
    }
    //验证诊所名称
//    if (hospital_name == '') {
//        error_state += '<p>' + review_error[9] + '</p>';
//        if (checkreiewvalue == 0) {
//            checkreiewvalue = 1;
//        }
//    }
//    else {
//        if (checkreiewvalue != 1) {
//            checkreiewvalue = 0;
//        }
//    }
    //验证访问的年份和月份
    if (visit_year == 0) {
        error_state += '<p>' + review_error[17] + '</p>';
        checkreiewvalue = 1;
    }
    else {
        if (checkreiewvalue != 1) {
            checkreiewvalue = 0;
        }
    }
    if (visit_month == 0) {
        error_state += '<p>' + review_error[18] + '</p>';
        if (checkreiewvalue == 0) {
            checkreiewvalue = 1;
        }
    }
    else {
        var myDate = new Date();
        checkreiewvalue = 0;
        if (visit_year > myDate.getFullYear()) {
            if (visit_month > myDate.getMonth()) {
                error_state += '<p>' + review_error[20] + '</p>';
                checkreiewvalue = 1;
            }
        }

    }
    starcheck();   //评分和付费  检查
    //验证 阅读条款 
    if (agree == 0) {
        error_state += '<p>' + review_error[13] + '</p>';
        checkreiewvalue = 1;
    }
    else {
        if (checkreiewvalue != 1) {
            checkreiewvalue = 0;
        }
    }
    //验证评论 填写的是否小于1000字符
    if (commect != '') {
        if (commect.length > 10000) {
            error_state += '<p>' + review_error[16] + '</p>';
            checkreiewvalue = 1;
        }
    }
//    } else {
//        checkreiewvalue = 1;
//        error_state += '<p>' + review_error[19] + '</p>';
//    }
    // alert(checkreiewvalue);
    if (checkreiewvalue == 1) {
        $('#review_error_list').html(error_state);
        $('#review_error_div').show();
        var error_review_height = $('#review_error_list').height();
        $('#reviewerror').height(error_review_height);
        $('#reviewerror').show();
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');
    } else {
        $('#reviewerror').hide();
        $('#reviewerror').html('');
        $('#reviewfrom').submit();
    }
}
/**
 *
 */
function starcheck() {
    $('.rate_value').each(function() {
        var rate_val = $(this).val();
        var rate_title = $(this).attr('rate');
        if (rate_val == '' || rate_val == 0) {
            error_state += '<p>' + rate_title + 'is not null</p>';
            checkreiewvalue = 1;
        }
    })
    var cost_select = $('#costselect').val();
    if (cost_select == 1) {
        var fina_cost = 0;
        $('.cost_data').each(function() {
            var cost_val = $(this).val();
            fina_cost += cost_val;
            var cost_title = $(this).attr('cost');
            if (cost_val == '') {
                error_state += '<p>' + cost_title + ' is not null</p>';
                checkreiewvalue = 1;
            } else {
                if (isNaN(cost_val)) {
                    error_state += '<p>' + cost_title + review_error[13] + '</p>';
                    checkreiewvalue = 1;
                }
            }
        })
    } else {
        var fina_cost = $('#fina_cost').val();
        if (fina_cost != '') {
            if (isNaN(fina_cost)) {
                error_state += '<p>please enter the amount you end up paying in total ' + review_error[13] + '</p>';
                checkreiewvalue = 1;
            }
        } else {
            error_state += '<p>please enter the amount you end up paying in total  is not null' + '</p>';
            checkreiewvalue = 1;
        }
    }
    if (fina_cost <= 0) {
        error_state += '<p>cost must be greater than 0' + '</p>';
        checkreiewvalue = 1;
    }
}
/**
 * 验证邮编 和 州 与 城市的名称
 */
function checkreviewlocation(zip_code, state, city) {
    var visit_url = getUrl('Home/Ajax/checkreviewzsc', url);  //获取登录页面AJAX调用网址  url 为全局变量
    $.ajax({
        type: 'GET',
        async: false,
        cache: false,
        url: visit_url,
        data: "zip_code=" + zip_code + '&state=' + state + '&city=' + city,
        success: function(resp) {
            switch (resp) {
                case '1':
                    error_state += '<p>' + review_error[1] + '</p>';
                   checkreiewvalue = 1;
                    break;
                case '2':
                    error_state += '<p>' + review_error[3] + '</p>';
                   checkreiewvalue = 1;
                    break;
                case '5':
                    error_state += '<p>' + review_error[5] + '</p>';
                    error_state += '<p>' + review_error[3] + '</p>';
                    checkreiewvalue = 1;
                    break;
            }
        }
    });
}
function getInteger(val)
{
    val = val + "";
    var ret = val.replace(/\D/g, '');
    return ret;
}
function checkNum(obj)
{
    var val = getInteger($(obj).val());
    $(obj).val(val);
}
/**
 *  review  自动纠正 英文单词
 */
$(function() {
    var correnct_word_url = getUrl('Home/Ajax/wordAutoCorrection', url);  //获取登录页面AJAX调用网址  url 为全局变量
    $('#hospitals_name').keyup(function(event) {
        if ((event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105)) {
            var correnct_word = $(this).val();
            $.ajax({
                type: 'GET',
                url: correnct_word_url,
                data: "correnct_word=" + correnct_word,
                success: function(resp) {
                    if (resp != correnct_word) {
                        $('#hospitals_name').val(resp);
                    }
                }
            });
        } else {
            return false;
        }
    })
    if ($("#IsBack").val() == "yes") {
        $("#zip_code").attr('disabled', "disabled");
        $("#doctors_frist_name").attr('disabled', "disabled");
        $("#doctors_last_name").attr('disabled', "disabled");
        $("#doctors_middle_name").attr('disabled', "disabled");
        $("#state").attr('disabled', "disabled");
        $("#city").attr('disabled', "disabled");
    }
})