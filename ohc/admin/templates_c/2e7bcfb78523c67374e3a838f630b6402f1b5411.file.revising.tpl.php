<?php /* Smarty version Smarty-3.0-RC2, created on 2014-01-07 15:39:57
         compiled from "/web/www/OHC-/ohc/admin//templates/revising.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6944737952cbaf4d50f2d6-56035039%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2e7bcfb78523c67374e3a838f630b6402f1b5411' => 
    array (
      0 => '/web/www/OHC-/ohc/admin//templates/revising.tpl',
      1 => 1389073637,
    ),
  ),
  'nocache_hash' => '6944737952cbaf4d50f2d6-56035039',
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
    </head>
    <body>
        <div>
            <form  action="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=revising&function=deleteReview" method="POST">
                <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th><th>id</th><th>user name</th><th>doctor name</th><th>procedures_name</th><th>hospitals_name</th>
                        <th>city_location</th><th>zip_code</th><th>commect review</th>
                        <th>check_state</th>
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
                    <td><input type='checkbox' name='checkbox[]' value=<?php echo $_smarty_tpl->tpl_vars['vo']->value['contentId'];?>
,<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
></td>
                    <td><a href="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=revising&function=upDateReviewRevising&reviewId=<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
</a></td>
                    <td style="display: none;"><?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
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
                    <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['check_state'];?>
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