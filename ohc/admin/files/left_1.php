<?php
session_start();
include 'include.php';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
        <style type="text/css">
            <!--
            body {
                margin-left: 0px;
                margin-top: 0px;
                margin-right: 0px;
                margin-bottom: 0px;
                background-image: url(../images/left.gif);
            }
            -->
        </style>
        <link href="../css/css.css" rel="stylesheet" type="text/css" />
    </head>
    <SCRIPT language='JavaScript'>
        function isIE(){
            if (window.navigator.userAgent.toLowerCase().indexOf("msie")>=1)
                return true;
            else
                return false;
        }

        function tupian(idt){
            var nametu="xiaotu"+idt;
            var tp = document.getElementById(nametu);
            tp.src="../images/ico05.gif";

            for(var i=1;i<200;i++)
            {

                var nametu2="xiaotu"+i;
                if(i!=idt*1)
                {
                    var tp2=document.getElementById('xiaotu'+i);
                    if(tp2!=undefined)
                    {tp2.src="../images/ico06.gif";}
                }
            }
        }

        function list(idstr){
            var name1="subtree"+idstr;
            var name2="img"+idstr;
            var objectobj=document.all(name1);
            var imgobj=document.all(name2);


            //alert(imgobj);

            if(objectobj.style.display=="none"){
                for(i=1;i<10;i++){
                    var name3="img"+i;
                    var name="subtree"+i;
                    var o=document.all(name);
                    if(o!=undefined){
                        o.style.display="none";
                        var image=document.all(name3);
                        //alert(image);
                        image.src="../images/ico04.gif";
                    }
                }
                objectobj.style.display="";
                imgobj.src="../images/ico03.gif";
            }
            else{
                objectobj.style.display="none";
                imgobj.src="../images/ico04.gif";
            }
        }

        window.onload = function()
        {
            if(!isIE())
            {
<?php
$admin = new admin();
$admin_where = "admin_id = " . $_SESSION['user_id'];
$admin->addCondition($admin_where);
$admin->initialize();
$a = split(',', $admin->vars['admin_power']);
foreach ($a as $k => $v) {
    echo "document.getElementById('table" . $v . "').style.display='';";
}
?>
        }
        else
        {
<?php
$admin = new admin();
$admin_where = "admin_id = " . $_SESSION['user_id'];
$admin->addCondition($admin_where);
$admin->initialize();
$a = split(',', $admin->vars['admin_power']);
foreach ($a as $k => $v) {
    echo "document.getElementById('table" . $v . "').style.display='block';";
}
?>
        }

    }

    </SCRIPT>

    <body>
        <table width="198" border="0" cellpadding="0" cellspacing="0" class="left-table01">
            <tr>
                <TD>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="207" height="55" background="../images/nav01.gif">
                                <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="25%" rowspan="2"><img src="../images/ico02.gif" width="35" height="35" /></td>
                                        <td width="75%" height="22" class="left-font01">您好，<span class="left-font02"><?php echo $admin->vars['admin_username'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <td height="22" class="left-font01">
						[&nbsp;<a href="../process.php?login=0" target="_top" class="left-font01">退出</a>&nbsp;]</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <!--  页面管理开始    -->
                    <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="left-table03" id="table1" style="DISPLAY: none">
                        <tr>
                            <td height="29">
                                <table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="8%"><img name="img1" id="img1" src="../images/ico04.gif" width="8" height="11" /></td>
                                        <td width="92%">
                                            <a href="javascript:" target="mainFrame" class="left-font03" onClick="list('1')" >页面管理</a></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </TABLE>
                    <table id="subtree1" style="DISPLAY: none" width="80%" border="0" align="center" cellpadding="0" ellspacing="0" class="left-table02">
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu20" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../gamesort.php" target="mainFrame" class="left-font03" onClick="tupian('20')">游戏分类</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu17" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%">
                                <a href="../hotgame.php" target="mainFrame" class="left-font03" onClick="tupian('17')">热门游戏</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu18" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%">
                                <a href="../newgame.php" target="mainFrame" class="left-font03" onClick="tupian('18')">最新游戏</a></td>
                        </tr>
<!--                        <tr>
                            <td width="9%" height="21" ><img id="xiaotu21" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../gameplatin.php" target="mainFrame" class="left-font03" onClick="tupian('21')">游戏平台</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu22" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../blogroll.php" target="mainFrame" class="left-font03" onClick="tupian('22')">友情链接</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu13" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../announcement_list.php" target="mainFrame" class="left-font03" onClick="tupian('13')">公告管理</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu16" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../advertisement.php" target="mainFrame" class="left-font03" onClick="tupian('16')">广告管理</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu28" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../images_index.php" target="mainFrame" class="left-font03" onClick="tupian('28')">首页图片</a></td>
                        </tr>-->
<!--                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu41" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%">
                                <a href="../index_order_web.php" target="mainFrame" class="left-font03" onClick="tupian('41')">网页游戏</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu42" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%">
                                <a href="../index_order_game.php" target="mainFrame" class="left-font03" onClick="tupian('42')">网络游戏</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu29" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../gamesort_image.php" target="mainFrame" class="left-font03" onClick="tupian('29')">二级页面图片</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu33" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../new_server.php" target="mainFrame" class="left-font03" onClick="tupian('33')">网游游戏中心</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu34" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../index_game.php" target="mainFrame" class="left-font03" onClick="tupian('34')">热门网页游戏</a></td>
                        </tr>-->
                    </table>
                    <!--  页面管理结束    -->

                    <!--  游戏库管理开始    -->
                    <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="left-table03"  id="table2" style="DISPLAY: none">
                        <tr>
                            <td height="29">
                                <table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="8%"><img name="img2" id="img2" src="../images/ico04.gif" width="8" height="11" /></td>
                                        <td width="92%">
                                            <a href="javascript:" target="mainFrame" class="left-font03" onClick="list('2')" >游戏库管理</a></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </TABLE>
                    <table id="subtree2" style="DISPLAY: none" width="80%" border="0" align="center" cellpadding="0"
                           cellspacing="0" class="left-table02">

                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu19" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%">
                                <a href="../gameassembly.php" target="mainFrame" class="left-font03" onClick="tupian('19')">游戏管理</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu24" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%">
                                <a href="../type.php" target="mainFrame" class="left-font03" onClick="tupian('24')">添加分类</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu40" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%">
                                <a href="../tools.php" target="mainFrame" class="left-font03" onClick="tupian('40')">游戏工具</a></td>
                        </tr>

                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu69" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../gamelist.php" target="mainFrame" class="left-font03" onClick="tupian('69')">游戏中心</a></td>
                        </tr>
                    </table>
                    <!--  游戏库管理结束    -->

                    <!--  热门词管理开始    -->
                    <!--                    <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="left-table03"  id="table3" style="DISPLAY: none">
                                            <tr>
                                                <td height="29">
                                                    <table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td width="8%"><img name="img3" id="img3" src="../images/ico04.gif" width="8" height="11" /></td>
                                                            <td width="92%">
                                                                <a href="javascript:" target="mainFrame" class="left-font03" onClick="list('3')" >热门词管理</a></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </TABLE>
                                        <table id="subtree3" style="DISPLAY: none" width="80%" border="0" align="center" cellpadding="0"
                                               cellspacing="0" class="left-table02">
                                            <tr>
                                                <td width="9%" height="20" ><img id="xiaotu1" src="../images/ico06.gif" width="8" height="12" /></td>
                                                <td width="91%"><a href="../keywords.php" target="mainFrame" class="left-font03" onClick="tupian('1')">首页热门词</a></td>
                                            </tr>
                                            <tr>
                                                <td width="9%" height="20" ><img id="xiaotu4" src="../images/ico06.gif" width="8" height="12" /></td>
                                                <td width="91%"><a href="../sort_keywords.php" target="mainFrame" class="left-font03" onClick="tupian('4')">分类热门词</a></td>
                                            </tr>
                                        </table>-->
                    <!--  热门词管理结束    -->

                    <!--用户管理开始-->
                    <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="left-table03"  id="table5" style="DISPLAY: none">
                        <tr>
                            <td height="29">
                                <table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="8%"><img name="img5" id="img5" src="../images/ico04.gif" width="8" height="11" /></td>
                                        <td width="92%">
                                            <a href="javascript:" target="mainFrame" class="left-font03" onClick="list('5')" >用户管理</a></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </TABLE>
                    <table id="subtree5" style="DISPLAY: none" width="80%" border="0" align="center" cellpadding="0"  cellspacing="0" class="left-table02">
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu11" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../user.php" target="mainFrame" class="left-font03" onClick="tupian('11')">用户信息</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu14" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../mark.php" target="mainFrame" class="left-font03" onClick="tupian('14')">积分统计</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu15" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../pay.php" target="mainFrame" class="left-font03" onClick="tupian('15')">充值管理</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu65" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../goldCarry.php" target="mainFrame" class="left-font03" onClick="tupian('65')">现金提现</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu68" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../goldExchange.php" target="mainFrame" class="left-font03" onClick="tupian('68')">金币兑换</a></td>
                        </tr>
                    </table>
                    <!--用户管理结束-->

                    <!--  后台管理开始    -->
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="left-table03">
                        <tr>
                            <td height="29"><table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="8%" height="12"><img name="img4" id="img4" src="../images/ico04.gif" width="8" height="11" /></td>
                                        <td width="92%"><a href="javascript:" target="mainFrame" class="left-font03" onClick="list('4')" >后台管理</a></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>

                    <table id="subtree4" style="DISPLAY: none" width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="left-table02">
                        <tr id="table4" style="DISPLAY: none">
                            <td width="9%" height="20" ><img id="xiaotu7" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../admin.php" target="mainFrame" class="left-font03" onClick="tupian('7')">管理员管理</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu10" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../myadmin.php" target="mainFrame" class="left-font03" onClick="tupian('10')">个人管理</a></td>
                        </tr>
                    </table>
                    <!--  后台管理结束    -->
                    <!--  招聘模块开始    -->
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="left-table03">
                        <tr>
                            <td height="29"><table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="8%" height="12"><img name="img4" id="img6" src="../images/ico04.gif" width="8" height="11" /></td>
                                        <td width="92%"><a href="javascript:" target="mainFrame" class="left-font03" onClick="list('6')" >招聘管理</a></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>

                    <table id="subtree6" style="DISPLAY: none" width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="left-table02">
                        <tr id="table6" style=" ">
                            <td width="9%" height="20" ><img id="xiaotu100" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../userjob.php" target="mainFrame" class="left-font03" onClick="tupian('100')">玩家招聘管理</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu101" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../notice.php" target="mainFrame" class="left-font03" onClick="tupian('101')">招聘成绩公告管理</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu102" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../inform.php" target="mainFrame" class="left-font03" onClick="tupian('102')">最新通知管理</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu105" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../statistics.php" target="mainFrame" class="left-font03" onClick="tupian('105')">数据统计</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu106" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../job_skill.php" target="mainFrame" class="left-font03" onClick="tupian('106')">求职技巧管理</a></td>
                        </tr>
                    </table>
                    <!--招聘模块结束-->


                    <!--  招聘 职位模块开始    -->
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="left-table03">
                        <tr>
                            <td height="29"><table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="8%" height="12"><img name="img4" id="img7" src="../images/ico04.gif" width="8" height="11" /></td>
                                        <td width="92%"><a href="javascript:" target="mainFrame" class="left-font03" onClick="list('7')" >招聘&nbsp;职位管理</a></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>

                    <table id="subtree7" style="DISPLAY: none" width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="left-table02">
                        <tr id="table7" style=" ">
                            <td width="9%" height="20" ><img id="xiaotu106" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../add_professional.php" target="mainFrame" class="left-font03" onClick="tupian('106')">添加职位</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu107" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../professional.php" target="mainFrame" class="left-font03" onClick="tupian('107')">职位管理</a></td>
                        </tr>
                        <tr>
                            <td width="9%" height="20" ><img id="xiaotu108" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../industry.php" target="mainFrame" class="left-font03" onClick="tupian('108')">行业管理</a></td>
                        </tr>  
                    </table>
                    <!--招聘职位模块结束-->



                    <!--  招聘 职位模块开始    -->
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="left-table03">
                        <tr>
                            <td height="29"><table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="8%" height="12"><img name="img4" id="img8" src="../images/ico04.gif" width="8" height="11" /></td>
                                        <td width="92%"><a href="javascript:" target="mainFrame" class="left-font03" onClick="list('8')" >招聘 公司管理</a></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>

                    <table id="subtree8" style="DISPLAY: none" width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="left-table02">
                        <tr id="table8" style=" ">
                            <td width="9%" height="20" ><img id="xiaotu108" src="../images/ico06.gif" width="8" height="12" /></td>
                            <td width="91%"><a href="../company.php" target="mainFrame" class="left-font03" onClick="tupian('106')">公司管理</a></td>
                        </tr>
                    </table>
                    <!--招聘职位模块结束-->

                </TD>
            </tr>
        </table>
    </body>
</html>
