<?php

class ReviewModel extends Model {

    var $tableName = 'ohc_review';
    var $doctor_review_rate = 0;  //医生 就医疗项目 的收费的平均值
    var $doctor_review_number = 0;
    var $city_review_rate = 0;  //某个城市中所有病人就医疗项目 的花费的平均值
    var $rating_array_ = array();
    private $doctors_id;
    private $doctors_frist_name;
    private $doctors_last_name;
    private $procedures_id;
    private $procedures_name;
    private $procedures_other_name;
    private $hospitals_name;
    private $city_location;
    var $zip_code = 0;
    var $review_level; //医生 在医疗项目 上的得分
    var $city_zip_code = 0;
    private $review_number;
    private $review_id;
    private $isRevising; //是否插入审查表
    public $Reviewdata;
    //public $Reviewdata_content;
    public $ReturnReview_id;
    //
    var $review_All_array = array(); //分页前 前数据
    var $review_array = array(); //分页后 数据
    var $vars_number = 0;
    // 医院计算 
    var $hospital_produce_temp = array();
    var $produce_all_avrg = 0;
    var $hospital_list_temp = array();
    var $hospital_produce_arvg = 0;
    var $hospital_scorce = 0;
    //审查表类型
    public $review_state = array();

   public $fina_review_level = 0;
    
    public $doctor_produre_review;
    public $produre_scores;
    public $count_produre_list;
    //医院详情
    public $hospital_array = array();



    private $soft_array = array('b1','b2','b3','b4');

    /**
     * 根据review 数量  排序  获取分数 等操作
     * 获取医生 所有项目的分数 
     * @param type $doctor_list
     * @return type
     */
    public function getDoctorSorceByReviewAndSortReviewNumber($doctor_list, $maxDataNumber, $minDataNumber) {
        $doctor_new_list = array();
        $dateMaxNumber = 0;
        for ($num = $minDataNumber; $num < $maxDataNumber; $num++) {
            if (!empty($doctor_list[$num])) {
                $doctor_new_list[$dateMaxNumber] = $doctor_list[$num];
                $dateMaxNumber++;
                unset($doctor_list[$num]);
            }
        }
        foreach ($doctor_new_list as $k => $i) {
            if (!empty($i['doctor_id']) && $i['doctor_id'] > 0) {
                $doctor_new_list[$k]['doctor_frist_name'] = urlencode($i['doctor_frist_name']);
                $doctor_new_list[$k]['doctor_middle_name'] = urlencode($i['doctor_middle_name']);
                $doctor_new_list[$k]['doctor_last_name'] = urlencode($i['doctor_last_name']);
                $doctor_new_list[$k]['review_scorce'] = D('DoctorReview')->getDoctorScorceValById($i['doctor_id']);
            }
        }
        return $doctor_new_list;
    }

    /**
     * 
     * @param type $doctor_list
     * @return type
     */
    public function getDoctorListBySortScorceAndShow($doctor_list, $maxDataNumber, $minDataNumber) {
        $doctor_sort_scorce = array();
        $doctor_show_list = array();
        $dateMaxNumber = 0;
        foreach ($doctor_list as $k => $i) {
            if ($i['doctor_id'] > 0) {
                $review_scorce = D('DoctorReview')->getDoctorScorceValById($i['doctor_id']);
                $doctor_list[$k]['review_scorce'] = $review_scorce;
                $doctor_sort_scorce[$k] = $review_scorce;
            }
        }
        array_multisort($doctor_sort_scorce, SORT_DESC, $doctor_list);
        for ($num = $minDataNumber; $num < $maxDataNumber; $num++) {
            $doctor_show_list[$dateMaxNumber] = $doctor_list[$num];
            $dateMaxNumber++;
        }
        return $doctor_show_list;
    }


 public function getDoctorListBySoft($doctor_list, $maxDataNumber, $minDataNumber,$type){

        $doctor_sort_scorce = array();
        $doctor_show_list = array();
        $dateMaxNumber = 0;

        foreach ($doctor_list as $k => $i) {
            if ($i['doctor_id'] > 0) {
                $review_scorce = D('DoctorReview')->getDoctorScorceValById($i['doctor_id']);

                $soft_val = D('Review')->getDoctorSoftSumVal($i['doctor_id'],$type);

                $doctor_list[$k]['review_scorce'] = $review_scorce;

                $doctor_sort_scorce[$k] = $soft_val;
            }
        }

        
        array_multisort($doctor_sort_scorce, SORT_DESC, $doctor_list);

        for ($num = $minDataNumber; $num < $maxDataNumber; $num++) {
            $doctor_show_list[$dateMaxNumber] = $doctor_list[$num];
            $dateMaxNumber++;
        }
        return $doctor_show_list;

    }

    public function showSearch($doctor_sort_list, $maxDataNumber, $minDataNumber = 0) {
        $doctor_new_list = array();
        $dateMaxNumber = 0;
        for ($num = $minDataNumber; $num < $maxDataNumber; $num++) {
            $doctor_new_list[$dateMaxNumber] = $doctor_sort_list[$num];
            $dateMaxNumber++;
            unset($doctor_sort_list[$num]);
        }
        return $doctor_new_list;
    }


    /**
     * 医生详情
     */
    public function getHospitalListDetail($hospitalName, $keyHospital) {
        $hospitalDetail = array();
        $hospital_sql = 'select procedures_name,city_zip_code from ohc_review where hospitals_name like "' . $hospitalName . '"  order by review_number DESC';
        $hospital_result = $this->query($hospital_sql);
        $this->hospital_array[$keyHospital]['hospital_name'] = $hospitalName;
        if (count($hospital_result) > 0) {
            foreach ($hospital_result as $k_hospital_detail => $v_hospital_detail) {
                $selectProduceAllAreaSroce = 'select review_scorce  from ohc_procedures_review where procedures_name like "' . $v_hospital_detail['procedures_name'] . '" ';
                $produre_review = M('ohc_procedures_review')->where('procedures_name like "' . $v_hospital_detail['procedures_name'] . '"')->select();
                $this->hospital_array[$keyHospital]['review_scorce'][$k_hospital_detail] = $scorce > 0 ? $scorce : 0;
                ;
                $this->hospital_array[$keyHospital]['procedures_name'][$k_hospital_detail] = $v_hospital_detail['procedures_name'];
            }
        }
    }

    /**
     * 清空原先循环变量
     */
    public function emptyVars() {
        $this->doctor_review_number = $this->doctor_review_rate = $this->city_review_rate = 0;
    }

    /*
     * 邮件发送 
     */

    public function sendRevisingMail($errorVal) {
        $url = urlencode("action=revising&function=RevisingReview&revisingId=" . $this->ReturnReview_id);
        import('ORG.Email'); //导入邮件类
        $data['mailto'] = C('SMTP_USER'); //收件人
        $data['subject'] = '审核错误邮件';
        $data['body'] = '<html>
             <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></meta></head>
             <body>
             <div> <p  style="color:red; font-weight:bold;"> review info error </p> <br /><a href="' . C('adminUrl') . '/index.php?a=' . $url . '">check</a>
             </div>
             </body>
             </html>';
        $mail = new Email();
        $mail->send($data);
    }

    /*
     * 
     * 获取某个医生的所有的医疗项目
     */

    public function getReviewListBydoctor($doctor_id) {
        return $this->where('doctors_id = ' . $doctor_id)->group('procedures_name')->select();
    }

    /**
     * 获取该地区 该医疗项目 中的 所有的review 信息
     * @param type $code
     * @param type $produce
     * @return type
     */
    public function getReivewListBycodeAndProduces($produce, $zipCode) {
        $cityCode = $this->getCityAreaCode($zipCode);
        $city_review = $this->where('city_zip_code like  "' . $cityCode . '" and procedures_name like "' . $produce . '"')->select();
        $city_review_number = count($city_review);
        foreach ($city_review as $v_review) {
            $city_review_cost += $v_review['cost'];
        }
        $this->zip_code = $zipCode;
        $this->city_zip_code = $cityCode;
        $this->city_review_rate = ceil($city_review_cost / $city_review_number);
    }

    /*
     * 获取 该医生 对 某个医疗项目 对 某个地点 的 所有的review 信息
     */

    public function getReviewListByDoctorProduce($doctorId, $producename, $cityAreaCode) {
        $rating_array = D('System')->getSystemInfoById(2);
        $this->rating_array_ = array();
        $cityCode = $this->getCityAreaCode($cityAreaCode);
        $doctor_review = $this->where('doctors_id =  "' . $doctorId . '" and procedures_name like "' . $producename . '"  and city_zip_code like "' . $cityCode . '"')->group()->select();
        $doctor_review_number = count($doctor_review);
        foreach ($doctor_review as $k_doctor => $v_doctor) {
            $doctor_review_cost += $v_doctor['cost'];
            foreach ($rating_array as $rate_v) {
                $this->rating_array_[$rate_v] += $v_doctor[$rate_v];
            }
        }
        $doctor_review_rate = round($doctor_review_cost / $doctor_review_number);
        $this->doctor_review_rate = $doctor_review_rate;
        $this->doctor_review_number = $doctor_review_number;
        $this->doctorId = $doctorId;
        $this->review_number = $doctor_review_number;
        $this->procedures_name = $producename;
    }

    /**
     * 修改review 对应的 综合评分
     */
    public function UpdateReivewLevelByReivewId() {
        $review_rate = ($this->rating_array_['b1'] - $this->doctor_review_number) / (4 * $this->doctor_review_number) + ($this->rating_array_['b2'] - $this->doctor_review_number) / (4 * $this->doctor_review_number) + ($this->rating_array_['b3'] - $this->doctor_review_number) / (4 * $this->doctor_review_number) + ($this->rating_array_['b4'] - $this->doctor_review_number) / (4 * $this->doctor_review_number) + 1;
        $review_rate_ = $review_rate / ($this->doctor_review_rate / $this->city_review_rate);
        $this->review_level = floor($review_rate_ * 100) / 100;
        $reviewScroce = M('ohc_review_fraction')->where('doctor_id = ' . $this->doctorId . ' and produce_name like "' . $this->procedures_name . '"')->find();
        if (count($reviewScroce) > 0) {
            $save['review_scorce'] = $this->review_level;
            $save['review_number'] = $this->review_number;
            M('ohc_review_fraction')->where('doctor_id = ' . $this->doctorId . ' and produce_name like "' . $this->procedures_name . '"')->save($save);
        } else {
            $insertReviewFraction['doctor_id'] = $this->doctorId;
            $insertReviewFraction['produce_name'] = $this->procedures_name;
            $insertReviewFraction['city_zip_code'] = $this->city_zip_code;
            $insertReviewFraction['zip_code'] = $this->zip_code;
            $insertReviewFraction['review_scorce'] = $this->review_level;
            $insertReviewFraction['review_number'] = $this->review_number;
            M('ohc_review_fraction')->add($insertReviewFraction);
        }
    }

    /**
     * 计算 医生对 某个医疗项目的综合评分
     */
    public function sumDoctorAndProduceScroce($doctor_id) {
        /**
         * 获取该医生的review 信息  
         */
        $review = D('Review')->getReviewListBydoctor($doctor_id);
          foreach ($review as $vv_review) {
            //某个城市中所有病人就医疗项目 的花费的平均值
            $this->getReivewListBycodeAndProduces($vv_review['procedures_name'], $vv_review['zip_code']);
            //医生 就医疗项目 的收费的平均值
            $this->getReviewListByDoctorProduce($vv_review['doctors_id'], $vv_review['procedures_name'], $vv_review['zip_code']);
            //医生 在医疗项目 
            $review = $this->UpdateReivewLevelByReivewId($vv_review['review_id']);
            unset($vv_review);
            $this->emptyVars();
        }
    }

    /**
     * 插入医疗项目 如果数据库中没有该项目则审核
     */
    public function addProceduresVals($proceduresVal) {
        if (count($proceduresVal) == 0) {
            $this->isRevising = 1;
            $procedures_vals = ($_REQUEST['procedures_val'] == 'other') ? $_REQUEST['procedure_name_other'] : $_REQUEST['procedures_val'];
            $this->Reviewdata['procedures_name'] = $procedures_vals;
            array_push($this->review_state, 4);
        } else {
            if ($proceduresVal['procedure_type'] == 'Other Name') {
                $this->Reviewdata['procedures_other_name'] = $proceduresVal['procedure_name'];
                $proceduresVal = D('Procedure')->where('procedure_id like "' . $proceduresVal['procedure_id'] . '" and procedure_type like "Preferred Name" ')->find();
            }
            $this->Reviewdata['procedures_id'] = $proceduresVal['id'];
            $this->Reviewdata['procedures_name'] = $proceduresVal['procedure_name'];
        }
    }

    /**
     *  将正确的地点信息 存放在reviewdata里面 
     * @param type $codeVal
     */
    public function addCodeVals($codeVal) {
        if (count($codeVal) > 0) {
            $this->Reviewdata['zip_code'] = (int) $codeVal['code_id'];
            $this->Reviewdata['city_zip_code'] = (int) substr($codeVal['code_id'], 0, 3);
            $this->Reviewdata['city_location'] = $codeVal['city'];
            $this->Reviewdata['state'] = $codeVal['state'];
        } else {
            $this->isRevising = 1;
            $this->Reviewdata['zip_code'] = $_REQUEST['zip_code'];
            $this->Reviewdata['city_zip_code'] = (int) substr($_REQUEST['zip_code'], 0, 3);
            $this->Reviewdata['city_location'] = $_REQUEST['city'];
            $this->Reviewdata['state'] = $_REQUEST['state'];
            array_push($this->review_state, 3);
        }
    }

    /**
     * 存放医生信息
     * @param type $doctorVal
     * @return int
     */
    public function addDoctorVals($doctorVal) {
        $display_able = 0;
        if (count($doctorVal) > 0) {
            $this->Reviewdata['doctors_id'] = $doctorVal['doctor_id'];
            $this->Reviewdata['doctors_frist_name'] = $doctorVal['doctor_frist_name'];
            $this->Reviewdata['doctors_last_name'] = $doctorVal['doctor_last_name'];
            $this->Reviewdata['doctor_middle_name'] = $doctorVal['doctor_middle_name'];
        } else {
            //发送邮件
            $this->isRevising = 1;
            array_push($this->review_state, 1);
            $display_able = 1;
            $this->Reviewdata['doctors_id'] = 0;
            $this->Reviewdata['doctors_frist_name'] = $_REQUEST['doctors_frist_name'];
            $this->Reviewdata['doctors_last_name'] = $_REQUEST['doctors_last_name'];
            $this->Reviewdata['doctor_middle_name'] = $_REQUEST['doctors_middle_name'];
        }

        return $display_able;
    }

    /**
     * 存放医院信息
     * @param type $hostipalVal
     * @return int
     */
    public function addHostipalVals($hostipalVal) {
        $display_able = 0;
        if (count($hostipalVal) > 0) {
            $this->Reviewdata['hospitals_name'] = $hostipalVal['hospital_name'];
            $this->Reviewdata['hospital_id'] = $hostipalVal['ohc_hospital_id'];
        } else {
            //发送邮件
            array_push($this->review_state, 2);
            $display_able = 1;
            $this->isRevising = 1;
            $this->Reviewdata['hospitals_name'] = $_REQUEST['hospitals_name'];
        }
        return $display_able;
    }

    /**
     * 存放时间以及用户id
     * @param type $users_id
     * @return type
     */
    public function getAnotherSetting($users_id) {
        if ($users_id > 0) {
            $user_id = $users_id;
        } else {
            $user_id = -1;
        }
        $this->Reviewdata['user_id'] = $user_id;
        $this->Reviewdata['display_able'] = 0;
        $this->Reviewdata['review_time'] = time();
        return $user_id;
    }

    /**
     * 存放星级
     */
    public function getScoreVal() {
        $rating = D('System')->where('system_id = 2')->getField('system_value');
        $rating_array = json_decode($rating, true);
        foreach ($rating_array as $rate_v) {
            $this->Reviewdata[$rate_v] = $_REQUEST[$rate_v];
        }
    }

    /**
     * 存放 用户填写的价钱
     */
    public function getCostVals() {
        if ($_REQUEST['costselect'] == 1) {
            $costing = D('System')->where('system_id = 5')->getField('system_value');
            $costing_array = json_decode($costing, true);
            $fina_cost = 0;
            foreach ($costing_array as $cost_v) {
                $fina_cost+=$_REQUEST[$cost_v];
                $this->Reviewdata[$cost_v] = $_REQUEST[$cost_v];
                unset($cost_v);
            }
            $this->Reviewdata['cost'] = $fina_cost;
            $this->Reviewdata['costselect'] = $_REQUEST['costselect'];
        } else {
            $this->Reviewdata['cost'] = $_REQUEST['fina_cost'];
        }
    }

    /**
     * 存放 用户填写的诊断时间
     */
    public function getYearAndMonth() {
        if ($_REQUEST['year_val'] > 0) {
            $this->Reviewdata['review_year'] = $_REQUEST['year_val'];
        }
        if ($_REQUEST['month_val'] > 0) {
            $this->Reviewdata['review_month'] = $_REQUEST['month_val'];
        }
        if ($_REQUEST['year_val'] > 0 && $_REQUEST['month_val'] > 0) {
            $visit_time = mktime(0, 0, 0, $_REQUEST['month_val'], 0, $_REQUEST['year_val']);
            $this->Reviewdata['visit_year'] = $visit_time;
        }
    }

    /**
     * 存放用户填写的评论
     */
    public function getReview() {
        if (!empty($_REQUEST['commect_review'])) {
            $this->Reviewdata['commect_review'] = $_REQUEST['commect_review'];
        }
    }

    /**
     * 插入数据库
     * @return int
     */
    public function insertReviewContent() {
        $review_scroce = 0;
        if ($this->isRevising == 1) {
            $this->Reviewdata['review_state'] = json_encode($this->review_state);
            $where = 'zip_code = ' .$this->Reviewdata['zip_code'].' and city_zip_code =  '.$this->Reviewdata['city_zip_code'].'';
            $where.=' and city_location like "'.$this->Reviewdata['city_location'].'" and procedures_name like "'.$this->Reviewdata['procedures_name'].'"';
            $where.=' and doctors_frist_name like "'.$this->Reviewdata['doctors_frist_name'].'"  and doctors_last_name like "'.$this->Reviewdata['doctors_last_name'].'"';
            $where.='and doctor_middle_name like "'.$this->Reviewdata['doctor_middle_name'].'"';
            $revising_review_result = M('ohc_revising_review')->where($where)->find();

            if(count($revising_review_result) <= 0 ){

                     $review_id = M("ohc_revising_review")->add($this->Reviewdata);
                     $this->ReturnReview_id = $review_id;
                     $this->sendRevisingMail($this->review_state);
            }
           
        } else {
            $review_scroce = 1;
            $this->Reviewdata['review_time_insert'] = date('Y-m-d H:i:s');
            $review_id = $this->add($this->Reviewdata);
            $user['user_path'] = 1;
            $userInfo = D('User')->updateUserState($user);
            $this->ReturnReview_id = $review_id;
        }
        return $review_scroce;
    }

    /**
     * 个人页面  显示review东西
     */
    public function getUserReviewByUserInfo($page) {
        $userReviewquery = 'select review_id,doctors_frist_name,doctors_id,doctors_last_name,doctor_middle_name,city_location,state from ohc_review where user_id = ' . $_SESSION['user_id'] . ' GROUP BY doctors_id';
        $otherReviewDataResult = $userReviewDataResult = array();
        $this->review_All_array = $this->query($userReviewquery);
        $this->vars_number = count($this->review_All_array);
        if ($this->vars_number > 0) {
            foreach ($this->review_All_array as $k_result => $v_result) {
                if ($k_result == $page - 1) {
                    $userReviewData = 'select commect_review from ohc_review where  doctors_id = ' . $v_result['doctors_id'] . '  order by review_id  DESC   limit 3 ';
                    $userReviewDataResult = $this->query($userReviewData);
                    $userReviewLimit = 3 - count($userReviewDataResult);
                    $this->review_array[$k_result]['doctor_info'] = $v_result;
                    if ($userReviewLimit <= 0) {
                        $otherUserReviewSql = 'select commect_review from ohc_review where user_id != ' . $_SESSION['user_id'] . ' and  doctors_id = ' . $v_result['doctors_id'] . '  order by review_id  DESC   limit ' . $userReviewLimit;
                        $otherReviewDataResult = $this->query($otherUserReviewSql);
                    }
                    if (count($userReviewDataResult) > 0) {
                        foreach ($userReviewDataResult as $k_user_result => $v_user_result) {
                            $this->review_array[$k_result]['doctor_info']['review'][$k_user_result] = $v_user_result['commect_review'];
                            unset($v_user_result);
                        }
                    }
                    if (count($otherReviewDataResult) <= 0) {
                        foreach ($otherReviewDataResult as $k_other_result => $v_other_result) {
                            $this->review_array[$k_result]['doctor_info']['review'][$k_other_result] = $v_other_result['commect_review'];
                            unset($v_other_result);
                        }
                    }
                }
            }
        }
    }

    /**
     * 计算医院中的 所有的医生分数 以及 医疗项目的分数
     */
    public function sumHospitalInDoctor($hospital_id, $produre_arg = -1, $produre_count = -1) {
        $hospital_produce_temp = $hospital_list_temp = array();
        $hospital_key = $hospital_produce_arvg = $produce_all_avrg = 0;
        $hospital_list = $this->where('hospital_id  =  ' . $hospital_id)->select();
        foreach ($hospital_list as $v_list) {
            if (!in_array($v_list['procedures_name'], $hospital_produce_temp)) {
                $this->hospital_produce_temp[] = $v_list['procedures_name'];
                /**
                 * 获取该医疗项目的 综合评分  如 查询出 有数据 则 获取分数 如数据库没有的话 则调用计划任务的方法  直接返回
                 */
                $produre_review = M('ohc_procedures_review')->where('procedures_name like "' . $v_list['procedures_name'] . '" and  zip_code  = ' . $v_list ['zip_code'])->find();
                if (count($produre_review) > 0) {
                    $scorce = $produre_review['review_scorce'];
                } else {
                    $scorce = R('Crontab/crontab/hosptialReviewCalculate', array($v_list['procedures_name'], $v_list['zip_code'], 2));
                }
                $this->produce_all_avrg+=$scorce;
                $hospital_key++;
            }
            /**
             * 获取医生的医疗项目的分数
             */
            $doctor_list = M('ohc_doctor_review')->where('doctor_id = ' . $v_list['doctors_id'])->find();
            if (count($doctor_list) > 0) {
                $doctor_review_id = $doctor_list['doctor_review_id'];
            } else {
                $doctor_review_id = D('Doctor')->doctorAllSorce($v_list['doctors_id']);
            }
            if (!in_array($doctor_review_id, $hospital_list_temp)) {
                $this->hospital_list_temp[] = $doctor_review_id;
                $doctor_list = M('ohc_doctor_review')->where('doctor_id = ' . $v_list['doctors_id'])->getField('review_scroce');
                $this->hospital_produce_arvg+=$doctor_list['review_scroce'];
            }
            unset($v_list);
        }
        /**
         * 医疗项目中的平均分
         */
        if ($produre_count != -1) {
            $hospital_produce_arvg = round($this->produce_all_avrg / $produre_count) > 5 ? 5 : round($produce_all_avrg / $produre_count);
        } else {
            $hospital_produce_arvg = round($this->produce_all_avrg / count($this->hospital_produce_temp)) > 5 ? 5 : round($this->produce_all_avrg / count($this->hospital_produce_temp));
        }
        /**
         * 医生的平均分
         */
        $hospital_hospital_arvg = round($this->hospital_produce_arvg / count($this->hospital_list_temp)) > 5 ? 5 : round($this->hospital_produce_arvg / count($this->hospital_list_temp));
        /**
         * 返回综合评分 并存储数据库
         */
        $hospital_count = M('ohc_hospital_review')->where('hospitals_id =' . $hospital_id)->count();
        $this->hospital_scorce = ceil($hospital_produce_arvg + $hospital_hospital_arvg) > 5 ? 5 : ceil($hospital_produce_arvg + $hospital_hospital_arvg);
        $hospital_data['hospital_scroce'] = $this->hospital_scorce;
        if ($hospital_count > 0) {
            M('ohc_hospital_review')->where('hospitals_id =' . $hospital_id)->save($hospital_data);
        } else {
            $hospital_data['hospitals_id'] = $hospital_id;
            M('ohc_hospital_review')->add($hospital_data);
        }
    }

    /**
     * 组装邮编 如邮编为9461  补0  为09461  获取前三位 地区数字
     */
    public function getCityAreaCode($code) {
        $newSubfiex_ = $this->writeZipCode($code);
        $cityCode = (int) substr($newSubfiex_, 0, 3);
        return $cityCode;
    }

    /**
     * 2013-8-1 by zxp
     * review 查询 判断 邮编是否大于5位  如大于5位 则截取5位
     * 2013-8-1 by LY
     * review 查询 判断 邮编是否大于指定长度  如大于指定长度 则截取指定长度 默认为截取5位
     */
    public function getCodeByReview($code, $stringLength = 5) {
        $codeLength = strlen($code);
        if ($codeLength > $stringLength) {
            $cityCode = (int) substr($code, 0, $stringLength);
        } else {
            $cityCode = $code;
        }
        return $cityCode;
    }

    /**
     * 
     */
    public function writeZipCode($code) {
        $testCount = 5 - strlen($code);
        $subfiex = '';
        for ($i = 1; $i <= $testCount; $i++) {
            $subfiex .= '0';
        }
        $newSubfiex_ = (string) $subfiex . $code;
        return $newSubfiex_;
    }

    //统计医生某医疗项目的回复总数
    public function countDoctorReview($doctorId, $procedureName) {
        $DoctorReview = $this->where("doctors_id =" . $doctorId . " and procedures_name = '" . $procedureName . "'")->select();
        $returnNum = count($DoctorReview);
        return $returnNum;
    }

    /*
     * index中获取医生的医疗项目
     */

    public function getDoctorProdure($review, $user, $pageAction, $currentPage) {
        $temp_doctor_produce = array(); //存放医疗项目
        $temp_doctor_review = array(); //存放该医疗项目 对应的键名
        $temp_doctor_produce_number = array(); //存放该医疗项目的评论数
        $key_produce = 0; //key
        $review_count = 0; //总review个数
        $doctor_new_produce = array();
        $reviewScore = Array();
        $s1 = $s2 = $s3 = $s4 = NULL;
        $doctor_produre = $this->where('doctors_id = ' . $review['doctor_id'])->field('b1,b2,b3,b4,procedures_name,procedures_other_name,review_id,commect_review,review_id')->select();
        if (count($doctor_produre) > 0) {
            foreach ($doctor_produre as $k_produce => $v_produce) {
                $review_count++;
                /**
                 * 获取该医生 该医疗项目的 数量 
                 * 获取该医生 对  该医疗项目的 分数
                 */
                // if ($v_produce['procedures_other_name'] != '') {
                //     $produce_name = $v_produce['procedures_other_name'];
                // } else {
                    $produce_name = $v_produce['procedures_name'];
                //}
                if (!in_array($produce_name, $temp_doctor_produce)) {
                    if (!empty($review['doctor_id']) && $review['doctor_id'] > 0 && !empty($v_produce['procedures_name'])) {
                        $doctor_produre_info = M('ohc_review_fraction')->where('doctor_id = ' . $review['doctor_id'] . ' and produce_name = "' . $v_produce['procedures_name'] . '"')->find();
                        if (count($doctor_produre_info) > 0) {
                            $doctor_new_produce[$key_produce]['review_number'] = $doctor_produre_info['review_number'];
                            $doctor_new_produce[$key_produce]['produre_scores'] = $doctor_produre_info['review_scorce'];
                        } else {
                            $doctor_new_produce[$key_produce]['review_number'] = 0;
                            $doctor_new_produce[$key_produce]['produre_scores'] = 0;
                        }
                        $doctor_new_produce[$key_produce]['review_id'] = $v_produce['review_id'];
                        $doctor_new_produce[$key_produce]['produre_name'] = $v_produce['procedures_name'];
                        $doctor_new_produce[$key_produce]['procedure_other_name'] = $v_produce['procedures_other_name'];
                        $doctor_new_produce[$key_produce]['review_content_number'] = 1;

                        $doctor_new_produce[$key_produce]['b1'] = $v_produce['b1'];
                        $doctor_new_produce[$key_produce]['b2'] = $v_produce['b2'];
                        $doctor_new_produce[$key_produce]['b3'] = $v_produce['b3'];
                        $doctor_new_produce[$key_produce]['b4'] = $v_produce['b4'];


                        $doctor_new_produce[$key_produce]['commect_review'] = $v_produce['commect_review'];
                        //排序
                        if ($_REQUEST['sort_type'] == "1" || $_REQUEST['sort_type'] == "") {
                            $temp_doctor_produce_number[$key_produce] = $doctor_new_produce[$key_produce]['review_content_number'];
                        } else if ($_REQUEST['sort_type'] == "2") {
                            $temp_doctor_produce_number[$key_produce] = $doctor_produre_info['review_scorce'];
                        } else{

                            $soft_type = $_REQUEST['sort_type'] - 2;
                            $temp_doctor_produce_number[$key_produce] = $doctor_new_produce[$key_produce][$this->soft_array[$soft_type -1]];



                        }

                        



                       


                        //$doctor_new_produce = $this->getDoctorReview($doctor_produre_info['review_number'], $user, $doctor_new_produce, $pageAction, $currentPage, $key_produce);
                        // 存储 该医疗项目 对应的 是 哪个键名
                        $temp_doctor_review[$produce_name] = $key_produce;
                        $key_produce++;
                        array_push($temp_doctor_produce, $produce_name);
                    }
                } else {
                    if ($temp_doctor_review[$produce_name] >= 0) {
                        $key_produce_new = $temp_doctor_review[$produce_name];
                        $doctor_new_produce[$key_produce_new]['review_content_number'] +=1;


                         //排序
                        if ($_REQUEST['sort_type'] == "1" || $_REQUEST['sort_type'] == "") {
                            $temp_doctor_produce_number[$key_produce_new] = $doctor_new_produce[$key_produce_new]['review_content_number'];
                        } else if ($_REQUEST['sort_type'] == "2") {
                            $temp_doctor_produce_number[$key_produce_new] = $doctor_produre_info['review_scorce'];
                        } else{

                            $soft_type = $_REQUEST['sort_type'] - 2;

                            if($sort_type >= 1){

                               $temp_doctor_produce_number[$key_produce]+=$doctor_new_produce[$key_produce][$this->soft_array[$soft_type -1]];
                            }
                            
                        }


                        //$temp_doctor_produce_number[$key_produce_new] = $doctor_new_produce[$key_produce_new]['review_content_number'];
                    }
                }
                /**
                 * 获取医生的所有的星级分数 累加
                 */
                $s1 +=$v_produce['b1'];
                $s2 +=$v_produce['b2'];
                $s3 +=$v_produce['b3'];
                $s4 +=$v_produce['b4'];
            }


            /**
             * 分数计算
             */
            $s1 = round($s1 / $review_count, 1);
            $s2 = round($s2 / $review_count, 1);
            $s3 = round($s3 / $review_count, 1);
            $s4 = round($s4 / $review_count, 1);
            array_push($reviewScore, $s1, $s2, $s3, $s4);


            //根据数量 进行排
            array_multisort($temp_doctor_produce_number, SORT_DESC, $doctor_new_produce);
            /**
             * 遍历数组  获取 医生在这个医疗项目中的分页
             */
            foreach ($doctor_new_produce as $new_produce_k => $new_produce) {
                $doctor_new_produce[$new_produce_k] = $this->doctorProdureReviewPaging($new_produce['review_content_number'], $new_produce, $pageAction, $currentPage, $user, $new_produce_k);
            }
            $array['doctor_new'] = $doctor_new_produce;
            $array['review_sorce'] = $reviewScore;
            return json_encode($array);
        }
    }

    /**
     * 获取医生的所有的review评论
     * min 分页的最小值
     * max 分页的最大值
     * doctor_id 医生id
     * page  当前页数
     */
    public function doctorAllReview($doctor_id, $page, $User, $pageAction) {
        $sql = 'SELECT  commect_review,review_id FROM ohc_review where doctors_id =  ' . $doctor_id;
        $doctor_review_all = $this->query($sql);
        $doctor_review_count = count($doctor_review_all);
        $doctor_review = $this->getDoctorReview($doctor_review_count, $User, $doctor_review_all, $pageAction, $page, ($page - 1));
        return $doctor_review[$page - 1];
    }

    /**
     * 获取医生 某项医疗项目的 review 内容
     */
    public function doctorProduceReview($page, $doctor_info, $key, $produce_name, $pageAction, $user) {
        $produce_info = D('Procedure')->getProceduresValById($produce_name);
        if ($produce_info['procedure_type'] == 'Other Name') {
            $produce_where = ' procedures_other_name = "' . $produce_name . '"';
        } else {
            $produce_where = ' procedures_name = "' . $produce_name . '"  AND  procedures_other_name  IS NULL ';
        }
        $sql = 'SELECT commect_review,review_id FROM ohc_review WHERE doctors_id = ' . $doctor_info['doctor_id'] . ' AND ' . $produce_where;
        $doctor_review = $this->query($sql);
        $doctor_review_count = count($doctor_review);
        $doctor_new_produce = $this->doctorProdureReviewPaging($doctor_review_count, $doctor_review[$page - 1], $pageAction, $page, $user, $key);
        return $doctor_new_produce;
    }

    /**
     * 医生详情  医生中的全部review分页
     * @param type $number
     * @param type $User
     * @param type $doctor_review
     * @param type $pageAction
     * @param type $currentPage
     * @param type $currentReview
     * @return int
     */
    public function getDoctorReview($number, $User, $doctor_review, $pageAction, $currentPage = 1, $currentReview = 0) {
        if ($User == 0) {
            $doctor_review[$currentReview]['review_page'] = $pageAction->getPage($currentPage, $number, 1, 'doctor:doctorreview', 'seachSmall', 'no');
        } else {
            $doctor_review[$currentReview]['review_page'] = $pageAction->getPage($currentPage, $number, 1, 'doctor:doctorreview', 'seachSmall');
        }
        if ($User == 1) {
            $review_like_count = M('ohc_review_like')->where('user_id = ' . $_SESSION['user_id'] . ' and review_id = ' . $doctor_review[$currentReview]['review_id'])->count();
            if ($review_like_count == 0) {
                $doctor_review[$currentReview]['produre_reviewlike'] = 1;
            } else {
                $doctor_review[$currentReview]['produre_reviewlike'] = 0;
            }
        } else {
            $doctor_review[$currentReview]['produre_reviewlike'] = 0;
        }
        return $doctor_review;
    }

    /**
     * 医生详情  医疗项目中的分页
     * @param type $doctor_produre_list
     * @param type $pageAction
     * @param type $currentPage
     * @param type $user
     * @param type $key
     * @return type
     */
    public function doctorProdureReviewPaging($number, $doctor_produre_list, $pageAction, $currentPage, $user, $key) {
        if ($user == 1) {
            $review_like_count = M('ohc_review_like')->where('user_id = ' . $_SESSION['user_id'] . ' and review_id = ' . $doctor_produre_list['review_id'])->count();
            if ($review_like_count == 0) {
                $doctor_produre_list['produre_reviewlike'] = 1;
            }
        }
        if ($user == 0) {
            $doctor_produre_list['page'] = $pageAction->getPage($currentPage, $number, 1, 'doctor:produrelist:' . $key . '', 'seachSmall', 'no');
        } else {
            $doctor_produre_list['page'] = $pageAction->getPage($currentPage, $number, 1, 'doctor:produrelist:' . $key . '', 'seachSmall');
        }
        return $doctor_produre_list;
    }

    /**
     * 
     */
    public function getUserReviewByNew($page) {
        $userReviewquery = 'select review_id,doctors_frist_name,doctors_id,doctors_last_name,doctor_middle_name,city_location,state from ohc_review   GROUP BY doctors_id ORDER BY review_time DESC';
        $otherReviewDataResult = $userReviewDataResult = array();
        $this->review_All_array = $this->query($userReviewquery);
        $this->vars_number = count($this->review_All_array);
        if ($this->vars_number > 0) {
            foreach ($this->review_All_array as $k_result => $v_result) {
                if ($k_result == $page - 1) {
                    $userReviewData = 'select commect_review from ohc_review where  doctors_id = ' . $v_result['doctors_id'] . '  order by review_id  DESC   limit 3 ';
                    $userReviewDataResult = $this->query($userReviewData);
                    $this->review_array[$k_result]['doctor_info'] = $v_result;
                    if (count($userReviewDataResult) > 0) {
                        foreach ($userReviewDataResult as $k_user_result => $v_user_result) {
                            $this->review_array[$k_result]['doctor_info']['review'][$k_user_result] = $v_user_result['commect_review'];
                            unset($v_user_result);
                        }
                    }
                }
            }
        }
    }


    public function getDoctorSoftSumVal($doctorId,$type){

        $doctorReviewQuery = 'select sum('.$this->soft_array[$type - 1].') as soft_val from ohc_review where doctors_id = '.$doctorId;

        $soft_result= $this->query($doctorReviewQuery);

        $soft_val = ($soft_result[0]['soft_val'] > 0 ) ? $soft_result[0]['soft_val'] : 0;

        return $soft_val;


    }

}

?>