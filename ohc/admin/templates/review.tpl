<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
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
        <script>
            window.onload=function(){
            var delBut=document.getElementById("deleteButton");
            var tableObj=document.getElementsByTagName("table");
            var tbodyObj=tableObj[0].getElementsByTagName("tbody");
            var checkBoxes=tbodyObj[0].getElementsByTagName('input');
            delBut.onclick=function(){
            var flag=false;
            var len=checkBoxes.length;
            for (var i=0 ;i<len;i++){
            if(checkBoxes[i].checked){
            if(checkBoxes[i].type=='checkbox'){
            flag=true;
        }
    }
}
if(flag){
if (window.confirm("你确定要删除这些数据么")){
return true;
}else{
return false;
}
}else{
alert('你必须选择一项进行操作');
return false;
}
}
}
        </script>
    </head>
    <body>
        <div>

            <form  action="{$URLController}redirst.php?action=review&function=deleteReview" method="POST">
                <div><input type="submit" id='deleteButton' value="delete"/><a style="margin-left:20px;">insert</a></div>
<!--                href="{$URLController}redirst.php?action=review&function=insertReview" -->

                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"></th><th>id</th><th>user name</th><th>doctor name</th><th>procedures_name</th><th>hospitals_name</th>
                            <th>city_location</th><th>zip_code</th><th>commect review</th>
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
                                    <td><input type='checkbox' name='checkbox[]'  value={$vo.review_id}></td>
                                    <td><a href="{$URLController}redirst.php?action=review&function=upDateReview&reviewId={$vo.review_id}">{$vo.review_id}</a></td>
                                    <td style="display: none;">{$vo.review_id}</td>
                                    <td> {$vo.user_name}</td>
                                    <td> {$vo.doctors_frist_name}&nbsp;{$vo.doctors_last_name}</td>
                                    <td class="nocenter"> {$vo.procedures_name}</td>
                                    <td> {$vo.hospitals_name}</td>
                                    <td> {$vo.city_location}</td>
                                    <td> {$vo.zip_code}</td>
                                    <td class="nocenter"> {$vo.commect_review}</td>
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
