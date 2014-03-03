<?php if (!defined('THINK_PATH')) exit();?><!--            医疗项目开始-->

<div style="width: 535px;margin-left: 55px; " class="left">
    <?php if(is_array($doctor_procedure)): foreach($doctor_procedure as $k=>$vo): ?><div id="doctor_produce_<?php echo ($k); ?>">
            
            <div class=" produce_doctor" style=" margin-top: 10px;" id="produce_doctor_<?php echo ($k); ?>">
                <div class="doctor_produce_title">
                    <?php if($vo["procedure_other_name"] == '' ): echo (strdoctordefined($vo["produre_name"],50)); ?>
                        <input type="hidden" name="doctor_procedure_<?php echo ($k); ?>" id="doctor_procedure_<?php echo ($k); ?>" value="<?php echo ($vo["produre_name"]); ?>" />
                        <?php else: ?>
                        <?php echo (strdoctordefined($vo["procedure_other_name"],50)); ?>
                        <input type="hidden" name="doctor_procedure_<?php echo ($k); ?>" id="doctor_procedure_<?php echo ($k); ?>" value="<?php echo ($vo["procedure_other_name"]); ?>" /><?php endif; ?>
                    <!--                                        <?php echo ($vo["procedure_other_name"]); ?>-->
                </div>
                <!--                                <div class="doctor_produce_info">
                                                    <?php echo (strreviewmax($vo["produre_info"])); ?>
                                                </div>-->
                <div style="margin-bottom: 10px;font-size: 14px; margin-top: 20px;"><span class="doctor_produce_title" style="font-size: 16px; display: block;width: 100px; margin-top: 0px; float: left;">Reviews:</span><span class=" doctor_produce_info" style="margin-left: 5px; font-size: 15px;"> <?php echo ($vo['review_content_number']); ?></span></div>
                <div style="float:left;font-size: 14px;"><span class="doctor_produce_title" style="font-size: 16px; width: 100px; display: block; float: left; position: absolute; margin-left: 10px; margin-top: 0px;">Score:</span><span class=" doctor_produce_info" style="margin-left: 115px; font-size: 15px"> <?php echo (round($vo['produre_scores'])); ?></span></div>
                <div class="doctor_produce_image" style="margin-top: 0" onclick="reviewproduceDisplay('<?php echo ($k); ?>')" ><div class="doctor_butSty doctor_produceButOff"></div></div>
            </div>
            <div class="doctor_review_list_like" style="font-size: 12px;margin-top: 8px; width: 555px; margin-left: -53px;position: relative; display: none; border: 1px solid #5b5b5b;border-radius: 5px; " id="produce_doctor_review_list_like_<?php echo ($k); ?>">
                <?php if($vo["commect_review"] == '' ): ?><div style="text-align: center; margin-top: 75px; font-size: 20px;">
                        No review now
                    </div>
                    <?php else: ?>
                     <div style="margin-left: 20px;margin-top: 10px;color: #acabab; font-size: 12px;">
    <?php echo ($vo['commect_review']); ?>
</div>
<div style="margin-top: 20px;"></div>
<div class="doctor_like_produce left"  id="doctor_produce_list_<?php echo ($k); ?>" >
    <?php if($vo["produre_reviewlike"] == 1 ): ?><span style="line-height: 23px;color: #848484; display: inline-block;width: 70px; margin-left: 2px" class="left">comment</span> 
        <span style="line-height: 22px;color:#323232;display: inline-block; " class="left">Was this review helpful for you?</span>
        <span class="left" style=" display: inline-block;width:70px; line-height: 22px;" id="review_like_yn">
            <span class="review_like" style=" text-align: center; line-height: 22px;" onclick="doctorLike('<?php echo ($vo["review_id"]); ?>', 1, 'doctor:produce:<?php echo ($k); ?>')">Yes</span>
            <span class="review_like" style=" text-align: center;line-height: 22px;" onclick="doctorLike('<?php echo ($vo["review_id"]); ?>', 0, 'doctor:produce:<?php echo ($k); ?>')">No</span>
        </span>
        <?php else: ?>
        &nbsp;<?php endif; ?>
</div>
<?php echo ($vo["page"]); endif; ?>
            </div>
        </div><?php endforeach; endif; ?>
</div>