<?php

class infoAction extends Action {

    public function setting() {
        /**
         * 判断传递过来的值 如等于1的时候  则进行修改方法
         */
        if (!empty($_REQUEST['settingupdateNow']) && $_REQUEST['settingupdateNow'] == 1) {
            $this->settingUpdate();
        }
        $this->settingUserInfo(); //获取用户信息
        $this->display();
    }

    /**
     * 
     */
    public function settingUserInfo() {
        //根据id记录session  判断是用户登录时 进入setting 页面 则不需要重新记录session
        if ($_SESSION['user_id'] > 0) {
            $user_id = $_SESSION['user_id'];
            $souce = 0;
        }
        if ($_REQUEST['id'] > 0) {
            $user_id = $_REQUEST['id'];
            $souce = 1;
        }
        $Info = D('User')->getUserById($user_id);  //获取用户内容
        $InfoConfig = D('UserInfo')->getUserInfoByuserid($user_id);
        if ($souce == 1) {  //当页面是从邮箱激活中来的时候 将字段记录 如已经激活 则 跳错误
            if ($Info['email_activation'] == 1) {
            } else {
                $this->sessionuser($Info);
                $data['email_activation'] = 1;
                D('User')->updateUserState($data);
                $this->assign('activation', 1);
                $this->assign('success', 1);
            }
        } 
        $this->assign('user', $Info);
        $this->assign('userconfig', $InfoConfig);
    }

    /*
     *  用户 信息修改 
     */

    public function settingUpdate() {
        //判断是否输入新的email   如果输入的是EMAIL 检查是否已经被人填写 查找非本人的
        $UserInfo = D('User')->getUserById();
        if (!empty($_REQUEST['newemail'])) {
            if ($_REQUEST['newemail'] != $UserInfo['user_email']) {
                $User['user_email'] = $_REQUEST['newemail'];
            }
        }
        if ($_REQUEST['email_path'] == 1) {  //邮箱激活
            $data['email_activation'] = 1;
            D('User')->updateUserState($data);
            $activation = 1;
        } else {
            $activation = 0;
        }
        //判断输入的旧密码是否为数据库的旧密码  新密码 2次 是否输入正确  
        if (!empty($_REQUEST['settingpassword']) && !empty($_REQUEST['settingrepassword'])) {
            $User['user_pass'] = $_REQUEST['settingpassword'];
        }
        //用户修改基本配置
        $userInfo = D('UserInfo');
        $userInfo->updateUserInfoByUserId($User);
        if ($userInfo->save == 1) {
            $this->assign('activation', $activation);
            $this->assign('success', 1);
        }
    }

    public function userLogout() {
        if ($_SESSION['user_id'] > 0) {
            session_destroy();
        }
    }

    /**
     * 修改用户 密码
     */
    public function updatePassword() {
        $password = $_REQUEST['lostpassword'];
        $email = $_REQUEST['email'];
        if (!empty($email) && !empty($password)) {
             if (preg_match("/^(\w+([+!~=^#-<>.]\w+)*@\w+([.-]\w+)*[.][a-zA-Z]{2,9})?$/", $email)) {
                $state =  D('User')->updatePasswordByEmail($email, $password);
                if($state){
                    $this->assign('state',1);
                    $this->display('LostPassword');
                }
             }
        }
    }
    /**
     * 验证 找回密码中 填写的EMAIL 是否存在
     */
    public function passwordEmail() {
        $email = $_REQUEST['email'];
        if (!empty($email)) {
            if (preg_match("/^(\w+([+!~=^#-<>.]\w+)*@\w+([.-]\w+)*[.][a-zA-Z]{2,9})?$/", $email)) {
                //验证是否为邮箱格式
                 $userInfo = D('User')->getUserInfoByEmail($email);
                 if($userInfo['user_id'] > 0 ){
                     $EmailSendAble = $this->sendErrorEmail($email);
                     if($EmailSendAble == 1){
                         echo '1';
                         die;
                     } else{
                         echo '0';
                         die();
                     }
                 } else{
                     echo L('register_0001');
                     die;
                 }
            } else {
                echo L('register_0001');
                die;
            }
        }
    }
    /**
     * 发送忘记密码  邮件
     */
    public function sendErrorEmail($email) {
        /**
         * 获取用户信息
         */
        if(!empty($email)){
            if (preg_match("/^(\w+([+!~=^#-<>.]\w+)*@\w+([.-]\w+)*[.][a-zA-Z]{2,9})?$/", $email)) {
                 $userInfo = D('User')->getUserInfoByEmail($email);
             }
        }
        /**
         * MD5 标识
         */
        if ($userInfo['user_id'] > 0) {
            $parent = 'erroremail';
            global $PUBLICJSURL;
            import('ORG.Email'); //导入邮件类
            $md5 = md5($email . $parent);
            $data['mailto'] = $email; //收件人
            $data['subject'] = 'Changing your password';
            $changePassword = $PUBLICJSURL . '?g=User&m=info&a=LostPassword&id=' . $userInfo['user_id'] . '&verify=' . $md5; 
            $data['body'] = '<html>
             <body>
             <div style="">
             Hello! '.$userInfo['user_name'].'
             <br /><br />
             We have received your request to reset your password at Transparentmedicalcare.com. Please click the following link to create a new password:
             <br /><br />
             <a href="' . $PUBLICJSURL . '?g=User&m=info&a=LostPassword&id=' . $userInfo['user_id'] . '&verify=' . $md5 . '">' . $PUBLICJSURL . '?g=User&m=info&a=LostPassword&id=' . $userInfo['user_id'] . '&verify=' . $md5 . '</a>
             <br />
             Sincerely,
             <br /><br />
             Transparent Medical Care
             <br /><br />
             P.S: If the above url doesn’t work, please copy and paste it into your browser manually.
             </div>
             </body>
             </html>';
            $mail = new Email();
            $id = $mail->send($data);
            if($id){
                return 1;
            } else{
                return 0;
            }
        }
    }

    /**
     * 找回密码页面
     */
    public function LostPassword() {
        $parent = 'erroremail';
        if (!empty($_REQUEST['id']) && !empty($_REQUEST['verify'])) {
            $userInfo = D('User')->getUserById($_REQUEST['id']);
            if ($userInfo['user_id'] > 0) {
                $newMd5 = md5($userInfo['user_email'] . $parent);
                if ($newMd5 == $_REQUEST['verify']) {
                    $this->assign('email',$userInfo['user_email']);
                    $this->display();
                }
            }
        }
    }
    /**
     * 忘记密码  填写邮箱界面
     */
    public function lostpasswordEmail(){
        $this->display();
    }

}

?>