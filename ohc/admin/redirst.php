<?php

include 'include.php';
if (!empty($_REQUEST['action'])) {
    $action = $_REQUEST['action'] . 'Controller';
    if (!empty($_REQUEST['function'])) {
        $function = $_REQUEST['function'];
    } else {
        $function = 'index';
    }
    $pageController = new $action($smarty, $function);
}
?>
