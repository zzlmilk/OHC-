<?php


/**
 * 医生对某个医疗项目的得分
 */
$doctor = file_get_contents('http://transparentmedicalcare.com/?g=Crontab&m=crontab&a=crontabdoctor');
/**
 * 医生所有项目中的得分
 */
$doctor_all = file_get_contents('http://transparentmedicalcare.com/?g=Crontab&m=crontab&a=doctorreviewAll');
/**
 *  计算诊所的综合评分 为 所有的医生 以及 所有的项目 的 平均分
 */
$hospital = file_get_contents('http://transparentmedicalcare.com/?g=Crontab&m=crontab&a=hospitallist');
/**
 * 某个医疗项目 在 某个城市的 综合评分
 */
$produce = file_get_contents('http://transparentmedicalcare.com/?g=Crontab&m=crontab&a=hospital_review');
?>
