<?php

class crontabAction extends Action {

    /**
     * 计算 某个医生 对 某个项目的 星级
     */
    public function crontabdoctor() {

        set_time_limit(0);

        

        // $doctor_number = D('Doctor')->count();

        // $size = 100;


        // $number = ceil($doctor_number/$size);


        // for($i = 1; $i<=$number; $i++){

        //         $a = $size * ($i - 1);

        


        $number = $_REQUEST['number'];


        if($number <=0  || empty($number)){

            echo ' number is empty';
            die;
        } 

        $doctor_all = D('Doctor')->getDoctorLimit($number);


       


                    /**
                     *  计算 该医生 以及 这个项目的 综合评分
                     *  先计算 该城市  对 该医疗项目的 话费的平均值 
                     * 
                     *  后计算综合得分
                     */

             foreach ($doctor_all as $k_doctor=>$v_doctor) {


                echo $k_doctor.'<br />';
                    D('Review')->sumDoctorAndProduceScroce($v_doctor['doctor_id']);
                    unset($v_doctor);

            }

            unset($doctor_all);

            
        //}

      

    
       
    }

    /**
     * 计算某个医疗项目 在 某个城市的 综合评分
     * 获取review_fraction表中 获取单一的医疗项目 以及区域编码 
     */
    public function hospital_review() {
          ini_set("memory_limit","4048M");
        $model = M();
        $sql = 'select review_scorce from ohc_review_fraction group by produce_name"';
        $procedures_list = $model->query($sql);
        $city_list = D('Code')->select();
        foreach ($city_list as $city_v) {
            foreach ($procedures_list as $v_list) {
                $this->hosptialReviewCalculate($v_list['procedure_name'], $city_v['code_id']);
            }
        }
    }

    public function hosptialReviewCalculate($name, $zip_code, $return = 1) {
          ini_set("memory_limit","4048M");
        $fina_level = 0;
        $areaZipCode = (int)substr($zip_code, 0, 3);
        $sql = 'select review_scorce from ohc_review_fraction  where  produce_name  like "' . $name . '" and  city_zip_code like  "' . $areaZipCode . '"';
        $model = M();
        $review_list = $model->query($sql);
        if (count($review_list) > 0) {
            foreach ($review_list as $v_hospital) {
                $fina_level+=$v_hospital['review_scorce'];
            }
            $HospitalScorece = floor($fina_level / count($review_list) * 100) / 100;
            $data['review_scorce'] = $HospitalScorece;
            /**
             * 
             */
            $produre_review = M('ohc_procedures_review')->where('procedures_name like "' . $name . '" and  zip_code like "' . $areaZipCode . '"')->find();
            if (count($produre_review) == 0) {
                $data['procedures_name'] = $name;
                $data['zip_code'] = $areaZipCode;
                M('ohc_procedures_review')->add($data);
            } else {
                M('ohc_procedures_review')->where('procedures_name like "' . $name . '" and  zip_code  like "' . $areaZipCode . '"')->save($data);
            }

            /**
             * return  2为 搜索时 直接调用
             */
            if ($return == 2) {
                return $data['review_scorce'];
            }
            unset($data);
        }
    }

    /**
     * 计算某个医生在所有项目中的综合评分
     */
    public function doctorreviewAll() {
          $doctor_all = D('Doctor')->selectReviewDoctorInfo();
        if (count($doctor_all) > 0) {
            foreach ($doctor_all as $v_doctor) {
                $this->doctorall($v_doctor['doctors_id']);
            }
        }
    }

    /**
     * 当数据库这个医生的数据时 则单独获取该医生的 综合评分
     * @param type $fristname
     * @param type $lastname 
     */
    public function doctorall($doctorId, $return = 1) {
          
        /**
         * 数据库获取该医生的所有的医疗项目分数
         */
        $doctor_review_id = D('Doctor')->doctorAllSorce($doctorId);
        /**
         * return  2为 搜索时 直接调用
         */
        if ($return == 2) {
            return $doctor_review_id;
        }
    }

    /**
     *  计算诊所的综合评分 为 所有的医生 以及 所有的项目 的 平均分
     */
    public function hospitallist() {

        /**
         * 获取医院库中存在的医院名称 进行计算
         */
        $hospital_list = M('ohc_hospital')->select();
        foreach ($hospital_list as $v_list) {
            $this->hospitallistDetail($v_list['ohc_hospital_id']);
        }
    }

    /*
     * 详细计算诊所的综合评分
     */

    public function hospitallistDetail($hospital_id, $produre_arg = -1, $produre_count = -1, $return = 0) {

        /**
         * 遍历数组 查询是否有相同的医疗项目 并累加review条数
         */
        $review = D('Review');
        $review->sumHospitalInDoctor($hospital_id, $produre_arg = -1, $produre_count = -1);
        if ($return == 1) {
            return $review->hospital_scorce;
        }
    }

}

?>
