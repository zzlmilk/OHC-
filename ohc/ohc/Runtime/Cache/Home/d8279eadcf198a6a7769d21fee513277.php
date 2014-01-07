<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></meta>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/jquery-1.3.2.min.js"></script>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/url.js"></script>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/home.js"></script>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/login.js"></script>
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/checkword.js"></script> 
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/effect.js"></script> 
        <script  type="text/javascript" src="<?php echo ($PUBLIC); ?>/js/placetest.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/css_clear.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/home.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/register.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/footer.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/public.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/search.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/public.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo ($PUBLIC); ?>/css/login.css" media="all" />      
        <!--[if lt IE 9]> 
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> 
        <![endif]--> 

        <script>
            $(function() {
                var WebsitePublic = '<?php echo ($PUBLIC); ?>';
                setpublic(WebsitePublic);
            })
            //搜索下拉框 变线
            $(function(){
                $("#search_type li").click(function(){
                    $("#search_type").css({"border":"none"});
                })
                $("#search_background").click(function(){
                    $("#search_type").css({"border-right":"solid 1px #848484"});
                    $("#search_type").css({"border-left":"solid 1px #848484"});
                    $("#search_type").css({"border-bottom":"solid 1px #848484"});             
                })
            })
           
        </script>
    </head>
    <body >
        <div  id="bodydiv"  class="bodydiv" style="position: relative;">
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

            <div id="Theme_background"  style="padding-top: 20px;background:url(public/image/Home/Index/<?php echo ($images); ?>)  no-repeat scroll 0 0 transparent;">
                <form action="<?php echo U('Medical/index/search');?>"  method="post" id="formcode" name="formcode">
                    <div class="body_search"  id="body_search"  style=" position: relative; ">
                        <span style=" display: block;width: 680px;  margin-left: 12px; padding-top: 12px; position: relative;">
                            <input type="hidden" name="searching" id="searching"  value="">
                                <span  style="float: left; display: block; width: 133px; ">
                                    <span id="search_background" onclick="list()"style="display: block; font-size:12px; text-align: left; font-size:14px; padding-left:22px;background-repeat:no-repeat; height:36px; line-height: 36px;" class="search_background">
                                        Doctors
                                    </span>
                                    <ul id="search_type" class="search_type" style="display: none;border-top:none; margin-left:0px; width:123px;">
                                        <li id="type_1" onclick="listAction(1, 'Doctors')">Doctors</li>
                                        <li id="type_2" onclick="listAction(2, 'Institutions')">Institutions</li>
                                        <li id="type_3" onclick="listAction(3, 'Procedures')">Procedures</li>
                                    </ul>
                                </span>  
                                <input type="hidden" name="location_type" id="location_type" value="<?php echo ($search_contion["location_type"]); ?>" />
                                <input type="hidden" name="location_code" id="location_code" value="<?php echo ($search_contion["search_text_location_hidden"]); ?>" />
                                <span style="position: relative; left:9px; overflow: hidden; width: 205px; height: 36px; display: block; float: left; "   onkeydown="KeyDown(event,'search')" id="search_text_span"><input type="text" name="search_text"  autocomplete="off" id="search_text" class="search_text"  style="position: relative; color: gray; " placeholder="Doctor name, e.g., John Smith" /></span>
                                <input type="hidden" name="search_text_id" id="search_text_id"/>
                                <input type="text" name="search_text_location"  autocomplete="off" id="search_text_location" class="search_text"   onkeydown="KeyDown(event,'search')"  style=" margin-left: 10px; width:177px;width:178px \0\9; width:178px \0; float: left;border-top-right-radius:0px;border-bottom-right-radius:0px; " placeholder="location, e.g., a zip code or city"/>

                                <input name="search_text_location_hidden" id="search_text_location_hidden" type="hidden" value="t"/>
                                <span style=" width: 55px; height: 35px; display: block; position: absolute;left: 535px; top: 12px;cursor: pointer;left: 537px \0\9;" onclick="ajaxSearch('Home/Ajax/locationcode', '<?php echo ($PUBLICJSURL); ?>')">
                                    <img id="img_search" src="<?php echo ($PUBLIC); ?>/image/Home/Index/search_03.png"width="100%" height="100%"/>
                                </span>
                                <ul id="autocomplete_city" class="autocomplete"></ul>
                                <span id="font_advanced"  style="position: absolute; left:612px;top:26px;font-size: 12px;  color:#525353;cursor: pointer;" onclick="formReset('body_search', 'advanced_search')">
                                    Advanced
                                </span>
                                <div style="clear: both; position: absolute; top: 12px; left: 133px;border-left: 2px solid #D3D3D3; height: 36px; width: 1px; position: absolute;">&nbsp;</div>
                        </span>
                    </div>
                    <!--                    <a id="font_WriteAReview" href="<?php echo U('Home/Index/viewbody');?>">viewbody</a>-->
                    <!--                 高级搜索开始-->
                    <div id="advanced_search" style="position:relative; ">
                        <input type="hidden" name="search_advanced_type" id="search_advanced_type" value="0"/>
                        <div style=" height: 20px;"></div>
                        <div style=" color: #969696; width: 702px; margin-left: 49px;font-size: 18px; ">Please specify a combination of two or more searching criteria from below:</div>
                        <div id="advanced_search_div" style="position: relative; height:79px; overflow:hidden;">
                            <div id="advanced_doctorAndhospital" style=" color: #898D90">
                                <div   class="left">
                                    <span class="left advanced_frist" >Doctor</span>
                                    <span  class="left" style=" position: relative;">

                                        <span  class='searchTextStyle advanced_background'>
                                            <input  id="doctor_search_text"  onkeydown="KeyDown(event,'advancedsearch')" type="text" name="doctor_search_text"value="" autocomplete="off"  placeholder="Doctor name, e.g., John Smith"  />
                                        </span>
                                    </span>
                                </div>

                                <div  class="left" >
                                    <span  class="left advanced_seconed" style="">At this institution</span>
                                    <span  class="left" style=" position: relative;">
                                        <span class='searchTextStyle advanced_background'>
                                            <input  id="hospital_search_text"  type="text"  onkeydown="KeyDown(event,'advancedsearch')" name="hospital_search_text" value="" autocomplete="off"  placeholder="Institutions eg John Smith"/>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div style="clear: both; height: 1px;"></div>
                            <div  id="advanced_procedureAndlocation" style=" position: relative;">
                                <div  class="left">
                                    <span  class="left advanced_frist" >Procedure’s </span>
                                    <span  class="left" style=" position: relative;">
                                        <span  class='searchTextStyle advanced_background'>
                                            <input  id="procedure_search_text"  type="text" onkeydown="KeyDown(event,'advancedsearch')" name="procedure_search_text" value="" autocomplete="off"  placeholder="Procedures eg John Smith"/>
                                        </span>
                                    </span>
                                </div>
                                <div class="left">
                                    <span class="left advanced_seconed" >Location:</span>
                                    <span class="left" style=" position: relative;" >
                                        <span  class='searchTextStyle advanced_background'>
                                            <input id="location_search_text"  type="text" onkeydown="KeyDown(event,'advancedsearch')" name="location_search_text"value="" autocomplete="off"  placeholder="location, e.g., zip code or city" />
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                        <div id="advanced_button_div">
                            <span id="advanced_button" onclick="advancedAjaxSearch()" style=" margin-left:-26px;">&nbsp;</span>
                            <span id="font_reset" style=" margin-left: 91px; *margin-top:23px; width: 45px;" onclick="formReset('advanced_search_div', '1')">Reset</span>
                            <!--                                                        竖线下-->
                            <span id="font_cancel" style=" text-align: center;width: 92px;margin-left:169px;*margin-left:166px; margin-top:-18px; *margin-top:-18px; border-left: solid 2px #ccc; height: 20px;"  onclick="formReset('advanced_search', 'body_search')">
                                Cancel 
                            </span>
                        </div>
                        <ul id="autocompleteadvanced_city" class="autocomplete" style=" left:485px; top:115px; *left:470px; "></ul>
                        <!--                        竖线上-->
                        <div style=" border-left: 2px solid #ccc;height: 75px; left: 339px;*left: 335px;position: absolute;top: 43px; width: 1px; "></div>
                    </div>
                </form>
            </div>
            <div  class="error_search" id="search_result" style="  display: none;position: absolute;  font-size: 13px; background-color: white;">
                <div class="user_login_close"></div>
                <div>
                    <p id="search">
                        Sorry! No Search  results !
                    </p>
                </div>
            </div>
            <!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
        
        <style>
            #docName:hover{
                text-decoration: underline;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div style=" color:#1E1E1E; text-indent: 10px; font-size: 13px;">
            <div id="vb_action" style="margin-top: -10px; height: 183px;">              
                <div id="left_action">
                    <p id="left_font">Membership status </p>
                    <div style=" margin-top: 30px;">
                        <div class="show_name_review">User Name:</div> <p class="p_username_review"><?php echo ($user_name); ?></p>
                        <div class="show_name_review">Review:</div><p class="p_username_review"><?php echo ($reviewCount); ?></p>
                    </div>
                </div>
                <div id="right_action" style="margin-left: 1px;">
                    <div id="btn1_img">Featured&nbsp;&nbsp;Review</div>
                    <div>
                        <div class="txar_Rview" style="width: 795px; border-radius: inherit;">
                            <div id="doctor_name">
                                <div id='doctor_name_ex'  style='height: 84px; margin-left: 20px; font-size: 14px;'>
                                    <?php if(is_array($doctor_review)): foreach($doctor_review as $key=>$doctor_review_data): ?><a href="javascript:void(0)"style="color: #696969;">
                                            doctor_name:<a id="docName"  onclick="searchCustom('1','<?php echo ($doctor_review_data["doctor_info"]["doctors_id"]); ?>','<?php echo ($doctor_review_data["doctor_info"]["doctors_frist_name"]); ?> <?php echo ($doctor_review_data["doctor_info"]["doctor_middle_name"]); ?> <?php echo ($doctor_review_data["doctor_info"]["doctors_last_name"]); ?>','<?php echo ($doctor_review_data["doctor_info"]["city_location"]); ?> <?php echo ($doctor_review_data["doctor_info"]["state"]); ?>','')" > <?php echo ($doctor_review_data["doctor_info"]["doctors_frist_name"]); ?> <?php echo ($doctor_review_data["doctor_info"]["doctor_middle_name"]); ?> <?php echo ($doctor_review_data["doctor_info"]["doctors_last_name"]); ?> </a>
                                        </a><?php endforeach; endif; ?>   
                                    <?php if(is_array($doctor_review)): foreach($doctor_review as $k=>$doctor_review_data): if(is_array($doctor_review_data["doctor_info"]["review"])): foreach($doctor_review_data["doctor_info"]["review"] as $data_k=>$review_data): ?><div id="doctor_name_con"  style="margin-top: 12px;">
                                                <?php echo ($data_k+1); ?>.<?php echo ($review_data); ?>
                                            </div><?php endforeach; endif; endforeach; endif; ?> 
                                </div>      
                                <div id="fenye1_w"> <div id="page1" style=" margin-left: 558px;"><?php echo ($review_page); ?></div></div>

                            </div>
                        </div>
                        <div id="btn2_img">Featured Article from Our Forum</div>
                        <div>
                            <div class="txar_Rview" id="forum_review" style="width: 795px;">
                                <div  style='height: 70px; margin-left: 20px; '>
                                    <?php if(is_array($forum_data)): foreach($forum_data as $forum_k=>$forum_result): ?><div id="txar_review_con1">
                                            <a href="<?php echo U('forum/forum/forumTopic',array('id'=>$forum_result['forum_id']));?>" style="color: #696969">
                                                <?php echo ($forum_k+1); ?>:
                                                <?php echo ($forum_result["title"]); ?><br />
                                                <?php echo ($forum_result["forum_id"]); ?>
                                            </a>
                                        </div>
                                        <div id="reply_question">
                                            <?php if(($forum_result["able"] == 1)): ?>提的问题...
                                                <?php else: ?>
                                                回复问题...<?php endif; ?>
                                        </div>
                                        <div id="txar_review_con2" style="width: 500px;"><?php echo ($forum_result["forum_content"]); ?></div><?php endforeach; endif; ?>   
                                </div>
                                <div id="fenye_w"> <div id="page2" style=" margin-left: 560px;"><?php echo ($forum_page); ?></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>-->

            <!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style>
            .Paragraph{
                margin: 10px 0 10px 0;
                line-height: 15px;
            }
            .fiveRows{
                padding-left: 37px;
            }
        </style>
    </head>
    <body>
        <div style=" border: solid 1px #696969; width: 795px; margin-left: 2px; color:#1E1E1E; text-indent: 10px; font-size: 13px;">

            <div class="Paragraph">
                <div> Welcome to the "yelp" for patients. We are the first website that allows patients or users to review on both "quality" and "cost" of</div>
                <div>medical services! And it is also free!</div> 
            </div>
            <div class="Paragraph">
                <div>You can write and share reviews on various medical services you have received, such as a doctor visit or a medical</div>
                <div>operation/procedure, from the perspectives of</div>
            </div>
            <div class="Paragraph fiveRows">
                <div>Ease of appointment and waiting time,</div>
                <div>Bedside manner,</div>
                <div>Knowledge and skills of the provider,</div>
                <div>Satisfaction of the outcome,</div> 
                <div>and COST</div>
            </div>

            <div class="Paragraph">
                <div>Given enough patients share their experiences transparently, this website will make your medical decision as easy as ordering in a</div>
                <div> restaurant because you know what choices you have. More than that, you can make the smartest decision even before walking</div>
                <div>into a clinic or hospital.</div>
            </div>

            <div class="Paragraph">Simply start today by signing up!</div>
        </div>
    </body>
</html>

            <div style="clear: both; height: 20px;"></div>
<div class="footer">
    <p  style=" padding-top: 30px; padding-left: 30px;font-size: 12px; ">Copyright @ 2013, Transparent Medical Care. All Rights Reserved. Your use of this service is subject to our <a href="<?php echo U('Medical/review/agreeService');?>" style="color: gray;"  id="termUser">Terms of Use</a></p>
</div>
        </div>
    </body>
</html>