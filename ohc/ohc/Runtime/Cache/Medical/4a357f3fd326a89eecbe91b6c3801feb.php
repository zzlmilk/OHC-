<?php if (!defined('THINK_PATH')) exit();?><script>
    var doctorList = '<?php echo ($doctor_json_list); ?>';
    //数据库查询结果 用json编码
    currentPageData = eval("(" +(doctorList) + ")");  //当前
    //数据总数
    finaCount = '<?php echo ($doctor_list_count); ?>';
    //当前区域
    currentArea = '<?php echo ($current); ?>';
    $(function(){
        doctorListHeight();
    })
</script>
<?php if(is_array($doctor_list)): foreach($doctor_list as $k=>$vo): if($k < 3): ?><div class="doctor_more_list"  style="margin-top: 10px;">
            <!--                            <div style="height: 105px;">
                                                                        医生的基本信息
                                                                        医生简介
                                            <div style="color: #acabab; height: 120px; margin-left: 50px;margin-top: 10px;padding-bottom: 20px; font-weight: bold;font-size: 13px; width: 435px; line-height: 21px;" class="left"><?php echo (strmax($vo["doctor_info"])); ?></div>
                                        </div>-->

            <!--                         Name-->
            <div class="left rowStyle" >
                <span class="promptStyle">Name:</span>
                <div class="doctorinfofont"><div id="nameStyle" onclick="searchCustom('1','<?php echo ($vo["doctor_id"]); ?>','<?php echo (urldecode($vo["doctor_frist_name"])); ?> <?php echo (urldecode($vo["doctor_middle_name"])); ?> <?php echo (urldecode($vo["doctor_last_name"])); ?>','<?php echo ($vo["street_city"]); ?> <?php echo ($vo["street_state"]); ?>','')"><?php echo (urldecode($vo["doctor_frist_name"])); ?>&nbsp;<?php echo (urldecode($vo["doctor_middle_name"])); ?>&nbsp;<?php echo (urldecode($vo["doctor_last_name"])); ?></div></div>
            </div>                                 
            <!--                         Location   -->

            <div class="left rowStyle" >
                <span class="promptStyle">Location:</span>
                <div class="doctorinfofont" ><?php echo ($vo["street_city"]); ?>&nbsp;<?php echo ($vo["street_state"]); ?></div>
            </div>


            <!--                            医生专业技能-->
            <?php if($vo["title"] != ''): ?><div class="left rowStyle"  id="professionalHeight">
                    <span class="promptStyle">title:</span>
                    <div class="doctorinfofont"><?php echo ($vo["title"]); ?></div>
                </div><?php endif; ?>
            <!--                            医生所属科-->
            <div class="left rowStyle" >
                <span class="promptStyle">specialty：</span>
                <div class="doctorinfofont"><?php echo ($vo["specialty"]); ?>
                    <?php if(($vo["specialty"] != '')and($vo["specialty2"] != '')): ?>,<?php endif; ?>
                    <?php echo ($vo["specialty2"]); ?>
                </div>
            </div>

            <!--                            Reviews-->
            <div class="left rowStyle" >
                <span class="promptStyle">Reviews:</span>
                <div class="doctorinfofont"><?php echo ($vo["review_number"]); ?></div>
            </div>
            <!--                            Colligation-->
            <div class="left rowStyle" >
                <span class="promptStyle">O score:</span>
                <div class="doctorinfofont">
                    <?php echo ($vo["review_scorce"]); ?>
                </div>
            </div>

            <!--                            more 按钮-->
            <div class="moreArea" style="width: 538px;">
                <div class="moreButtom moreButtomNomal"  style="margin-left: 475px; float: right;cursor: pointer;" onclick="searchCustom('1','<?php echo ($vo["doctor_id"]); ?>','<?php echo ($vo["doctor_frist_name"]); ?> <?php echo ($vo["doctor_middle_name"]); ?> <?php echo ($vo["doctor_last_name"]); ?>','<?php echo ($vo["street_city"]); ?> <?php echo ($vo["street_state"]); ?>','')">
                </div>
            </div>
        </div><?php endif; endforeach; endif; ?>
<!--                    分页-->
<div style=" width: 514px; margin-top: 12px;"><?php echo ($doctor_page); ?></div>