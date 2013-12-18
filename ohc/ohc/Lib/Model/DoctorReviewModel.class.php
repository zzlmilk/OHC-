<?php

/**
 * 2013-8-1 by zxp
 * 医生总综合评分类
 */
class DoctorReviewModel extends Model {

    var $tableName = 'ohc_doctor_review';

    public function getDoctorScorceValByDoctorId($doctorid) {

        $doctorReviewScore = $this->where("doctor_id =" . $doctorid)->find();
        /**
         * 2013-8-1  by zxp
         * 添加判断 如该医生无总分 则调用计划任务 进行计算
         */
        if (count($doctorReviewScore) <= 0) {
            R('Crontab/crontab/doctorall', array($doctorid, 2));
            $doctorReviewScore = M("ohc_doctor_review")->where("doctor_id ='" . $doctorid . "'")->find();
        }
        return $doctorReviewScore;
    }
    /**
     * 获取医生 的 所有 分数
     */
    public function getDoctorScorceValById($doctorid){
        $doctorReviewScore = $this->where("doctor_id =" . $doctorid)->find();
        $doctorScore = ($doctorReviewScore['review_scroce'] > 0) ? $doctorReviewScore['review_scroce'] : 0;
        return $doctorScore;
    }
}

?>
