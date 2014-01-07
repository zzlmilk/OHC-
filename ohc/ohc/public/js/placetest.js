$(function() {
    if (!placeholderSupport()) {   // 判断浏览器是否支持 placeholder
        $('input').each(function() {
            var input = $(this);
            /**
             * 判断类型 如果是password的类型的话  在这个input password类型后 生成个新的text文本框
             */
            var input_type = input.attr('type');
            var input_placeholder = input.attr('placeholder');
            var input_class = input.attr('class');
            var input_id = input.attr('id');

            /**
             *  判断是否存在默认显示 内容  如有显示 则开始修改
             */
            if (input_placeholder != undefined) {
                /**
                 *  类型等于password 和 text 时候 才需要修改
                 */
                if (input_type == 'password') {
                    var newInputId = input_id+'placeholder';
                    input.after('<input  id='+newInputId+'   class="'+input_class+'" type="text" value=' + input_placeholder + ' autocomplete="off" />');
                    var pwdPlaceholder = $('#'+newInputId);
                    pwdPlaceholder.css('color', 'gray');
                    pwdPlaceholder.show();
                    input.hide();
                    pwdPlaceholder.focus(function() {
                        pwdPlaceholder.hide();
                        input.show();
                        input.focus();
                    });
                    input.blur(function() {
                        if (input.val() == '') {
                            pwdPlaceholder.show();
                            input.hide();
                        }
                    });
                }
                else if (input_type == 'text') {
                    if (input.val() == '' || input.val() == input.attr('placeholder')) {
                        input.addClass('placeholder');
                        input.val(input.attr('placeholder'));
                        input.css('color', 'gray');
                        input.focus(function() {
                            if ($(this).val() == $(this).attr("placeholder")) {
                                $(this).val("");
                            }
                            /**
                             *  判断是否为错误提示 如果是的话 则去除
                             */
                            for (var searchCount = 0; searchCount < 4; searchCount++) {
                                if (search_state[searchCount] == $(this).val() || search_index[searchCount] == $(this).val()) {
                                    $(this).val("");
                                }
                            }
                        });
                        input.blur(function() {
                            if ($(this).val() == "") {
                                 var textStatue = '';
                                /**
                                 * 针对搜索这边的默认提示  当选其他的类型时  默认提示还是第一个
                                 */
                                 if(input_id !='user_email'){
                                       var search_type = $('#searching').val();
                                var search_type_advanced = $('#search_advanced_type').val();
                                var text_id = $(this).attr('id');
                                textStatue= emptyInputText(search_type_advanced, text_id, search_type);
                            }  else{
                                  textStatue = 'Email';
                            }
                             
                                $(this).val(textStatue);
                            }
                        });
                    }
                }
            }

        })
    }
    ;
})
function placeholderSupport() {
    return 'placeholder' in document.createElement('input');
}



function emptyInputText(search_type_advanced, text_id, search_type) {
    if (search_type_advanced == 1) {
        var textName = text_id;
        var textContent = '';
        switch (textName) {
            case 'doctor_search_text':
                textContent = search_index[0];
                break;
            case 'hospital_search_text':
                textContent = search_index[1];
                break;
            case 'procedure_search_text':
                textContent = search_index[2];
                break;
            case 'location_search_text':
                textContent = search_index[3];
                break;
        }
    } else {
        if(search_type == ''){
            search_type = 1;
        }
        if (search_type >= 1) {
            if (text_id == 'search_text_location') {
                textContent = search_index[3];
            } else {
                textContent = search_index[search_type - 1];
            }

        } else {
            textContent = $(this).attr("placeholder");
        }
    }
    return textContent;
}