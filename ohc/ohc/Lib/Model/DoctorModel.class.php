<?php

class DoctorModel extends Model {

    var $tableName = 'ohc_doctor';
    var $vars_number = 0;
    private $fieldStr = "review_number,doctor_id,doctor_gender,doctor_frist_name,doctor_middle_name,doctor_last_name,street_city,street_state,street_zip,specialty,specialty2,title";

    /**
     * 根据条件 获取单独医生数据 或 全部医生数据
     * @param type $doctor_fristname
     * @param type $doctor_lastname
     * @param type $city_location
     * @return type
     */
    public function getDoctorListByWhere($doctor_fristname = '', $doctor_lastname = '', $city_location = '') {
        $where = '';
        if ($doctor_fristname != '' && $doctor_lastname != '' && $city_location != '') {
            $where = 'doctor_frist_name like "' . $doctor_fristname . '" and doctor_last_name like "' . $doctor_lastname . '" and mailing_city  like "' . $city_location . '"';
        }
        $result = $this->where($where)->select();
        $this->vars_number = count($result);
        return $result;
    }

    public function getDoctorByWhere($doctor_fristname = '', $doctor_lastname = '', $zip_code = '') {
        $where = '';
        if ($doctor_fristname != '' && $doctor_lastname != '' && $zip_code != '') {
            $where = 'doctor_frist_name like "' . $doctor_fristname . '" and doctor_last_name like "' . $doctor_lastname . '" and street_zip  like "' . $zip_code . '%"';
        }
        $result = $this->where($where)->find();
        return $result;
    }

    /**
     * 计算该医生  所有项目 的得分
     */
    public function doctorAllSorce($doctorId) {
        $doctor_produce_list = M('ohc_review_fraction')->where('doctor_id = ' . $doctorId)->select();
        $doctor_produce_list_count = count($doctor_produce_list);
        if ($doctor_produce_list_count > 0) {
            foreach ($doctor_produce_list as $v_list) {
                $fina_level +=$v_list['review_scorce'];
                unset($v_list);
            }
            $doctor_review = M('ohc_doctor_review')->where('doctor_id   = ' . $doctorId)->find();
            $review_level = $fina_level / $doctor_produce_list_count;
            $review_level_ = floor($review_level * 100) / 100;
            if (count($doctor_review) == 0) {
                $data['doctor_id'] = $doctorId;
                $data['review_scroce'] = $review_level_;
                $doctor_review_id = M('ohc_doctor_review')->add($data);
            } else {
                $doctor_review_id = $doctor_review['doctor_review_id'];
                $data['review_scroce'] = $review_level_;
                M('ohc_doctor_review')->where('doctor_id   = ' . $doctorId)->save($data);
            }
            return $doctor_review_id;
        }
    }

    /**
     * review 添加middleName
     */
    public function getDoctorByFullName($doctor_middle_name = '', $doctor_fristname = '', $doctor_lastname = '', $zip_code = '') {
        $where = '';
        /**
         * 获取城市以及州名
         */
        $areaZipCode = D('Review')->writeZipCode($zip_code);
        $cityInfo = D('Code')->getCodeValById($areaZipCode);
        if ($doctor_fristname != '' && $doctor_lastname != '' && $zip_code != '') {
            /**
             * 2013-8-1 by zxp
             * 添加 判断 如医生middle name 为空时 搜索数据库时 不添加middlename 进行查询
             */
            if (!empty($doctor_middle_name)) {
                $whereTemp = 'doctor_middle_name like "' . $doctor_middle_name . '" and';
            } else {
                $whereTemp = '';
            }
            $where = $whereTemp . ' doctor_frist_name like "' . $doctor_fristname . '" and doctor_last_name like "' . $doctor_lastname . '" and (street_zip  like "' . $zip_code . '%"
                or (street_city like "' . $cityInfo['city'] . '" and street_state like "' . $cityInfo['state'] . '"))';
        }

        $result = $this->where($where)->find();
        return $result;
    }

    /**
     * review 条数 自增长
     */
    public function updateReviewNuberByDoctorId($doctor_id) {
        $this->where('doctor_id = ' . $doctor_id)->setInc('review_number', 1);
    }

    /**
     * 查询语句 处理
     */
    public function searchDoctorQuery($searchtext, $searchlocation) {
        /**
         * 获取城市中的邮编区段 查询邮编前3位
         */
        $oldwhere = '';
        $where = '';
        if (!empty($_REQUEST['search_text_id']) && $_REQUEST['search_text_id'] > 0) {
            $sql = 'SELECT ' . $this->fieldStr . ' FROM ohc_doctor WHERE  doctor_id = ' . $_REQUEST['search_text_id'];
        } else {
            if (!empty($searchlocation)) {
                if ($_REQUEST['search_advanced_type'] == 1) {
                    $code = $_REQUEST['location_search_text'];
                } else {
                    $code = $_REQUEST['search_text_location'];
                }
                $codeArray = D('Code')->getMaxCodeByCityAndState($code);
                $codeMinArray = D('Code')->getMinCodeIdByCityAndCity($code);
                if($codeMinArray['new_code'] == $codeArray['new_code']){
                    $where.=' AND street_city = "' . $codeArray['city'] . '" AND street_state = "' . $codeArray['state'] . '"';
                } else{
                    $where .=' AND street_zip  between   "' . $codeMinArray['new_code'] . '%" AND "' . $codeArray['new_code'] . '%" AND street_city = "' . $codeArray['city'] . '" AND street_state = "' . $codeArray['state'] . '"';
                }
                if($codeMinArray['old_code'] == $codeArray['old_code']){
                     $oldwhere.=' AND street_city = "' . $codeArray['city'] . '" AND street_state = "' . $codeArray['state'] . '"';
                } else{
                     $oldwhere.=' AND street_zip  between   "' . $codeMinArray['old_code'] . '%" AND "' . $codeArray['old_code'] . '%" AND street_city = "' . $codeArray['city'] . '" AND street_state = "' . $codeArray['state'] . '"';
                }
                
               
            }
            /**
             * 拼写医生sql语句  
             */
            if (!empty($searchtext)) {
                if (strpos($searchtext, ' ')) {
                    $search_array = array_filter(explode(' ', $searchtext));
                } else {
                    $search_array = array_filter(explode(',', $searchtext));
                }
                $search_new_array = search_filter($search_array);
                $search_array_count = count($search_new_array);
                switch ($search_array_count) {
                    case '3':
                        $sql = '(SELECT ' . $this->fieldStr . ' FROM ohc_doctor  WHERE doctor_frist_name = "' . $search_new_array[0] . '" AND doctor_middle_name  = "' . $search_new_array[1] . '"' . $where . '';
                        $sql.=' AND doctor_last_name ="' . $search_new_array[2] . '")';
                        if ($oldwhere != $where) {
                            $sql.=' UNION ALL ';
                            $sql .= '(SELECT ' . $this->fieldStr . ' FROM ohc_doctor  WHERE doctor_frist_name = "' . $search_new_array[0] . '" AND doctor_middle_name  = "' . $search_new_array[1] . '"' . $oldwhere . '';
                            $sql.=' AND doctor_last_name ="' . $search_new_array[2] . '")';
                        }
                        break;
                    case '2':
                        $sql = '(SELECT ' . $this->fieldStr . ' FROM ohc_doctor where doctor_frist_name = "' . $search_new_array[0] . '" AND doctor_last_name = "' . $search_new_array[1] . '"' . $where . ')';
                        $sql.=' UNION ALL ';
                        $sql.= '(SELECT ' . $this->fieldStr . ' FROM ohc_doctor where doctor_frist_name = "' . $search_new_array[1] . '" AND doctor_last_name = "' . $search_new_array[0] . '"' . $where . ')';
                        if ($oldwhere != $where) {
                            $sql.=' UNION ALL ';
                            $sql = '(SELECT ' . $this->fieldStr . ' FROM ohc_doctor where doctor_frist_name = "' . $search_new_array[0] . '" AND doctor_last_name = "' . $search_new_array[1] . '"' . $oldwhere . ')';
                            $sql.=' UNION ALL ';
                            $sql.= '(SELECT ' . $this->fieldStr . ' FROM ohc_doctor where doctor_frist_name = "' . $search_new_array[1] . '" AND doctor_last_name = "' . $search_new_array[0] . '"' . $oldwhere . ')';
                        }
                        $sql.=' ORDER BY review_number DESC';
                        break;
                    case '1':
                        $sql = '(SELECT ' . $this->fieldStr . ' FROM ohc_doctor where doctor_frist_name = "' . $search_new_array[0] . '"' . $where . ')';
                        $sql.=' UNION ALL ';
                        $sql.= '(SELECT ' . $this->fieldStr . ' FROM ohc_doctor where doctor_last_name = "' . $search_new_array[0] . '"' . $where . ')';
                        if ($oldwhere != $where) {
                            $sql.=' UNION ALL ';
                            $sql = '(SELECT ' . $this->fieldStr . ' FROM ohc_doctor where doctor_frist_name = "' . $search_new_array[0] . '"' . $oldwhere . ')';
                            $sql.=' UNION ALL ';
                            $sql.= '(SELECT ' . $this->fieldStr . ' FROM ohc_doctor where doctor_last_name = "' . $search_new_array[0] . '"' . $oldwhere . ')';
                        }
                        $sql.=' ORDER BY review_number DESC';
                        break;
                }
            } else {
                $sql = '(SELECT ' . $this->fieldStr . ' FROM ohc_doctor  WHERE  1' . $where . ')';
                if ($oldwhere != $where) {
                    $sql.=' UNION ALL ';
                    $sql .= '(SELECT ' . $this->fieldStr . ' FROM ohc_doctor  WHERE 1 ' . $oldwhere . ')';
                }
            }
        }
        /**
         * 获取相关医生信息
         */
        $doctor_list = $this->query($sql);
        return $doctor_list;
    }

    /**
     * 医生列表 查询
     */
    public function doctorListSearch($review, $max, $min) {
        $SearchIndex = D('SearchIndex');
        /**
         * 获取医生全部得分 
         */
        if ($_REQUEST['sort_type'] == "1" || $_REQUEST['sort_type'] == "") {
            $doctor_new_list = $SearchIndex->getDoctorSorceByReviewAndSortReviewNumber($review, $max, $min);
        } else if ($_REQUEST['sort_type'] == "2") {
            $doctor_new_list = $SearchIndex->getDoctorListBySortScorceAndShow($review, $max, $min);
        }
        return $doctor_new_list;
    }

    /**
     *
     */

    public function selectReviewDoctorInfo(){

        $selectDoctorSql = 'select DISTINCT doctors_id from  ohc_review  ';
        $result = $this->query($selectDoctorSql);
        return $result;
    }

}

?>