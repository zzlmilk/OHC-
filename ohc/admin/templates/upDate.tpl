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
            {if $isrevising=='1'}
            <form action="{$URLController}redirst.php?action=revising&function=upDateReviewRevising" method="post">    
                {else}
            <form action="{$URLController}redirst.php?action=review&function=upDateReview" method="post">
                {/if}
            <table>
                <tr>
                    <td>
                        {if $isrevising=='1'}
                        
                        id:{$updateValue.id}
                        {else}
                        id:{$updateValue.review_id}
                         {/if}
                         {if $isrevising=='1'}
                        <input type="hidden" value="{$updateValue.id}" id="reviewId" name="reviewId">
                             {else}
                        <input type="hidden" value="{$updateValue.review_id}" id="reviewId" name="reviewId">
                        {/if}
                    </td>
                    <td>UserName:{$updateValue.user_name}</td>
                </tr>
            <tr>
                <td class="rightText">doctors frist name:</td>
                <td><input type="text" name="doctors_frist_name" id="doctors_frist_name" value="{$updateValue.doctors_frist_name}"/></td>
            </tr>
            <tr>
                <td class="rightText">doctors middle name:</td>
                <td><input type="text" name="doctors_middle_name" id="doctors_middle_name" value="{$updateValue.doctor_middle_name}"/></td>
            </tr>
            <tr>
                <td class="rightText">doctors last name:</td>
                <td><input type="text" name="doctors_last_name" id="doctors_last_name" value="{$updateValue.doctors_last_name}"/></td>
            </tr>
            <tr>
                <td class="rightText">procedures name:</td>
                <td><input type="text" name="procedures_name" id="procedures_name" value="{$updateValue.procedures_name}"/></td>
            </tr>
            <tr>
                <td class="rightText">hospitals name:</td>
                <td><input type="text" name="hospitals_name" id="hospitals_name" value="{$updateValue.hospitals_name}"/></td>
            </tr>
            <tr>
                <td class="rightText">city location:</td>
                <td><input type="text" name="city_location" id="city_location" value="{$updateValue.city_location}"/></td>
            </tr>
            <tr>
                <td class="rightText">zip_code:</td>
                <td><input type="text" name="zip_code" id="zip_code" value="{$updateValue.zip_code}"/></td>
            </tr>
            <tr>
                <td class="rightText">commect review:</td>
                <td>
                <textarea id="commect_review" name="commect_review" style="width: 450px; height: 195px;">{$updateValue.commect_review}</textarea>
                </td>
            </tr>
            {if $isrevising=='1'}
                <tr><td><input type="submit" value="submit"/></td><td><a href='redirst.php?action=revising&function=RevisingReview&revisingId={$updateValue.id}'><input type="button" value="审核"/></a></td></tr>
            {else}
                <tr><td colspan="2"><input type="submit" value="submit"/></td></tr>
            {/if}

        </table>
            </form>
        </div>
    </body>
</html>
