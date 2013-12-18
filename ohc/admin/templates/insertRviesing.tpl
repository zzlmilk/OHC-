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
        <script  type="text/javascript" src="{$URLController}js/jquery.js"></script>
        <script>

        function formSubmit(){

            var result = 1;

            var revisingState = $('#revisingState').val();

            switch(revisingState){
                case '4':result = checkProduce();
                break;
            }



            alert(result);

            if(result == 1){

                $('#form1').submit();
            }

        }


        function checkProduce(){
           var proceduresId = $('#proceduresId').val();

           var procedures  = $('#procedures').val();

           if(proceduresId == ''){


                alert('请输入proceduresId');

                return 0;
           }
           if(procedures == ''){


                alert('请输入proceduresId');

                return 0;
           }


           if(procedures!='' && proceduresId!=''){
            return 1;
           }



        }
        </script>
    </head>
    <body>
        <input type='hidden' name='revisingState' id='revisingState' value='{$revisingState[0]}'>
        <div>
            <h1>                   
                {if $revisingState[0]=='1'}
                 以下Doctor是否实际存在 
                {else if $revisingState[0]=='2'}
                  以下Hosptial是否实际存在
                {else if $revisingState[0]=='3'}
                   以下ZipCode是否实际存在 
                {else if $revisingState[0]=='4'}
                   以下Procedures是否实际存在 
                {/if}
            </h1>
            <form action="{$URLController}redirst.php?action=revising&function=checkRevising" method="post" id='form1'  name='form1'>
                <input type='hidden' id='checkType' value="{$revisingState[0]}">
                <input type="hidden" id='revisingId' name='revisingId' value="{$updateValue.id}">
            <table>
                {if $revisingState[0]=='2'}
                <tr>
                <td class="rightText">hospitals name:</td>
                <td><input type="text" name="hospitalName" id="hospitalName" value="{$updateValue.hospitals_name}"/></td>
                </tr>
                {else if $revisingState[0]=='1'}
                <tr>
                    <td class="rightText">doctors frist name:</td>
                    <td><input type="text" name="firstName" id="firstName" value="{$updateValue.doctors_frist_name}"/></td>
                </tr>
                <tr>
                    <td class="rightText">doctors middle name:</td>
                    <td><input type="text" name="middleName" id="middleName" value="{$updateValue.doctor_middle_name}"/></td>
                </tr>
                <tr>
                    <td class="rightText">doctors last name:</td>
                    <td><input type="text" name="lastName" id="lastName" value="{$updateValue.doctors_last_name}"/></td>
                </tr>
                <tr>
                    <td class="rightText">doctor gender:</td>
                    <td>
                        <select name="doctorGender" id="doctorGender" value=""/>
                        <option value="M">male</option>  
                        <option value="F">female</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="rightText">street zip:</td>
                    <td><input type="text" name="streetZip" id="streetZip" value="{$updateValue.zip_code}"/></td>
                </tr>
                <tr>
                    <td class="rightText">street city:</td>
                    <td><input type="text" name="streetCity" id="streetCity" value="{$updateValue.city_location}"/></td>
                </tr>
                <tr>
                    <td class="rightText">street state:</td>
                    <td><input type="text" name="streetState" id="streetState" value="{$updateValue.state}"/></td>
                </tr>
                <tr>
                    <td class="rightText">npi:</td>
                    <td><input type="text" name="npi" id="npi" value=""/></td>
                </tr>
                <tr>
                    <td class="rightText">graduation year:</td>
                    <td><input type="text" name="graduationYear" id="graduationYear" value=""/></td>
                </tr>
                <tr>
                    <td class="rightText">medical school:</td>
                    <td><input type="text" name="medicalSchool" id="medicalSchool" value=""/></td>
                </tr>
                <tr>
                    <td class="rightText">specialty:</td>
                    <td><input type="text" name="specialty" id="specialty" value=""/></td>
                </tr>
                <tr>
                    <td class="rightText">specialty2:</td>
                    <td><input type="text" name="specialty2" id="specialty2" value=""/></td>
                </tr>
                <tr>
                    <td class="rightText">doctor telephone:</td>
                    <td><input type="text" name="doctorTelephone" id="doctorTelephone" value=""/></td>
                </tr>
                <tr>
                    <td class="rightText">doctor email:</td>
                    <td><input type="text" name="doctorEmail" id="doctorEmail" value=""/></td>
                </tr>
                {else if $revisingState[0]=='4'}



              
                <tr>
                    <td class="rightText">procedures id:</td>
                    <td><input type="text" name="proceduresId" id="proceduresId" value=""/></td>
                </tr>
                <tr>
                    <td class="rightText">procedures name:</td>
                    <td><input type="text" name="procedures" id="procedures" value="{$updateValue.procedures_name}"/></td>
                </tr>
                <tr>
                    
                    <td class="rightText">procedures type:</td> 
                    <td><select name="proceduresType" id="proceduresType">
                            <option selected>Preferred Name</option>
                            <option>Other Name</option>
                        </select>
                </tr>
                {else if $revisingState[0]=='3'}
                <tr>
                <td class="rightText">code id:</td>
                <td><input type="text" name="code_id" id="code_id" value="{$updateValue.zip_code}"/></td>
                </tr>
                <tr>
                <td class="rightText">city:</td>
                <td><input type="text" name="city" id="city" value="{$updateValue.city_location}"/></td>
                </tr>
                <tr>
                <td class="rightText">state:</td>
                <td><input type="text" name="state" id="state" value="{$updateValue.state}"/></td>
                </tr>
<!--                <tr>
                <td class="rightText">state name:</td>
                <td><input type="text" name="state_name" id="state_name" value=""/></td>
                </tr>-->
                {else}
                    此数据无需验证！
                    <a href="redirst.php?action=revising">返回</a>
                    
                {/if}

<!--            <tr>
                <td class="rightText">city location:</td>
                <td><input type="text" name="city_location" id="city_location" value="{$updateValue.city_location}"/></td>
            </tr>
            <tr>
                <td class="rightText">zip_code:</td>
                <td><input type="text" name="zip_code" id="zip_code" value="{$updateValue.zip_code}"/></td>
            </tr>-->
            <tr><td colspan="2"><input id='button1' type="button" value="submit" onclick='formSubmit();'/></td></tr>
        </table>
            </form>
        </div>
    </body>
</html>
