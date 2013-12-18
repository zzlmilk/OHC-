<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class testDoctorAction extends Action {

    public function testdoctor() {
        $doctor_fristname = $_REQUEST['doctor_fristname'];
        $doctor_lastname = $_REQUEST['doctor_lastname'];
        $zip_code = $_REQUEST['zip_code'];
        $testCount = 5 - strlen($zip_code);
        $subfiex = '';
        for($i = 1 ; $i <= $testCount ; $i++){
            $subfiex .= '0';
        }
        $newSubfiex = (string)$subfiex.$zip_code;
        $newSubfiex = substr($newSubfiex, 0, 3);
        $doctor_info = D('Doctor')->getDoctorByWhere($doctor_fristname, $doctor_lastname, $zip_code);
        D('Doctor')->doctorAllSorce($doctor_info['doctor_id']);
        if (count($doctor_info) > 0) {
            //某个城市 对 某个医疗项目 的 综合评分
            $review = D('Review')->getReviewListBydoctor($doctor_info['doctor_id']);
            foreach ($review as $vv_review) {
                //某个城市中所有病人就医疗项目 的花费的平均值
                D('Review')->getReivewListBycodeAndProduces($newSubfiex, $vv_review['procedures_name']);
                echo '医疗项目的名称:' . $vv_review['procedures_name'] . '<br />';
                echo $zip_code . '对' . $vv_review['procedures_name'] . '分数：' . D('Review')->city_review_rate . '<br />';
                echo '------------------------------------------------------------------------------------';
                echo '<br />';
                //医生 就医疗项目 的收费的平均值
                D('Review')->getReviewListByDoctorProduce($vv_review['doctors_id'], $vv_review['procedures_name'], $newSubfiex);
                echo $doctor_info['full_name'] . '对医疗项目的名称:' . $vv_review['procedures_name'] . '分数：' . D('Review')->doctor_review_rate . '<br />';
                echo '------------------------------------------------------------------------------------';
                echo '<br />';
                //医生 在医疗项目 
                $review = D('Review')->UpdateReivewLevelByReivewId($vv_review['review_id']);
                echo '医生对' . $vv_review['procedures_name'] . '的综合评分：' . D('Review')->review_level;
                echo '<br />';
                echo '------------------------------------------------------------------------------------';
                echo '<br />';
                unset($vv_review);
                D('Review')->emptyVars();
            }
            D('Doctor')->doctorAllSorce($doctor_info['doctor_id']);
            $doctor_review = M('ohc_doctor_review')->where('doctor_id   = ' . $doctor_info['doctor_id'])->find();
            echo '医生对所有医疗项目的的综合评分：' . $doctor_review['review_scroce'];
        } else {
            echo '医生不存在';
            die;
        }
    }

    /**
     *   某个医疗项目  对 某个地区的 综合评分
     */
    public function testproduce() {
        $produce_id = $_REQUEST['produce_id'];
        $zip_code = $_REQUEST['zip_code'];
        $producde_name = M('ohc_procedure')->where('id = ' . $produce_id)->find();
        $scorce = R('Crontab/crontab/hosptialReviewCalculate', array($producde_name['procedure_name'], $zip_code, 2));
        echo '分数为:' . $scorce;
        die;
    }

    /**
     * 诊所 所有的项目 以及 所有的医生的分数
     */
    public function testHospital() {
        $hospitalId = $_REQUEST['hospital_id'];
        $scorce = R('Crontab/crontab/hospitallistDetail', array($hospitalId, -1, -1, 1));
        echo '医院分数为:' . $scorce;
        die;
    }

}

?>
