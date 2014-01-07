$(function() {
    searchDisplayPage();
    $("#search_text").keydown(function() {
        $(this).css('color', 'black');
    })
    $('.user_login_close').click(function() {
        $('#search_result').toggle();
    })
})
/**
 *  搜索相关js
 */
var searchArray = new Array('search_text', 'search_text_location');
var advancedArray = new Array('doctor_search_text', 'hospital_search_text', 'procedure_search_text', 'location_search_text');
var search_index = new Array('Doctor name, e.g., John Smith', 'Institution name, e.g., Mayo Clinic', 'Procedure name, e.g., abdominal ultrosound', 'location, e.g., a zip code or city');
var search_state = new Array('Please enter the name of a doctor', 'Please enter the name of an institution', 'Please enter then name of a procedure', 'Please enter the location');
function list() {
    var type = $('#searching').val();
    $('#search_type li').show();
    $('#type_' + type).css('display', 'none');
    $('#search_type').slideToggle('fast');
}
function placeholderSupport() {
    return 'placeholder' in document.createElement('input');
}
/**
 * 
 * @para value 为  doctor Institutions producure  中的一个id doctor 为1 以此类推
 * name 为对应的名称
 */
function listAction(value, name) {
    $('#search_type').css('display', 'none');
    $('#search_type li').css('display', 'none');
    $('#search_background').html(name);
    $('#searching').val(value);
    if (!placeholderSupport()) {   //判断IE是否支持placeholder 函数  判断是否已经填写 如存在 则不替换
        if ($('#search_text').val() == search_index[0] || $('#search_text').val() == search_index[1] || $('#search_text').val() == search_index[2] || $('#search_text').val() == '') {
            $('#search_text').val(search_index[value - 1]);
            $('#search_text').css('color', 'gray');
            $('#search_text').attr('placeholder', search_index[value - 1]);
        }
        if ($('#search_text_location').val() == search_index[3] || $('#search_text_location').val() == '') {
            $('#search_text_location').val(search_index[3]);
            $('#search_text_location').css('color', 'gray');
        }
    } else {
        $('#search_text').attr('placeholder', search_index[value - 1]);
        $('#search_text_location').attr('placeholder', search_index[3]);
    }
}


function setting(value, name, selectname, asdname) {
    $('#' + name).html(value);
    $('#' + selectname).val(value);
    if ($('#' + asdname).css('display') == 'block') {
        $('#' + asdname).toggle();
    }
    else {
        if (asdname == 'RaceEthnicityUL') {
            $('#race_span').removeClass('selectScoll');
            $('#race_span').addClass('NomalScoll');
        }
        else {
            $('#race_span1').removeClass('selectScoll');
            $('#race_span1').addClass('NomalScoll');
        }
    }
}
function settingdisplay(name) {
    $('#' + name).toggle();
    if (name == 'RaceEthnicityUL') {
        $('#race_span').removeClass('NomalScoll');
        $('#race_span').addClass('selectScoll');
    }
    else if (name == 'BirthYearCount') {
        //race_span1
        $('#race_span1').removeClass('NomalScoll');
        $('#race_span1').addClass('selectScoll');
    }
}
function CheckLocationType(location) {
    var type = '';
    if (isNaN(location) || location == "") {
        type = 2;  //为字符串类型
    } else {
        type = 1; //为数字类型
    }

    $('#location_type').val(type);
    return type;
}
function ajaxSearch(path, PublicUrl) {
    $("#search_text_id").val('');
    var type = '';
    //判断location  是否为数字 如是数字 AJAX 查询该邮编的城市。。 如查询完成则把数据
    var locationHidden = $("#search_text_location_hidden").val();
    if ($('#search_text_location').val() != '') {
        var codeUrl = getUrl('Home/Ajax/getLocationCode', url);
        var LocationCode = getLocationCode($('#search_text_location').val(), codeUrl);
        if (LocationCode != 1) {
            $("#search_text_location_hidden").val(LocationCode);
        } else {
            autolocationcity(1);
            return false;
        }
    }
    type = CheckLocationType(locationHidden);

    var location = type == 1 ? locationHidden : $('#search_text_location').val();

    var pageurl = getUrl(path, PublicUrl);  //获取登录页面AJAX调用网址

    if (location == search_index[3] || location == search_state[3]) {  //去除默认显示内容
        location = '';
        $('#search_text_location').val('');
    }

    if ($("#searching").val() == "3" && $('#search_text_location').val() == "") {
        if (!placeholderSupport()) {   //判断IE是否支持placeholder 函数
            $('#search_text_location').val(search_state[3]);
        } else {
            $('#search_text_location').attr('placeholder', search_state[3]);
        }
        return false;
    }
    /**
     * 处理名称输入框 去除默认错误提示以及提示
     */
    checkSearchTextStatue($('#search_text').val(), 0);
    /**
     * checkSearchTextAndCode 为验证 地点和 名称是否填写
     */
    var checkSearchTextAndCodeResult = checkSearchTextAndCode(location, $('#search_text').val());
    if (checkSearchTextAndCodeResult == 0) {
        searchTextState($('#search_text').val(), 0);
        searchFromSubmit(pageurl, location, type);
    }
}
/*
 获取对应地址的邮政编码
 **/
function getLocationCode(locationName, getUrl) {
    var codeVal;
    $.ajax(
            {
                type: 'get',
                url: getUrl,
                data: {
                    locationName: locationName
                },
                async: false,
                success: function(rData) {
                    codeVal = rData;

                }
            });
    return codeVal;
}
/**
 * 如地点已输入 则查询该地点是否存在 不存在出现提示  存在 提交表单
 * 否则 直接提交表单
 */
function searchFromSubmit(pageurl, location, type) {
    var search_type = $('#search_advanced_type').val();
    var valueType = $("#search_text_location_hidden").val();
    var locationCode = $("#location_code").val();
    //alert(locationCode);
    if (valueType == 't' && CheckLocationType(locationCode) == 1 && locationCode != '') {
        var arr = location.split(" ");
        var addStr = "";
        arr.pop();
        for (var i = 0; i < arr.length; i++) {
            if (i == 0) {
                addStr += arr[0];
            }
            else {
                addStr += " " + arr[i];
            }
        }
        location = addStr;
    }
    // alert(location);
    /**
     * 判断如果地点没有填写 无需验证 地点内容 直接提交
     */
    if (location != '') {
        $.get(pageurl, {
            code: location,
            type: type
        }, function(res) {
            if (res == 0 || res > 1) {
                if (search_type == 0) {
                    autolocationcity(1);
                } else {
                    advancedAutolocationcity(1);
                }
            }
            else if (res == 1) {
                $('#formcode').submit();
            }
        });
    } else {
        $('#formcode').submit();
    }
}
/**
 * 同上 为高级搜索时 使用
 */
function advancedAjaxSearch() {
    var advanced_count = 0;
    var searchType = '';
    var pageurl = getUrl('Home/Ajax/locationcode', url);

    advanced_count = advancedIf(advancedArray.length);
    if (advanced_count == advancedArray.length) {
        advancedDisplay(4);
        return false;
    } else {

        var advancedLocation = $('#location_search_text').val();
        var advancedprocedure = $('#procedure_search_text').val();
        advanced_count = advancedIf(3);
        //当地点不为空时 则 医生 医院 医疗项目 必须填写一个 进行验证
        if (advanced_count == 3 && advancedLocation != '') {
            advancedDisplay(0);
            advancedDisplay(1);
            advancedDisplay(2);
            return false;
        }
        //当医疗项目不为空时 验证地点 地点为必须填写
        if (advancedprocedure != '') {
            if (advancedLocation == '') {
                advancedDisplay(2);
                return false;
            }
        }
        if (advanced_count <= 2) {
            if ($('#location_search_text').val() != '') {
                var pageurl = getUrl('Home/Ajax/getLocationCode', url);
                var LocationCode = getLocationCode($('#location_search_text').val(), pageurl);
                $("#search_text_location_hidden").val(LocationCode);
                searchType = CheckLocationType($("#search_text_location_hidden").val());
            }
            if (searchType == 1) {
                advancedLocation = $("#search_text_location_hidden").val();
                advancedLocation = advancedLocation.split(" ");
                advancedLocation = advancedLocation[0];
            }
            searchFromSubmit(pageurl, advancedLocation, searchType);
        }
    }
}
function advancedIf(number) {
    var advanced_count = 0; //统计有多少文本框没填写
    for (var i = 0; i < number; i++) {
        if ($('#' + advancedArray[i]).val() == '' || $('#' + advancedArray[i]).val() == search_state[i] || $('#' + advancedArray[i]).val() == search_index[i]) {
            advanced_count++;
            //            if (!placeholderSupport()) {   //判断IE是否支持placeholder 函数  判断是否已经填写 如存在 则不替换
            //                $('#' + advancedArray[i]).val(search_state[i]);
            //            } else {
            //                $('#' + advancedArray[i]).attr('placeholder', search_state[i]);
            //            }
        }
    }
    return advanced_count;
}
function advancedDisplay(advancedVal) {
    var advancedArrayCount = 0;
    var advancedArray_ = new Array('doctor_search_text', 'hospital_search_text', 'procedure_search_text', 'location_search_text');
    if (advancedVal != 4) {
        advancedArrayCount = 1;
    } else {
        advancedArrayCount = 0;
    }
    if (advancedArrayCount == 0) {
        for (var j = 0; j < advancedArray_.length; j++) {
            if ($('#' + advancedArray_[j]).val() == '') {
                advancedErrorState(j, advancedArray[j]);
            }
        }
    } else {
        advancedErrorState(advancedVal, advancedArray[advancedVal]);
    }
}
/**
 * 高级搜索 添加错误提示
 * @param {type} text
 * @param {type} check
 * @returns {undefined}
 */
function advancedErrorState(state, searchName) {
    if (!placeholderSupport()) {   //判断IE是否支持placeholder 函数  判断是否已经填写 如存在 则不替换
        $('#' + searchName).val(search_state[state]);
    } else {
        $('#' + searchName).attr('placeholder', search_state[state]);
    }
}
/*
 * text 添加  错误提示
 * 同下
 */
function searchTextState(text, check) {
    /*
     *  获取提示 如在IE下的话  则获取value的值 如在火狐等支持placeholder属性 就获取placeholder的值
     */
    if (!placeholderSupport()) {   //判断IE是否支持placeholder 函数
        text = $('#search_text').val();
    } else {
        text = $('#search_text').attr('placeholder');
    }
    if ($('#search_text_location').val() == '') {
        if (check == 1) {
            if (!placeholderSupport()) {   //判断IE是否支持placeholder 函数
                $('#search_text_location').val(search_state[3]);
            } else {
                $('#search_text_location').attr('placeholder', search_state[3]);
            }
        }
    }
    checkSearchTextStatue(text, check);
}
/**
 *  check 为1 时  如输入框为空 则出现错误提示
 *  否则 将text 默认为空值 避免表单提交时 将默认值提交
 */
function checkSearchTextStatue(text, check) {
    var searchState;
    var search_type = $('#search_advanced_type').val();
    var search_type_ = $('#searching').val();
    if (search_type == 0) {
        if (search_index[search_type_ - 1] == text || search_state[search_type_ - 1] == text || text == '') {
            if (check == 1) {
                searchState = search_state[search_type_ - 1];
            } else {
                searchState = '';
            }
            if (!placeholderSupport()) {   //判断IE是否支持placeholder 函数
                $('#search_text').val(searchState);
            } else {
                $('#search_text').attr('placeholder', searchState);
            }
        }
    } else {
        for (var searchCount = 0; searchCount < search_index.length - 1; searchCount++) {
            /**
             *  IE下查找 是否等于默认提示 如果等于的话 则把变量为空
             */
            if (search_index[searchCount] == text || search_state[searchCount] == text || text == '') {
                if (check == 1) {
                    searchState = search_state[searchCount];
                } else {
                    searchState = '';
                }
                if (!placeholderSupport()) {   //判断IE是否支持placeholder 函数
                    $('#search_text').val(searchState);
                } else {
                    $('#search_text').attr('placeholder', searchState);
                }
            }
        }
    }
}
/**
 *  验证内容 和 地点是否全部填写  如没有填写 则不通过搜索 进行提示
 */
function checkSearchTextAndCode(location, text) {
    var alert_state = 0;
    /**
     * 验证地点和填写的框   地点和输入框 选填一个
     */
    if (location == '' && text == '') {
        alert_state = 1;
        searchTextState(text, 1);
    }
    return alert_state;
}
/**
 *  搜索ajax时 判断高级搜索还是普通搜索 来获取不同的变量
 * @param {type} str
 * @returns {Boolean}
 */
function searchAjaxAdvancedAndSearch(search_advanced_type, searchname, searchval, scroce, visiturl) {
    if (search_advanced_type == 0) {
        searchAjax(searchname, searchval, scroce, visiturl);
    } else {
        searchAdvancedAjax(search_advanced_type, searchname, searchval, scroce, visiturl);
    }
}
function searchReturnResult(scroce, res) {
    var scorce_detail = scroce.split(':');
    switch (scorce_detail[1]) {
        case 'nomral':
            $('#' + scorce_detail[0]).html(res);
            break;
        case 'doctorreview':
            $('#doctor_review_list').html(res);
        case 'produrelist':
            $('#produce_doctor_review_list_like_' + scorce_detail[2]).html(res);
        case 'doctorlist':
            $('#doctor_detail_list').html(res);
            buttomClick(".moreArea div", "moreButtomDown", "moreButtomNomal");
            break;
    }
}
function  searchAdvancedAjax(search_advanced_type, searchname, searchval, scroce, visiturl) {
    /**
     *  判断 4个高级搜索是否全部没有填写 如没有填写 则提示
     */
    advanced_count = advancedIf(advancedArray.length);
    if (advanced_count != advancedArray.length) {
        var advancedLocation = $('#location_search_text').val();
        advanced_count = advancedIf(3);
        if (advancedLocation == '' || advancedLocation == search_state[3]) {
            $('#location_search_text').val(search_state[3]);
        } else {
            if (advanced_count <= 2) {
                searchType = CheckLocationType(advancedLocation);
                $.get(visiturl, {
                    doctor_search_text: $('#doctor_search_text').val(),
                    hospital_search_text: $('#hospital_search_text').val(),
                    procedure_search_text: $('#procedure_search_text').val(),
                    location_search_text: $('#location_search_text').val(),
                    location_zip_code: $("#hidden_zip_code").val(),
                    search_advanced_type: search_advanced_type,
                    sort_type: $("#sortType").val(),
                    location_type: $("#location_type").val(),
                    search_text_id: $('#search_text_id').val(),
                    location_code: location_code,
                    searchscroce: scroce,
                    searchname: searchname,
                    searchval: searchval
                }, function(res) {
                    searchReturnResult(scroce, res);
                    searchDisplayPage();
                });
            }
        }
    }
}
function searchAjax(searchname, searchval, scroce, visiturl) {
    var search_location = $('#search_text_location').val();
    if (search_location == search_index[3] || search_location == search_state[3]) {  //去除默认显示内容
        search_location = '';
    }
    var checkSearchTextAndCodeResult = checkSearchTextAndCode(search_location, $('#search_text').val());
    if (checkSearchTextAndCodeResult == 0) {
        var scorce_detail = scroce.split(':');
        $.get(visiturl, {
            searching: $('#searching').val(),
            search_text: $('#search_text').val(),
            search_text_location: $('#search_text_location').val(),
            location_zip_code: $("#hidden_zip_code").val(),
            sort_type: $("#sortType").val(),
            location_type: $("#location_type").val(),
            search_text_id: $('#search_text_id').val(),
            location_code: $("#location_code").val(),
            produce_name: $('#doctor_procedure_' + scorce_detail[2]).val(),
            searchscroce: scroce,
            searchval: searchval,
            searchname: searchname
        }, function(res) {
            searchReturnResult(scroce, res);
            searchDisplayPage();
        });
    }
}
function PleaseRegister(url) {
    $.get(url, {
    }, function(res) {
        $('body').append(res);
    });
}
//搜索页面  排序ajax JS
//allDisplay
function  searchCount(searchname, searchval, path, scroce, allDisplay) {
    var visiturl = getUrl(path, url);  //获取登录页面AJAX调用网址

    var search_advanced_type = $('#search_advanced_type').val();
    if (allDisplay == "no") {
        var pleaseRegisterUrl = getUrl('Medical/index/PleaseRegister', url);
        PleaseRegister(pleaseRegisterUrl);
        return false;
    }
    /**
     *  医生列表 
     **/
    if (scroce == 'doctor:doctorlist') {
        var loadingImg = '<img id="loader" src="' + WebsitePublic + '/image/Medical/search/loader/loader1.gif" style=" margin-left: 240px; margin-top: -240px;">';
        $('#doctor_detail_list').html(loadingImg);
        $('#doctor_detail_list').css('width', 578);
        $('#doctor_detail_list').css('height', 803);
        var currentDoctorArea = Math.ceil(searchval / 5);
        var lastDoctorArea = currentDoctorArea - 1;
        if (currentDoctorArea > 0) {
            if (currentDoctorArea == currentArea) {
                getDoctorList(searchval);
            } else {
                searchAjaxAdvancedAndSearch(search_advanced_type, searchname, searchval, scroce, visiturl);
            }
        }
    } else {
        searchAjaxAdvancedAndSearch(search_advanced_type, searchname, searchval, scroce, visiturl);
    }
}
// setting  与 排序页面 checkbox 选中
function checkbox(obj, name, classname) {
    if (name == 'soft') {
        var alvlue = classname
        var softvalue = $(obj).attr('checkbox_value');  //用户按的是哪个数值
        $('#soft_name').val(softvalue);
    } else {
        var alvlue = $(obj).attr('checkbox_value');  //用户按的是哪个数值
    }
    var pageName = name;  //操作哪个checked
    //去除所有radio的选中class
    $('.' + pageName + ' .zogo-form-radio').removeClass('zogo-form-radio-checked');
    //给选中的 那个内容 增加选中class
    $('#' + name + alvlue).addClass('zogo-form-radio-checked');
    //取消所有的默认选中框
    $("input[name=" + name + "]").attr("checked", false);
    //跟选中的raido 默认选中
    $("input[name=" + name + "][value=" + alvlue + "]").attr("checked", true);
}
//高级搜索相关   page_value 指的是 哪个功能点击的 
function formReset(page, page_display) {
    /**
     * 当page_display 传输为1时  清空该内容
     */
    if (page_display == 1) {
        $('#' + page + ' input').val('');
    }
    if (page_display != '' && page_display != 1) {
        $('#' + page_display + '  input ').val('');
        if (page_display == 'body_search' || page_display == 'Theme_background_public') {
            $('#search_advanced_type').val(0);
            listAction(1, 'Doctors');
        } else {
            $('#search_advanced_type').val(1);
            if (!placeholderSupport()) {
                var advancedArray_ = new Array('doctor_search_text', 'hospital_search_text', 'procedure_search_text', 'location_search_text');
                for (var j = 0; j < advancedArray_.length; j++) {
                    if ($('#' + advancedArray_[j]).val() == '') {
                        $('#' + advancedArray_[j]).val(search_index[j]);
                    }
                }
            }
        }
        $('#' + page).slideToggle('fast');
        $('#' + page_display).slideToggle('fast');
    }
    $('#search_result').hide();

}

/**
 * 搜索后使用  按照记录 是否显示高级搜索的页面
 */
function searchDisplayPage() {
    var search_type_name = new Array();
    var search_advanced_value = $('#search_advanced_type').val();
    if (search_advanced_value == 0) {
        search_type_name[1] = 'Doctors';
        search_type_name[2] = 'Institutions';
        search_type_name[3] = 'Procedures';
        var search_type = $('#searching').val();
        if (search_type == '') {
            $('#searching').val(1);
        } else {
            listAction(search_type, search_type_name[search_type]);
        }
    } else {
        if ($('#advance_page').val() == 1) {
            $('#Theme_background_public').hide();
            $('#advanced_search_publicdiv').show();
        }
    }
}
function  viewbodyAjax(searchname, searchval, path, scroce, allDisplay) {
    var visiturl = getUrl(path, url);  //获取登录页面AJAX调用网址
    $.get(visiturl, {
        page: searchval,
        scroce: scroce
    }, function(res) {
        var $scroce = scroce.split(':');
        var scroce_name = $scroce[0] + '_' + $scroce[1];
        if (scroce_name == 'userview_doctorlist') {
            $('#doctor_name').html(res);
        } else if (scroce_name == 'userview_forumlist') {
            $('#forum_review').html(res);
        }
    });
}

function nologin() {
    var pleaseRegisterUrl = getUrl('Medical/index/PleaseRegister', url);
    PleaseRegister(pleaseRegisterUrl);
    return false;
}


function KeyDown(event, name) {
    var keynum;
    if (window.event) // IE
    {
        keynum = event.keyCode
    }
    else if (event.which) // Netscape/Firefox/Opera
    {
        keynum = event.which
    }
    if (keynum == 13) //13 回车
    {
        switch (name) {
            case 'search':
                ajaxSearch('Home/Ajax/locationcode', url);
                break;
            case 'login':
                UserLogin('Home/Ajax/userLogin', url)
                break;
            case 'register':
                registerSubmit();
                break;
            case 'review':
                reviewsubmit();
                break;
            case 'lostpassword':
                checkPasswordSubmit();
                break;
            case 'lostpasswordEmail':
                checkPasswordEmail($('#lostemail').val());
                break;
            case 'myaccount':
                ajaxSettingUpdate();
                break;
            case 'forumpost':
                forumPost();
                break;
            case 'forumtopic':
                forum_topic_submit();
                break;
            case 'reviewAgree':
                var publicurl = getUrl('Medical/review/review', url);
                window.location.href = publicurl;
                break;
            case 'advancedsearch':
                advancedAjaxSearch();
                break;

        }
    }
}