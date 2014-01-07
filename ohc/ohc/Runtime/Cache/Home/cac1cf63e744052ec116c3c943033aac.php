<?php if (!defined('THINK_PATH')) exit();?><div class="main_mask" id="main_mask">
    <div id ="login"  class="loginBoxShdow " style="*position: absolute;*top:30px; *left:450px;">
        <div class="user_login_close" onclick="$('#main_mask').remove();"></div>
        <div style=" width:220px;margin: 0 auto; padding-top: 54px;">
            <div style="width:210px; top:-12px; position: relative;">
                <img src="<?php echo ($PUBLIC); ?>/image/Home/Login/word.gif"  width ="100%"/>
            </div>
        </div>
        <!--              用户框和密码框   -->
        <div style=" width: 375px;margin: 0 auto; padding-top: 20px;">
            <div id="EmailAndPassword"  class="EmailAndPasswordBoxShaow">
                <div style="width: 260px; margin: 0px auto;  padding-top: 20px;">
                    <div id="user_email_bg">
                        <div style=" width: 220px;">   
                            <input id="user_email"  onkeydown="KeyDown(event, 'login')"  type="text" placeholder="<?php echo (L("loginStatus_0004")); ?>" onfocus="$('#loginStatus').html('')"/>
                        </div>
                    </div>
                    <div id="user_password_bg">
                        <div style=" width: 220px; padding-top: 17px;">
                            <input id="user_password"  onkeydown="KeyDown(event, 'login')" type="password" class="user_password" placeholder="<?php echo (L("loginStatus_0005")); ?>" onfocus="$('#loginStatus').html('')" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--            登录提示框-->
        <div  style=" width: 100%;height: 33px;">
            <span  style="padding-left: 60px; color: red; position: relative;top: 10px;" id="loginStatus">
            </span> 
        </div>
        <!--            登录按钮 提示框-->
        <div  id ="buttondiv" style=" width: 305px; height: 67px; padding-left: 57px;position: relative; cursor: pointer;" class="">
            <button  onclick="UserLogin('Home/Ajax/userLogin', '<?php echo ($PUBLICJSURL); ?>')"  id="button" class="buttonImage" type="button" style=" position: relative;width:113%; margin-left: -16px; height:63px;">
                <span  style="color: white; font-weight: bold; font-size: 28px;">Login</span>
            </button>
        </div>
        <!--            LOST  your-->

        <div  style="  padding-left: 75px;">
            <font><a id="ForgotPassword" style="color: #737375;text-decoration: none; position: relative; top:20px; font-size: 16px; display: block; word-spacing: 4px; width: 343px; margin-left: -32px; font-weight: bold;  text-decoration:none;" href="<?php echo U('User/info/lostpasswordEmail');?>"><?php echo (L("loginStatus_0006")); ?></a></font>
        </div>
    </div>
</div>