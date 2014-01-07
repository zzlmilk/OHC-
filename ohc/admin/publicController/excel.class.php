<?php

class excelController extends BaseController {

    protected $templateFile = "excel.tpl";

    function __construct($smarty, $function = 'index') {
        ini_set("max_execution_time", 14000); //设置PHP文件最大执行时间 
        ini_set("memory_limit","120M");
        parent::__construct($smarty);
        $this->$function();
    }

    function index() {
        $page = $_REQUEST['filetype'];
        $this->setBaseTemplate($page.'_excel.tpl');
        $this->display();
    }

    function upload() {
        /**
         * 判断用户上传的是否为xls 格式的文件类型  如不是 提示用户并返回刚才的页面
         *  将xls 文件 放入临时目录 并获取相关内容 进行数据库插入 
         */
        if (!empty($_REQUEST['upload_type'])) {
            $fileType = strtolower(substr($_FILES['excel']['name'], '-3', 3)); //取得扩展名
            if ($fileType == 'xls') {
                $fileName = urlencode($_FILES['excel']['name']);
                if (move_uploaded_file($_FILES['excel']['tmp_name'], EXCELREAD . $fileName)) {
                    $this->excelMysqlUpload($_REQUEST['upload_type'], $fileName);
                }
            } else{
                 $this->jsJump('-1', '请选择以xls为后戳名的文件进行上传');
            }
        } else{
            $this->jsJump('-1', '请选择导入类型');
        }
    }

    function excelMysqlUpload($tableName, $fileName) {
        $excel = new Spreadsheet_Excel_Reader();
        $excel->read(EXCELREAD . $fileName);
        $mysqlCount = 0;
        $tableField = new $tableName();
        for ($i = 2; $i <= $excel->sheets[0]['numRows']; $i++) {
            for ($j = 1; $j <= $excel->sheets[0]['numCols']; $j++) {
                if(!empty($excel->sheets[0]['cells'][$i][$j]) && !empty($excel->sheets[0]['cells'][1][$j])){
                    $data[$excel->sheets[0]['cells'][1][$j]] = $excel->sheets[0]['cells'][$i][$j];
                }
            }
            $tableId = $tableField->insert($data);
            unset($data);
            if ($tableId > 0) {
                $mysqlCount++;
            }
        }
        if ($mysqlCount > 0) {
            $message = '数据导入成功 已导入' . $mysqlCount . '条数据';
        } else {
            $message = '数据导入失败';
        }
        @unlink(EXCELREAD . $fileName);
        $this->jsJump('-1', $message);
    }

}
?>