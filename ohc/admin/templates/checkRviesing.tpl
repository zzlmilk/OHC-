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
                {foreach from=$revisingState item=vo}
                    {if $vo=='1'}
                        Doctor
                    {else if $vo=='2'}
                        &nbsp;Hosptial
                    {else if $vo=='3'}
                        &nbsp;ZipCode
                    {else if $vo=='4'}
                        &nbsp;Procedures
                    {/if}
                {/foreach}
                需要审核</h1>
            <form action="{$URLController}redirst.php?action=revising&function=upDateReviewRevising" method="post">    
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
                {foreach from=$revisingState item=vo}
                    {if $vo=='1'}
                      <td style="color:red;">*</td>
                    {/if}
                {/foreach}
            </tr>
            <tr>
                <td class="rightText">doctors middle name:</td>
                <td>{$updateValue.doctor_middle_name}</td>
                {foreach from=$revisingState item=vo}
                    {if $vo=='1'}
                      <td style="color:red;">*</td>
                    {/if}
                {/foreach}
            </tr>
            <tr>
                <td class="rightText">doctors last name:</td>
                <td>{$updateValue.doctors_last_name}</td>
                {foreach from=$revisingState item=vo}
                    {if $vo=='1'}
                      <td style="color:red;">*</td>
                    {/if}
                {/foreach}
            </tr>
            <tr>
                <td class="rightText">procedures name:</td>
                <td>{$updateValue.procedures_name}</td>
                    {foreach from=$revisingState item=vo}
                    {if $vo=='4'}
                      <td style="color:red;">*</td>
                    {/if}
                {/foreach}
            </tr>
            {if $updateValue.procedures_other_name!=''}
            <tr>
                <td class="rightText">procedures other name:</td>
                <td>{$updateValue.procedures_other_name}</td>
                {foreach from=$revisingState item=vo}
                    {if $vo=='4'}
                      <td style="color:red;">*</td>
                    {/if}
                {/foreach}
            </tr>
            {/if}
            <tr>
                <td class="rightText">hospitals name:</td>
                <td>{$updateValue.hospitals_name}</td>
                {foreach from=$revisingState item=vo}
                    {if $vo=='2'}
                      <td style="color:red;">*</td>
                    {/if}
                {/foreach}
            </tr>
            <tr>
                <td class="rightText">city location:</td>
                <td>{$updateValue.city_location}</td>
                {foreach from=$revisingState item=vo}
                    {if $vo=='3'}
                      <td style="color:red;">*</td>
                    {/if}
                {/foreach}
            </tr>
            <tr>
                <td class="rightText">city state:</td>
                 <td>{$updateValue.state}</td>
                {foreach from=$revisingState item=vo}
                    {if $vo=='3'}
                      <td style="color:red;">*</td>
                    {/if}
                {/foreach}
            </tr>
            <tr>
                <td class="rightText">zip_code:</td>
                <td>{$updateValue.zip_code|writecode}</td>
                {foreach from=$revisingState item=vo}
                    {if $vo=='3'}
                      <td style="color:red;">*</td>
                    {/if}
                {/foreach}
            </tr>
            <tr>
                <td class="rightText">review time:</td>
                <td>{'Y-m-d H:i:s'|date:$updateValue.review_time}</td>
            </tr>
            <tr>
                <td class="rightText">cost:</td>
                <td>{$updateValue.cost}</td>
            </tr>
            <tr>
                <td class="rightText">review year:</td>
                <td>{$updateValue.review_year}</td>
            </tr>        
            <tr>
                <td class="rightText">review month:</td>
                <td>{$updateValue.review_month}</td>
            </tr>    
            <tr>
                <td class="rightText">costselect:</td>
                <td>{$updateValue.costselect}</td>
            </tr> 
            <tr>
                <td class="rightText">cost review1:</td>
                <td>{$updateValue.c1}</td>
            </tr> 
            <tr>
                <td class="rightText">cost review2:</td>
                <td>{$updateValue.c2}</td>
            </tr> 
            <tr>
                <td class="rightText">waiting time in the office:</td>
                <td>{$updateValue.b1}</td>
            </tr> 
            <tr>
                <td class="rightText">bedside manner of the doctor:</td>
                <td>{$updateValue.b2}</td>
            </tr> 
            <tr>
                <td class="rightText">knowledge and skills of the doctor:</td>
                <td>{$updateValue.b3}</td>
            </tr> 
            <tr>
                <td class="rightText">satisfaction with the outcome:</td>
                <td>{$updateValue.b4}</td>
            </tr> 
             <tr>
                <td class="rightText">check state:</td>
                <td>
               {$updateValue.check_state}
                </td>
            </tr>
            <tr>
                <td class="rightText">commect review:</td>
                <td>
               {$updateValue.commect_review}
                </td>
            </tr>
            <tr>
                <td class="rightText">Need to review information:</td>
                <td>
                    {foreach from=$revisingState item=vo}
                    {if $vo=='1'}
                        Doctor
                    {else if $vo=='2'}
                        &nbsp;Hosptial
                    {else if $vo=='3'}
                        &nbsp;ZipCode
                    {else if $vo=='4'}
                        &nbsp;Procedures
                    {/if}
                {/foreach}
                </td>
            </tr>
            <tr><td ><a href="redirst.php?action=revising&function=upDateReviewRevising&reviewId={$updateValue.id}"><input type="button" value="修改"/></a></td><td><a href="redirst.php?action=revising&function=checkRevising&{$revisingClass}"><input type="button" value="开始审核"/></a></td></tr>
        </table>
            </form>
        </div>
    </body>
</html>
