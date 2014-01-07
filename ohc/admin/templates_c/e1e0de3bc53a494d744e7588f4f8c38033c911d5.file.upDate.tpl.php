<?php /* Smarty version Smarty-3.0-RC2, created on 2014-01-07 15:25:49
         compiled from "/web/www/OHC-/ohc/admin//templates/upDate.tpl" */ ?>
<?php /*%%SmartyHeaderCode:43003189552cbabfd6bb396-70024975%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e1e0de3bc53a494d744e7588f4f8c38033c911d5' => 
    array (
      0 => '/web/www/OHC-/ohc/admin//templates/upDate.tpl',
      1 => 1389079526,
    ),
  ),
  'nocache_hash' => '43003189552cbabfd6bb396-70024975',
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
            <?php if ($_smarty_tpl->getVariable('isrevising')->value=='1'){?>
            <form action="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=revising&function=upDateReviewRevising" method="post">   

                <?php }else{ ?>
            <form action="<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=review&function=upDateReview" method="post">
                <?php }?>
            <table>
                <tr>
                    <td>
                        <?php if ($_smarty_tpl->getVariable('isrevising')->value=='1'){?>
                        
                        id:<?php echo $_smarty_tpl->getVariable('updateValue')->value['id'];?>

                        <?php }else{ ?>
                        id:<?php echo $_smarty_tpl->getVariable('updateValue')->value['review_id'];?>

                         <?php }?>
                         <?php if ($_smarty_tpl->getVariable('isrevising')->value=='1'){?>
                        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('updateValue')->value['id'];?>
" id="reviewId" name="reviewId">
                             <?php }else{ ?>
                        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('updateValue')->value['review_id'];?>
" id="reviewId" name="reviewId">
                        <?php }?>
                    </td>
                    <td>UserName:<?php echo $_smarty_tpl->getVariable('updateValue')->value['user_name'];?>
</td>
                </tr>
            <tr>
                <td class="rightText">doctors frist name:</td>
                <td><input type="text" name="doctors_frist_name" id="doctors_frist_name" value="<?php echo $_smarty_tpl->getVariable('updateValue')->value['doctors_frist_name'];?>
"/></td>
            </tr>
            <tr>
                <td class="rightText">doctors middle name:</td>
                <td><input type="text" name="doctors_middle_name" id="doctors_middle_name" value="<?php echo $_smarty_tpl->getVariable('updateValue')->value['doctor_middle_name'];?>
"/></td>
            </tr>
            <tr>
                <td class="rightText">doctors last name:</td>
                <td><input type="text" name="doctors_last_name" id="doctors_last_name" value="<?php echo $_smarty_tpl->getVariable('updateValue')->value['doctors_last_name'];?>
"/></td>
            </tr>
            <tr>
                <td class="rightText">procedures name:</td>
                <td><input type="text" name="procedures_name" id="procedures_name" value="<?php echo $_smarty_tpl->getVariable('updateValue')->value['procedures_name'];?>
"/></td>
            </tr>
            <tr>
                <td class="rightText">hospitals name:</td>
                <td><input type="text" name="hospitals_name" id="hospitals_name" value="<?php echo $_smarty_tpl->getVariable('updateValue')->value['hospitals_name'];?>
"/></td>
            </tr>
            <tr>
                <td class="rightText">city location:</td>
                <td><input type="text" name="city_location" id="city_location" value="<?php echo $_smarty_tpl->getVariable('updateValue')->value['city_location'];?>
"/></td>
            </tr>

              <tr>
                <td class="rightText">state:</td>
                <td><input type="text" name="state" id="state" value="<?php echo $_smarty_tpl->getVariable('updateValue')->value['state'];?>
"/></td>
            </tr>


            <tr>
                <td class="rightText">zip_code:</td>
                <td><input type="text" name="zip_code" id="zip_code" value="<?php echo smarty_modifier_writecode($_smarty_tpl->getVariable('updateValue')->value['zip_code']);?>
"/></td>
            </tr>
            <tr>
                <td class="rightText">commect review:</td>
                <td>
                <textarea id="commect_review" name="commect_review" style="width: 450px; height: 195px;"><?php echo $_smarty_tpl->getVariable('updateValue')->value['commect_review'];?>
</textarea>
                </td>
            </tr>
            <?php if ($_smarty_tpl->getVariable('isrevising')->value=='1'){?>
                <tr><td><input type="submit" value="submit"/></td><td><a href='redirst.php?action=revising&function=RevisingReview&revisingId=<?php echo $_smarty_tpl->getVariable('updateValue')->value['id'];?>
'><input type="button" value="审核"/></a></td></tr>
            <?php }else{ ?>
                <tr><td colspan="2"><input type="submit" value="submit"/></td></tr>
            <?php }?>

        </table>
            </form>
        </div>
    </body>
</html>
