<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></meta>
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/jquery-1.3.2.min.js"></script>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/home.js"></script>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/url.js"></script> 
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/login.js"></script> 
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/search.js"></script> 
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/placetest.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/css_clear.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/home.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/register.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/footer.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/public.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/public_search.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/hospital_search.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/doctor_search.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/search.css" media="all" />
        <script>
            $(document).ready(function() {
                buttomClick(".doctor_butSty", "doctor_produceButOn", "doctor_produceButOff");
                $("ul>li>div:first-child").click(function() {
                    $("ul>li>div:first-child").each(function() {
                        $(this).find("img").attr('src', "<?php echo ($PUBLIC); ?>/image/Medical/review/button-off_03.png");
                    });
                    $(this).find("img").attr('src', "<?php echo ($PUBLIC); ?>/image/Medical/review/button-on_03.png");
                    $("#sortType").val($(this).find(":hidden").val());
                    sortAjax($(this).find(":hidden").val(), 'Medical/sort/search', '<?php echo ($PUBLICJSURL); ?>', 4);
                })
                var arr = new Array();
                $(".scoreArr").each(function() {
                    arr.push($(this).val());
                });
                getDoctorscores(arr);
            });
            function getDoctorscores(scoreVal) {
                var endNum = scoreVal.length;
                for (var i = 0; i < endNum; i++) {
                    var score = 0;
                    if (scoreVal[i] > 5) {
                        score = 5;
                    } else {
                        score = scoreVal[i];
                    }
                    var scores = (score / 5) * 81;
                    $(".selectA").eq(i).find(".doctorLeavelDown").css("width", scores + "px");
                }
            }
        </script>
        <style>
            #writeReview:hover{
                text-decoration: underline;
            }
            #reviews:hover {
                text-decoration: underline;
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
            <!--             医生基本信息 and 综合评价 开始-->
            <div style="width: 770px; height: 46px; text-align: right; margin-top: 10px;">
                <input type="hidden" value="1" id="sortType"/>
                <!--                  处方评分-->
                <div class="right">
                    <div style=" width: 170px; " class="left">
                        <span class="TitleColor">O score:</span>
                    </div>
                    <div id="doctor_scroce_detail" class="left">
                        <span class="public_review">
                            <?php if($doctorReviewScore["review_scroce"] == ''): ?>0
                                <?php else: ?>
                                <?php echo (round($doctorReviewScore["review_scroce"])); endif; ?>

                        </span>
                        <span class="public_line"></span>
                    </div>
                </div>
            </div>
            <div style=" margin-left: 40px; " id="doctor_list">
                <div class="left" style=" width:145px;"> 
                    <div style="text-align:left">
                        <p style=" font-weight:bold; font-size: 18px; margin-top:15px; margin-bottom: 15px;padding-left: 24px;">Sort By</p>
                    </div>
                    <ul>
                        <li>
                            <div class="liFloat" style=" height: 20px; line-height: 20px;padding-top: 3px"><img src="<?php echo ($PUBLIC); ?>/image/Medical/review/button-on_03.png"/><input type="hidden" value="1"/></div>
                            <div class="liFloat listText" style="line-height: 20px;">Number of reviews </div>
                            <div style="float:left;padding-top: 5px"><img src="<?php echo ($PUBLIC); ?>/image/Medical/review/cursor_03.png"/></div>
                            <div style="clear:both"></div>
                        </li>
                        <li>
                            <div class="liFloat" style=" height: 20px; line-height: 20px;padding-top: 3px"><img src="<?php echo ($PUBLIC); ?>/image/Medical/review/button-off_03.png"/><input type="hidden" value="2"/></div>
                            <div class="liFloat listText" style="line-height: 20px; ">O score </div>
                            <div style="float:left; padding-top: 5px"><img src="<?php echo ($PUBLIC); ?>/image/Medical/review/cursor_03.png"/></div>
                            <div style="clear:both"></div>
                        </li>
                    </ul>   
                </div>

                <div class="left doctor_list">
                    <!--                 医生介绍-->
                    <div class="left " style="clear: both; margin-left: 20px; width: 170px;margin-top: 10px; margin-bottom: 10px;">
                        <span class="doctorinfobold">Name:</span>
                        <span class="doctorinfofont"><?php echo ($doctor_info["doctor_frist_name"]); ?>&nbsp;<?php echo ($doctor_info["doctor_middle_name"]); ?>&nbsp;<?php echo ($doctor_info["doctor_last_name"]); ?></span>
                    </div>
                    <!--                医生性别 科目 专业技能  工作经验 电话 邮箱 -->
                    <div  style="clear: both; margin-top: 4px;">
                        <div class="left" style=" margin-left: 20px;width: 170px; margin-bottom: 10px;">
                            <span class="doctorinfobold">Gender:</span>
                            <span class="doctorinfofont">
                                <?php if($doctor_info["doctor_gender"] == M): ?>Male
                                    <?php else: ?>
                                    Female<?php endif; ?>
                            </span>
                        </div>
                        <!--                        Location-->
                        <div class="left " style="clear: both; margin-left: 20px; width: 170px; margin-bottom: 10px;">
                            <span class="doctorinfobold">Location:</span>
                            <span class="doctorinfofont"><?php echo ($doctor_info["street_city"]); ?>&nbsp;<?php echo ($doctor_info["street_state"]); ?></span>
                        </div>
                        <!--                                        Medical_school-->
                        <?php if($doctor_info["medical_school"] != ''): ?><div class="left " style="clear: both; margin-left: 20px; width: 170px;margin-bottom: 10px;">
                                <span class="doctorinfobold">Medical_school:</span>
                                <span class="doctorinfofont"><?php echo ($doctor_info["medical_school"]); ?></span>
                            </div><?php endif; ?>
                        <!--                                            Graduation_year-->
                        <?php if($doctor_info["graduation_year"] != ''): ?><div class="left " style="clear: both; margin-left: 20px;  width: 170px;margin-bottom: 10px;">
                                <span class="doctorinfobold">Graduation_year:</span>
                                <span class="doctorinfofont"><?php echo ($doctor_info["graduation_year"]); ?></span>
                            </div><?php endif; ?>
                        <!--                                              Object-->
                        <?php if(($doctor_info["specialty"] != '')and($doctor_info["specialty2"] != '')): ?><div class="left " style="clear: both; margin-left: 20px; width: 170px; margin-bottom: 10px;">
                                <span class="doctorinfobold">speciality:</span>
                                <span class="doctorinfofont"><?php echo ($doctor_info["specialty"]); ?>
                                    <?php if(($doctor_info["specialty"] != '')and($doctor_info["specialty2"] != '')): ?>,<?php endif; ?>
                                    <?php echo ($doctor_info["specialty2"]); ?></span>
                            </div><?php endif; ?>
                        <!--                                              Telephone-->
                        <?php if($doctor_info["doctor_telephone"] != ''): ?><div class="left " style="clear: both; margin-left: 20px; width: 170px;margin-bottom: 10px;">
                                <span class="doctorinfobold">Telephone:</span>
                                <span class="doctorinfofont"><?php echo ($doctor_info["doctor_telephone"]); ?></span>
                            </div><?php endif; ?>
                    </div>
                    <div style="font-size: 12px; margin-left:20px;clear: both; ">
                        <div class="selectA"><div class="left scoreTitle">Knowledge and skills:</div><div class="left" style="position: relative;"><div class="doctorLeavelDown" style="width:9px;"></div><div class=" doctorLeavelTop" >&nbsp;</div></div><div style="clear: both"></div></div>
                        <div class="selectA"> <div class="left scoreTitle">Satisfaction of the outcome:</div><div class="left"  style="position: relative;"><div class="doctorLeavelDown" style="width:45px;"></div><div class=" doctorLeavelTop" >&nbsp;</div></div><div style="clear: both"></div></div>
                        <div class="selectA"> <div class="left scoreTitle">Easiness of appointment & waiting time: </div><div class="left"  style="position: relative;"><div class="doctorLeavelDown" style="width:45px;"></div><div class=" doctorLeavelTop" >&nbsp;</div></div><div style="clear: both"></div></div>
                        <div class="selectA"> <div class="left scoreTitle">Bedside manner:</div><div class="left"  style="position: relative;"><div class="doctorLeavelDown" style="width:45px;"></div><div class=" doctorLeavelTop" >&nbsp;</div></div><div style="clear: both"></div></div>
                        <input class="scoreArr" type="hidden" value="<?php echo ($reviewScore[0]); ?>"/>
                        <input class="scoreArr" type="hidden" value="<?php echo ($reviewScore[1]); ?>"/>
                        <input class="scoreArr" type="hidden" value="<?php echo ($reviewScore[2]); ?>"/>
                        <input class="scoreArr" type="hidden" value="<?php echo ($reviewScore[3]); ?>"/>
                    </div>
                    <!--                    review评论-->
                    <div style="  height: 26px; width: 520px;margin-top: 9px;" id="doctor_review" >
                        <div  class="right" style="margin-right: 22px;">
                            <span id="reviews" style="width: 85px; height: 26px; font-size: 16px; color:#959595; cursor: pointer;" class="" onclick="buttonchange(this)" >Reviews</span>
                            <?php if($userable == 1 ): if($doctor_info["doctor_middle_name"] != '' ): ?><span><a id="writeReview" href="<?php echo U('Medical/review/review/');?>&firstName=<?php echo ($doctor_info["doctor_frist_name"]); ?>&middleName=<?php echo ($doctor_info["doctor_middle_name"]); ?>&lastName=<?php echo ($doctor_info["doctor_last_name"]); ?>&zipCode=<?php echo (substr($doctor_info["street_zip"],0,5)); ?>&back=yes" style="color: #959595; font-size: 16px; margin-left: 21px;">Write&nbsp;&nbsp;a&nbsp;&nbsp;&nbsp;review</a></span>
                                    <?php else: ?>
                                    <span><a id="writeReview" href="<?php echo U('Medical/review/review/');?>&firstName=<?php echo ($doctor_info["doctor_frist_name"]); ?>&lastName=<?php echo ($doctor_info["doctor_last_name"]); ?>&zipCode=<?php echo (substr($doctor_info["street_zip"],0,5)); ?>&back=yes" style="color: #959595; font-size: 16px; margin-left: 21px;">Write&nbsp;&nbsp;a&nbsp;&nbsp;&nbsp;review</a></span><?php endif; ?>
                                <?php else: ?>
                                 <span><a id="writeReview" href="javascript:void(0)" onclick="nologin()" style="color: #959595; font-size: 16px;">Write&nbsp;&nbsp;a&nbsp;&nbsp;&nbsp;review</a></span><?php endif; ?>
                        </div>
                    </div>
                    <!--                    review 内容-->
                    <div class="doctor_review_list" id="doctor_review_list" style="display: none; height: 107px;">
                        <?php if($doctor_review["commect_review"] == null ): ?><div style="text-align: center; margin-top: 75px; font-size: 20px;height: 75px;">
                                No review now
                            </div>
                            <?php else: ?>
                            <div style="margin-left: 20px;margin-top: 10px;color: #acabab;word-break:break-all;font-size: 12px;">
    <?php echo (strreviewmax($doctor_review["commect_review"])); ?>
</div>
<div style="margin-left: 20px;margin-top: 10px;height: 40px"></div>
<div style="font-size: 12px;margin-left: 5px;margin-top: 8px;position: relative; " id="review_list_like">
    <div id="doctor_like" class="left" style=" width: 370px;">

        <?php if($doctor_review["produre_reviewlike"] == 1 ): ?><span style="line-height: 23px;color: #848484; display: inline-block;width: 70px; margin-left: 2px" class="left">comment</span> 
            <span style="line-height: 22px;color:#323232;display: inline-block; " class="left">Was this review helpful for you? </span>
            <span class="left" style=" display: inline-block; width:70px; line-height: 22px;" id="review_like_yn">
                <span class="review_like" style=" text-align: center; line-height: 22px;" onclick="doctorLike('<?php echo ($doctor_review["review_id"]); ?>', 1, 'normal')">Yes</span>
                <span class="review_like" style=" text-align: center;line-height: 22px;" onclick="doctorLike('<?php echo ($doctor_review["review_id"]); ?>', 0, 'normal')">No</span>
            </span>
            <?php else: ?>
            &nbsp;<?php endif; ?>
    </div>
    <?php echo ($doctor_review["review_page"]); ?>
</div><?php endif; ?>
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div id="ajaxfield" style=" margin-left: 85px; margin-top: 10px; overflow: hidden;">
              <!--            医疗项目开始-->
<div class="left" style="  color: #acabab; margin-left: 20px; width: 137px; "></div>
<div style="width: 535px;" class="left">
    <?php if(is_array($doctor_procedure)): foreach($doctor_procedure as $k=>$vo): ?><div id="doctor_produce_<?php echo ($k); ?>">
            
            <div class=" produce_doctor" style=" margin-top: 10px;" id="produce_doctor_<?php echo ($k); ?>">
                <div class="doctor_produce_title">
                    <?php if($vo["procedure_other_name"] == '' ): echo (strdoctordefined($vo["produre_name"],50)); ?>
                        <input type="hidden" name="doctor_procedure_<?php echo ($k); ?>" id="doctor_procedure_<?php echo ($k); ?>" value="<?php echo ($vo["produre_name"]); ?>" />
                        <?php else: ?>
                        <?php echo (strdoctordefined($vo["procedure_other_name"],50)); ?>
                        <input type="hidden" name="doctor_procedure_<?php echo ($k); ?>" id="doctor_procedure_<?php echo ($k); ?>" value="<?php echo ($vo["procedure_other_name"]); ?>" /><?php endif; ?>
                    <!--                                        <?php echo ($vo["procedure_other_name"]); ?>-->
                </div>
                <!--                                <div class="doctor_produce_info">
                                                    <?php echo (strreviewmax($vo["produre_info"])); ?>
                                                </div>-->
                <div style="margin-bottom: 10px;font-size: 14px; margin-top: 20px;"><span class="doctor_produce_title" style="font-size: 16px; display: block;width: 100px; margin-top: 0px; float: left;">Reviews:</span><span class=" doctor_produce_info" style="margin-left: 5px; font-size: 15px;"> <?php echo ($vo['review_content_number']); ?></span></div>
                <div style="float:left;font-size: 14px;"><span class="doctor_produce_title" style="font-size: 16px; width: 100px; display: block; float: left; position: absolute; margin-left: 10px; margin-top: 0px;">Score:</span><span class=" doctor_produce_info" style="margin-left: 115px; font-size: 15px"> <?php echo (round($vo['produre_scores'])); ?></span></div>
                <div class="doctor_produce_image" style="margin-top: 0" onclick="reviewproduceDisplay('<?php echo ($k); ?>')" ><div class="doctor_butSty doctor_produceButOff"></div></div>
            </div>
            <div class="doctor_review_list_like" style="font-size: 12px;margin-top: 8px; width: 555px; margin-left: -53px;position: relative; display: none; border: 1px solid #5b5b5b;border-radius: 5px; " id="produce_doctor_review_list_like_<?php echo ($k); ?>">
                <?php if($vo["commect_review"] == '' ): ?><div style="text-align: center; margin-top: 75px; font-size: 20px;">
                        No review now
                    </div>
                    <?php else: ?>
                     <div style="margin-left: 20px;margin-top: 10px;color: #acabab; font-size: 12px;">
    <?php echo ($vo['commect_review']); ?>
</div>
<div style="margin-top: 20px;"></div>
<div class="doctor_like_produce left"  id="doctor_produce_list_<?php echo ($k); ?>" >
    <?php if($vo["produre_reviewlike"] == 1 ): ?><span style="line-height: 23px;color: #848484; display: inline-block;width: 70px; margin-left: 2px" class="left">comment</span> 
        <span style="line-height: 22px;color:#323232;display: inline-block; " class="left">Was this review helpful for you?</span>
        <span class="left" style=" display: inline-block;width:70px; line-height: 22px;" id="review_like_yn">
            <span class="review_like" style=" text-align: center; line-height: 22px;" onclick="doctorLike('<?php echo ($vo["review_id"]); ?>', 1, 'doctor:produce:<?php echo ($k); ?>')">Yes</span>
            <span class="review_like" style=" text-align: center;line-height: 22px;" onclick="doctorLike('<?php echo ($vo["review_id"]); ?>', 0, 'doctor:produce:<?php echo ($k); ?>')">No</span>
        </span>
        <?php else: ?>
        &nbsp;<?php endif; ?>
</div>
<?php echo ($vo["page"]); endif; ?>
            </div>
        </div><?php endforeach; endif; ?>
</div>
              </div>
            <div>
                <div style="clear: both; height: 20px;"></div>
<div class="footer">
    <p  style=" padding-top: 30px; padding-left: 30px;font-size: 12px; ">Copyright @ 2013, Transparent Medical Care. All Rights Reserved. Your use of this service is subject to our <a href="<?php echo U('Medical/review/agreeService');?>" style="color: gray;"  id="termUser">Terms of Use</a></p>
</div>
            </div>
        </div>
    </body>
</html>