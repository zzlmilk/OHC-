<?php

class SearchIndexModel extends Model {

    public $fina_review_level = 0;
    public $review_level = 0;
    public $doctor_produre_review;
    public $produre_scores;
    public $count_produre_list;
    //医院详情
    public $hospital_array = array();

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

}

?>
