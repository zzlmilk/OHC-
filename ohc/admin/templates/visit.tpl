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
               
<!--                href="{$URLController}redirst.php?action=review&function=insertReview" -->

                <table style=' width: 600px;'>
                    <thead>
                        <tr>
                           <th>ip</th>

                           <th>visit_time</th>

                           <th>visit page</th>
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
                                   
                                    <td style="display: none;">{$vo.review_id}</td>
                                    <td> {$vo.ip}</td>
                                  
                                    <td> {$vo.visit_time}</td>
                                    <td class="nocenter"> {$vo.page_name}</td>
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
