<?php

class reviewController extends BaseController {

    protected $templateFile = "review.tpl";

    function __construct($smarty, $function = 'index') {
//        ini_set("max_execution_time", 14000); //设置PHP文件最大执行时间 
        parent::__construct($smarty);
        $this->$function();
    }

    function index() {
        // $this->templateFile='';

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $service = '/admin/redirst.php?action=review';
        $review = new ohc_review();
        $review->addOrderBy("review_id ");
        $join_str = array(array("ohc_user", "ohc_user.user_id", "ohc_review.user_id"));
        $review->addJoin($join_str);
        $review->initialize();

        //var_dump($r);
        $reviewAll = $review->vars_all;
        if ($review->vars_number < 1) {
            $this->assign("reviewAll", $reviewAll);
        } else {
            $array = $review->page0($service, $page, $reviewAll, 10);
            $this->assign("reviewAll", $array['data']); //分页数据
            $this->assign("paging", $array['key']); //分页
        }

//        $this->assign("reviewAll", $reviewAll);
        //var_dump($reviewAll);
        $this->display();
    }

    function pageFunction() {
        $this->index();
    }

    function upDateReview() {
        $review = new ohc_review();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $reviewId = $_POST['reviewId'];
            $doctors_frist_name = $_POST['doctors_frist_name'];
            $doctors_middel_name = $_POST['doctors_middle_name'];
            $doctors_last_name = $_POST['doctors_last_name'];
            $procedures_name = $_POST['procedures_name'];
            $hospitals_name = $_POST['hospitals_name'];
            $city_location = $_POST['city_location'];
            $zip_code = $_POST['zip_code'];
            $commect_review = $_POST['commect_review'];
            $join_str = array(array("ohc_user", "ohc_user.user_id", "ohc_review.user_id"));
            $review->addJoin($join_str);
            $Wherestr = "review_id = $reviewId";
            $review->addCondition($Wherestr, 1);
            $updateStr = "
            ohc_review.doctors_frist_name='$doctors_frist_name'
            ,ohc_review.doctors_last_name='$doctors_last_name'
            ,ohc_review.doctor_middle_name='$doctors_middel_name'  
            ,ohc_review.procedures_name= '$procedures_name' 
            ,ohc_review.hospitals_name= '$hospitals_name' 
            ,city_location= '$city_location' 
            ,zip_code= '$zip_code' 
            ,commect_review= '$commect_review'
        ";
            $review->update($updateStr, 1);
            $this->index();
        } else {
            $reviewId = $_GET["reviewId"];
            $join_str = array(array("ohc_user", "ohc_user.user_id", "ohc_review.user_id"));
            $review->addJoin($join_str);
            $Wherestr = "review_id = $reviewId";
            $review->addCondition($Wherestr, 1);
            $review->initialize();
            $reviewSign = $review->vars;
            // var_dump($reviewSign);
            $this->assign("updateValue", $reviewSign);
            $this->setBaseTemplate('upDate.tpl');
            $this->display();
        }
    }

    function deleteReview() {
        $c = $_POST["checkbox"];
        foreach ($c as $i) {
            $d = explode(",", $i);
            $review = new ohc_review();
            $review->initialize("review_id='$d[0]'");
            $review->remove();
        }
        $this->index();
    }

    function insertReview() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $display_able = 0;
            /**
             *  根据处方名称  获取官方名称 并 储存
             */
            if (!empty($_REQUEST['ProceduresName'])) {
                $procedures = new ohc_procedure();

                $procedures->addCondition("procedure_name like '" . $_REQUEST['ProceduresName'] . "'", 1);
                $procedures->initialize();
                $ohc_procedures = $procedures->vars;
                if ($ohc_procedures['procedure_type'] == 'Other Name') {
                    $data['procedures_other_name'] = $ohc_procedures['procedure_name'];
                    $data_content['procedures_other_name'] = $ohc_procedures['procedure_name'];
                    $procedures->addCondition("'procedure_id like '" . $ohc_procedures['procedure_id'] . "' and procedure_type like 'Preferred Name'", 1);
                    $procedures->initialize();
                    $ohc_procedures = $procedures->vars;
                }
                $data['procedures_id'] = $ohc_procedures['id'];
                $data['procedures_name'] = $ohc_procedures['procedure_name'];
                $data_content['procedures_name'] = $ohc_procedures['procedure_name'];
            }
            /**
             * 根据邮编 获取城市 与 州  如邮编为空 根据州和城市 获取邮编 来插入 并添加所选择的城市所在的州的ID
             */
            if (!empty($_REQUEST['zipcode']) || !empty($_REQUEST['City']) || !empty($_REQUEST['State'])) {
                if (!empty($_REQUEST['zipcode'])) {
                    $where = ' code_id = ' . $_REQUEST['zipcode'];
                } else {
                    $where = 'city like "' . $_REQUEST['City'] . '" and state like "' . $_REQUEST['State'] . '"';
                }
                $code = new ohc_code();
                $code->addCondition($where, 1);
                $code->initialize();
                $code_content = $code->vars;
                $data['zip_code'] = $code_content['code_id'];
                $data['city_zip_code'] = substr($code_content['code_id'], 0, 3);
                $data['city_location'] = $code_content['city'];
                $data['state'] = $code_content['state'];
            }
            /**
             *  邮编数据获取 结束
             * 验证医生名称 和 医院名称 如没有发送邮件至管理员
             */
            if (!empty($_REQUEST['firstName']) && !empty($_REQUEST['lastName'])) {
                $doctorSearch = new ohc_doctor();
                $where = "full_name like '" . $_REQUEST['firstName'] . "%" . $_REQUEST['middleName'] . "%" . $_REQUEST['lastName'] . "'";
                $doctorSearch->addCondition($where, 1);
                $doctorSearch->initialize();
                $doctor_info = $doctorSearch->vars;

                if (count($doctor_info) > 0) {
                    $data['doctors_id'] = $doctor_info['doctor_id'];
                } else {
                    //发送邮件
                    $this->sendDoctorEmail($_REQUEST['firstName'], $_REQUEST['lastName']);
                    $display_able = 1;
                    $data['doctors_id'] = 0;
                }
                $data['doctors_frist_name'] = $_REQUEST['firstName'];
                $data['doctors_last_name'] = $_REQUEST['lastName'];
                $data_content['doctors_frist_name'] = $_REQUEST['firstName'];
                $data_content['doctors_last_name'] = $_REQUEST['lastName'];
            }
            /**
             * 医生验证结束   医院验证 
             */
            if (!empty($_REQUEST['organization'])) {
                $where = "hospital_name like '" . $_REQUEST['hospitals_name'] . "'";
                $hospitalSearch = new ohc_hospital();
                $hospitalSearch->addCondition($where, 1);
                $hospitalSearch->initialize();
                $hospital = $hospitalSearch->vars;
                if (count($hospital) > 0) {
                    $data_content['hospitals_id'] = $hospital['hospital_id'];
                } else {
                    //发送邮件
                    $this->sendHosptialEmail($_REQUEST['organization']);
                    $display_able = 1;
                }
                $data_content['hospitals_name'] = $_REQUEST['organization'];
                $data['hospitals_name'] = $_REQUEST['organization'];
            }
            /**
             *    根据 处方 名称 医生名称  医院名称  查询副表(ohc_review_content)数据库  是否有相同数据 如存在 则不需要添加到 主表 把相关信息插入到附表即可 
             */
            $review_where = 'doctors_frist_name like "' . $_REQUEST['doctors_frist_name'] . '"  and doctors_last_name like "' . $_REQUEST['doctors_last_name'] . '"';
            $review_where .= ' and procedures_name  like "' . $data['procedures_name'] . '"  and  hospitals_name like "' . $_REQUEST['hospitals_name'] . '" and  procedures_other_name like "' . $data['procedures_other_name'] . '"';
            $reviewContent = new ohc_review_content();
            $reviewContent->addCondition($review_where, 1);
            $reviewContent->initialize();
            $review_exist = $reviewContent->vars_all;
            if ($_SESSION['user_id'] > 0) {
                $user_id = $_SESSION['user_id'];
            } else {
                $user_id = -1;
            }
            $data['user_id'] = $user_id;
            $data['display_able'] = 0;
            $data['review_time'] = time();
            $data['review_number'] = 1;
            /**
             *  判断 医生  医院 是否已经在数据库 输入过了  如果输入过了  则 通过数据库 字段
             */
            $review_where_ = 'doctors_id like "' . $data['doctors_id'] . '" and  hospitals_name like "' . $data_content['hospitals_name'] . '"';
            $reviewContent->addCondition($review_where_, 1);
            $reviewContent->initialize();
            // $reviewContent->
            $review_if = $reviewContent->vars_number;
            if (count($review_exist) == 0) {
                if ($review_if >= 1) {
                    $data['review_unique'] = 0;
                } else {
                    $data['review_unique'] = 1;
                }
                $review_id = M('ohc_review')->add($data);
                $review_scroce = 1;
            } else {
                $review_id = $review_exist[0]['ohc_review_id'];
                M('ohc_review')->where('review_id  = ' . $review_id)->setInc('review_number');
            }
            $data_content['user_id'] = $user_id;
            $data_content['ohc_review_id'] = $review_id;
            /**
             *   数据库 获取 星级 和cost 对应的字段名称  并插入到数据中
             */
            $rating = M('ohc_system')->where('system_id = 2')->getField('system_value');
            $rating_array = json_decode($rating, true);
            foreach ($rating_array as $rate_v) {
                $data_content[$rate_v] = $_REQUEST[$rate_v];
            }
            /**
             * 获取review 下的 付费内容
             * 如在页面上 选择no 则 不获取 付费 内容  选择yes 直接在总数中计算
             */
            if ($_REQUEST['costselect'] == 1) {
                $costing = M('ohc_system')->where('system_id = 5')->getField('system_value');
                $costing_array = json_decode($costing, true);
                $fina_cost = 0;
                foreach ($costing_array as $cost_v) {
                    $data[$cost_v] = $_REQUEST[$cost_v];
                    $fina_cost+=$_REQUEST[$cost_v];
                    $data_content[$cost_v] = $_REQUEST[$cost_v];
                    unset($cost_v);
                }
                $data_content['cost'] = $fina_cost;
                $data_content['costselect'] = $_REQUEST['costselect'];
            } else {
                $data_content['cost'] = $_REQUEST['fina_cost'];
            }
            /**
             *  访问年份 与 月份
             */
            if ($_REQUEST['year_val'] > 0) {
                $data_content['review_year'] = $_REQUEST['year_val'];
            }
            if ($_REQUEST['month_val'] > 0) {
                $data_content['review_month'] = $_REQUEST['month_val'];
            }
            if ($_REQUEST['year_val'] > 0 && $_REQUEST['month_val'] > 0) {
                $visit_time = mktime(0, 0, 0, $_REQUEST['month_val'], 0, $_REQUEST['year_val']);
                $data_content['visit_year'] = $visit_time;
            }
            /**
             * 评论
             */
            if (!empty($_REQUEST['commect_review'])) {
                $data_content['commect_review'] = $_REQUEST['commect_review'];
            }

            $add_review = M('ohc_review_content')->add($data_content);
            /**
             * review_scroce  评分功能  当第一次输入的时候  则进行评分  
             * 评分 更新 主要通过计划任务 来 执行
             */
            if ($review_scroce == 1) {
                /**
                 *  计算 该医生 以及 这个项目的 综合评分
                 *  先计算 该城市  对 该医疗项目的 话费的平均值 
                 * 
                 *  后计算综合得分
                 */
                $city_review_number = 0;
                $city_review_cost = 0;
                $city_review = M('ohc_review')->where('zip_code = ' . $data['zip_code'] . ' and procedures_name like "' . $data['procedures_name'] . '"')->select();
                foreach ($city_review as $k_review => $v_review) {
                    $content_where = 'ohc_review_id = ' . $v_review['review_id'];
                    $review_content_all = M('ohc_review_content')->where($content_where)->select();
                    $city_review_number += count($review_content_all);
                    foreach ($review_content_all as $k_all => $v_all) {
                        $city_review_cost += $v_all['cost'];
                        unset($v_all);
                    }
                    unset($v_review);
                }
                $city_review_rate = $city_review_cost / $city_review_number;
                /**
                 *  计算 该医生 对  该医疗项目的 平均值
                 */
                $doctor_review_number = 0;
                $doctor_review_cost = 0;
                $doctor_review = M('ohc_review')->where(' doctors_frist_name like "' . $_REQUEST['doctors_frist_name'] . '"  and doctors_last_name like "' . $_REQUEST['doctors_last_name'] . '" and procedures_name like "' . $data['procedures_name'] . '" ')->select();
                foreach ($doctor_review as $k_doctor => $v_doctor) {
                    $content_where = 'ohc_review_id = ' . $v_doctor['review_id'];
                    $review_content_all = M('ohc_review_content')->where($content_where)->select();
                    $doctor_review_number += count($review_content_all);
                    foreach ($review_content_all as $k_all => $v_all) {
                        $doctor_review_cost += $v_all['cost'];
                        foreach ($rating_array as $rate_v) {
                            $rating_array_[$rate_v] += $v_all[$rate_v];
                        }
                        unset($v_all);
                    }
                    unset($v_review);
                }
                $doctor_review_rate = $doctor_review_cost / $doctor_review_number;
                /**
                 *  计算  该医生  对 该项目 的 综合评分
                 */
                $review_rate = ($rating_array_['b1'] - $doctor_review_number) / (4 * $doctor_review_number) + ($rating_array_['b2'] - $doctor_review_number) / (4 * $doctor_review_number) + ($rating_array_['b3'] - $doctor_review_number) / (4 * $doctor_review_number) + ($rating_array_['b4'] - $doctor_review_number) / (4 * $doctor_review_number) + 1;
                $review_rate_ = $review_rate / ($doctor_review_rate / $city_review_rate);
                $level['review_level'] = ceil($review_rate_) > 5 ? 5 : ceil($review_rate_);
                $review = M('ohc_review')->where('review_id = ' . $review_id)->save($level);
            }
            /**
             *   判断是否为注册页面跳过来。。 如是的话 则跳入到注册成功地方 
             */
            if ($_REQUEST['register_review'] == 1) {
                redirect(U('User/register/register_reviewnext'));
            } else {
                global $PUBLICJSURL;
                redirect($PUBLICJSURL);
            }
        } else {
            $month = date("m");
            $year = date('Y');
            $monthArray = array();
            $yearArray = array();
            $startYear = 1955;
            for ($i = 0; $i < (int) $month; $i++) {
                $monthArray[$i] = $i + 1;
            }
            for ($i = 0; $i < (int) $year - $startYear; $i++) {
                $yearArray[$i] = $startYear + $i + 1;
            }
            for ($i = 0; $i <= 5; $i++) {
                $scoreArray[$i] = $i;
            }
            var_dump($scoreArray);
            $this->assign("score", $scoreArray);
            $this->assign('month', $monthArray);
            $this->assign('year', $yearArray);
            $this->setBaseTemplate("insert.tpl");
            $this->display();
        }
    }

}

?>
