<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form action='{$URLController}redirst.php?action=excel&function=upload&upload_type=ohc_doctor' method='post' enctype="multipart/form-data">
            <div>
                请选择excel文件:<input type="file" name='excel' id='excel' />
            </div>
            <div>
                <input type='submit' name='formsubmit' id='formsubmit' value='提交'>
            </div>
        </form>
    </body>
</html>
