<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="<?php echo ($PUBLIC); ?>/js/jquery-1.3.2.min.js"></script>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/url.js"></script>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/home.js"></script>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/login.js"></script> 
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/placetest.js"></script>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/search.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/css_clear.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/home.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/footer.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/register.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/public.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/viewbody.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/search.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/setting.css" media="all" />
        <script>
            $(function() {
                var re = $('#right_action').html();
                $('#right_action').html(re.replace(/<br(\s+)?\/?>(\s+)?/gi, ''));
            })
        </script>
        <style>
            #docName:hover{
                text-decoration: underline;
                cursor: pointer;
            }
        </style>
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
                    <div style=" height: 30px;">
                        &nbsp;
                    </div>
                    <div  style=" width: 597px;border-top:solid 2px #ccc; border-left: solid 2px #ccc; height: 464px;border-right: solid 1px #837D7D; border-bottom: solid 1px #B9B6B6;box-shadow: 1px 1px 0px #ccc;margin-left: -28px; margin-top: -27px; padding-left: 20px;" id="setting_body">
                        <div id="vb_action">              
                            <div style=" text-align: left;">
                                <div class="show_name_review">User Name:<?php echo ($user_name); ?></div>
                                <div class="show_name_review">Review:<?php echo ($reviewCount); ?></div>
                                <div>
                                    <p id="left_font">Membership status:
                                        <?php if($email_activation == 0 ): ?>Trial account. Please activate your account following the email TransparentMedicalCare has sent to you.
                                            <?php elseif($user_path == 0): ?>
                                            Trial account. You can share a review to upgradte to an official user with unlimited access!
                                            <?php else: endif; ?>   
                                    </p>
                                </div>
                            </div>
                            <div id="right_action"  style=" margin: 0;">
                                <div id="btn1_img">Your&nbsp;&nbsp;Review</div>
                                <div>
                                    <div class="txar_Rview">
                                        <div id="doctor_name">
                                            <div id='doctor_name_ex'  style='height: 84px; margin-left: 20px;font-size: 14px;'>
                                                <?php if(is_array($doctor_review)): foreach($doctor_review as $key=>$doctor_review_data): ?><a href="javascript:void(0)"  style="color: #696969;">
                                                        doctor_name: <a id="docName"onclick="searchCustom('1', '<?php echo ($doctor_review_data["doctor_info"]["doctors_id"]); ?>', '<?php echo ($doctor_review_data["doctor_info"]["doctors_frist_name"]); ?> <?php echo ($doctor_review_data["doctor_info"]["doctor_middle_name"]); ?> <?php echo ($doctor_review_data["doctor_info"]["doctors_last_name"]); ?>', '<?php echo ($doctor_review_data["doctor_info"]["city_location"]); ?> <?php echo ($doctor_review_data["doctor_info"]["state"]); ?>', '')"><?php echo ($doctor_review_data["doctor_info"]["doctors_frist_name"]); ?> <?php echo ($doctor_review_data["doctor_info"]["doctor_middle_name"]); ?> <?php echo ($doctor_review_data["doctor_info"]["doctors_last_name"]); ?> </a>
                                                    </a><?php endforeach; endif; ?>   
                                                <?php if(is_array($doctor_review)): foreach($doctor_review as $k=>$doctor_review_data): if(is_array($doctor_review_data["doctor_info"]["review"])): foreach($doctor_review_data["doctor_info"]["review"] as $data_k=>$review_data): ?><div id="doctor_name_con" >
                                                            <?php echo ($data_k+1); ?>.<?php echo ($review_data); ?>
                                                        </div><?php endforeach; endif; endforeach; endif; ?> 
                                            </div>      
                                            <div id="fenye1_w"> <div id="page1"><?php echo ($review_page); ?></div></div>

                                        </div>
                                    </div>
                                    <div id="btn2_img">Your Article from Our Forum</div>
                                    <div>
                                        <div class="txar_Rview" id="forum_review">
                                            <div  style='height: 70px; margin-left: 20px; '>
                                                <?php if(is_array($forum_data)): foreach($forum_data as $forum_k=>$forum_result): ?><div id="txar_review_con1">
                                                        <a href="<?php echo U('forum/forum/forumTopic',array('id'=>$forum_result['forum_id']));?>" style="color: #696969">
                                                            <?php echo ($forum_k+1); ?>:
                                                            <?php echo ($forum_result["title"]); ?><br />
                                                            <?php echo ($forum_result["forum_id"]); ?>
                                                        </a>
                                                    </div>
                                                    <div id="reply_question">
                                                        <?php if(($forum_result["able"] == 1)): ?>post...
                                                            <?php else: ?>
                                                            reply...<?php endif; ?>
                                                    </div>
                                                    <div id="txar_review_con2"><?php echo ($forum_result["forum_content"]); ?></div><?php endforeach; endif; ?>   
                                            </div>
                                            <div id="fenye_w"> <div id="page2"><?php echo ($forum_page); ?></div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div style="clear: both; height: 20px;"></div>
<div class="footer">
    <p  style=" padding-top: 30px; padding-left: 30px;font-size: 12px; ">Copyright @ 2013, Transparent Medical Care. All Rights Reserved. Your use of this service is subject to our <a href="<?php echo U('Medical/review/agreeService');?>" style="color: gray;"  id="termUser">Terms of Use</a></p>
</div>
        </div>
    </body>
</html>