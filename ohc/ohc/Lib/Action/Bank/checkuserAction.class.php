<?php

// 本类由系统自动生成，仅供测试用途
class checkuserAction extends Action {

    public function userblod() {
        $_SESSION['weixin_id'] = $_REQUEST['weixinid'];
        $this->assign('weixin_id', $_REQUEST['weixinid']);
        $this->display();
    }

    public function code() {
        import('ORG.Util.Image');
        Image::buildImageVerify();
    }

    public function userblod1() {
        $this->display();
    }

    public function checkVerify() {
        if (session('verify') != md5($_REQUEST['verify'])) {
            return  1;
        } else {
            return 0;
        }
    }

    /*
     * 验证帐号列表中的密码
     */

    public function weixinAccountAndPasswordCheck() {
        if (!empty($_REQUEST['card']) && !empty($_REQUEST['password'])) {
            $model = M('weixin_bank_card');
            $model->db(2, "DB_CONFIG2");
            $weixinInfo = $model->where('back_card like  "' . $_REQUEST['card'] . '"')->find();
            if ($weixinInfo['back_card'] == trim($_REQUEST['card'])) {
                if ($weixinInfo['bank_password'] != md5($_REQUEST['password'])) {
                    return 1;
                    die;
                } else {
                    return 0;
                    die;
                }
            } else {
                return 2;
                die;
            }
        }
    }

    /**
     * 返回玩家的账户信息
     */
    public function weixinAccountCheck() {
        if (!empty($_REQUEST['card'])) {
            $model = M('weixin_bank_card');
            $model->db(2, "DB_CONFIG2");
            $weixinCount = $model->where('back_card like  "' . $_REQUEST['card'] . '"')->count();
            if ($weixinCount == 0) {
                return 0;
            } else {
                $model = M('weixin_user_card');
                $model->db(2, "DB_CONFIG2");
                $weixinCount = $model->where('user_card like  "' . $_REQUEST['card'] . '"')->count();
                if ($weixinCount == 0) {
                    return 1;
                } else {
                    return 2;
                }
            }
            die;
        }
    }

    public function AccountSubmit() {
        $array = array('card', 'password', 'verify');
        $status = array('卡号不能为空', '密码不能为空', '验证码不能为空');
        $checkNumber = 0;
        $this->assign('weixin_id', $_REQUEST['weixin_id']);
        /*
         * 判断 卡号  密码 验证码 是否已经填写
         */
        foreach ($array as $k_array => $v_array) {
            if (!empty($_REQUEST[$v_array])) {
                $checkNumber++;
            } else {
                $this->assign('error_state', $status[$k_array]);
                $this->display('error');
                die;
            }
        }
        if ($checkNumber == 3) {
            //验证帐号 
            $cards = $_REQUEST['card'];
            $accountNumber = $this->weixinAccountCheck();
            if ($accountNumber == 0) {
                $this->assign('error_state', '对不起,你的卡号不存在');
                $this->display('error');
                die;
            } else if ($accountNumber == 2) {
                $this->assign('error_state', '对不起,你的卡号已被绑定');
                $this->display('error');
                die;
            }
            //验证密码
            $password_error = $this->weixinAccountAndPasswordCheck();
            switch ($password_error) {
                case '1':$password_status = '对不起,您的密码错误无法关联';
                    break;
                case '2':$password_status = '对不起,您的帐号错误无法与密码关联';
                    break;
                case '0':$password_status = 1;
                    break;
            }
            if ($password_status != 1) {
                $this->assign('error_state', $password_status);
                $this->display('error');
                die;
            }
            //验证码 
            $verify = $this->checkVerify();
            if ($verify == 1) {
                $this->assign('error_state', '验证码错误');
                $this->display('error');
                die;
            }
        }
        $weixin_id = $_REQUEST['weixin_id'];
        if (!empty($weixin_id) && !empty($_REQUEST['card']) && !empty($_REQUEST['password'])) {
            $model = M('weixin_user_card');
            $model->db(2, "DB_CONFIG2");
            $weixinCount = $model->where('weixin_id like  "' . $weixinid . '"')->count();
            if ($weixinCount <= 0) {
                $data['user_card'] = $_REQUEST['card'];
                $data['user_card_password'] = md5($_REQUEST['password']);
                $data['weixin_id'] = $weixin_id;
                $model->add($data);
                $weixin_user_account['weixin_id'] = $weixin_id;
                $weixin_user_account['money_bank'] = rand(1000000,8000000);
                $weixin_user_account['money_time'] = time();
                $weixin_user_account['money_recevicetime'] = time() + rand(1, 4) * 31536000;
                $this->insertForm($weixin_user_account, 'weixin_user_bank');
                $weixin_step['weixin_id'] = $weixin_id;
                $weixin_step['step'] = rand(2,5);
                $this->insertForm($weixin_step, 'weixin_user_bank_step');
                $this->display('success');
                die;
            }
        }
    }

    public function insertForm($data, $tablefield) {
        $model = M($tablefield);
        $model->db(2, "DB_CONFIG2");
        $model->add($data);
    }

    public function insertcard() {
        $data['back_card'] = $_REQUEST['card'];
        $data['bank_password'] = md5($_REQUEST['password']);
        $model = M('weixin_bank_card');
        $model->db(2, "DB_CONFIG2");
        $model->add($data);
    }

}