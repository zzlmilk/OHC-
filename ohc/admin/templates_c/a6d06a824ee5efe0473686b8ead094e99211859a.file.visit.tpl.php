<?php /* Smarty version Smarty-3.0-RC2, created on 2014-03-03 17:44:25
         compiled from "/web/www/OHC-/ohc/admin//templates/visit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8816550253144ef986b3c0-01756565%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a6d06a824ee5efe0473686b8ead094e99211859a' => 
    array (
      0 => '/web/www/OHC-/ohc/admin//templates/visit.tpl',
      1 => 1393839861,
    ),
  ),
  'nocache_hash' => '8816550253144ef986b3c0-01756565',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>
            table{
                border-top:1px solid #000;
                border-bottom:1px solid #000;
                border-collapse: collapse;
            }
            table td{
                border-top:1px solid #000;
                text-align:center;
                border-bottom:1px solid #000;
            }
            table td,table th{
                padding-left:15px;
            }
            .nocenter{
                text-align:justify;
            }
        </style>
        <script>
            window.onload=function(){
            var delBut=document.getElementById("deleteButton");
            var tableObj=document.getElementsByTagName("table");
            var tbodyObj=tableObj[0].getElementsByTagName("tbody");
            var checkBoxes=tbodyObj[0].getElementsByTagName('input');
            delBut.onclick=function(){
            var flag=false;
            var len=checkBoxes.length;
            for (var i=0 ;i<len;i++){
            if(checkBoxes[i].checked){
            if(checkBoxes[i].type=='checkbox'){
            flag=true;
        }
    }
}
if(flag){
if (window.confirm("你确定要删除这些数据么")){
return true;
}else{
return false;
}
}else{
alert('你必须选择一项进行操作');
return false;
}
}
}
        </script>
    </head>
    <body>
        <div>

            <form  action="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=review&function=deleteReview" method="POST">
               
<!--                href="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=review&function=insertReview" -->

                <table>
                    <thead>
                        <tr>
                           <th>ip</th>

                           <th>visit_time</th>

                           <th>visit page</th>


                        </tr>
                    </thead>
                    <tbody>            
                        <?php if ($_smarty_tpl->getVariable('reviewAll')->value==null){?>
                        <tr>
                            <td colspan="10">暂无数据</td>

                        </tr>

                        <?php }else{ ?>

                            <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('reviewAll')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
?>
                                <tr>
                                   
                                    <td style="display: none;"><?php echo $_smarty_tpl->tpl_vars['vo']->value['review_id'];?>
</td>
                                    <td> <?php echo $_smarty_tpl->tpl_vars['vo']->value['ip'];?>
</td>
                                  
                                    <td> <?php echo $_smarty_tpl->tpl_vars['vo']->value['visit_time'];?>
</td>
                                    <td class="nocenter"> <?php echo $_smarty_tpl->tpl_vars['vo']->value['page_name'];?>
</td>
                                </tr>
                            <?php }} ?>
                            <?php }?>
                        </tbody>
                    </table>
                </form>
                <div><?php echo $_smarty_tpl->getVariable('paging')->value;?>
</div> 

            </div>
        </body>
    </html>
