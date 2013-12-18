<?php /* Smarty version Smarty-3.0-RC2, created on 2013-12-16 16:09:42
         compiled from "/var/chroot/home/content/94/11570594/html/admin//templates/checkRviesing.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7632598152aeb54684f4c2-44863639%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2d7c1514a0a9f9e3433d9e72ccf24c18462718a7' => 
    array (
      0 => '/var/chroot/home/content/94/11570594/html/admin//templates/checkRviesing.tpl',
      1 => 1387181018,
    ),
  ),
  'nocache_hash' => '7632598152aeb54684f4c2-44863639',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>
            .rightText{
                text-align: justify;
                width: 250px;
            }
        </style>
    </head>
    <body>
        <div>
           
            <h1>此数据中
                <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('revisingState')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
?>
                    <?php if ($_smarty_tpl->tpl_vars['vo']->value=='1'){?>
                        Doctor
                    <?php }elseif($_smarty_tpl->tpl_vars['vo']->value=='2'){?>
                        &nbsp;Hosptial
                    <?php }elseif($_smarty_tpl->tpl_vars['vo']->value=='3'){?>
                        &nbsp;ZipCode
                    <?php }elseif($_smarty_tpl->tpl_vars['vo']->value=='4'){?>
                        &nbsp;Procedures
                    <?php }?>
                <?php }} ?>
                需要审核</h1>
            <form action="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=revising&function=upDateReviewRevising" method="post">    
            <table>
                <tr>
                    <td>
                        
                        id:<?php echo $_smarty_tpl->getVariable('updateValue')->value['id'];?>

                        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('updateValue')->value['id'];?>
" id="reviewId" name="reviewId">
                    </td>
                    <td>UserName:<?php echo $_smarty_tpl->getVariable('updateValue')->value['user_name'];?>
</td>
                </tr>
            <tr>
                <td class="rightText">doctors frist name:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['doctors_frist_name'];?>
</td>
                <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('revisingState')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
?>
                    <?php if ($_smarty_tpl->tpl_vars['vo']->value=='1'){?>
                      <td style="color:red;">*</td>
                    <?php }?>
                <?php }} ?>
            </tr>
            <tr>
                <td class="rightText">doctors middle name:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['doctor_middle_name'];?>
</td>
                <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('revisingState')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
?>
                    <?php if ($_smarty_tpl->tpl_vars['vo']->value=='1'){?>
                      <td style="color:red;">*</td>
                    <?php }?>
                <?php }} ?>
            </tr>
            <tr>
                <td class="rightText">doctors last name:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['doctors_last_name'];?>
</td>
                <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('revisingState')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
?>
                    <?php if ($_smarty_tpl->tpl_vars['vo']->value=='1'){?>
                      <td style="color:red;">*</td>
                    <?php }?>
                <?php }} ?>
            </tr>
            <tr>
                <td class="rightText">procedures name:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['procedures_name'];?>
</td>
                    <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('revisingState')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
?>
                    <?php if ($_smarty_tpl->tpl_vars['vo']->value=='4'){?>
                      <td style="color:red;">*</td>
                    <?php }?>
                <?php }} ?>
            </tr>
            <?php if ($_smarty_tpl->getVariable('updateValue')->value['procedures_other_name']!=''){?>
            <tr>
                <td class="rightText">procedures other name:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['procedures_other_name'];?>
</td>
                <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('revisingState')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
?>
                    <?php if ($_smarty_tpl->tpl_vars['vo']->value=='4'){?>
                      <td style="color:red;">*</td>
                    <?php }?>
                <?php }} ?>
            </tr>
            <?php }?>
            <tr>
                <td class="rightText">hospitals name:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['hospitals_name'];?>
</td>
                <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('revisingState')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
?>
                    <?php if ($_smarty_tpl->tpl_vars['vo']->value=='2'){?>
                      <td style="color:red;">*</td>
                    <?php }?>
                <?php }} ?>
            </tr>
            <tr>
                <td class="rightText">city location:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['city_location'];?>
</td>
                <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('revisingState')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
?>
                    <?php if ($_smarty_tpl->tpl_vars['vo']->value=='3'){?>
                      <td style="color:red;">*</td>
                    <?php }?>
                <?php }} ?>
            </tr>
            <tr>
                <td class="rightText">city state:</td>
                 <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['state'];?>
</td>
                <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('revisingState')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
?>
                    <?php if ($_smarty_tpl->tpl_vars['vo']->value=='3'){?>
                      <td style="color:red;">*</td>
                    <?php }?>
                <?php }} ?>
            </tr>
            <tr>
                <td class="rightText">zip_code:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['zip_code'];?>
</td>
                <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('revisingState')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
?>
                    <?php if ($_smarty_tpl->tpl_vars['vo']->value=='3'){?>
                      <td style="color:red;">*</td>
                    <?php }?>
                <?php }} ?>
            </tr>
            <tr>
                <td class="rightText">review time:</td>
                <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->getVariable('updateValue')->value['review_time']);?>
</td>
            </tr>
            <tr>
                <td class="rightText">cost:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['cost'];?>
</td>
            </tr>
            <tr>
                <td class="rightText">review year:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['review_year'];?>
</td>
            </tr>        
            <tr>
                <td class="rightText">review month:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['review_month'];?>
</td>
            </tr>    
            <tr>
                <td class="rightText">costselect:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['costselect'];?>
</td>
            </tr> 
            <tr>
                <td class="rightText">cost review1:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['c1'];?>
</td>
            </tr> 
            <tr>
                <td class="rightText">cost review2:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['c2'];?>
</td>
            </tr> 
            <tr>
                <td class="rightText">waiting time in the office:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['b1'];?>
</td>
            </tr> 
            <tr>
                <td class="rightText">bedside manner of the doctor:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['b2'];?>
</td>
            </tr> 
            <tr>
                <td class="rightText">knowledge and skills of the doctor:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['b3'];?>
</td>
            </tr> 
            <tr>
                <td class="rightText">satisfaction with the outcome:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['b4'];?>
</td>
            </tr> 
             <tr>
                <td class="rightText">check state:</td>
                <td>
               <?php echo $_smarty_tpl->getVariable('updateValue')->value['check_state'];?>

                </td>
            </tr>
            <tr>
                <td class="rightText">commect review:</td>
                <td>
               <?php echo $_smarty_tpl->getVariable('updateValue')->value['commect_review'];?>

                </td>
            </tr>
            <tr>
                <td class="rightText">Need to review information:</td>
                <td>
                    <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('revisingState')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
?>
                    <?php if ($_smarty_tpl->tpl_vars['vo']->value=='1'){?>
                        Doctor
                    <?php }elseif($_smarty_tpl->tpl_vars['vo']->value=='2'){?>
                        &nbsp;Hosptial
                    <?php }elseif($_smarty_tpl->tpl_vars['vo']->value=='3'){?>
                        &nbsp;ZipCode
                    <?php }elseif($_smarty_tpl->tpl_vars['vo']->value=='4'){?>
                        &nbsp;Procedures
                    <?php }?>
                <?php }} ?>
                </td>
            </tr>
            <tr><td ><a href="redirst.php?action=revising&function=upDateReviewRevising&reviewId=<?php echo $_smarty_tpl->getVariable('updateValue')->value['id'];?>
"><input type="button" value="修改"/></a></td><td><a href="redirst.php?action=revising&function=checkRevising&<?php echo $_smarty_tpl->getVariable('revisingClass')->value;?>
"><input type="button" value="开始审核"/></a></td></tr>
        </table>
            </form>
        </div>
    </body>
</html>
