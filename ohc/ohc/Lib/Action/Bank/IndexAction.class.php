<?php

// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {

    private $subscribe = '你好！欢迎来到农村信用社(农商银行)微信平台！我们将及时为您送上最新资讯动态 ';  //关注内容
    private $reply = array('[1]我的款项', '[2]业务办理进度查询', '[3]产品目录', '[4]我的客户经理', '[5]优惠大礼包','[6]退出登录'); //存放显示在微信中的内容
    private $reply_ = array('[6]最新活动', '[7]退出登入'); //存放显示在微信中的内容
    private $check = '为确保您的账户信息安全,请先验证一次身份.<a href="http://121.199.43.50/Bank/checkuser/userblod/weixinid/{$weixinid}">验证身份</a>';
    private $card = '持卡人<a href="http://121.199.43.50/Bank/checkuser/userblod/weixinid/{$weixinid}">请先验证身份</a> 即可使用以下功能:';
    private $public = '您好！欢迎来到农村信用社（农商银行）微信平台！我们将及时为您送上最新资讯动态';
    private $step = array('申请', '客服专员核实基本信息', '当地客服经理核实信息属实', '专员审核', '符合签订合同', '银行放款');
    private $step_end = '如有疑问,回复M联系你的客户经理';
    private $removeblnd = '您好！你已安全退出登录！';

    public function __construct() {
        $this->subscribe .= ''. $this->card .''.PHP_EOL;
    }

    public function index() {
        import('ORG.Wechat');
        $options = array(
            'token' => 'weixinplatform' //填写你设定的key
        );
        $this->sendmessage($options);
    }

    /**
     * 自定义菜单  发送请求
     */
    public function menu() {
        import('ORG.access_token'); //导入微信类
        $access_token = new access_token();
        $token = $access_token->processresults();
        import('ORG.menu'); //导入自定义菜单类
        $menu = new menu();
        $menu->sendmeunapi($token);
    }

    /**
     *  
     */
    public function sendmessage($options) {
        $weObj = new Wechat($options);
        //$weObj->valid();
        $type = $weObj->getRev()->getRevType();
        $weixinCode = $weObj->getRev()->getRevFrom(); //获取微信号码 查询数据库 查看是否已经绑定帐号
        switch ($type) {
            case Wechat::MSGTYPE_TEXT:
                $weixin_content = $weObj->getRev()->getRevContent();
                switch (strtolower($weixin_content)) {
                    case '1':
                        if ($this->weixinCheck($weixinCode) > 0) {
                            $wexin_account = $this->weixinAccountCheck($weixinCode);
                            $text = '您有1笔贷款款项' . PHP_EOL . '贷款金额:￥' . $wexin_account['money_bank'].'.00' . PHP_EOL;
                            $text.='借款时间:' . date('Y-m-d', $wexin_account['money_time']) . PHP_EOL;
                            $text.='还款截至日:' . date('Y-m-d', $wexin_account['money_recevicetime']) . PHP_EOL;
                            $text.='请于还款截至日前还清您的贷款金额'.PHP_EOL;
                            $text = $this->weixinString($text, 0);
                        } else {
                            $text = str_replace('{$weixinid}', $weixinCode, $this->check);
                        }
                        break;
                    case '2':
                        if ($this->weixinCheck($weixinCode) > 0) {
                            $weixin_step = $this->weixinStepCheck($weixinCode);
                            $text = '您有1笔贷款业务正在办理，您申请的500万贷款正在审核中,预计还有3个工作日即可完成审查' . PHP_EOL;
                            $step = $weixin_step['step'];
                            foreach ($this->step as $k => $v) {
                                if ($k == ($step - 1)) {
                                    $text.='●';
                                } else {
                                    if($k < ($step - 1)){
                                       $text.='√';
                                    } else{
                                        $text.='  ';
                                    }
                                }
                                $text.='('.($k+1).')'.$v.PHP_EOL;
                            }
                            $text.= PHP_EOL . $this->step_end.PHP_EOL;
                            $text = $this->weixinString($text, 1);
                        } else {
                            $text = str_replace('{$weixinid}', $weixinCode, $this->check);
                        }
                        break;
                    case '3':
                        $text = '产品目录'.PHP_EOL;
                        $text .= '(a)人民币活期储蓄' . PHP_EOL . '(b)承兑汇票' . PHP_EOL . '(c)清算结算' . PHP_EOL . '(d)理财产品';
//                        $text .=PHP_EOL . '<a href="http://121.199.43.50/Weixin/weixin/gift">更多积分换好礼</a>' . PHP_EOL;
                        $text.=PHP_EOL;
                        $text = $this->weixinString($text, 2);
                        break;
                    case '4':
                        if ($this->weixinCheck($weixinCode) > 0) {
                            $text = '王先生' . PHP_EOL;
                            $text .= '手机:+861391-118-2758' . PHP_EOL;
                            $text .= '电话:021 5788-9300'.PHP_EOL;
                            $text = $this->weixinString($text, 3);
                        } else {
                            $text = str_replace('{$weixinid}', $weixinCode, $this->check);
                        }
                        break;
                    case '5':
                        $text = '农商银行' ;
                        $text .='<a href="http://121.199.43.50/Weixin/weixin/gift">优惠大礼包</a>'.PHP_EOL;
                        $text = $this->weixinString($text, 4);
                        break;
                    case 'm':
                       if ($this->weixinCheck($weixinCode) > 0) {
                            $text = '王先生' . PHP_EOL;
                            $text .= '手机:+861391-118-2758' . PHP_EOL;
                            $text .= '电话:021 5788-9300'.PHP_EOL;
                            $text = $this->weixinString($text, 3);
                        } else {
                            $text = str_replace('{$weixinid}', $weixinCode, $this->check);
                        }
                        break;   
                     case '6':
                        $this->weixinremoveblnd($weixinCode);
                        $text = $this->removeblnd;
                        $text = $this->weixinString($text, 14);
                        break;                           
                    default :
                        //获取数据库内容 查询关键字内容 如关键字查询不出 则 出来错误引到;
                        $model = M('weixin_keyword');
                        $model->db(2, "DB_CONFIG2");
                        $search_text = $model->where('keyword_name like "%' . $weixin_content . '%"')->select();
                        if (count($search_text) > 0) {
                            $text = $this->public . PHP_EOL;
                            foreach ($search_text as $text_value) {
                                $text.=$this->reply[$text_value['keyword_value']] . PHP_EOL;
                            }
                        } else {
                            $text = $this->public;
                            $text = $this->weixinString($text, 14);
                        }
                }
                $weObj->text($text)->reply();
                exit;
                break;
            case Wechat::MSGTYPE_EVENT:
                $event = $weObj->getRev()->getRevEvent();
                switch ($event['event']) {
                    case 'subscribe':
                        if ($this->weixinAccountCheck($weixinCode) <= 0) {
                            $subscribe = str_replace('{$weixinid}', $weixinCode, $this->subscribe);
                            $text = $this->weixinString($subscribe);
                        } else {
                            $text = $this->public;
                            $text = $this->weixinString($text, 14);
                        }

                        break;
                }
                $weObj->text($text)->reply();
                exit();
                break;
            case Wechat::MSGTYPE_IMAGE:
                break;
            default:
                $weObj->text("help info")->reply();
        }
    }

    /**
     * 验证
     */
    public function checkSignature($token) {
        $signature = $_REQUEST["signature"];
        $timestamp = $_REQUEST["timestamp"];
        $nonce = $_REQUEST["nonce"];

        $toke = $token;
        $tmpArr = array($toke, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 验证当前微信号 是否绑定内容
     */
    public function weixinCheck($weixinid) {
        $model = M('weixin_user_card');
        $model->db(2, "DB_CONFIG2");
        $weixinCount = $model->where('weixin_id like  "' . $weixinid . '"')->count();
        return $weixinCount;
    }

    /**
     * 组装字符串
     */
    public function weixinString($text, $key = 10) {
        foreach ($this->reply as $k_replay => $v_reply) {
            if ($k_replay != $key) {
                $text.=PHP_EOL . $v_reply;
            }
        }
        return $text;
    }

    /**
     * 组装字符串
     */
    public function weixinString_more($text, $key = 10) {
        foreach ($this->reply_ as $k_replay => $v_reply) {
            if ($k_replay != $key) {
                if ($k_replay == 0) {
                    $text.= $v_reply;
                } else {
                    $text.=PHP_EOL . $v_reply;
                }
            }
        }
        $text.=PHP_EOL;
        return $text;
    }

    /**
     * 返回玩家的贷款信息
     */
    public function weixinAccountCheck($weixinid) {
        $model = M('weixin_user_bank');
        $model->db(2, "DB_CONFIG2");
        $weixinArray = $model->where('weixin_id like  "' . $weixinid . '"')->find();
        return $weixinArray;
    }

    /**
     * 返回玩家的积分信息
     */
    public function weixinStepCheck($weixinid) {
        $model = M('weixin_user_bank_step');
        $model->db(2, "DB_CONFIG2");
        $weixinArray = $model->where('weixin_id like  "' . $weixinid . '"')->find();
        return $weixinArray;
    }

    /**
     * 解除绑定
     */
    public function weixinremoveblnd($weixinid) {
        $weixin_user_account = M('weixin_user_bank');
        $weixin_user_account->db(2, "DB_CONFIG2");
        $weixin_user_account->where('weixin_id like  "' . $weixinid . '"')->delete();

        $weixin_user_integration = M('weixin_user_bank_step');
        $weixin_user_integration->db(2, "DB_CONFIG2");
        $weixin_user_integration->where('weixin_id like  "' . $weixinid . '"')->delete();

        $weixin_user_card = M('weixin_user_card');
        $weixin_user_card->db(2, "DB_CONFIG2");
        $weixin_user_card->where('weixin_id like  "' . $weixinid . '"')->delete();
    }

    /**
     * 
     */
    public function weixinmysql() {
        $this->weixinremoveblnd('312312');
        $weixin_user_account = M('weixin_user_card');
        $weixin_user_account->db(1, "DB_CONFIG1");
        $result = $weixin_user_account->select();
        print_r($result);
    }

}