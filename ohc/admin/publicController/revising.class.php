<?php

class revisingController extends BaseController {

    protected $templateFile = "revising.tpl";

    function __construct($smarty, $function = 'index') {
//        ini_set("max_execution_time", 14000); //设置PHP文件最大执行时间 
        parent::__construct($smarty);
        $this->$function();
    }
    //显示所有待审核的数据
    function index() {

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
//        $service=$_SERVER['REQUEST_URI'];
        $service = '/admin/redirst.php?action=revising';
        $revising = new ohc_revising_review();
        //执行sql语句查询表全部内容 并输出
        $revising->addOrderBy("id");
        $join_str = array(array("ohc_user", "ohc_user.user_id", "ohc_revising_review.user_id"));
        $revising->addJoin($join_str);
        $revising->addOffset(0, 10); //limit
        $revising->initialize();


        $revisingAll = $revising->vars_all;
        if ($revising->vars_number < 1) {
            $this->assign("reviewAll", $revisingAll);
        } else {
            $a = $revising->page0($service, $page, $revisingAll, 2);
            $this->assign("reviewAll", $a['data']);
            $this->assign("paging", $a['key']);
        }
        $this->display();
    }
    
    function pageFunction() {
        $this->index();
    }
    //提交修改的审核内容
    function upDateReviewRevising() {
        $revising = new ohc_revising_review();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $reviewId = $_POST['reviewId'];
            $doctors_frist_name = $_POST['doctors_frist_name'];
            $doctors_last_name = $_POST['doctors_last_name'];
            $procedures_name = $_POST['procedures_name'];
            $hospitals_name = $_POST['hospitals_name'];
            $city_location = $_POST['city_location'];
            $zip_code = $_POST['zip_code'];
            $commect_review = $_POST['commect_review'];
            $join_str = array(array("ohc_user", "ohc_user.user_id", "ohc_revising_review.user_id"));
            $revising->addJoin($join_str);
            $Wherestr = "ohc_revising_review.id = $reviewId ";
            $revising->addCondition($Wherestr, 1);
            $revising->initialize();
            $updateStr = " 
            ohc_revising_review.doctors_frist_name='$doctors_frist_name'
            ,ohc_revising_review.doctors_last_name='$doctors_last_name'
            ,ohc_revising_review.procedures_name= '$procedures_name' 
            ,ohc_revising_review.hospitals_name= '$hospitals_name' 
            ,city_location= '$city_location' 
            ,zip_code= '$zip_code' 
            ,commect_review= '$commect_review'
        ";
            $revising->update($updateStr, 1);
            $this->index();
        } else {
            $reviewId = $_GET["reviewId"];
            $join_str = array(array("ohc_user", "ohc_user.user_id", "ohc_revising_review.user_id"));
            $revising->addJoin($join_str);
            $Wherestr = "ohc_revising_review.id= $reviewId";
            $revising->addCondition($Wherestr, 1);
            $revising->initialize();
            $reviewSign = $revising->vars;
            // var_dump($reviewSign);
            $this->assign("updateValue", $reviewSign);
            // var_dump($reviewId);
            $this->assign("isrevising", "1");
            $this->setBaseTemplate('upDate.tpl');
            $this->display();
        }
    }
    //显示审核信息与需要审核字段，如此数据无需审核 则自动进入添加数据流程
    function RevisingReview() {
        $revising = new ohc_revising_review();
        $Wherestr = '';
        $revisingClass = '';
        /*        if (isset($_GET['hospitalName'])) {
          //            $Wherestr = $this->revisingHospitalName($_GET['hospitalName']);
          //            $revisingClass = "hospitalName=" . $_GET['hospitalName'];
          //        } else if (isset($_GET['firstName']) && isset($_GET['lastName']) &&
          //                isset($_GET['middleName']) && isset($_GET['zipCode'])) {
          //            $Wherestr = $this->revisingDoctorName($_GET['firstName'], $_GET['middleName'], $_GET['lastName'], $_GET['zipCode']);
          //            $revisingClass = "firstName=" . $_GET['firstName'] . "&lastName=" .
          //                    $_GET['lastName'] . "&middleName=" . $_GET['middleName'] . "&zipCode=" .
          //                    $_GET['zipCode'];
          //        } else if (isset($_GET["procedures"])) {
          //            $Wherestr = $this->revisingProcedures($_GET["procedures"]);
          //            $revisingClass = "procedures=" . $_GET['procedures'];
          //        } else if (isset($_GET["code"])){
          //            $Wherestr=" ohc_revising_review.procedures_name = '".$_GET["code"]."'";
          //            $revisingClass = "code=" . $_GET['code'];
          }else */
        if (isset($_GET['revisingId'])) {
            $Wherestr = "ohc_revising_review.id = " .
                    $_GET['revisingId'];
            $revisingClass = "revisingId=" . $_GET['revisingId'];
        }
        $join_str = array(array("ohc_user", "ohc_user.user_id", "ohc_revising_review.user_id"));
        $revising->addJoin($join_str);
        $revising->addCondition($Wherestr, 1);
        $revising->initialize();
        $reviewSign = $revising->vars;
        if ($revising->vars_number < 1) {
            $this->errorReturnMessage();
            die;
        } else {
            $revisingState = json_decode($reviewSign['review_state']);
            if (count($revisingState) < 1) {
                $revising->addCondition('ohc_revising_review.id = ' . $_GET['revisingId'], 1);
                $revising->initialize();
                $revisingVal = $revising->vars;
                $this->assign("updateValue", $revisingVal);
                $this->setBaseTemplate('addToMainTable.tpl');
                $this->display();
            } else {
                $this->assign("updateValue", $reviewSign);
                $this->assign("revisingState", $revisingState);
              
                $this->assign("revisingClass", $revisingClass);
                $this->setBaseTemplate('checkRviesing.tpl');
                $this->display();
            }
        }
    }
    //确定审核信息内容，并提交相应数据
    function checkRevising() {
        $num = '';
        $Wherestr = '';
        $checkType = '';
        $revising = new ohc_revising_review();
        $join_str = array(array("ohc_user", "ohc_user.user_id", "ohc_revising_review.user_id"));
        $revising->addJoin($join_str);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $revisingReview = new ohc_revising_review();
            if (isset($_POST['hospitalName'])) {   


                $hospital = new ohc_hospital();

                $hospital->addCondition('hospital_name like "'.$_POST['hospitalName'].'"',1);

                $hospital->initialize();


                if($hospital->vars_number > 0 ){

                    $hospitalId= $hospital->vars['ohc_hospital_id'];

                } else{

                    $insertVal["hospital_name"] = $_POST['hospitalName'];
                    $hospitalId= $hospital->insert($insertVal);
                }
                
                
                if($hospitalId){
                    $whereString ='hospitals_name="'.$_POST['hospitalName'].'"';
                    $revisingReview->addCondition($whereString,1);
                    $revisingReview->initialize();

                    if($revisingReview->vars_number > 0 ){

                              $update['hospitals_name'] = $_POST['hospitalName'];
                $update['hospital_id'] =$hospitalId;
                $revisingReview->update($update);
                unset($update);
                    }
              
                $num = 1;
                
                }
            }
            if (isset($_POST['firstName']) && isset($_POST['lastName']) &&
                    isset($_POST['middleName']) && isset($_POST['streetZip'])) {
                $doctorId = $this->insertDoctor($_POST);
                $WhereString = "ohc_revising_review.doctors_frist_name ='" . $_POST['firstName'] . "' 
            and ohc_revising_review.doctors_last_name='" . $_POST['lastName'] . "'
            and ohc_revising_review.doctor_middle_name='" . $_POST['middleName'] . "'
            and ohc_revising_review.zip_code='" . $_POST['streetZip'] . "'";
                
                $revisingReview->addCondition($WhereString, 1);
                $revisingReview->initialize();
                $update['doctors_id'] = (int) $doctorId;
                $revisingReview->update($update);
                unset($update);
                $update['ohc_revising_review.doctors_frist_name'] = $_POST['firstName'];
                $update['ohc_revising_review.doctor_middle_name'] = $_POST['middleName'];
                $update['ohc_revising_review.doctors_last_name'] = $_POST['lastName'];
                $num = 1;
            }
            if (isset($_POST["procedures"])) {
                $procedure = new ohc_procedure();
                $procedure->addCondition('procedure_name like "'.$_POST['procedures'].'"',1);
                $procedure->initialize();


                if($procedure->vars_number <= 0 ){

                    $insertVal["procedure_name"] = $_POST["procedures"];
                    $insertVal["procedure_id"] = $_POST["proceduresId"];
                    $insertVal["procedure_type"] = $_POST["proceduresType"];
                  $procedure->insert($insertVal);


                }
                
                $update['procedures_name'] = $_POST["procedures"];
                $update['procedures_id'] = $_POST["proceduresId"];
                $num = 1;
            }
            if (isset($_POST["code_id"])) {
                $code = new ohc_code();
                $insertVal["code_id"] = $_POST["code_id"];
                $insertVal["city"] = $_POST["city"];
                $insertVal["state"] = $_POST["state"];
                $code->insert($insertVal);
                $whereString="zip_code='".$_POST["code_id"].
                        "' or (state='".$_POST["state"].
                        "' and city_location='".$_POST["city"]."')";
                $revisingReview->addCondition($whereString, 1);
                $revisingReview->initialize();
                $update['zip_code'] = $_POST["code_id"];
                $update['state'] = $_POST["state"];
                $update['city_location'] = $_POST["city"];
                $update['city_zip_code'] = (int) substr($_POST["code_id"], 0, 3);
                $revisingReview->update($update);
                unset($update);
                $num = 1;
                
            }
            if ($num == 1) {
                $revising->addCondition('ohc_revising_review.id = ' . $_POST['revisingId'], 1);
                $revising->initialize();
                $revisingVal = $revising->vars;
                $revisingState = json_decode($revisingVal['review_state']);
                unset($revisingState[0]);
                $revisingState = implode(',', $revisingState);
                $update['review_state'] = "[" . $revisingState . ']';
                $revising->update($update);
                //($revisingState);
                //判断是否还有数据需要审核，如没有则进入提交数据流程
                if (count($revisingState) > 0 && $revisingState != '') {
                    unset($_POST);
                    $_SERVER["REQUEST_METHOD"] = "GET";
                    $_GET['revisingId'] = $revisingVal['id'];
                    $this->checkRevising();
                } else {




                    
                    $this->assign("updateValue", $revisingVal);
                    $this->setBaseTemplate('addToMainTable.tpl');
                    $this->display();
                }
                //$this->checkOtherRevising($revisingVal);
            }
            else{
                $this->errorReturnMessage(4);
            }
        } else {

            if (isset($_GET['hospitalName'])) {
                $Wherestr = $this->revisingHospitalName($_GET['hospitalName']);
                $checkType = 'hospital';
            } else if (isset($_GET['firstName']) && isset($_GET['lastName']) &&
                    isset($_GET['middleName']) && isset($_GET['zipCode'])) {
                $Wherestr = $this->revisingDoctorName($_GET['firstName'], $_GET['middleName'], $_GET['lastName'], $_GET['zipCode']);
                $checkType = 'doctor';
            } else if (isset($_GET["procedures"])) {
                $Wherestr = $this->revisingProcedures($_GET["procedures"]);
                $checkType = 'procedures';
            } else if (isset($_GET['revisingId']) && isset($_GET['contentId'])) {
                $Wherestr = "ohc_revising_review.id = " .
                        $_GET['revisingId'] . " and ohc_revising_review_content.id="
                        . $_GET['contentId'];
            } else if (isset($_GET['revisingId'])) {
                $Wherestr = "ohc_revising_review.id = " . $_GET['revisingId'];
            } else if (isset($_GET["code"])) {
                $Wherestr = " ohc_revising_review.procedures_name = '" . $_GET["code"] . "'";
            }
            $revising->initialize($Wherestr, 1);
            $reviewSign = $revising->vars;
            $this->assign("updateValue", $reviewSign);
            $revisingState = json_decode($reviewSign['review_state']);
            if (count($revisingState) == 0) {
                $this->errorReturnMessage(1);
                die;
            }
            $this->assign('revisingState', $revisingState);
            $this->setBaseTemplate('insertRviesing.tpl');
            $this->display();
        }
    }
    //index进入审核流程 （此方法已废弃）
    function selectRevising() {
        $revising = new ohc_revising_review();
        $revising->addSelect("ohc_revising_review.id as revisingId,ohc_revising_review_content.id as contentId,user_name,ohc_revising_review.doctors_frist_name,ohc_revising_review.doctor_middle_name,ohc_revising_review.doctors_last_name
                        ,ohc_revising_review.procedures_name,ohc_revising_review.hospitals_name,ohc_revising_review.city_location,
                        ohc_revising_review.zip_code,commect_review,ohc_revising_review.state,review_state", 1);
        $join_str = array(array("ohc_revising_review_content", "ohc_revising_review_content.ohc_review_id", "ohc_revising_review.id"), array("ohc_user", "ohc_user.user_id", "ohc_revising_review.user_id"));
        $revising->addJoin($join_str);
        $revising->addCondition('ohc_revising_review.id = ' . $_GET['revisingId'], 1);
        $revising->initialize();
        $revisingVal = $revising->vars;
        $this->checkOtherRevising($revisingVal);
    }

    //将数据插入到主表内
    function addToMainTable() {
        $insertIsSucess = true;
        $revising = new ohc_revising_review();
        $reviewId = isset($_POST["reviewId"]) ? $_POST["reviewId"] : $_GET['reviewId'];
        $Wherestr = "ohc_revising_review.id= $reviewId";
        $revising->addCondition($Wherestr, 1);
        $revising->initialize();
        $reviewSign = $revising->vars;
        unset($reviewSign['id']);
        unset($reviewSign['review_state']);
        if ($reviewSign['hospital_id'] == "") {
            unset($reviewSign['hospital_id']);
        }

        unset($reviewSign['check_state']);
        $review = new ohc_review();
//        if ($review->vars_number < 1) {
//        }
//        else{
//            $reviewList=$review->vars;
//            $reviewSignId=$reviewList['review_id'];
//        }
        $reviewSignId = $review->insert($reviewSign);
$doctor = new ohc_doctor();

         $doctor->secIncReviewNumber($reviewSign['doctors_id']);
        //如果插入成功则寻找是否有 相同类型数据 一并插入
        if ($reviewSignId) {
             $update1['check_state'] = 1;

            $revising->update($update1);
            unset($revising);
            $revising = new ohc_revising_review();
            $hospitalId = isset($reviewSign['hospital_id']) ? $reviewSign['hospital_id'] : null;
            $whereStr = ' doctors_id = "' . $reviewSign['doctors_id'] . '"
                    AND procedures_name = "' . $reviewSign['procedures_name'] . '"
                    AND procedures_other_name = "' . $reviewSign['procedures_other_name'] . '" 
                    AND hospital_id = "' . $hospitalId . '" 
                    AND zip_code = "' . $reviewSign['zip_code'] . '" ';
            $revising->addCondition($whereStr, 1);
            $revising->initialize();
            $reviewRevisingContent = $revising->vars_all;
            if ($revising->vars_all > 0) {
                foreach ($reviewRevisingContent as $singleReviewContent) {
                    $thisId = $singleReviewContent['id'];
                    unset($singleReviewContent['id']);
                    unset($singleReviewContent['review_state']);

                    if ($singleReviewContent['hospital_id'] == "") {
                        unset($singleReviewContent['hospital_id']);
                    }

                    if ($review->insert($singleReviewContent)) {
//                echo '数据载入成功 <br> ';
//                echo '<a href="redirst.php?action=revising">返回</a>';
                        $Wherestr = 'id=' . $thisId;
                        $revising->addCondition($Wherestr, 1);
                        $revising->initialize();
                        if($revising->vars_number > 0){

                            $update1['check_state'] = 1;

                            $revising->update($update1);


                            $doctor = new ohc_doctor();

                            $doctor->secIncReviewNumber($revising->vars['doctors_id']);
                        }
                        //$revising->remove();
                    } else {
                        $insertIsSucess = false;
                        break;
                    }
                }
            }
            if (!$insertIsSucess) {
                $this->errorReturnMessage(2);
                die;
            } else {
                $this->errorReturnMessage(3);
                die;
            }
        } else {
            $this->errorReturnMessage(2);
            die;
        }
    }

    //确认是否有其他的数据需要审核（此方法已废弃）
    function checkOtherRevising($tableVal) {

        $notAnyUnrevisingData = TRUE;
        $hospital = new ohc_hospital();
        $selectString = "hospital_name='" . $tableVal['hospitals_name'] . "'";
        $hospital->addCondition($selectString, 1);
        $hospital->initialize();
        if ($hospital->vars_number < 1) {
            unset($_POST);
            $_SERVER["REQUEST_METHOD"] = "GET";
            $_GET['hospitalName'] = $tableVal['hospitals_name'];
            $notAnyUnrevisingData = FALSE;
            $this->checkRevising();
        }
        $doctor = new ohc_doctor();
        $selectString = "doctor_frist_name='" . $tableVal['doctors_frist_name'] . "'
                and doctor_last_name='" . $tableVal['doctors_last_name'] . "' 
                and doctor_middle_name='" . $tableVal['doctor_middle_name'] . "' 
                and  street_zip like '" . $tableVal['zip_code'] . "%'";
        $doctor->addCondition($selectString, 1);
        $doctor->initialize();
        if ($doctor->vars_number < 1) {
            unset($_POST);
            $_SERVER["REQUEST_METHOD"] = "GET";
            $_GET['firstName'] = $tableVal['doctors_frist_name'];
            $_GET['lastName'] = $tableVal['doctors_last_name'];
            $_GET['middleName'] = $tableVal['doctor_middle_name'];
            $_GET['zipCode'] = $tableVal['zip_code'];
            $notAnyUnrevisingData = FALSE;
            $this->checkRevising();
        }
        $procedures = new ohc_procedure();
        $selectString = "procedure_name='" . $tableVal['procedures_name'] . "'";
        $procedures->addCondition($selectString, 1);
        $procedures->initialize();
        if ($procedures->vars_number < 1) {
            unset($_POST);
            $_SERVER["REQUEST_METHOD"] = "GET";
            $_GET['procedures'] = $tableVal['procedures_name'];
            $notAnyUnrevisingData = FALSE;
            $this->checkRevising();
        }
        if ($notAnyUnrevisingData) {
            $this->assign("updateValue", $tableVal);
            $this->setBaseTemplate('addToMainTable.tpl');
            $this->display();
        }
    }
    //插入医生
    function insertDoctor($doctorParameter) {
        $doctor = new ohc_doctor();
        $doctorValue['doctor_frist_name'] = $doctorParameter['firstName'];
        $doctorValue['doctor_last_name'] = $doctorParameter['lastName'];
        $doctorValue['doctor_middle_name'] = $doctorParameter['middleName'];
        $doctorValue['doctor_gender'] = $doctorParameter['doctorGender'];
        $doctorValue['npi'] = $doctorParameter['npi'];
        $doctorValue['graduation_year'] = $doctorParameter['graduationYear'];
        $doctorValue['medical_school'] = $doctorParameter['medicalSchool'];
        $doctorValue['specialty'] = $doctorParameter['specialty'];
        $doctorValue['specialty2'] = $doctorParameter['specialty2'];
        $doctorValue['street_zip'] = $doctorParameter['streetZip'];
        $doctorValue['street_city'] = $doctorParameter['streetCity'];
        $doctorValue['street_state'] = $doctorParameter['streetState'];
        $doctorValue['doctor_telephone'] = $doctorParameter['doctorTelephone'];
        $doctorValue['doctor_email'] = $doctorParameter['doctorEmail'];
        return $doctor->insert($doctorValue);
    }

//拼装医院查询字符串 并且检查数据库是否已存在对应数据
    /*    function revisingHospitalName($hospitalName) {
      //        $hospital = new ohc_hospital();
      //        $selectString = "hospital_name='$hospitalName'";
      //        $hospital->addCondition($selectString, 1);
      //        $hospital->initialize();
      //        if ($hospital->vars_number >= 1) {
      //            echo '医院已存在无需审核';
      //            die;
      //        } else {
      //            $WhereString = "ohc_revising_review.hospitals_name = '$hospitalName' and ohc_revising_review_content.hospitals_name='$hospitalName'";
      //            return $WhereString;
      //        }
      } */
    function revisingHospitalName($hospitalName) {

        $WhereString = "ohc_revising_review.hospitals_name = '$hospitalName' and ohc_revising_review_content.hospitals_name='$hospitalName'";
        return $WhereString;
    }


    /*  function revisingDoctorName($firstName, $middleName, $lastName, $zipCode) {
      $doctor = new ohc_doctor();
      $selectString = "doctor_frist_name='$firstName' and doctor_last_name='$lastName' and doctor_middle_name='$middleName' and
      street_zip like '$zipCode%'";
      $doctor->addCondition($selectString, 1);
      $doctor->initialize();
      if ($doctor->vars_number) {
      echo '医生已存在无需审核';
      die;
      } else {
      $WhereString = "ohc_revising_review.doctors_frist_name ='$firstName'
      and ohc_revising_review.doctors_last_name='$lastName'
      and ohc_revising_review.doctor_middle_name='$middleName'
      and ohc_revising_review.zip_code='$zipCode'";

      return $WhereString;
      }
      } */
    //拼装医生查询字符串 并且检查数据库是否已存在对应数据
    function revisingDoctorName($firstName, $middleName, $lastName, $zipCode) {
        $WhereString = "ohc_revising_review.doctors_frist_name ='$firstName' 
            and ohc_revising_review.doctors_last_name='$lastName'
            and ohc_revising_review.doctor_middle_name='$middleName'
            and ohc_revising_review.zip_code='$zipCode'";

        return $WhereString;
    }


    /* function revisingProcedures($proceduresName) {
      $procedures = new ohc_procedure();
      $selectString = "procedure_name='$proceduresName'";
      $procedures->addCondition($selectString, 1);
      $procedures->initialize();
      if ($procedures->vars_number >= 1) {
      echo '医疗项目已存在无需审核';
      die;
      } else {
      $WhereString = "ohc_revising_review.procedures_name = '$proceduresName'";
      return $WhereString;
      }
      } */
    //拼装医疗项目查询字符串 并且检查数据库是否已存在对应数据
    function revisingProcedures($proceduresName) {

        $WhereString = "ohc_revising_review.procedures_name = '$proceduresName'";
        return $WhereString;
    }

//输出错误信息或者提示信息
    function errorReturnMessage($errorNumber = 0) {
        switch ($errorNumber) {
            case 0:
                echo '此数据审核已通过或不存在 <br> ';
                echo '<a href="files/mainfra.html">返回</a>';
                break;
            case 1:
                echo '此数据无需验证！ <br> ';
                echo '<a href="files/mainfra.html">返回</a>';
                break;
            case 2:
                echo '数据载入失败！ <br> ';
                echo '<a href="files/mainfra.html">返回</a>';
                break;
            case 3:
                echo '审核成功 <br> ';
                echo '<a href="files/mainfra.html">返回</a>';
                break;
            case 4:
                echo '发生未知错误！<br>';
                echo '<a href="files/mainfra.html">返回</a>';
        }
    }

}

?>
