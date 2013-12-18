/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var currentPageData ='';//当前页
var lastPage = ''; //上一页
var nextPage ='' //下一页
var current = 1;  //当前区域  取莫5
var finaCount = 0;  //数据总数
function getDoctorList(page){
    var temp =0;
    // 获取 当前页数 是  5的倍数中的 第几页
    /**
     * 8   
     * 2*5-8   5-2 = 3
     */
    temp = 5-(currentArea*5-page); 
    var min = (temp - 1) * 3;
    var max = temp *3;       
    //获取 最小 与 最大之间的数据
    $('#doctor_detail_list').html('');
    for(var i = min; i<max;i++){
        getDoctorListView(currentPageData[i]);
        if(max-i  == 1){
            getDoctorPageCss(page);
        }
    }
}
function getDoctorListView(doctorArray){
    var html = ' <div class="doctor_more_list"  style="margin-top: 10px;">';
    if(doctorArray['doctor_middle_name'] == null || doctorArray['doctor_middle_name'] == undefined ){
        var middleName = '';
    } else{
        var middleName = decodeURI(doctorArray['doctor_middle_name']);
    }
    var doctor_full_name  = decodeURI(doctorArray['doctor_frist_name']) +' '+middleName+' '+decodeURI(doctorArray['doctor_last_name']);
    var doctor_city = doctorArray['street_city'] +' '+doctorArray['street_state'];
    html+=' <div class="left rowStyle" >';
    html+=' <span class="promptStyle">Name:</span> <div class="doctorinfofont">';
    html+=' <div id="nameStyle" onclick="searchCustom(\'1\',\''+doctorArray['doctor_id']+'\',\''+doctor_full_name+'\',\''+doctor_city+'\',\'\')">'+doctor_full_name+'</div>';
    html+='</div>';
    html+='  </div> ';
    html+='<div class="left rowStyle" ><span class="promptStyle">Location:</span><div class="doctorinfofont" >'+doctorArray['street_city']+'</div></div>';
    if(doctorArray['title']!=''){
        html+='<div class="left rowStyle"  id="professionalHeight"><span class="promptStyle">Professional:</span><div class="doctorinfofont">'+doctorArray['title']+'</div></div>';
    }
    html+='  <div class="left rowStyle" ><span class="promptStyle">Object:</span> <div class="doctorinfofont">'+doctorArray['specialty']+'';
    if(doctorArray['specialty']!='' && doctorArray['specialty2']!=''  && doctorArray['specialty2']!=null){
        html +=','+doctorArray['specialty2'];
    }
    html+='</div></div>';
    html+='<div class="left rowStyle" ><span class="promptStyle">Reviews:</span> <div class="doctorinfofont">'+doctorArray['review_number']+'</div></div>';
    html+='<div class="left rowStyle" ><span class="promptStyle">Colligation score:</span><div class="doctorinfofont">'+doctorArray['review_scorce']+'</div> </div>';
    html+='<div class="moreArea" style="width: 538px;"><div class="moreButtom moreButtomNomal"  style="margin-left: 475px; float: right;cursor: pointer;" onclick="searchCustom(\'1\',\''+doctorArray['doctor_id']+'\',\''+doctor_full_name+'\',\''+doctor_city+'\',\'\')"> </div></div>';
    html+='</div>';
    $('#doctor_detail_list').append(html);
    doctorListHeight();
}
//分页样式
function getDoctorPageCss(page){
    var $pageUrl = getUrl('View/View/doctorListPageCss', url);
    $.get($pageUrl, {
        page:page,
        number:finaCount
    }, function(res) {
        $('#doctor_detail_list').append('<div style=" width: 514px; margin-top: 12px;">'+res+'</div>');
    });
}