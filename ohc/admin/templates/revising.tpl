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
            <form  action="{$URLController}redirst.php?action=revising&function=deleteReview" method="POST">
                <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th><th>id</th><th>user name</th><th>doctor name</th><th>procedures_name</th><th>hospitals_name</th>
                        <th>city_location</th><th>zip_code</th><th>commect review</th>
                        <th>check_state</th>
                    </tr>
                </thead>
                <tbody>
            {if $reviewAll eq null}
                <tr>
                    <td colspan="10">暂无数据</td>

                </tr>
                
           {else}
            {foreach from=$reviewAll item=vo}
                <tr>
                    <td><input type='checkbox' name='checkbox[]' value={$vo.contentId},{$vo.id}></td>
                    <td><a href="{$URLController}redirst.php?action=revising&function=upDateReviewRevising&reviewId={$vo.id}">{$vo.id}</a></td>
                    <td style="display: none;">{$vo.id}</td>
                    <td> {$vo.user_name}</td>
                    <td> {$vo.doctors_frist_name}&nbsp;{$vo.doctors_last_name}</td>
                    <td class="nocenter"> {$vo.procedures_name}</td>
                    <td> {$vo.hospitals_name}</td>
                    <td> {$vo.city_location}</td>
                    <td> {$vo.zip_code}</td>
                    
                    <td class="nocenter"> {$vo.commect_review}</td>
                    <td>{$vo.check_state}</td>
                </tr>
            {/foreach}
             {/if}
                </tbody>
            </table>
            </form>
                <div>{$paging}</div> 
                
        </div>
    </body>
</html>