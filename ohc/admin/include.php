<?php
session_start();

ini_set("display_errors", 1);
defined('FOOT_') or define('FOOT_', $_SERVER['DOCUMENT_ROOT'].'/OHC-/ohc/');



defined('FOOT') or define('FOOT', FOOT_ . 'admin/');
defined('FOOTBASIC') or define('FOOTBASIC', FOOT_ . '/admin/basicClasses/');
defined('FOOTCLASS') or define('FOOTCLASS', FOOT_ . '/admin/classes/');
defined('FOOTController') or define('FOOTController', FOOT_ . '/admin/publicController/');
//defined('URLController') or define('URLController', 'http://transparentmedicalcare.com/admin/');
defined('URLController') or define('URLController', 'http://localhost/OHC-/ohc/admin/');
defined('URLAjaxController') or define('URLAjaxController', 'http://transparentmedicalcare.com/admin/ajax');
//defined('URLAjaxController') or define('URLAjaxController', 'http://localhost/admin/ajax');
defined('URLJsController') or define('URLJsController', 'http://localhost/admin/js');
defined('EXCELREAD') or define('EXCELREAD', FOOT . 'excelfile/');
require_once FOOT . 'js/smarty.php';
require_once FOOT . '/plug/reader.php';   //excel 文件问题
if ($handle = opendir(FOOTBASIC)) {
    /* to include all files that in the class folder what a way to include classes!!! */
    while (false !== ($file = readdir($handle))) {
        if ($file != '.' && $file != '..' && $file != '.svn') {
            include_once(FOOTBASIC . $file);
        }
    }
    closedir($handle);
}
if ($handle = opendir(FOOTController)) {
    /* to include all files that in the class folder what a way to include classes!!! */
    while (false !== ($file = readdir($handle))) {
        if ($file != '.' && $file != '..' && $file != '.svn') {
            include_once(FOOTController . $file);
        }
    }
    closedir($handle);
}
if ($handle = opendir(FOOTCLASS)) {
    /* to include all files that in the class folder what a way to include classes!!! */
    while (false !== ($file = readdir($handle))) {
        if ($file != '.' && $file != '..' && $file != '.svn') {
            include_once(FOOTCLASS . $file);
        }
    }
    closedir($handle);
}
$smarty->assign('URLController', URLController);
$smarty->assign('URLAjaxController', URLAjaxController);
$smarty->assign('URLJsController', URLJsController);
?>