<?php

// OHC  ajax 调用的专门页面
class AjaxAction extends Action {

    function _initialize() {
        
    }

    public function combineUrl() {  //网站字段整合
        $path = $_REQUEST['path'];
        echo U($path);
    }

    public function UserLogin() {  //验证登录email和密码
        $user_email = $_REQUEST['email'];
        $user_password = $_REQUEST['password'];
        if (!empty($user_email) && !empty($user_password)) {
            $result = M('ohc_user')->where('user_email like "' . $user_email . '"')->find();
            if (count($result) > 0) {
                $md5_password = $result['user_pass'];
                if ($md5_password == $user_password) {
                    $this->sessionuser($result);
                    //测试  跳转到 首页
                    echo '0:' . L('loginStatus_0001');
                    die;
                } else {
                    echo '1:' . L('loginStatus_0002');
                    die;
                }
            } else {
                $result = M('ohc_user')->where('user_email like "' . $user_email . '"')->count();
                if ($result > 0) {
                    echo '2:' . L('loginStatus_0007');
                    die;
                } else {
                    echo '3:' . L('loginStatus_0002');
                    die;
                }
            }
        } else {
            echo '4:' . L('loginStatus_0001');
            die;
        }
    }

    public function changeWebsiteLanguage() {
        $language = $_REQUEST['language'];
        //获取当前模块
        if (count($_GET["_URL_"]) > 0) {
            $model = '';
        } else {  //为默认首页
            $model = '';
        }
        print_r($_GET["_URL_"]);
    }

    //jquery  auto_complete
    public function location() {
        $location = $_REQUEST['searchDbInforItem'];
        if (!empty($location)) {
            $model = M();
            $locationResult = array();
            //判断传入的数值是否为城市的缩写 如果符合 则不从城市列表中 模糊查询
//            $sql = 'select * from ohc_code where abbreviation like  "' . $location . '"';
//            $location_result = $model->query($sql);
            if (count($locationResult) <= 0) {
                $sql = 'select DISTINCT(city),state from ohc_code where city like  "' . $location . '%" limit 10';
                $locationName = $model->query($sql);
                foreach ($locationName as $locationNameVal)
                    $locationResult[] = $locationNameVal['city'] . " " . $locationNameVal["state"];
            }
            if (count($locationName) > 0) {
                $this->assign('location', $locationResult);
                $this->display();
            } else {
                echo 1;
                die;
            }
        }
    }

//    获取locationcode 用于查询
    public function getLocationCode() {
        $locationVal = $_REQUEST['locationName'];
        $locationResult = D('Code')->getCodeValById($locationVal);
        if (!empty($locationResult['code_id'])) {
            echo (int) $locationVal;
            die;
        } else {
            $locationName = explode(" ", trim($locationVal));
            $locationLength = count($locationName);
            $locationState = $locationName[$locationLength - 1];
            array_pop($locationName);
            $locationCity = null;
            if (($locationLength - 1) > 0) {
                for ($i = 0; $i < $locationLength - 1; $i++) {
                    $locationCity.=$locationName[$i] . " ";
                }
                $sql = "select code_id from ohc_code where city like '" . trim($locationCity) . "' and state like '" . $locationState . "' limit 1";
                $locationCode = M()->query($sql);
                echo (int) $locationCode[0]['code_id'];
            } else {
                echo 1;
                die;
            }
        }
    }

    public function locationcode() {
        //判断类型
        $code = $_REQUEST['code'];
        $ohc_city = M('ohc_code')->where('code_id = "' . $code . '"')->getField('city');
        if (!empty($ohc_city['code_id'])) {
            $ohc_city_count = count($ohc_city);
        } else {
            /**
             * 2013-8-1 by zxp
             * 地点验证
             */
            $ohc_city_count = D('Code')->getCodeByCityAndState($code);
        }
        echo $ohc_city_count;
    }

    //jquery auto changeCode
    public function codeChangeLocation() {
        $codeModel = M('ohc_code')->where("code_id='" . $_REQUEST["changeCode"] . "'")->find();
        if (count($codeModel) > 0) {
            echo $codeModel['city'] . " " . $codeModel['state'];
        }
    }

    /**
     * review zip_code  state city 验证
     */
    function checkreviewzsc() {
        /**
         *   验证邮编 是否数据库存在 不存在的话  返回1
         *   验证州 是否存在 不存在的话 返回2
         *   验证城市 是否存在 不存在的话 返回 3
         *   州和城市 都不存在 返回5
         */
        if ($_REQUEST['zip_code'] > 0) {
            $zip_code = M('ohc_code')->where('code_id = ' . $_REQUEST['zip_code'])->count();
            if ($zip_code == 0) {
                $str = 1;
            } else {
                $str = 0;
            }
        } else {
            $model = M();
            /**
             * 验证州是否存在,不存在则提示州名错误
             * 验证城市是否存在,不存在则提示城市错误
             */
            $statecount = count($model->query('select city from ohc_code where `state_name` Like "' . $_REQUEST['state'] . '" limit 1'));
            if ($statecount <= 0) {
                $str = 2;
                $state_count = 1;
            }
            $ohc_result = $model->query('select city from ohc_code where `city` Like "' . $_REQUEST['city'] . '" limit 1');
            $ohc_city_count = count($ohc_result);
            if ($ohc_city_count <= 0) {
                $str = 3;
                $city_count = 1;
            }
            if ($state_count != 1 && $city_count != 1) {
                $str = 0;
            } else {
                $str = 5;
            }
        }
        echo $str;
    }

    /**
     *  用户点击like 或 no like   进行操作
     */
    public function reviewlike() {
        $review_id = $_REQUEST['review_id'];
        $review_ablelike = $_REQUEST['review_ablelike'];
        /**
         *  判断用户 是否 已经like 过了
         *  将用户评论的内容  插入数据库 并更新review 数据库 
         */
        if ($_SESSION['user_id'] > 0) {
            if (!empty($review_id)) {
                $user_reviewlike = M('ohc_review_like')->where('user_id = ' . $_SESSION['user_id'] . ' and review_id = ' . $review_id)->count();
                if ($user_reviewlike <= 0) {
                    $data['review_id'] = $review_id;
                    $data['ohc_review_like'] = $review_ablelike;
                    $data['user_id'] = $_SESSION['user_id'];
                    $data['ohc_review_time'] = time();


                    $data['review_like_format'] = date('Y-m-d H:i:s');
                     $review_like = M('ohc_review_like')->add($data);
                    if ($review_like > 0) {
                        $review_like_array = array('review_nolike', 'review_like');
                        $review_inc = M('ohc_review')->where('review_id = ' . $review_id)->setInc($review_like_array[$review_ablelike]);
                        echo $review_inc;
                    }
                } else{
                    echo '1111';
                }
            }
        } else {
            echo 333;
        }
    }

    /**
     * 英文单词自动纠正  根据空格 分离单词。。 组成数组。
     */
    public function wordAutoCorrection() {
        $word = $_REQUEST['correnct_word'];
        if (strpos($word, ' ')) {
            $word_array = explode(' ', $word);
            $str = ' ';
        } else {
            $word_array = explode(',', $word);
            $str = ',';
        }
        if (count($word_array) > 0) {
            foreach ($word_array as $k_word => $v_array) {
                if ($v_array != '') {
                    $correction_word = M('ohc_word_correction')->where('word_name like "' . trim($v_array) . '"')->find();
                    if (count($correction_word) > 0) {
                        $word_array[$k_word] = $correction_word['correction_word'];
                    }
                }
            }
        }
        echo stripcslashes(implode($str, $word_array));
    }

    /**
     * 登出
     */
    public function userlogout() {
        session_destroy();
    }
}

?>