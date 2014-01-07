/*
 * 自动完成js 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() {
    $('#search_text_location').keyup(function() {
        autolocationcity(0);
        textAndCodeColor('search_text_location');
        saveNumWithHidden($(this));
    });
    $('#search_text_location').blur(function(){
            changeLoction($(this));
    });
    $('#location_search_text').blur(function(){
            changeLoction($(this));
    });
    
    $('#search_text').keyup(function() {
        //autolocationcity(0);
        textAndCodeColor('search_text');
    });
    $('#location_search_text').keyup(function() {
        advancedAutolocationcity(0);
        saveNumWithHidden($(this));
    });
    
   function  saveNumWithHidden(obj){
       var a="";
       if(CheckLocationType(obj.val())==1){
           $("#search_text_location_hidden").val(obj.val());
       }
       else{
           $("#search_text_location_hidden").val('');
       }
       //alert($("#search_text_location_hidden").val());
       
   }
    /**
     * 处理火狐下 如输错内容 则焦点上去的时  显示默认的内容
     */
//    if (placeholderSupport()) {
//       var search_advanced_value = $('#search_advanced_type').val();
//       
//        $('input').focus(function() {
//            var input_id = $(this).attr('id');
//            var input_val = $(this).attr('placeholder');
//            if (search_advanced_value == 0) {
//                searchDefault(input_id,input_val);
//            }
//        })
//    }
})
//将数字变换为地址
function changeLoction(changeValue){
     var purl = getUrl('Home/Ajax/codeChangeLocation',url);
     var changeVal=changeValue.val();
    if(CheckLocationType(changeVal)==1&&changeValue!=''){
        $.ajax({
            url:purl,
            type:'GET',
            data:{
                "changeCode":changeVal
            },
            success:function(rData){
                if(rData!=""){
                    changeValue.val(rData);
                }
                else{
                     changeValue.val(changeVal);
                }
            }
        });
    }
}
//火狐下 变化 输出的颜色
function textAndCodeColor(name) {
    if ($('#' + name).css('color') != 'black') {
        $('#' + name).css('color', 'black');
    }
}
//将选择的城市名 放入text框内  关闭选择对话框
function locationcity(city) {
    var search_type_advanced = $('#search_advanced_type').val();
    if (search_type_advanced == 0) {
        $('#search_text_location').val(city);
        $('#autocomplete_city').hide();
        $('#autocomplete_city').html('');
    } else {
        $('#location_search_text').val(city);
        $('#autocompleteadvanced_city').hide();
        $('#autocompleteadvanced_city').html('');
    }

}
/**
 *  使用方法直接调用 自动完成
 */
function autolocationcity(source) {
    $('#search_result').hide();
    var val = $('#search_text_location').val();
    if(CheckLocationType($("#search_text_location_hidden").val())==1){
        val=val.split(" ");
        val=val[0];
    }

    var advance_page = $('#advance_page').val(); //为public header 页面
    if (val == '') {
        return false;
    }
    var pageurl = getUrl('Home/Ajax/location',url);
    $.get(pageurl, {
        searchDbInforItem: val
    }, function(res) {
        if (res != 1) {  //1为没有数据
            $('#autocomplete_city').html(res);
            $('#autocomplete_city').show();
        } else {
            $('#autocomplete_city').html('');
            $('#autocomplete_city').hide();
            if (source == 1) {
                if (advance_page == 1) {
                    $('#search_result').addClass('public_search');
                } else {
                    $('#search_result').addClass('public_search_0');
                }
                $('#search_result').show();
            }

        }
    });
}
function advancedAutolocationcity(source) {
    $('#search_result').hide();
    var val = $('#location_search_text').val();
    var advance_page = $('#advance_page').val();
    if (val != '') {
        var pageurl = getUrl('Home/Ajax/location',url);
        $.get(pageurl, {
            searchDbInforItem: val
        }, function(res) {
            if (res != 1) {  //1为没有数据
                $('#autocompleteadvanced_city').html(res);
                $('#autocompleteadvanced_city').show();
            } else {
                $('#autocompleteadvanced_city').html('');
                $('#autocompleteadvanced_city').hide();
                if (source == 1) {
                    if (advance_page == 1) {
                        $('#search_result').addClass('advanced_search');
                    } else {
                        $('#search_result').addClass('advanced_search_0');
                    }

                    $('#search_result').show();
                }

            }
        });
    } else {
        $('#autocompleteadvanced_city').html('');
        $('#autocompleteadvanced_city').hide();
    }

}
/**
 *  普通搜索时 焦点点击出现默认  
 */
function searchDefault(input_id, input_val) {
    /**
     * 处理火狐下 如输错内容 则焦点上去的时  显示默认的内容
     */
    for (var i = 0; i < searchArray.length; i++) {
        if (input_id == searchArray[i]) {
            //判断 如内容帮错误信息一样 则显示默认
            if (input_val == search_state[i]) {
                alert(search_state[i]);
            }
        }
    }
}