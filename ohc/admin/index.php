<?php
include 'include.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
        <script type='text/javascript'>
            window.onload = function() {
<?php
if (!empty($_REQUEST['a'])) {
    $url = URLController . 'redirst.php?' . $_REQUEST['a'];
    $_SESSION['admin_url'] = $_REQUEST['a'];
} else {
    $url = 'files/mainfra.html';
}

if (!isset($_SESSION['admin_id'])) {
    echo 'window.top.location="login.html";';
}
?>
         }
        </script>
    </head>
    <frameset rows="30,*" cols="*" frameborder="no" border="0" framespacing="0">
        <frame src="files/top.html" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
        <frameset cols="150,*" frameborder="no" border="0" framespacing="0">
            <frame src="left.php" name="leftFrame" scrolling="No" noresize="noresize" id="leftFrame" title="leftFrame" />
            <frame src=<?= $url ?> name="mainFrame" id="mainFrame" title="mainFrame" />
        </frameset>
    </frameset>
    <noframes>
        <body>
        </body>
    </noframes></html>
