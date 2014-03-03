<?php /* Smarty version Smarty-3.0-RC2, created on 2014-03-03 17:20:49
         compiled from "/web/www/OHC-/ohc/admin//templates/left.tpl" */ ?>
<?php /*%%SmartyHeaderCode:639490311531449714f9c87-13758408%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8d68d565ad4a31996ee3b630015433adf93f171a' => 
    array (
      0 => '/web/www/OHC-/ohc/admin//templates/left.tpl',
      1 => 1393838448,
    ),
  ),
  'nocache_hash' => '639490311531449714f9c87-13758408',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
        
        <style type="text/css">

            body {
                margin: 0;background:url(images/menu-shadow.png) repeat-y right top #eeeeee;
            }

        </style>
        <link href="./css/css.css" rel="stylesheet" type="text/css" />
        <script language='JavaScript'>
            function isIE() {
                if (window.navigator.userAgent.toLowerCase().indexOf("msie") >= 1)
                    return true;
                else
                    return false;
            }

            function tupian(idt) {
                var nametu = "xiaotu" + idt;
                var tp = document.getElementById(nametu);
                tp.src = "./images/ico05.gif";

                for (var i = 0; i < 200; i++)
                {

                    var nametu2 = "xiaotu" + i;
                    if (i != idt * 1)
                    {
                        var tp2 = document.getElementById('xiaotu' + i);
                        if (tp2 != undefined)
                        {
                            tp2.src = "./images/ico06.gif";
                        }
                    }
                }
            }

            function list(idstr) {
                var name1 = "subtree" + idstr;
                var name2 = "img" + idstr;
                var objectobj = document.all(name1);

                


                var imgobj = document.all(name2);


                //alert(imgobj);

                if (objectobj.style.display == "none") {
                    for (i = 1; i < 100; i++) {
                        var name3 = "img" + i;
                        var name = "subtree" + i;
                        var o = document.all(name);
                        if (o != undefined) {
                            o.style.display = "none";
                            var image = document.all(name3);
                            //alert(image);
                            image.src = "./images/ico04.gif";
                        }
                    }
                    objectobj.style.display = "";
                    imgobj.src = "./images/ico03.gif";
                }
                else {
                    objectobj.style.display = "none";
                    imgobj.src = "./images/ico04.gif";
                }
            }
        </script>
        
    </head>

    <body>
        <div class="left_background">
            <div class="left_act_bg"></div>
            <table width="150" border="0" cellpadding="0" cellspacing="0" class="left-table01">
                <tr>
                    <TD>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:0 0 5px 0;">
                            <tr>
                                <td width="207" height="55"  style="background:#ECECEC;border-bottom:1px solid #DDDDDD;">
                                    <div>
                                        <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="25%" rowspan="2"><img src="./images/ico02.gif" width="35" height="35" /></td>
                                                <td width="75%" height="22" class="left-font01">您好，<span class="left-font02"><?php echo $_smarty_tpl->getVariable('uname')->value;?>
</span></td>
                                            </tr>
                                            <tr>
                                                <td height="22" class="left-font01">
                                                    [&nbsp;<a href="./process.php?login=0" target="_top" class="left-font01">退出</a>&nbsp;]</td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="left-table03" id="table1" >
                            <tr>
                                <td height="29">
                                    <table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="15%"><img name="img1" id="img2" src="./images/ico04.gif" width="8" height="11" /></td>
                                            <td width="85%">
                                                <a href="javascript:vold(0)" target="mainFrame" class="left-font03" onClick="list('2')" >review</a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </TABLE>
                        <table id="subtree2" style="DISPLAY: none" width="95%" border="0" align="center" cellpadding="0" ellspacing="0" class="left-table02">
                            <tr>
                                <td width="15%" height="20" ><img id="xiaotu4" src="./images/ico06.gif" width="8" height="12" /></td>
                                <td width="85%"><a href="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=review" target="mainFrame" class="left-fontSmall" onClick="tupian('4')">review</a></td>
                                                            <tr>
                                <td width="15%" height="20" ><img id="xiaotu8" src="./images/ico06.gif" width="8" height="12" /></td>
                                <td width="85%"><a href="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=revising" target="mainFrame" class="left-fontSmall" onClick="tupian('8')">revising</a></td>
                        </table>
                        <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="left-table03" id="table1" >
                            <tr>
                                <td height="29">
                                    <table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="15%"><img name="img1" id="img3" src="./images/ico04.gif" width="8" height="11" /></td>
                                            <td width="85%">
                                                <a href="javascript:vold(0)" target="mainFrame" class="left-font03" onClick="list('3')" >excel</a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </TABLE>
                        <table id="subtree3" style="DISPLAY: none" width="95%" border="0" align="center" cellpadding="0" ellspacing="0" class="left-table02">
                            <tr>
                                <td width="15%" height="20" ><img id="xiaotu5" src="./images/ico06.gif" width="8" height="12" /></td>
                                <td width="85%"><a href="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=excel&filetype=doctor" target="mainFrame" class="left-fontSmall" onClick="tupian('5')">doctor excel import</a></td>
                            </tr>      


                            <tr>
                                <td width="15%" height="20" ><img id="xiaotu6" src="./images/ico06.gif" width="8" height="12" /></td>
                                <td width="85%"><a href="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=excel&filetype=produce" target="mainFrame" class="left-fontSmall" onClick="tupian('6')">produceal excel import</a></td>
                            </tr>    

                            <tr>
                                <td width="15%" height="20" ><img id="xiaotu7" src="./images/ico06.gif" width="8" height="12" /></td>
                                <td width="85%"><a href="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=excel&filetype=hospital" target="mainFrame" class="left-fontSmall" onClick="tupian('7')">hosptial excel import</a></td>
                            </tr>    


                        </table>


                        <!-- 访问页面 -->



                        <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="left-table03" id="table2" >
                            <tr>
                                <td height="29">
                                    <table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="15%"><img name="img10" id="img10" src="./images/ico04.gif" width="8" height="11" /></td>
                                            <td width="85%">
                                                <a href="javascript:vold(0)" target="mainFrame" class="left-font03" onClick="list('10')" >visit</a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </TABLE>
                        <table id="subtree10" style="DISPLAY: none" width="95%" border="0" align="center" cellpadding="0" ellspacing="0" class="left-table02">
                            <tr>
                                <td width="15%" height="20" ><img id="xiaotu16" src="./images/ico06.gif" width="8" height="12" /></td>
                                <td width="85%"><a href="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=visit" target="mainFrame" class="left-fontSmall" onClick="tupian('16')">user visit</a></td>
                            </tr>      


                         
                        </table>


                    </TD>
                </tr>
            </table>
        </div>
    </body>
</html>
