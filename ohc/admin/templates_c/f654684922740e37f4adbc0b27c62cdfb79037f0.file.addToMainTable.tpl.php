<?php /* Smarty version Smarty-3.0-RC2, created on 2014-01-07 15:27:46
         compiled from "/web/www/OHC-/ohc/admin//templates/addToMainTable.tpl" */ ?>
<?php /*%%SmartyHeaderCode:129016362852cbac722a94e4-50277019%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f654684922740e37f4adbc0b27c62cdfb79037f0' => 
    array (
      0 => '/web/www/OHC-/ohc/admin//templates/addToMainTable.tpl',
      1 => 1389077919,
    ),
  ),
  'nocache_hash' => '129016362852cbac722a94e4-50277019',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_writecode')) include '/web/www/OHC-/ohc/admin/Smarty/libs/plugins/modifier.writecode.php';
?><!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>
            .rightText{
                text-align: justify;
            }
        </style>
    </head>
    <body>
        <div>
            <h1>请确认是否要将以下数据添加至数据库？</h1>
            <form action="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=revising&function=addToMainTable" method="post">    
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
            </tr>
            <tr>
                <td class="rightText">doctors last name:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['doctors_last_name'];?>
</td>
            </tr>
            <tr>
                <td class="rightText">procedures name:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['procedures_name'];?>
</td>
            </tr>
            <tr>
                <td class="rightText">hospitals name:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['hospitals_name'];?>
</td>
            </tr>
            <tr>
                <td class="rightText">city location:</td>
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['city_location'];?>
</td>
            </tr>
            <tr>
                <td class="rightText">zip_code:</td>
                <td><?php echo smarty_modifier_writecode($_smarty_tpl->getVariable('updateValue')->value['zip_code']);?>
</td>
            </tr>
            <tr>
                <td class="rightText">commect review:</td>
                <td>
               <?php echo $_smarty_tpl->getVariable('updateValue')->value['commect_review'];?>

                </td>
            </tr>
            
            <tr><td ><input type="submit" value="载入数据"/></td></tr>
        </table>
            </form>
        </div>
    </body>
</html>
