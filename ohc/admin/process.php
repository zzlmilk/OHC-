<?php

include 'include.php';
session_start();
if (isset($_GET['login'])) {
    session_unset();
    echo '<script type="text/javascript">window.location="login.html";</script>';
}
if (isset($_POST['user'])) {
    $admin = new admin_user();
    $ad['admin_username'] = $_POST['user'];
    $ad['admin_password'] = $_POST['password'];
    $admin->initialize($ad);
    if (count($admin->vars) > 0) {
        $_SESSION['admin_id'] = $admin->vars['admin_id'];
        $_SESSION['user_name'] = $admin->vars['admin_username'];
        if(!empty($_SESSION['admin_url'])){
            $url = URLController.'index.php?a='.urlencode($_SESSION['admin_url']);
            unset($_SESSION['admin_url']);
        } else{
            $url = 'index.php';
        }
        echo '<script type="text/javascript">window.location="'.$url.'";</script>';
    } else {
        echo '<script type="text/javascript">alert("登录失败");window.location="login.html";</script>';
    }
}


?>