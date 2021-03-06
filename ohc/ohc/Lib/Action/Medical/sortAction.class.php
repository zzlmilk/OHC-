<?php
/**
 * 搜索 排序使用
 *
 * @author Administrator
 */
class sortAction extends Action {
    
    function _initialize() {
        Load('extend');
        //根据类型判断名字  以及是否高级搜索
        $this->pageconfig();
        $this->pagereview();  //页面分页
        $this->advancedSearch($_REQUEST); //高级搜索以及搜索判断 并组装where语句
        /**
         *    根据用户搜索不同的类型   显示不同的页面
         */
        switch ($this->type) {
            case '1':
                $this->doctorsearch();
                break;
            case '2':$this->hospitalsearch();
                break;
            case '3':$this->producereSearch();
                break;
        }
        $this->assign('search_contion', $_REQUEST);
        $this->assign('userable', $this->user);
        $this->assign('search_status', 1);
    }

    function search() {
        $this->display($this->page);
    }



    public function hospitalSql($searchtext, $searchlocation) {
        $this->where .= 'display_able = 0';
        if (!empty($searchtext)) {
            $this->where.=' and hospitals_name like "' . trim($searchtext) . '%"';
        }
        if (!empty($searchlocation)) {
            if ($_REQUEST['location_type'] == 1) {
                $this->where.=' and city_zip_code  like "' . substr($searchlocation, 0, 3) . '"';
            } else {
                $this->where.=' and city_location  like "' . trim($searchlocation) . '"';
            }
        }
    }

    public function procudureSql($searchtext, $searchlocation) {
        $this->where .= 'display_able = 0 ';
        if (!empty($searchtext)) {
            $this->where.=' and (procedures_name like "' . trim($searchtext) . '" or procedures_other_name like "' . trim($searchtext) . '")';
        }
        if (!empty($searchlocation)) {
            if ($_REQUEST['location_type'] == 1) {
                $this->where.=' and city_zip_code  like "' . substr($searchlocation, 0, 3) . '"';
            } else {
                $this->where.=' and city_location  like "' . $searchlocation . '"';
            }
        }
    }

    /**
     *  诊所的查询。。  出现的内容 为 医疗项目 以及 医疗项目的综合评分 以及review的条数
     */
    public function hospitalsearch() {
        $hospital_list = M('ohc_review')->where($this->where . $this->advance_where)->group('hospitals_name')->limit($this->limit)->order($this->order)->select();
        if (count($hospital_list) > 1) {
            $this->hospitalList($hospital_list);
        } else {
            if (count($hospital_list) > 0) {
                $this->hospitalDetail($hospital_list);
            } else {
                $this->page = "noList";
            }
        }
    }

    /**
     * 医院列表
     */
    public function hospitalList($hospital_list) {
        //var_dump($hospital_list);
        $hospitals = $hospital_introduction = array();
        foreach ($hospital_list as $i) {
            $hospital_name = $i['hospitals_name'];
            $hospital_model = M();
            $hospital_sql = 'select * from ohc_review where hospitals_name like "' . $hospital_name . '" group by procedures_name order by review_number DESC LIMIT 0,5';
            $hospital_result = $hospital_model->query($hospital_sql);
            // var_dump($hospital_result);
            if (count($hospital_result) > 0) {

                foreach ($hospital_result as $k_hospital_detail => $v_hospital_detail) {
                    /**
                     * 获取该医疗项目 在地方的评分等级  查询数据库 如数据不存在 则调用计划任务里面的方法
                     */
                    $produre_review = M('ohc_procedures_review')->where('procedures_name like "' . $v_hospital_detail['procedures_name'] . '" and  city_location like "' . $v_hospital_detail['city_location'] . '"')->find();
                    if (count($produre_review) > 0) {
                        $scorce = $produre_review['review_scorce'];
                    } else {
                        $scorce = R('Crontab/crontab/hosptial_review_calculate', array($v_hospital_detail['procedures_name'], $v_hospital_detail['city_location'], 2));
                    }
                    $hospital_result[$k_hospital_detail]['review_scorce'] = $scorce;
                }
                array_push($hospitals, $hospital_result);
            }
            $hospital_info = M('ohc_hospital')->where('hospital_name like "' . $hospital_name . '"')->find();
            array_push($hospital_introduction, $hospital_info);
        }
        $thisPage = $this->getPage(1, count($hospitals), $this->pagesize, "hospitalList:nomral", "");
        // $content= $this->fetch('hospitalList');
        $this->assign("paging", $thisPage);
        $this->assign("hospitals", $hospitals);
        $this->assign('hospital_introduction', $hospital_introduction);
        $this->assign('hospital_list', $hospital_list);
        $this->page = 'ajaxhospitalList';
    }

    /**
     * 单个医院的显示内容
     */
    public function hospitalDetail($hospital_list) {
        /**
         * 获取该医院的所有的医疗项目 并用review数量 进行排序
         */
        $hospital_name = $hospital_list[0]['hospitals_name'];
        $hospital_review = M('ohc_review_content')->field("commect_review")->where("hospitals_name='" . $hospital_name . "'")->order('visit_year DESC')->find();
        $this->assign('hospital_review', $hospital_review);
        $hospital_model = M();
        $hospital_sql = 'select * from ohc_review where hospitals_name like "' . $hospital_name . '" group by procedures_name order by ' . $this->order;
        $hospital_result = $hospital_model->query($hospital_sql);
        if (count($hospital_result) > 0) {
            foreach ($hospital_result as $k_hospital_detail => $v_hospital_detail) {
                /**
                 * 获取该医疗项目 在地方的评分等级  查询数据库 如数据不存在 则调用计划任务里面的方法
                 */
                $produre_review = M('ohc_procedures_review')->where('procedures_name like "' . $v_hospital_detail['procedures_name'] . '" and  city_location like "' . $v_hospital_detail['city_location'] . '"')->find();
                if (count($produre_review) > 0) {
                    $scorce = $produre_review['review_scorce'];
                } else {
                    $scorce = R('Crontab/crontab/hosptial_review_calculate', array($v_hospital_detail['procedures_name'], $v_hospital_detail['city_location'], 2));
                }
                $hospital_result[$k_hospital_detail]['review_scorce'] = $scorce;
            }
            $this->assign('hospital_produce_list', $hospital_result);
        }
        //获取医院基本信息
        $hospital_info = M('ohc_hospital')->where('hospital_name like "' . $hospital_name . '"')->join("ohc_hospital_review ON ohc_hospital.hospital_name =ohc_hospital_review.hospitals_name")->find();
        $this->assign('hospital_info', $hospital_info);
        $this->page = "ajaxhospitalDetail";
    }

    /**
     * 医生搜索 规则  如果医生搜索出来多个 显示列表页面 如果显示一个 则显示 单个医生的详细页面
     */
    public function doctorsearch() {
        $review = D('Doctor')->searchDoctorQuery($_REQUEST['search_text'], $_REQUEST['search_text_location']);
       
        if ($review == null || !$review) {
            $this->page = "noList";
            return;
        }
        $reviewCount = count($review);
        /**
         * 获取review数量 大于1条 则显示列表 否饿就显示详情
         */
        if ($reviewCount >= 1) {
            switch ($reviewCount) {
                case '1';
                    $this->doctorDetailView($review);
                    break;
                default :
                    $this->doctorListView($review, $reviewCount);
            }
        } else {
            $this->page = 'noList';
        }
    }

    /**
     *  医疗项目 查询  出现医生 and 诊所 内容  获取医生 的综合评分 和 诊所的综合评分
     */
    public function producereSearch() {
        $producereVal = M('ohc_review')->where($this->where . $this->advance_where)->group('procedures_name')->find();
        if ($producereVal || count($producereVal) > 0) {

            if ($producereVal["procedures_other_name"] == '') {
                $whereStr = "display_able = 0 and review_unique = 1 and procedures_name like '" . $producereVal['procedures_name'] . "'";
            } else {
                $whereStr = "display_able = 0 and review_unique = 1 and procedures_other_name like '" . $producereVal['procedures_other_name'] . "'";
            }
            $model = M('ohc_review')->where($whereStr)->order('review_time')->select();
            $producere_info = M('ohc_procedure_info')->where('procedure_info_id   = "' . $producereVal['procedures_id'] . '"')->find();

            /**
             * 获取该地区的处方项目 的 综合评分
             */
            /**
             * 获取该医疗项目的 综合评分  如 查询出 有数据 则 获取分数 如数据库没有的话 则调用计划任务的方法  直接返回
             */
            $produre_review = M('ohc_procedures_review')->where('procedures_name like "' . trim($producereVal['procedures_name']) . '"and city_code like "' . trim($producereVal['zip_code']) . '"')->find();
            if (count($produre_review) > 0) {
                $scorce = $produre_review['review_scorce'];
            } else {
                $scorce = R('Crontab/crontab/hosptial_review_calculate', array($producereVal['procedures_name'], $_REQUEST['search_text_location'], 2));
            }


            $producere_info['review_scorce'] = $scorce;
            $producere_info['procedure_name'] = $producereVal['procedures_name'];
            $this->assign('procedure', $producere_info);
            /**
             * 医生列表获取
             */
            if ($_REQUEST['search_advanced_type'] == 1) {
                $produceSearchText = $_REQUEST['procedure_search_text'];
            } else {
                $produceSearchText = $_REQUEST['search_text'];
            }
            $doctor_list_all = M('ohc_review')->where('(procedures_name like "' . trim($produceSearchText) . '" or procedures_other_name like"' . trim($produceSearchText) . '") and  city_zip_code like "' . $producereVal['city_zip_code'] . '"  and display_able = 0   ')->join(' ohc_doctor ON ohc_review.doctors_id = ohc_doctor.doctor_id')->limit($this->limit)->order($this->order)->select();
            $doctor_list = M('ohc_review')->where('(procedures_name like "' . trim($produceSearchText) . '" or procedures_other_name like"' . trim($produceSearchText) . '") and  city_zip_code like "' . $producereVal['city_zip_code'] . '"  and display_able = 0   ')->join(' ohc_doctor ON ohc_review.doctors_id = ohc_doctor.doctor_id')->limit($this->min, $this->max)->order($this->order)->select();
            $doctor_text = array();
            if (count($doctor_list) > 0) {
                foreach ($doctor_list as $k_item => $v_item) {
                    /**
                     * 获取 2条review内容
                     */
                    $review_list = M('ohc_review_content')->where('ohc_review_id = ' . $v_item['review_id'] . ' and commect_review!=""')->limit(2)->select();
                    $doctor_text[$k_item]['review'] = $review_list;
                    $doctor_text[$k_item]['review_count'] = count($review_list);
                }
            }
            $page = $this->getPage(1, count($doctor_list_all), $this->pagesize, 'produce_doctor:nomral', '');
            $this->assign('doctor_list', $doctor_list);
            $this->assign('doctor_text', $doctor_text);
            $this->assign('doctor_page', $page);
            $this->page = 'ajaxprocedure_search';
        } else {
            $this->page = "noList";
            return;
        }
    }

    /**
     * 医生列表
     */
    public function doctorListView($review, $reviewCount) {

        $doctor_new_list = D('Doctor')->doctorListSearch($review, $this->max, $this->min);
        /**
         * 医生多个数据 分页
         */
        if ($this->user == 0) {
            $doctor_review_page = $this->getPage(1, $reviewCount, 3, 'doctor:doctorlist', 'seachBig', 'no');
        } else {
            $doctor_review_page = $this->getPage(1, $reviewCount, 3, 'doctor:doctorlist', 'seachBig');
        }
        $this->assign('doctor_list_count', $reviewCount);
        $this->assign('doctor_list', $doctor_new_list);
        $this->assign('doctor_json_list', json_encode($doctor_new_list));
        $this->assign('doctor_page', $doctor_review_page);
        $this->assign('current', ceil($this->page / 5));
        $this->page = 'ajaxdoctor_list';
    }

    /**
     * 医生详情
     */
    public function doctorDetailView($review) {
        $doctor_info = $review[0];
        /**
         * 获取该医生的医疗项目的信息(review个数 和 分数 评论内容 以及分页) 并排序
         */
        $doctor_produre = json_decode(D('Review')->getDoctorProdure($doctor_info,$this->user,$this,$this->page),true);
        $doctor_produre_new = $doctor_produre['doctor_new'];
        $reviewScore = $doctor_produre['review_sorce'];
        /**
         * 查询 医生的基本信息
         */
        if (count($doctor_produre_new) > 0) {
            /**
             * 获取该医生的评论一条
             */
            $doctor_review = D('Review')->doctorAllReview($doctor_info['doctor_id'],  $this->page,  $this->user,$this);
            $this->assign('doctor_procedure', $doctor_produre_new); //医生某个医疗项目的内容
            $this->assign('doctor_review', $doctor_review);  //医生所有review中的一条评论
        }
        /**
         * 获取医生所有项目的总分
         */
        $doctorReviewScore = D('DoctorReview')->getDoctorScorceValByDoctorId($doctor_info["doctor_id"]);
        $this->assign('doctor_info', $doctor_info);
        $this->assign("doctorReviewScore", $doctorReviewScore);
        $this->assign('reviewScore', $reviewScore);//医生所有的星级的总分
        $this->page = 'ajaxdoctor_search';
    }

}

?>
