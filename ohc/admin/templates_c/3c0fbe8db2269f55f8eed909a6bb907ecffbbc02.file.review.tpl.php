<?php /* Smarty version Smarty-3.0-RC2, created on 2013-12-16 22:11:31
         compiled from "/var/chroot/home/content/94/11570594/html/admin//templates/review.tpl" */ ?>
<?php /*%%SmartyHeaderCode:118150600052af0a13651449-30631282%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3c0fbe8db2269f55f8eed909a6bb907ecffbbc02' => 
    array (
      0 => '/var/chroot/home/content/94/11570594/html/admin//templates/review.tpl',
      1 => 1377741454,
    ),
  ),
  'nocache_hash' => '118150600052af0a13651449-30631282',
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
                <div><input type="submit" id='deleteButton' value="delete"/><a style="margin-left:20px;">insert</a></div>
<!--                href="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=review&function=insertReview" -->

                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"></th><th>id</th><th>user name</th><th>doctor name</th><th>procedures_name</th><th>hospitals_name</th>
                            <th>city_location</th><th>zip_code</th><th>commect review</th>
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
                                    <td><input type='checkbox' name='checkbox[]'  value=<?php echo $_smarty_tpl->tpl_vars['vo']->value['review_id'];?>
></td>
                                    <td><a href="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=review&function=upDateReview&reviewId=<?php echo $_smarty_tpl->tpl_vars['vo']->value['review_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['review_id'];?>
</a></td>
                                    <td style="display: none;"><?php echo $_smarty_tpl->tpl_vars['vo']->value['review_id'];?>
</td>
                                    <td> <?php echo $_smarty_tpl->tpl_vars['vo']->value['user_name'];?>
</td>
                                    <td> <?php echo $_smarty_tpl->tpl_vars['vo']->value['doctors_frist_name'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['vo']->value['doctors_last_name'];?>
</td>
                                    <td class="nocenter"> <?php echo $_smarty_tpl->tpl_vars['vo']->value['procedures_name'];?>
</td>
                                    <td> <?php echo $_smarty_tpl->tpl_vars['vo']->value['hospitals_name'];?>
</td>
                                    <td> <?php echo $_smarty_tpl->tpl_vars['vo']->value['city_location'];?>
</td>
                                    <td> <?php echo $_smarty_tpl->tpl_vars['vo']->value['zip_code'];?>
</td>
                                    <td class="nocenter"> <?php echo $_smarty_tpl->tpl_vars['vo']->value['commect_review'];?>
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
