<?php

// OHC 网站首页
class registerAction extends Action {

    public function index() {

        $this->display();
    }

    public function register_next() {
        $this->display('success');
    }

    public function register_reviewnext() {
        $this->assign('review', 1);
        $this->display('success');
    }

    public function userregister() {  //激活邮件
        //获取用户邮件验证表的内容
        $id = $_REQUEST['id'];
        $result = M('ohc_user')->where('user_id = ' . $id)->find();
        //验证MD5 是否相同
        $md5 = md5($id . $result['user_email'] . $result['user_pass']);
        if ($md5 == $_REQUEST['vecity']) {
            $this->assign('user_id', $id);
            $this->display();
        } else {
            echo 'MD5错误';
        }
    }

    //验证用户名 等  是否大于21个字符 
    //验证email与密码
    public function checkNickName() {
        $userInfo = M('ohc_user');
        if (!empty($_REQUEST['username'])) {  //判断用户名是否存在 存在判断用户名是否大于12个字符 如果大于跳错误提示 否则插入数据
            $result = M('ohc_user')->where('user_name like "' . $_REQUEST['username'] . '"')->find();
            if (count($result) > 0) {
                echo L('register_0015');
                die;
            }
            if (strlen($_REQUEST['username']) > 12) {
                echo L('register_0011');
                die;
            } else {
                echo 1;
                die;
            }
        } else {
            echo L('register_0012');
            die;
        }
    }

    /**
     * 验证邮箱 
     */
    public function checkEmail() {
        //验证邮箱是否已经被人注册
        if (!empty($_REQUEST['email'])) {
            $email = $_REQUEST['email'];
            $result = M('ohc_user')->where('user_email like "' . $email . '"')->find();
            if (count($result) == 0) {  //邮箱未注册
                if (preg_match("/^(\w+([+!~=^#-<>.]\w+)*@\w+([.-]\w+)*[.][a-zA-Z]{2,9})?$/", $email)) {
                    //验证是否为邮箱格式
                    echo 1;
                    die;
                } else {
                    echo L('register_0001');
                    die;
                }
            } else {
                echo L('register_0002');
                die;
            }
        } else {
            echo L('register_0017');
            die;
        }
    }

    public function checkPassword() {
        //验证2次密码 是否一致  
        if (!empty($_REQUEST['password'])) {
            if (strlen($_REQUEST['password']) < 6) {
                echo L('register_0004');
                die;
            } else {
                echo 1;
                die;
            }
        } else {
            echo L('register_0014');
            die;
        }
    }

    /**
     * 验证二次输入密码  如密码和前面次密码 不相同 则提示
     */
    public function checkRePassWord() {
        if (!empty($_REQUEST['repassword'])) {
            if (strlen($_REQUEST['repassword']) < 6) {
                echo L('register_0018');
                die;
            } else {
                if ($_REQUEST['password'] == $_REQUEST['repassword']) {
                    echo 1;
                    die;
                } else {
                    echo L('register_0005');
                    die;
                }
            }
        } else {
            echo L('register_0016');
            die;
        }
    }

    //插入数据库中的 用户验证表 并发送激活邮件 等激活完成后 再插入用户表
    public function registerAdd() {
        $user = M('ohc_user')->where('user_email like "' . $_REQUEST['email'] . '"')->find();
        if ($user['user_id'] > 0) {
            
        } else {
            $registerInfo['user_email'] = $_REQUEST['email'];
            $registerInfo['user_name'] = $_REQUEST['username'];
            $registerInfo['user_pass'] = $_REQUEST['password'];
            $registerInfo['register_time'] = time();

            $registerInfo['register_format_time'] = date('Y-m-d H:i:s');


            $user_check = M('ohc_user');
            $userid = $user_check->add($registerInfo);
            $registerInfo['user_id'] = $userid;
            $this->sessionuser($registerInfo);
            $info['user_id'] = $userid;
            $user_info = M('ohc_user_info');
            $user_info->add($info);
            $this->sendEmail($userid, $registerInfo);
            $this->display('register_next');
        }
    }

    //发送激活邮件
    public function sendEmail($id, $result) {
        global $PUBLICJSURL;
        import('ORG.Email'); //导入邮件类
        $md5 = md5($id . $result['user_email'] . $result['user_pass']);
        $data['mailto'] = $result['user_email']; //收件人
        $data['subject'] = L('email_0001');
        $data['body'] = '<html>
             <body>
             <div style="">
             Thank you for signing up for an account with transparentmedicalcare.com.<br /> You are just one step away from using your account.  <br />
             <br />
             Once you activate your account, you can<br />
            - search by doctor, institution or a procedure unlimited <br />
            - read reviews shared by others<br />
            - post your own reviews<br />
            - publish or communicate with others on the forum<br />
                Please click the following link to activate your account:<br />
             <a href="' . $PUBLICJSURL . '?g=User&m=info&a=setting&id=' . $id . '&vecity=' . $md5 . '">' . $PUBLICJSURL . '?g=User&m=info&a=setting&id=' . $id . '&vecity=' . $md5 . '</a><br />
             <br /><br />Yours truly,<br /><br />
             Transparent Medical Care Team  <br />
             <p style="color:gay; font-size:11px;">* If the above url does not work properly, please copy and paste it in your web brower.</p>
             </div>
             </body>
             </html>';
        $mail = new Email();
        $mail->send($data);
    }

    /**
     * 判断当前密码是否为数据库存储的密码 不是的话 判断个数 
     */
    public function settingCurrentPassword() {
        $current_password = $_REQUEST['current_password'];
        if ($_SESSION['user_id'] > 0) {
            if (!empty($current_password)) {
                $ohc_user = M('ohc_user')->where('user_id = ' . $_SESSION['user_id'])->find();
                $user_pass = $ohc_user['user_pass'];
                //$user_pass = Md5($ohc_user['user_pass']);
                if ($user_pass == $current_password) {
                    if (strlen($_REQUEST['current_password']) < 6) {
                        echo L('register_0004');
                        die;
                    } else {
                        echo 1;
                        die;
                    }
                } else {
                    echo L('usersetting_0004');
                    die;
                }
            } else {
                echo 1;
                die;
            }
        } else {
            echo L('public_error_0001');
            die;
        }
    }

    /**
     *   用户设置 判断 2次新密码 是否与第一次新密码 设置相同  如相同 则判断 新密码是否与老密码相同
     */
    public function settingConfigNewPassword() {
        if ($_SESSION['user_id'] > 0) {
            if (empty($_REQUEST['settingpassword']) && !empty($_REQUEST['settingrepassword'])) {
                echo L('usersetting_0006');
                die;
            }
            if (!empty($_REQUEST['settingrepassword'])) {
                if ($_REQUEST['settingpassword'] == $_REQUEST['settingrepassword']) {
                    $ohc_user = M('ohc_user')->where('user_id = ' . $_SESSION['user_id'])->find();
                    $user_pass = $ohc_user['user_pass'];
                    //$user_pass = Md5($ohc_user['user_pass']);
                    if ($user_pass != $current_password) {
                        if (strlen($_REQUEST['settingpassword']) < 6) {
                            echo L('register_0004');
                            die;
                        } else {
                            echo 1;
                            die;
                        }
                    } else {
                        echo L('usersetting_0005');
                        die;
                    }
                } else {
                    echo L('register_0005');
                    die;
                }
            } else {
                echo 1;
                die;
            }
        } else {
            echo L('public_error_0001');
            die;
        }
    }

    /**
     *  判断1次密码 是否格式正确
     */
    public function settingNewPassWord() {
        if ($_SESSION['user_id'] > 0) {
            if (!empty($_REQUEST['settingpassword'])) {
                if (strlen($_REQUEST['settingpassword']) < 6) {
                    echo L('register_0004');
                    die;
                } else {
                    echo 1;
                    die;
                }
            } else {
                echo 1;
                die;
            }
        } else {
            echo L('public_error_0001');
            die;
        }
    }

    /**
     * 判断email 的格式是否正确。。 如正确 判断是否有人使用
     */
    public function settingCheckEmail() {
        if ($_SESSION['user_id'] > 0) {
            $email = $_REQUEST['newemail'];
            $UserInfo = M('ohc_user')->where(' user_id =' . $_SESSION['user_id'])->find();
            if ($email != $UserInfo['user_email']) {
                $result = M('ohc_user')->where('user_email like "' . $email . '"  and user_id !=' . $_SESSION['user_id'])->find();
                if (count($result) > 0) {
                    echo L('register_0002');
                    die;
                } else {
                    if (preg_match("/^(\w+([+!~=^#-<>.]\w+)*@\w+([.-]\w+)*[.][a-zA-Z]{2,9})?$/", $email)) {
                        //验证是否为邮箱格式  并且判断邮箱是否相同 如相同 则不修改
                        echo 1;
                        die;
                    } else {
                        echo L('register_0001');
                        die;
                    }
                }
            } else {
                echo 0;
                die;
            }
        } else {
            echo L('public_error_0001');
            die;
        }
    }

    public function sendActivationEmail() {
        if(!empty($_SESSION['user_id']) && $_SESSION['user_id'] > 0 ){
            $user_id = $_SESSION['user_id'];
        } else{
            $user_id = $_REQUEST['user_id'];
        }
        if (!empty($user_id) && $user_id > 0) {
            $userInfo = M('ohc_user')->where('user_id = ' . $user_id)->find();
            $this->sendEmail($user_id,$userInfo);
        }
    }

}

?>