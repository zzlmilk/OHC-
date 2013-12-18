<?php /* Smarty version Smarty-3.0-RC2, created on 2013-12-16 16:09:47
         compiled from "/var/chroot/home/content/94/11570594/html/admin//templates/addToMainTable.tpl" */ ?>
<?php /*%%SmartyHeaderCode:96998501952aeb54b80b237-31211819%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '11fdc1d3d46f8ea4920a6d8411fecb0dc5b6817a' => 
    array (
      0 => '/var/chroot/home/content/94/11570594/html/admin//templates/addToMainTable.tpl',
      1 => 1377741454,
    ),
  ),
  'nocache_hash' => '96998501952aeb54b80b237-31211819',
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
                <td><?php echo $_smarty_tpl->getVariable('updateValue')->value['zip_code'];?>
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
