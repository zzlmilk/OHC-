/* 
 * 
 * 验证注册信息 以及  账户修改时候的信息
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(function(){
    $('#checkEmail').val(0);  //默认值 用来判断用户是否完整填写信息
    $('#checkNickname').val(0); 
    $('#checkPassword').val(0); 
    $('#checkRePassword').val(0); 
})
var check = 0;
var registerCheck = 0;
function checkEmail(){
    var email = $('#email').val();
    var visit_url = getUrl('User/register/checkEmail',url);  //获取登录页面AJAX调用网址  url 为全局变量
    $.ajax({
        type: 'GET',
        async:false,
        cache:false,
        url: visit_url,
        data: "email="+email,
        success: function(resp){
            check = resp;
        }
    });
    return check;
}
function checkNickname(){
    var nickname = $('#username').val();
    var visit_url = getUrl('User/register/checkNickName',url);  //获取登录页面AJAX调用网址  url 为全局变量
    $.ajax({
        type: 'GET',
        async:false,
        url: visit_url,
        data: "username="+nickname,
        success: function(resp){
            check = resp;
        }
    });
    return check;
}
function checkPassword(){
    var password = $('#password').val();
    var visit_url = getUrl('User/register/checkPassword',url);  //获取登录页面AJAX调用网址  url 为全局变量
    $.ajax({
        type: 'GET',
        async:false,
        cache:false,
        url: visit_url,
        data: "password="+password,
        success: function(resp){
            check = resp;
        }
    });
    return check;
}
function checkRePassword(){
    var repassword = $('#repassword').val();
    var password = $('#password').val();
    var visit_url = getUrl('User/register/checkRePassWord',url);  //获取登录页面AJAX调用网址  url 为全局变量
    $.ajax({
        type: 'GET',
        async:false,
        cache:false,
        url: visit_url,
        data: "repassword="+repassword+'&password='+password,
        success: function(resp){
            check = resp;
        }
    });
    return check;
}
function advSubmit(obj,name){
    var textVal = $(obj).val();
    if(textVal !=""){
        registerSubmit(name);
    }
}

function registerSubmit(name){
    var result = 0;
    var num = 0;
    $('.checkRegister').each(function(){
        var val_name =  $(this).attr('id');
        var associate = '';
        //判断是否有单独查询数据 过来 如存在的话 则直接检查该内容的输入规范
        if(name !=undefined){
            val_name = name;
        }
        switch(val_name){
            case 'checkEmail' :
                result=checkEmail();
                associate = 'email';
                break;
            case 'checkNickname' :
                result=checkNickname();
                associate = 'username';
                break;
            case 'checkPassword' :
                result=checkPassword();
                associate = 'password';
                break;
            case 'checkRePassword' :
                result=checkRePassword();
                associate = 'repassword';
                break;
        }
        //移除所有的成功和错误 内容
        $('#'+associate+'_ok').remove();
        if(result!=1){
            //如输入错误 移除 该页面的正确图片 并添加错误信息 到错误div里面
            $('#'+associate+'_ok').remove();
            //如 当前错误的邮箱和密码  则把提示开启
            if(associate ==  'email'){
                $('#helpEmail').css('display','block');
                $('#helpEmail').css('color','red');
                $('#helpEmail').html(result);
                
            }
            if(associate == 'password'){
                $('#helpPassword').css('display','block');
                $('#helpPassword').css('color','red');
                $('#helpPassword').html(result);
            }
            if(associate == 'username'){
                $('#helpUserName').css('display','block');
                $('#helpUserName').css('color','red');
                $('#helpUserName').html(result);                
            }
            if(associate == 'repassword'){
                $('#helpRepassword').css('display','block');
                $('#helpRepassword').css('color','red');
                $('#helpRepassword').html(result);                
            }
        } else{
            //如email password 输入正确 则关闭该内容的提示内容  并添加正确图片到旁边 并移除该错误信息的提示
            if(associate ==  'email'){
                $('#helpEmail').html("");
            }
            if(associate == 'password'){
                $('#helpPassword').html('');
            }
            if(associate == 'username'){
                $('#helpUserName').html('');                
            }
            if(associate == 'repassword'){
                $('#helpRepassword').html('');                
            }
            num++;
            $('#'+associate).parent().after( '<img id="'+associate+'_ok"  src="./public/image/Home/register/ok.png" width="15" height="15"  style="margin-left:10px;margin-top: 10px;">');
            $('#email_state').hide();
            
        }
        //统计错误提示  如没有错误提示 则 关闭div
        //        if($('#error  p').size() == 0){
        //            $('#error_div').hide();
        //        } else{
        //            //提示错误信息 获取该高度  并修改 父div的高度
        //            var error_height =  $('#error').height() ;
        //            $('#error_prompt').height(error_height);   
        //        }
        if(val_name ==  name) {
            return false;
        }
    })
    if(num == 4){
        if(registerCheck == 0){
            $('#formregister').submit();
            registerCheck++;
        }
    }
}
//用户设置页面调用JS   当前密码 的 判断为 是否大于6位  而且 当前输入的密码与数据库的是否一样
//2次输入的新密码是否一样。。  新密码是否与旧密码 一样
// email 判断  如为输入的email 为当前的email的话   不做数据库查询重复判断  只做格式等判断  如不是 则需要判断数据库是否重复
function userSettingCheck(name,divname){
    var result = '';
    var blur_value = '';
    if(name!=undefined){
        switch(name){
            case 'email':
                result   = checkSettingEmail();
                blur_value = $('#newemail').val();
                break;
            case 'currentpassword':
                result   =checkSettingCurrentPassword();
                blur_value = $('#current_password').val();
                break;
            case 'password':
                result   = checkSettingPassword();
                blur_value = $('#settingpassword').val();
                break;
            case 'repassword':
                result   = checkSettingRePassword();
                blur_value = $('#settingrepassword').val();
                break;
        }
        if(result!=1){
            if(result != 0){
                var html = '<img src="./public/image/Home/register/error.png" width="15" height="15" id="error_image">'
                $('#error_'+divname).show();
                $('#error_div_'+divname).html(html+'<p style=" margin-left:20px; margin-top:-15px;">'+result+'</p>');
                return false;   
            }
        } else{
            if(blur_value !=''){
                var html = '<img src="./public/image/Home/register/ok.png" width="15" height="15" id="error_image">'
                $('#error_'+divname).show();
                $('#error_div_'+divname).html(html);   
            }
        }
    }
}

function checkSettingRePassword(){
    var repassword = $('#settingrepassword').val();
    var password = $('#settingpassword').val();
    var visit_url = getUrl('User/register/settingConfigNewPassword',url);  //获取登录页面AJAX调用网址  url 为全局变量
    $.ajax({
        type: 'GET',
        async:false,
        cache:false,
        url: visit_url,
        data: "settingpassword="+password+'&settingrepassword='+repassword,
        success: function(resp){
            check = resp;
        }
    });
    return check;
}
function checkSettingPassword(){
    var password = $('#settingpassword').val();
    var visit_url = getUrl('User/register/settingNewPassWord',url);  //获取登录页面AJAX调用网址  url 为全局变量
    $.ajax({
        type: 'GET',
        async:false,
        cache:false,
        url: visit_url,
        data: "settingpassword="+password,
        success: function(resp){
            check = resp;
        }
    });
    return check;
}
function checkSettingCurrentPassword(){
    var password = $('#current_password').val();
    var visit_url = getUrl('User/register/settingCurrentPassword',url);  //获取登录页面AJAX调用网址  url 为全局变量
    $.ajax({
        type: 'GET',
        async:false,
        cache:false,
        url: visit_url,
        data: "current_password="+password,
        success: function(resp){
            check = resp;
        }
    });
    return check;
}
function checkSettingEmail(){
    var email = $('#newemail').val();
    var visit_url = getUrl('User/register/settingCheckEmail',url);  //获取登录页面AJAX调用网址  url 为全局变量
    $.ajax({
        type: 'GET',
        async:false,
        cache:false,
        url: visit_url,
        data: "newemail="+email,
        success: function(resp){
            check = resp;
        }
    });
    return check;
}
/**
 *  check 变量   
 *  1 验证邮箱  2 验证当前密码  3 验证新密码  4 验证2次密码  5  验证邮件配置 验证用户性别  6 验证人种  验证出生年
 */
function ajaxSettingUpdate(){
    $(this).css('background',"url('../image/User/info/save-button_03.png') no-repeat");
    var check1 = '';
    var check2 = '';
    var check3 = '';
    var check4 = '';
    var check5 = '';
    var check6='';
    var checkvalue = 0;
    check1   = checkSettingEmail();
    //判断 如填写密码的时候 只要填写一个 就全部填写  并显示用户提示
    var repassword = $('#settingrepassword').val();
    var password = $('#settingpassword').val();
    var currentpassword = $('#current_password').val();
    if(repassword !='' || currentpassword !=''  || password!=''){
        var html = '<img src="../../public/image/Home/register/error.png" width="15" height="15" id="error_image">'
        if(password == ''){
            $('#error_div_3').html(html+'新密码不能为空');
            $('#error_3').show();
            checkvalue = 1;
        }
        if(currentpassword ==''){
            $('#error_div_2').html(html+'当前密码不能为空');
            $('#error_2').show();
            checkvalue = 1;
        }
        if(repassword == ''){
            $('#error_div_4').html(html+'重复密码不能为空');
            $('#error_4').show();
            checkvalue = 1;
        }
    }
    if(checkvalue == 1){
        return false;
    }
    // 2种情况 验证是否要提交表单。。 如 密码内容全部没有填写 则提交
    // 第2种  如 3个  1个 当前密码 一个新密码  一个重复密码 只要填写一个 则就需要全部填写
    // 验证所有的radio  是否有做过修改 只要有一个的话 提交 没的话 则不需要提交
    if(repassword !='' && currentpassword !=''  && password!=''){
        check2   = checkSettingCurrentPassword();
        check3   = checkSettingPassword();
        check4   = checkSettingRePassword();
    }
    var notify_emial = $('input:radio[name="notify_emial"]:checked').val();
    var Gender = $('input:radio[name="Gender"]:checked').val();
    var race = $('#RaceEthnicity').val();
    var birthyear = $('#RaceEthnicity1').val();
    if(notify_emial !=undefined || Gender !=undefined || race!='' || birthyear!=''){
        check5 = 1;
    }
    /**
     * 邮箱验证  密码等通过  相关内容 填写
     */
    if(check1 == 1  || (check2 == 1 && check3 == 1 && check4 == 1)  || check5 == 1){
        $('#settingupdateNow').val(1);
        $('#formsetting').submit();
    }
}
////提交 用户帐号修改  AJAX 动态修改内容
//function settingUpdateAjax(){
//    var repassword = $('#settingrepassword').val();
//    var password = $('#settingpassword').val();
//    var email = $('#newemail').val();
//    var notify_emial = $('input:radio[name="notify_emial"]:checked').val();
//    var Gender = $('input:radio[name="Gender"]:checked').val();
//    var race = $('#RaceEthnicity').val();
//    var birthyear = $('#RaceEthnicity1').val();
//    var email_path = $('#email_path').val();
//    var visit_url = getUrl('User/info/settingupdate',url);  //获取登录页面AJAX调用网址  url 为全局变量
//    $.ajax({
//        type: 'POST',
//        async:false,
//        cache:false,
//        url: visit_url,
//        data: "newemail="+email+'&email_path='+email_path+'&new_password='+password+'&new_confim_password='+repassword
//        +'&notify_emial='+notify_emial+'&Gender='+Gender+'&race='+race
//        +'&birthyear='+birthyear,
//        success: function(resp){
//            if(resp != 0 ){
//                $('.bodydiv').scroll(0);
//                $('#CompletedAction').show();
//                $('#setting_body').html(resp);
//            }
//        }
//    });
//}