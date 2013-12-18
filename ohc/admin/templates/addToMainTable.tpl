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
            <form action="{$URLController}redirst.php?action=revising&function=addToMainTable" method="post">    
            <table>
                <tr>
                    <td>
                        
                        id:{$updateValue.id}
                        <input type="hidden" value="{$updateValue.id}" id="reviewId" name="reviewId">
                    </td>
                    <td>UserName:{$updateValue.user_name}</td>
                </tr>
            <tr>
                <td class="rightText">doctors frist name:</td>
                <td>{$updateValue.doctors_frist_name}</td>
            </tr>
            <tr>
                <td class="rightText">doctors last name:</td>
                <td>{$updateValue.doctors_last_name}</td>
            </tr>
            <tr>
                <td class="rightText">procedures name:</td>
                <td>{$updateValue.procedures_name}</td>
            </tr>
            <tr>
                <td class="rightText">hospitals name:</td>
                <td>{$updateValue.hospitals_name}</td>
            </tr>
            <tr>
                <td class="rightText">city location:</td>
                <td>{$updateValue.city_location}</td>
            </tr>
            <tr>
                <td class="rightText">zip_code:</td>
                <td>{$updateValue.zip_code}</td>
            </tr>
            <tr>
                <td class="rightText">commect review:</td>
                <td>
               {$updateValue.commect_review}
                </td>
            </tr>
            
            <tr><td ><input type="submit" value="载入数据"/></td></tr>
        </table>
            </form>
        </div>
    </body>
</html>
