<?php /* Smarty version Smarty-3.0-RC2, created on 2014-01-07 15:39:53
         compiled from "/web/www/OHC-/ohc/admin//templates/doctor_excel.tpl" */ ?>
<?php /*%%SmartyHeaderCode:66978412152cbaf495dfe63-02593667%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '28c4c327e9d82a04abfec2f4924561511bc5771e' => 
    array (
      0 => '/web/www/OHC-/ohc/admin//templates/doctor_excel.tpl',
      1 => 1388978694,
    ),
  ),
  'nocache_hash' => '66978412152cbaf495dfe63-02593667',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form action='<?php echo $_smarty_tpl->getVariable('URLController')->value;?>
redirst.php?action=excel&function=upload&upload_type=ohc_doctor' method='post' enctype="multipart/form-data">
            <div>
                请选择excel文件:<input type="file" name='excel' id='excel' />
            </div>
            <div>
                <input type='submit' name='formsubmit' id='formsubmit' value='提交'>
            </div>
        </form>
    </body>
</html>
