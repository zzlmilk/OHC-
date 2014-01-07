<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class searchAction extends Action {

    function _initialize() {
        $type = $_REQUEST['searchscroce'];
        $sort_type = $_REQUEST['sort_type'];
        $this->pageconfig();
        $this->pagereview($_REQUEST['searchval']);
        $typeDetail = explode(':', $type);
        switch ($sort_type) {
            case 1:
                $this->order = "review_time desc";
                break;
            case 2 :
                $this->order = "review_level desc";
                break;
            default :
                $this->order = "";
                break;
        }
        /**
         * 大页面 分页
         */
        if (count($typeDetail) == 2) {
            switch ($type) {
                case 'produce_doctor:nomral':
                    $this->produce_doctor($_REQUEST);
                    break;
                case 'doctor:doctorreview':
                    $this->doctor_review($_REQUEST);
                    break;
                case 'doctor:doctorlist':
                    $this->doctor_list($_REQUEST);
                    break;
                case "hospitalList:nomral":
                    $this->hospitalList($_REQUEST);
                    break;
            }
        }
        /**
         * 小页面分页 数值传过来带有数值
         */
        if (count($typeDetail) == 3) {
            switch ($typeDetail[1]) {
                case 'produrelist':
                    $this->doctor_produrelist_value($_REQUEST, $typeDetail[2]);
                    break;
            }
        }
        $this->assign('thisPage', $this->page);
        $this->assign("thisUser", $this->user);
    }
    
    function index() {
        $this->display($this->displaypage);
    }

    function produce_doctor($data) {
        if ($_REQUEST['search_advanced_type'] == 1) {
            $produceSearchText = $_REQUEST['procedure_search_text'];
        } else {
            $produceSearchText = $_REQUEST['search_text'];
        }
        /**
         * 医生列表获取
         */
        $doctor_list_all = M('ohc_review')->where('(procedures_name like "' . trim($produceSearchText) . '" or procedures_other_name like"' . trim($produceSearchText) . '") and  city_zip_code like "' . $data['location_zip_code'] . '"  and display_able = 0   ')->join(' ohc_doctor ON ohc_review.doctors_id = ohc_doctor.doctor_id')->limit($this->limit)->order($this->order)->select();

        $doctor_list = M('ohc_review')->where('(procedures_name like "' . trim($produceSearchText) . '" or procedures_other_name like"' . trim($produceSearchText) . '") and  city_zip_code like "' . $data['location_zip_code'] . '"  and display_able = 0   ')->join(' ohc_doctor ON ohc_review.doctors_id = ohc_doctor.doctor_id')->limit($this->min, $this->max)->order($this->order)->select();


//        $doctor_list_all = M('ohc_review')->where('procedures_name like "' . trim($data['search_text']) . '"  and  city_location like "' . $data['search_text_location'] . '" and  review_unique = 1 and display_able = 0   ')->join(' ohc_doctor ON ohc_review.doctors_id = ohc_doctor.doctor_id')->limit($this->limit)->select();
//        $doctor_list = M('ohc_review')->where('procedures_name like "' . trim($data['search_text']) . '"  and  city_location like "' . $data['search_text_location'] . '" and  review_unique = 1 and display_able = 0   ')->join(' ohc_doctor ON ohc_review.doctors_id = ohc_doctor.doctor_id')->limit($this->min, $this->max)->select();
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
        $page = $this->getPage($this->page, count($doctor_list_all), $this->max, 'produce_doctor:nomral', '');
        $this->assign('doctor_list', $doctor_list);
        $this->assign('doctor_text', $doctor_text);
        $this->assign('doctor_page', $page);
        $this->displaypage = 'produce_doctor';
    }

    public function doctor_review($data) {
        
        
        $review = D('Doctor')->searchDoctorQuery($_REQUEST['search_text'], $_REQUEST['search_text_location']);
        $doctor_info = $review[0];

        $doctor_review = D('Review')->doctorAllReview($doctor_info['doctor_id'],  $this->page,  $this->user,$this);
        $this->assign('doctor_review', $doctor_review);  //医生所有review中的一条评论
            
        $this->displaypage = 'doctor_review';
    }

    /**
     * 医生页面中 医疗项目 分页
     */
    public function doctor_produrelist_value($data, $key) {
       $review = D('Doctor')->searchDoctorQuery($data['search_text'],$data['search_text_location']);
       $review_count = count($review);
       $doctor_info = $review[0];
        if($review_count > 0 ){
            if(!empty($_REQUEST['produce_name'])){
              $doctor_review_prodouce=  D('Review')->doctorProduceReview($this->page,$doctor_info,$key,$_REQUEST['produce_name'],$this,  $this->user);
            }
            $this->assign('vo',$doctor_review_prodouce);
            $this->assign('k',$key);
        }
        $this->displaypage = 'doctor_produce_list';
    }

    /**
     *  医生列表中的医生分页
     */
    public function doctor_list() {
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
            $this->doctorListView($review, $reviewCount);
        }
    }

    public function hospitalsearch() {
        $hospital_list = M('ohc_review')->where($this->where)->group('hospitals_name')->limit($this->limit)->order("review_time desc")->select();
        hospitalList($hospital_list);
    }

    public function hospitalList($data) {
        //var_dump($hospital_list);
        $min = ($this->page - 1) * 2;
        $max = 2 * $this->page - 1;
        $hospital_list_info = D('Hospital')->getHospitalValByAllName($data['search_text']);
        foreach ($hospital_list_info as $kHospital => $iHospital) {
            if ($kHospital >= $min && $kHospital < $max) {
                $hospital_name = $iHospital['hospital_name'];
                D('Review')->getHospitalDetail($hospital_name, (int) $kHospital);
            }
        }
        $thisPage = $this->getPage($this->page, count($hospital_list), 2, "hospitalList:nomral", "");
        $this->assign("paging", $thisPage);
        $this->assign('hospital_list', D('Review')->hospital_array);
        $this->displaypage = "hospitalList";
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
            $doctor_review_page = $this->getPage($this->page, $reviewCount, 3, 'doctor:doctorlist', 'seachBig', 'no');
        } else {
            $doctor_review_page = $this->getPage($this->page, $reviewCount, 3, 'doctor:doctorlist', 'seachBig');
        }
        $this->assign('doctor_list_count', $reviewCount);
        $this->assign('doctor_list', $doctor_new_list);
        $this->assign('doctor_json_list', json_encode($doctor_new_list));
        $this->assign('doctor_page', $doctor_review_page);
        $this->assign('current', ceil($this->page / 5));
        $this->displaypage = 'doctor_list';
    }

}

?>
