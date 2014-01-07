<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <form action="{$URLController}redirst.php?action=review&function=insertReview" method="Post">
        <table>
            <tr><td>Procedures Name:</td><td><input type='text' name="ProceduresName" id="ProceduresName"></td></tr>
            <tr> <td>Zip code:</td><td><input type='text' name="zipcode" id="zipcode"></td></tr>
            <tr> <td>State:</td><td><input type='text' name="State" id="State"></td></tr>
            <tr> <td>City:</td><td><input type='text' name="City" id="City"></td></tr>
            <tr> <td>Doctor first name:</td><td><input type='text' name="firstName" id="firstName"></td></tr>
             <tr> <td>Doctor_middle_name:</td><td><input type='text' name="middleName" id="middleName"></td></tr>
            <tr> <td>Doctor last name:</td><td><input type='text' name="lastName" id="lastName"></td></tr>
            <tr> <td> organization:</td><td><input type='text' name="organization" id="organization"></td></tr>
            <tr> <td>visiting date:</td><td>year:
                    <select style="margin-left: 18px;width: 95px;" type='text' name="year" id="year">
                        {foreach from=$year item=vo}
                        <option>{$vo}</option>
                        {/foreach}
                    </select>
                    <br> month:
                    <select style="width: 95px;" type='text' name="month" id="month">
                        {foreach from=$month item=vo}
                        <option>{$vo}</option>
                        {/foreach}
                    </select></td></tr>
            <tr> <td>Please rate the ease of appointment and waiting time in the office(1-5):</td><td>
                    <select type='text' name="s1" id="s1">
                        {foreach from=$score item=vo}
                        <option>{$vo}</option>
                        {/foreach}
                    </select>
                </td></tr>
            <tr> <td>Please rate the bedside manner of the doctor(1-5):</td><td><select type='text' name="s2" id="s2">
                        {foreach from=$score item=vo}
                        <option>{$vo}</option>
                        {/foreach}
                    </select></td></tr>
            <tr> <td>Please rate the knowledge and skills of the doctor(1-5):</td><td><select type='text' name="s3" id="s3">
                        {foreach from=$score item=vo}
                            <option>{$vo}</option>
                        {/foreach}
                    </select></td></tr>
            <tr> <td>Please rate your satisfaction with the outcome(1-5): </td><td><select type='text' name="s4" id="s4">
                        {foreach from=$score item=vo}
                            <option>{$vo}</option>
                        {/foreach}
                    </select></td></tr>
            <tr> <td> Please enter your out-of-pocket payments:</td><td><input type='text' name="organization" id="organization"></td></tr>
            <tr> <td> Please enter the allowed charge the insurer paid to the provider:</td><td><input type='text' name="organization" id="organization"></td></tr>
            <tr><td>review:</td><td><textarea></textarea></td></tr>
            <tr><td colspan="2"><input type="submit" value='insert'></td></tr>
        </table>
        </form>
    </body>
</html>
