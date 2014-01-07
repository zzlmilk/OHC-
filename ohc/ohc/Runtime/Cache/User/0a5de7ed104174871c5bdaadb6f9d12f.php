<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="<?php echo ($PUBLIC); ?>/js/jquery-1.3.2.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo ($PUBLIC); ?>/css/checkbox.css"></link>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/url.js"></script>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/home.js"></script>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/login.js"></script> 
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/placetest.js"></script>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/register.js"></script>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/review.js"></script>
        <script src="<?php echo ($PUBLIC); ?>/js/WuBin-jsScroll.js" language="javascript" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/css_clear.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/review.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/home.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/register.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/footer.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/public.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/setting.css" media="all" />
        <link href="<?php echo ($PUBLIC); ?>/css/WuBin-jsScroll.css" rel="stylesheet" type="text/css">
            <script>
                $(function() {
                    $('#searching').val(1);
                    $("input[name='send_emial']").attr("checked", false);
                    $("input[name='share_emial']").attr("checked", false);
                    $("input[name='Gender']").attr("checked", false);
                    $("input[name='notify_emial']").attr("checked", false);
                    $("#saveButton").mousedown(function() {
                        //alert('a');
                        $("#saveButton").removeClass("saveUp");
                        $("#saveButton").addClass("saveDown");
                    });
                    $("#saveButton").mouseup(function() {
                        // alert('b');
                        $("#saveButton").addClass("saveUp");
                        $("#saveButton").removeClass("saveDown");
                    });
                    $("#saveButton").mouseout(function() {
                        $("#saveButton").addClass("saveUp");
                        $("#saveButton").removeClass("saveDown");
                    });


                    $(".setting_text").focus(function() {
                        $(this).removeClass('textFocusout');
                        $(this).addClass('textFoucs');
                    });
                    $(".setting_text").blur(function() {
                        $(this).removeClass('textFoucs');
                        $(this).addClass('textFocusout');
                    });
                    $(".inputStyle").focus(function() {
                        $(this).parent(".textBackground").removeClass('textFocusout');
                        $(this).parent(".textBackground").addClass('textFoucs');
                    });
                    $(".inputStyle").blur(function() {
                        $(this).parent(".textBackground").removeClass('textFoucs');
                        $(this).parent(".textBackground").addClass('textFocusout');
                    });
                })
            </script>
    </head>
    <body>
        <div class="bodydiv">
            <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/checkword.js"></script> 
<script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/effect.js"></script> 
<link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/public.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/login.css" media="all" />     
<script>
    $(function() {
        var WebsitePublic = '<?php echo ($PUBLIC); ?>';
        setpublic(WebsitePublic);
    })

    //搜索下拉框 变线
    $(function() {
        $("#search_type li").click(function() {
            $("#search_type").css({"border": "none"});
        })
        $("#search_background").click(function() {
            $("#search_type").css({"border-right": "solid 1px #848484"});
            $("#search_type").css({"border-left": "solid 1px #848484"});
            $("#search_type").css({"border-bottom": "solid 1px #848484"});
        })
    })
</script>
<script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/pub_head.js"></script> 
<div id="homemaindiv_register" class="homemaindiv_register">
    <div style=" width: 809px; position: relative;margin: 0px auto 0px 91px;  padding-top: 12px;">
        <!--         导航栏-->
        <span  style=" display: block; width: 44px; position: absolute; top: 10px;left: 10px;">
            <img src="<?php echo ($PUBLIC); ?>/image/Home/Index/logo_03.png" width="100%" id="logo" style=" margin-left: -40px; margin-top: -12px;"/>
            <a href="<?php echo ($PUBLICJSURL); ?>">
                <img src="<?php echo ($PUBLIC); ?>/image/Home/Index/home.png" id="img_home" style=" margin-top:-1px; margin-left: 9px; position: absolute; top:-2px;" />
            </a>
        </span> 
       <ul id="homeULpublic" style="position: absolute; top: 0; left: 82px;">
            <li style=" width: 80px;">
                <span class="homespan" onclick="listAction(1, 'Doctors')"><p class="font_daohang">Doctors</p></span>
            </li>
            <li style=" width: 120px;">
                <span style='' class="homespan" onclick="listAction(2, 'Institutions')"><p class="font_daohang">Institutions</p></span>
            </li>
            <li style=" width: 120px;">
                <span class="homespan"  onclick="listAction(3, 'Procedures')"><p class="font_daohang">Procedures</p></span> 
            </li>
            <li style=" width: 84px;">
                <span  class="homespan">
                    <a href="<?php echo U('forum/forum/forumList');?>" style='color: #fff;'>
                        <p class="font_daohang">Forum</p>
                    </a>
                </span>
            </li>
        </ul>
        <!--        注册等按钮开始-->
        <?php
 if($_SESSION['user_id']>0){ ?>
        <ul class="wordUL_public" style=" position: relative; left: 213px; top: 4px;">

            <?php
 } else{ ?>
            <ul class="wordUL_public" style=" position: relative; left: 213px; top: 4px;">

                <?php
 } ?>
                <!--            登录后-->
                <?php
 if($_SESSION['user_id']>0){ ?>
                <li>
                    <a href="<?php echo U('User/info/setting');?>" id="font_MyAccount" >My Account</a>&nbsp;&nbsp; 
                    <a style="border-left: 1px solid #535353;clear: both; height: 15px;left:63px; position: absolute;top: 6px;width: 1px;"></a>
                </li>
                <?php
 } else{ ?>
                <!--            未登录后-->            
                <li style="width: 55px;">
                    <a href="javascript:void(0)" onclick="isRepeatClick()" id="signup" style="clear: both;height: 15px;text-decoration: none;">Sign In</a>
                    <input type="hidden" onclick="LoginPage('Home/Index/userLogin', '<?php echo ($PUBLICJSURL); ?>')" id="hiddenSign"/>
                    <a style="    border-left: 1px solid #535353;clear: both; height: 15px;left: 46px; position: absolute;top: 8px;width: 1px;"></a>
                </li>
                <?php
 } ?>
                <!--            登录后-->       
                <?php
 if($_SESSION['user_id']>0){ ?>
                <li>
                    <a href="javascript:void(0)" onclick="userlogout()" id="signout">Sign Out</a>&nbsp;&nbsp;&nbsp;
                    <a style="border-left: 1px solid #535353;clear: both; height: 15px;left:118px; position: absolute;top: 6px;width: 1px;"></a>
                </li> 
                <?php
 } else{ ?>
                <!--            未登录后-->                   
                <li style="width: 55px;"> 
                    <a href="<?php echo U('User/register/index');?>" id="signin" style="">Sign Up</a>&nbsp;&nbsp;
                    <a style="border-left: 1px solid #535353;clear: both; height: 15px;left:104px; position: absolute;top: 8px;width: 1px;"></a>
                </li>
                <?php
 } ?>
                <!--            登录后-->       
                <?php
 if($_SESSION['user_id']>0){ ?>
                <li>
                    <a  href="<?php echo U('Medical/review/reviewAgree');?>" id="font_WriteAReview">Write a Review</a>
                </li>
                <?php
 } else{ ?>
                <!--            未登录后-->      
                <li>
                    <a  href="javascript:void(0)" onclick="nologin()" id="font_WriteAReview" style="">Write a Review</a>
                </li>
                <?php
 } ?>
            </ul>
    </div>
    <div  style="clear: both;"></div>
</div>

<form action="<?php echo U('Medical/index/search');?>"  method="post" id="formcode" name="formcode">
    <input type="hidden">
    <div id="Theme_background_public">
        <div  id="body_search_public">
            <div style=" width: 680px;  margin-left:63px; padding-top: 15px; position: relative;">
                <input type="hidden" name="searching" id="searching"  value="<?php echo ($search_contion["searching"]); ?>">
                <div  style="float: left;display: block;width: 133px; margin-left: -25px;">
                    <span onclick="list()"style="display: block; text-align: left;line-height: 36px;height: 36px; text-indent: 6px; font-size: 14px;" class="search_background" id="search_background">
                        Doctors
                    </span>
                    <ul id="search_type" class="search_type" style="display: none; width: 123px; margin-left: 0px;position: absolute;z-index: 9999;">
                        <li id="type_1" onclick="listAction(1, 'Doctors')">Doctors</li>
                        <li id="type_2" onclick="listAction(2, 'Institutions')">Institutions</li>
                        <li id="type_3" onclick="listAction(3, 'Procedures')">Procedures</li>
                    </ul>
                </div>
                <input type="hidden" name="location_type" id="location_type" value="<?php echo ($search_contion["location_type"]); ?>" />
                <input type="hidden" name="location_code" id="location_code" value="<?php echo ($search_contion["search_text_location_hidden"]); ?>" />
                <span style="position: relative; overflow: hidden; width: 211px; margin-left: 15px; height: 36px; display: block; float: left; " id="search_text_span">

                    <input type="text"  onkeydown="KeyDown(event,'search')" name="search_text"  autocomplete="off" id="search_text" class="search_text" value="<?php echo ($search_contion["search_text"]); ?>"  placeholder="Doctor name, e.g., John Smith" />
                    <!--                    more点击的时候存储搜索对应的ID    -->
                    <input type="hidden" name="search_text_id" id="search_text_id" value="<?php echo ($doctor_info["doctor_id"]); ?>"/>

                </span>

                <span style="position: relative;overflow: hidden; width: 205px; height: 36px; display: block; float: left; " id="search_text_span">
                    <input type="text" name="search_text_location"   onkeydown="KeyDown(event,'search')" autocomplete="off" id="search_text_location" class="search_text"  value="<?php echo ($search_contion["search_text_location"]); ?>"  placeholder="location, e.g., a zip code or city"  style=" width: 189px; width:190px \0\9; width:190px \0; margin-left: 3px;border-top-right-radius:0px;border-bottom-right-radius:0px; "/>
                    <input name="search_text_location_hidden"   id="search_text_location_hidden" type="hidden" value="t"/>
                </span>

                <span style=" width: 55px; height: 35px; display: block; position: absolute;left: 536px; top: 15px;cursor: pointer;left: 538px \0\9;" onclick="ajaxSearch('Home/Ajax/locationcode', '<?php echo ($PUBLICJSURL); ?>')">
                    <img id="img_search" src="<?php echo ($PUBLIC); ?>/image/Home/Index/search_03.png"width="100%" height="100%"/>
                </span>
                <ul id="autocomplete_city" class="autocomplete_public" style="left: 347px; text-indent: 6px;  width: 197px;"></ul>
                <span id="font_advanced" style=" margin-left: 90px; font-size: 12px; color: rgb(82, 83, 83); cursor: pointer; text-decoration: none; position: absolute; top: 27px; " onclick="formReset('Theme_background_public', 'advanced_search_publicdiv')">
                    Advanced
                </span>
                <div style="clear: both; position: absolute; top: 15px; left: 111px;border-left: 2px solid #D3D3D3; height: 36px; width: 1px; position: absolute;">&nbsp;</div>
            </div>
        </div>
    </div>
    <div class="error_search" id="search_result" >
        <div class="user_login_close"></div>
        <div>
            <p id="search">
                Sorry! No Search  results !
            </p>
        </div>
    </div>
    <input type="hidden" name="advanece_page" id="advance_page" value="1" />
    <div id="advanced_search_publicdiv" style="position:relative;">
        <input type="hidden" name="search_advanced_type" id="search_advanced_type" value="<?php echo ($search_contion["search_advanced_type"]); ?>" />
        <div id="advanced_search_public" style=" display: block; margin-left: 10px; margin-top: 2px; ">
            <div style=" height: 20px;"></div>
            <div style="text-align: center; color:#969696; width: 612px; margin-left: 44px;  font-size: 18px; ">Please specify a combination of two or more searching criteria from below:</div>
            <div id="advanced_search_div" style="position: relative;">

                <div id="advanced_doctorAndhospital" style=" color: #696969">
                    <div   class="left">
                        <span class="left advanced_frist">Doctor</span>
                        <span  class="left" >

                            <span  class='searchTextStyle advanced_background'>
                                <input type="text" onkeydown="KeyDown(event,'advancedsearch')" name="doctor_search_text" id="doctor_search_text" value="<?php echo ($search_contion["doctor_search_text"]); ?>" autocomplete="off"  placeholder="Name e.g.John Smith"  />
                            </span>
                        </span>
                    </div>
                    <div   class="left">
                        <span  class="left advanced_seconed" style="">At this institution</span>
                        <span  class="left">
                            <span class='searchTextStyle advanced_background'>
                                <input type="text" onkeydown="KeyDown(event,'advancedsearch')" name="hospital_search_text" id="hospital_search_text" value="<?php echo ($search_contion["hospital_search_text"]); ?>" autocomplete="off" placeholder="Institutions eg John Smith" />
                            </span>
                        </span>
                    </div>
                </div>
                <div style="clear: both; height: 1px;"></div>
                <div  id="advanced_procedureAndlocation" style=" display: block; *margin-top: 3px;">
                    <div  class="left">
                        <span  class="left advanced_frist" >Procedure’s </span>
                        <span class="left">
                            <span  class='searchTextStyle advanced_background'>
                                <input type="text" onkeydown="KeyDown(event,'advancedsearch')" name="procedure_search_text" id="procedure_search_text" value="<?php echo ($search_contion["procedure_search_text"]); ?>" autocomplete="off" placeholder="Procedures eg John Smith" /></span>
                        </span>
                    </div>
                    <div  class="left" style=" position: relative; ">
                        <span class="left advanced_seconed" >Location:</span>
                        <span class="left" >
                            <span  class='searchTextStyle advanced_background'>
                                <input type="text" onkeydown="KeyDown(event,'advancedsearch')" name="location_search_text" id="location_search_text" value="<?php echo ($search_contion["location_search_text"]); ?>" autocomplete="off"  placeholder="location, e.g., zip code or city" /></span>
                        </span>
                        <ul id="autocompleteadvanced_city" class="autocomplete"></ul>
                    </div>
                </div>
                <div style="clear: both;"></div>

            </div>
            <div id="advanced_button_div" style=" margin-left: 176px;">

                <span id="advanced_button" style="margin-top: -3px;margin-left: -33px;" onclick="advancedAjaxSearch()">&nbsp;</span>
                <span id="font_reset" style=" margin-left: 92px; margin-top:22px; *margin-top:43px;font-weight: bold; color:#AAAAAA;;width: 100px;" onclick="formReset('advanced_search_publicdiv', '1')">Reset</span>
                <!--                        竖线下-->
                <span id="font_cancel" style=" text-align: center;width: 88px;color: #AAAAAA; margin-left:156px;line-height: 1;  margin-top:-16px;font-weight: bold;height: 20px;" onclick="formReset('advanced_search_publicdiv', 'Theme_background_public')">Cancel</span>
            </div>
            <!--                        竖线上-->
            <!--            <div style=" border-left: 2px solid #ccc;height: 75px; left: 339px;position: absolute;top: 43px; width: 1px; "></div>-->
        </div>
    </div>
</form>
<div style="clear: both;"></div>
            <div style="width: 785px; margin-top: 18px;">
                <div style=" float: left; width: 193px; ">
                    <div id="setting_li">
                        <ul>
                            <li style=" color:#0578e3; font-weight: bold; font-size: 17px;">My Account</li>
                            <li><a class="navsAlink" href="<?php echo U('User/info/setting');?>">Settings</a></li>
                            <li><a class="navsAlink" href="<?php echo U('Home/Index/viewBody');?>">profile</a></li>
                            <!--  
                              <li><a class="navsAlink" href="javascript:void(0)">Doctors</a></li>
                              <li><a class="navsAlink" href="javascript:void(0)">Institutions</a></li>
                              <li><a class="navsAlink" href="javascript:void(0)">Procedures</a></li>-->
                        </ul>
                    </div>
                </div>
                <div style=" float: left;width: 587px;*min-height:1000px"  id="setting_left_body">
                    <div  style=" height: 30px;">
                        &nbsp;
                    </div>
                    <?php if($success == 1 ): ?><div id="CompletedAction"  style=" margin-bottom:50px;width: 650px;margin-left: -40px;">
                            <div>
                                <img  src="<?php echo ($PUBLIC); ?>/image/Home/register/ok.png" width="18" height="18" id="setting_complete"/>
                                <?php if($activation == 1 ): ?><p id="completeed">Your account have been activationed.</p>
                                    <?php else: ?>
                                    <p id="completeed">Your settings have been saved. Please continue your browsing.</p><?php endif; ?>
                            </div>
                        </div><?php endif; ?>
                    <div  style=" width: 597px;border-top:solid 2px #ccc; border-left: solid 2px #ccc; height: 771px;border-right: solid 1px #837D7D; border-bottom: solid 1px #B9B6B6;box-shadow: 1px 1px 0px #ccc;margin-left: -28px; margin-top: -27px; padding-left: 20px;" id="setting_body">
                        <form action="<?php echo U('User/info/setting');?>"  method="post" id="formsetting" name="formsetting">
                            <input type="hidden" name="settingupdateNow" id="settingupdateNow" value="0" />
                            <div style="height: 55px;"></div>
                            <div >
                                <p class="titleText">Account</p>
                            </div>
                            <div style=" margin-top: 20px;position: relative;" id="setting_body_div">
                                <span class="left setting_span setting_account formText">Email Address</span>
                                <span id="newemailDiv" class="textFocusout textBackground">
                                    <input type="text"  onkeydown="KeyDown(event,'myaccount')" id="newemail" name="newemail"class="inputStyle"   value="<?php echo ($user["user_email"]); ?>"  onblur="userSettingCheck('email', 1)" />
                                </span>
                                <div style="" class="error_message" id="error_1">
                                    <p  id="error_div_1"  class="error_p"></p>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="setting_body_margin margin_hack">
                                <p class="titleText">Change Password</p>
                            </div>
                            <div id="setting_body_div">
                                <div style=" margin-bottom: 10px; position: relative;">
                                    <span class="left setting_span setting_margin_span  setting_account formText ">Current Password</span>
                                    <span class="textFocusout textBackground">
                                        <input type="password"   onkeydown="KeyDown(event,'myaccount')" id="current_password" name="current_password" class="inputStyle"  onblur="userSettingCheck('currentpassword', 2)" />
                                    </span>
                                    <div style=" margin-top: -4px;" class="error_message" id="error_2">
                                        <p  id="error_div_2" style=""  class="error_p"></p>
                                    </div>
                                    <div class="clear "></div>
                                </div>
                                <div style=" margin-bottom: 10px;position: relative;">
                                    <span class="left setting_span setting_account formText">New Password</span>
                                    <span class="textFocusout textBackground">
                                        <input type="password"   onkeydown="KeyDown(event,'myaccount')" id="settingpassword" name="settingpassword" class="inputStyle"   onblur="userSettingCheck('password', 3)"  />
                                    </span>
                                    <div style="margin-top: -4px;" class="error_message" id="error_3">
                                        <p style=" "  class="error_p" id="error_div_3"></p>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div style=" margin-bottom: 10px;position: relative;">
                                    <span class="left setting_span setting_account formText">Confim New  Password</span>
                                    <span class="textFocusout textBackground">
                                        <input type="password"  onkeydown="KeyDown(event,'myaccount')" id="settingrepassword" name="settingrepassword" class="inputStyle"   onblur="userSettingCheck('repassword', 4)"   />
                                    </span>
                                    <div style="margin-top: -6px;" class="error_message" id="error_4">
                                        <p style=" margin-top: 4px;" class="error_p" id="error_div_4"></p>
                                    </div>
                                </div>
                                <div>
                                </div>
                                <div class="clear "></div>
                                <div id="setting_ajax">
                                    <div class="setting_body_margin">
                                        <h class="titleText">Email Preferences</h>  
                                        <!--                                                    <p class="formText">Manage which emails you recevie from Transparentmedicalbill </p>-->
                                    </div>
                                    <div style=" margin-top: 20px;*margin-top: 25px;" id="setting_body_div" class="notify_emial formText">
                                        <span class="left setting_span"  style="  width: 254px;">Send me personalized update emails from Transparentmedicalcare</span>
                                        <input  type="radio"  class="myClass notify " value="1"   id="notifyemial1" style="display: none;"   name="notify_emial" />
                                        <input  type="radio"  class="myClass notify" value="2"    id="notifyemial2"style="display: none;"name="notify_emial" />
                                        <input  type="radio"  class="myClass notify" value="3" id="notifyemial3" style="display: none;"  name="notify_emial" />
                                        <?php if($userconfig["notify_emial"] == 1 ): ?><span class="zogo-form-radio zogo-form-radio-checked" checkbox_value="1" onclick="checkbox(this, 'notify_emial', 'notifyemial')" id="notify_emial1">Weekly</span>
                                            <span class="zogo-form-radio" checkbox_value="2" onclick="checkbox(this, 'notify_emial', 'notifyemial')" id="notify_emial2">monthly</span>
                                            <span class="zogo-form-radio" checkbox_value="3" onclick="checkbox(this, 'notify_emial', 'notifyemial')" id="notify_emial3">Never</span>
                                            <!--                                        默认input 选中-->
                                            <?php elseif($userconfig["notify_emial"] == 2): ?>
                                            <span class="zogo-form-radio " checkbox_value="1" onclick="checkbox(this, 'notify_emial', 'notifyemial')" id="notify_emial1">Weekly</span>
                                            <span class="zogo-form-radio zogo-form-radio-checked" checkbox_value="2" onclick="checkbox(this, 'notify_emial', 'notifyemial')" id="notify_emial2">monthly</span>
                                            <span class="zogo-form-radio" checkbox_value="3" onclick="checkbox(this, 'notify_emial', 'notifyemial')" id="notify_emial3">Never</span>
                                            <?php elseif($userconfig["notify_emial"] == 3): ?>
                                            <span class="zogo-form-radio " checkbox_value="1" onclick="checkbox(this, 'notify_emial', 'notifyemial')" id="notify_emial1">Weekly</span>
                                            <span class="zogo-form-radio" checkbox_value="2" onclick="checkbox(this, 'notify_emial', 'notifyemial')" id="notify_emial2">monthly</span>
                                            <span class="zogo-form-radio zogo-form-radio-checked" checkbox_value="3" onclick="checkbox(this, 'notify_emial', 'notifyemial')" id="notify_emial3">Never</span>
                                            <?php else: ?>
                                            <span class="zogo-form-radio" checkbox_value="1" onclick="checkbox(this, 'notify_emial', 'notifyemial')" id="notify_emial1">Weekly</span>
                                            <span class="zogo-form-radio" checkbox_value="2" onclick="checkbox(this, 'notify_emial', 'notifyemial')" id="notify_emial2">monthly</span>
                                            <span class="zogo-form-radio" checkbox_value="3" onclick="checkbox(this, 'notify_emial', 'notifyemial')" id="notify_emial3">Never</span><?php endif; ?>
                                    </div>
                                    <div class="clear "></div> 
                                    <div class="setting_body_margin">
                                        <h2 class="titleText">Profile Information</h2>  
                                        <p class="formText">To help us better understand our community and offer more interesting data insights, please complete the OPTIONAL information below. Such information will not be shown to any other users.</p>
                                    </div>
                                    <dl class="gender_dl formText" >
                                        <dt>Gender</dt>
                                        <dd>
                                            <div class="Gender" style="margin-left: 45px;">
                                                <?php if($userconfig["Gender"] == 1 ): ?><span class="zogo-form-radio zogo-form-radio-checked" checkbox_value="1" onclick="checkbox(this, 'Gender', 'gder')" id="Gender1">Male</span>
                                                    <span class="zogo-form-radio" checkbox_value="2" onclick="checkbox(this, 'Gender', 'gder')" id="Gender2">Female</span>
                                                    <span class="zogo-form-radio " checkbox_value="3" onclick="checkbox(this, 'Gender', 'gder')" id="Gender3">prefer not to disclose</span>
                                                    <?php elseif($userconfig["Gender"] == 2): ?>
                                                    <span class="zogo-form-radio" checkbox_value="1" onclick="checkbox(this, 'Gender', 'gder')" id="Gender1">Male</span>
                                                    <span class="zogo-form-radio zogo-form-radio-checked" checkbox_value="2" onclick="checkbox(this, 'Gender', 'gder')" id="Gender2">Female</span>
                                                    <span class="zogo-form-radio " checkbox_value="3" onclick="checkbox(this, 'Gender', 'gder')" id="Gender3">prefer not to disclose</span>
                                                    <?php elseif($userconfig["Gender"] == 3): ?>
                                                    <span class="zogo-form-radio" checkbox_value="1" onclick="checkbox(this, 'Gender', 'gder')" id="Gender1">Male</span>
                                                    <span class="zogo-form-radio" checkbox_value="2" onclick="checkbox(this, 'Gender', 'gder')" id="Gender2">Female</span>
                                                    <span class="zogo-form-radio zogo-form-radio-checked" checkbox_value="3" onclick="checkbox(this, 'Gender', 'gder')" id="Gender3">prefer not to disclose</span>
                                                    <?php else: ?>
                                                    <span class="zogo-form-radio" checkbox_value="1" onclick="checkbox(this, 'Gender', 'gder')" id="Gender1">Male</span>
                                                    <span class="zogo-form-radio" checkbox_value="2" onclick="checkbox(this, 'Gender', 'gder')" id="Gender2">Female</span>
                                                    <span class="zogo-form-radio" checkbox_value="3" onclick="checkbox(this, 'Gender', 'gder')" id="Gender3">prefer not to disclose</span><?php endif; ?>
                                                <!--                                                                        默认input 选中-->
                                                <input  type="radio"   class="myClass sendemial " value="1"   id="gder1" style="display: none;"   name="Gender" />
                                                <input  type="radio"  class="myClass sendemial" value="2"    id="gder2"style="display: none;"name="Gender" />
                                                <input  type="radio"  class="myClass sendemial" value="3"    id="gder3"style="display: none;"name="Gender" />
                                            </div>
                                        </dd>
                                        <dt>Ethinicity </dt>
                                        <dd >
                                            <span id="race_span" class="race_span listText NomalScoll" onclick="settingdisplay('RaceEthnicityUL')">
                                                <?php if($userconfig["race"] != '' ): ?><p  style="padding-right:42px; text-align: right;" id="RaceEthnicitydiv"><?php echo ($userconfig["race"]); ?></p>
                                                    <?php else: ?>
                                                    <p  style="padding-right:42px;text-align: right;" id="RaceEthnicitydiv">Please Select</p><?php endif; ?>

                                            </span>
                                            <ul id="RaceEthnicityUL" style="overflow: hidden; width:197px;*width:185px; height: 200px;position: absolute; z-index: 999; margin-left: 16px; border-left:1px solid black;" class="Scroll3 ">
                                                <li class="listliNomal"  onclick="setting('Please Select', 'RaceEthnicitydiv', 'RaceEthnicity', 'RaceEthnicityUL')"><span>Please Select</span></li>
                                                <li class="listliNomal" onclick="setting('African American', 'RaceEthnicitydiv', 'RaceEthnicity', 'RaceEthnicityUL')"><span>African American</span></li>
                                                <li class="listliNomal" onclick="setting('Asian', 'RaceEthnicitydiv', 'RaceEthnicity', 'RaceEthnicityUL')"><span>Asian</span></li>
                                                <li class="listliNomal" onclick="setting('Hispanic', 'RaceEthnicitydiv', 'RaceEthnicity', 'RaceEthnicityUL')"><span>Hispanic</span></li>
                                                <li class="listliNomal" onclick="setting('Pacific Islander', 'RaceEthnicitydiv', 'RaceEthnicity', 'RaceEthnicityUL')"><span>Pacific Islander</span></li>
                                                <li class="listliNomal" onclick="setting('White', 'RaceEthnicitydiv', 'RaceEthnicity', 'RaceEthnicityUL')"><span>White</span></li>
                                                <li class="listliNomal" onclick="setting('Prefer not to disclose', 'RaceEthnicitydiv', 'RaceEthnicity', 'RaceEthnicityUL')"><span>Prefer not to disclose</span></li>
                                            </ul>
                                        </dd>
                                        <dt>Birth Year</dt>
                                        <dd>
                                            <span id="race_span1" class="race_span listText NomalScoll" onclick="settingdisplay('BirthYearCount')">
                                                <?php if($userconfig["birthyear"] != 0 ): ?><p  style="padding-right:42px; text-align: right;"  id="BirthYear"><?php echo ($userconfig["birthyear"]); ?></p>
                                                    <?php else: ?>
                                                    <p  style="padding-right:42px; text-align: right;" id="BirthYear">Please Select</p><?php endif; ?>

                                            </span>
                                            <ul id="BirthYearCount" style=" overflow: hidden; width:197px;*width:185px; height: 200px;position: absolute;z-index: 998;*padding-left:0px; margin-left: 16px; border-left: 1px solid #000;" class="Scroll3">
                                                <li  class="listliNomal" onclick="setting('Please Select', 'BirthYear', 'RaceEthnicity1', 'BirthYearCount')">
                                                    <span>  Please Select</span>
                                                </li>
                                                <?php  $year = date("Y"); $oldyear = '1955'; $count = $year - $oldyear; for($i = $year;$i >= '1955'; $i--){ ?>
                                                <li class="listliNomal"style="" onclick="setting('<?php  echo $i ?>', 'BirthYear', 'RaceEthnicity1', 'BirthYearCount')">
                                                    <span>
                                                        <?php  echo $i ?>
                                                    </span>
                                                </li>
                                                <?php  } ?>
                                            </ul>
                                        </dd>
                                    </dl>
                                    <div class="clear"></div>
                                </div>      
                                <div style=" margin-left:310px; margin-top:50px;">
                                    <span   style=" float: left; line-height: 53px; color: #51B0C2; font-size: 17px; padding-right: 60px; margin-top: -10px;">
                                        <a id="cannelLink" href="javascript:void(0)" onclick="location.reload();" style="color:#0578e3">cancel</a>
                                    </span>                                                     
                                    <span id="saveButton" class="savechange saveUp"  style=" float: left;" onclick="ajaxSettingUpdate()">
                                    </span>  

                                </div>
                                <input type="hidden" id="RaceEthnicity"  name="race"value="" />
                                <input type="hidden" id="RaceEthnicity1"   name="birthyear" value="" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div style="height: 8px;"></div>
        </div>
        <div>
            <div style="clear: both; height: 20px;"></div>
<div class="footer">
    <p  style=" padding-top: 30px; padding-left: 30px;font-size: 12px; ">Copyright @ 2013, Transparent Medical Care. All Rights Reserved. Your use of this service is subject to our <a href="<?php echo U('Medical/review/agreeService');?>" style="color: gray;"  id="termUser">Terms of Use</a></p>
</div>
        </div>
    </body>
</html>
<script>
    $('#BirthYearCount').WBjsScroll();
//    $('#RaceEthnicityUL').WBjsScroll();
    $('#RaceEthnicityUL').hide();
    $('#BirthYearCount').hide();
</script>