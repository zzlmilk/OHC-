<?php

/*
 * To change this template, choose Tools | Templates
 * review 填写
 */

class reviewAction extends Action {

    function _initialize() {
        
    }

    /**
     *  填写review
     */
    public function review() {
        $this->reviewFunction();
        if ($_REQUEST['firstName'] != '' && $_REQUEST['lastName'] != '') {
            $nameAry = array();
            array_push($nameAry, $_REQUEST['firstName'], $_REQUEST['lastName'], $_REQUEST['zipCode'], $_REQUEST['back'], $_REQUEST['middleName']);
            $this->assign("nameAry", $nameAry);
        } else{
            $codeAll = array('AK','AR','CA','CT','FL','HI','ID','IN','KY','MA','ME','MN','MO','NC','ND','NJ','NV','OH','OR'
                ,'RI','SD','TX','VA','WA','WV','AL','AZ','CO','DE','GA','IA','IL','KS','LA','MD','MI','MS','MT','NE','NH'
                ,'NM','NY','OK','PA','SC','TN','UT','VT','WI','WY');
            $this->assign('state_all',$codeAll);
            $this->assign('reviewFrom',0);
        }
        $this->assign('back', $_REQUEST['back']);
        $this->display();
    }

    /**
     *  填写review 注册页面转入
     */
    public function registerreview() {
        $this->reviewFunction();
        $this->assign('register_review', 1);
        $this->display('review');
    }

    /**
     *  填写review 的数据内容
     */
    public function reviewFunction() {
        //获取医疗review 信息
        $procedure = M('ohc_procedure')->where('procedure_type like "Preferred Name"')->select();
        $this->assign('procedure', $procedure);
        //获取在review下 评级的显示内容
        $rating = M('ohc_system')->where('system_id = 4')->getField('system_value');
        $this->assign('rate', json_decode($rating, true));
        //获取review 下的 付费内容
        $costing = M('ohc_system')->where('system_id = 6')->getField('system_value');
        $this->assign('cost', json_decode($costing, true));
    }

    /**
     * review 数据处理
     */
    public function addReview() {
        $reviewModel = D("Review");
        $display_able = 0;
        $isValidParameters = TRUE;
        $a=$_REQUEST;
        /**
         *  如果是通过search页面跳转将获取隐藏域中的值
         */
        if ($_REQUEST["back"] == 'yes') {
            $_REQUEST['zip_code'] = $_REQUEST['zip_code_back'];
            $_REQUEST["doctors_frist_name"] = $_REQUEST['doctors_frist_name_back'];
            $_REQUEST["doctors_last_name"] = $_REQUEST['doctors_last_name_back'];
            $_REQUEST['doctors_middle_name'] = $_REQUEST['doctors_middle_name_back'];
        }
        /**
         * 验证处方名  是否正确填写
         */
        if (empty($_REQUEST['procedures_val'])) {
            $isValidParameters = FALSE;
        }
        /**
         * 验证 邮编 如邮编不存在  则判断 用户是否填写城市与州名  如 未填写 
         */ else if (empty($_REQUEST['zip_code']) && !ctype_digit($_REQUEST['zip_code'])) {
            if (empty($_REQUEST['city']) || empty($_REQUEST['state'])) {
                $isValidParameters = FALSE;
            }
        }
        /**
         * 验证医生 fristname ,last_name,middlename 是否正确填写
         */ else if (!ctype_alpha($_REQUEST['doctors_frist_name']) && !ctype_alpha($_REQUEST['doctors_last_name'])) {
            $isValidParameters = FALSE;
            } 
//              else if (!empty($_REQUEST['doctors_middle_name'])) {
//
//                $isValidParameters = FALSE;
//
//        }
        /**
         * 如前面的验证全部通过  $isValidParameters 字段为true 否则为false
         */
        if ($isValidParameters) {
            /**
             * 验证医疗项目   该医疗项目是否在数据库存在 不存在 则发送邮件 存在则记录
             */
            if (!empty($_REQUEST['procedures_val'])) {
                if($_REQUEST['procedures_val'] == 'other'){
                    $procedures_val = $_REQUEST['procedure_name_other'];
                } else{
                    $procedures_val = $_REQUEST['procedures_val'];
                }
                $ohc_procedures = D('Procedure')->getProceduresValById($procedures_val);
                $reviewModel->addProceduresVals($ohc_procedures);
            }
            /**
             *  验证邮政号码  如邮政编码存在  则从数据库获取该邮政编码是否正确
             * 如邮政编码 为空 则验证城市名以及州名  
             * 如查询出来的结果  不存在 则发送邮件 否则 则记录数据
             */
            if (!empty($_REQUEST['zip_code']) || !empty($_REQUEST['city']) || !empty($_REQUEST['state'])) {
                if (!empty($_REQUEST['zip_code'])) {
                    $where = ' code_id = ' . $_REQUEST['zip_code'];
                } else {
                    $where = 'city like "' . $_REQUEST['city'] . '" and state_name like "' . $_REQUEST['state'] . '"';
                }
                $code_content = D('Code')->where($where)->find();
                $reviewModel->addCodeVals($code_content);
            }
            /**
             * 验证医生的名称 是否存在  如存在 则记录 否则发送邮件
             */
            if (!empty($_REQUEST['doctors_frist_name']) && !empty($_REQUEST['doctors_last_name'])) {
                $doctor_info = D('Doctor')->getDoctorByFullName($_REQUEST['doctors_middle_name'], $_REQUEST['doctors_frist_name'], $_REQUEST['doctors_last_name'], (int) $reviewModel->Reviewdata['zip_code']);
                $display_able = $reviewModel->addDoctorVals($doctor_info);
            }
            /**
             * 验证医院 是否在库中存在 不存在 则  发送邮件
             */
            if (!empty($_REQUEST['hospitals_name'])) {
                $hospital = D('Hospital')->getHospitalValByName($_REQUEST['hospitals_name']);
                $display_able = $reviewModel->addHostipalVals($hospital);
            };
            /**
             * 存放 时间  用户id  
             */
            $user_id = $reviewModel->getAnotherSetting($_SESSION['user_id']);
            /**
             * 存放用户填写的 分数
             */
            $reviewModel->getScoreVal();
            /**
             * 存放用户填写的 价钱
             */
            $reviewModel->getCostVals();
            /**
             * 存放 诊治时间
             */
            $reviewModel->getYearAndMonth();
            /**
             * 存放用户评论内容
             */
            $reviewModel->getReview();
            /**
             *  将上述存放的内容 插入数据库
             * 如上述 地点 医生 医院 医疗项目 其中有1项 填写不正确 则插入审核表 否则则插入正式表
             */
            $review_scroce = $reviewModel->insertReviewContent();

            /**
             * 如成功插入正式表 则返回$review_scroce 字段
             */
            if ($review_scroce == 1) {
                //某个城市中所有病人就医疗项目 的花费的平均值
                $reviewModel->getReivewListBycodeAndProduces($reviewModel->Reviewdata['procedures_name'], $reviewModel->Reviewdata['zip_code']);
                //医生 就医疗项目 的收费的平均值
                $reviewModel->getReviewListByDoctorProduce($reviewModel->Reviewdata['doctors_id'], $reviewModel->Reviewdata['procedures_name'], $reviewModel->Reviewdata['zip_code']);
                //医生 在医疗项目 
                $review = $reviewModel->UpdateReivewLevelByReivewId($reviewModel->ReturnReview_id);
                /**
                 * 该医生的review_number  +1
                 */
                $doctor_review_number = D('Doctor')->updateReviewNuberByDoctorId($reviewModel->Reviewdata['doctors_id']);
            }
            /**
             *   判断是否为注册页面跳过来。。 如是的话 则跳入到注册成功地方 
             */
            if ($_REQUEST['register_review'] == 1) {
                //redirect(U('User/register/register_reviewnext'));
                $redirectUrl = U('User/register/register_reviewnext');
            } else if ($_REQUEST["back"] == 'yes') {
                $doctorName = $_REQUEST["doctors_frist_name"] . ' ' . $_REQUEST['doctors_middle_name'] . ' ' . $_REQUEST["doctors_last_name"];
                $redirectUrl = U('Medical/index/search', array('back' => '1', 'search_text_id' => urlencode($reviewModel->Reviewdata['doctors_id']), 'search_text' => urlencode($doctorName), 'search_text_location' => $reviewModel->writeZipCode($reviewModel->Reviewdata["zip_code"]), 'searching' => 1));
            } else {
                $redirectUrl = 1;
            }
            $this->assign('redirectUrl', $redirectUrl);
            $this->display('success');
        }
    }

    /**
     *  review  阅读条款 
     */
    public function reviewAgree() {
        $this->display('review_last');
    }

    /**
     *  review 内的 同意条款
     */
    public function agreeService() {
        $this->display();
    }

}

?>
