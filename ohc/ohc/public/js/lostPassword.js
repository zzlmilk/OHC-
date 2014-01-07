/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 验证邮箱是否存在
 */
function checkPasswordEmail(email) {
    var visiturl = getUrl('User/info/passwordEmail', url);   
    if (email != '') {
        $.get(visiturl, {
            email: email,
        }, function(res) {
            if (res == 1) {
                var message = 'Please check your email for the instructions on how to reset the password';
            } else if (res == 0) {
                var message = ' email sent fail';
            } else {
                var message = res;
            }
            $('#lostpassword_state').html(message)
        });
    } else {
        $('#lostpassword_state').html('email input empty')
    }

}
function checkPasswordSubmit() {
    var message = '';
    var password = $('#lostpassword').val();
    var email = $('#email').val();
    var relostpassword = $('#relostpassword').val();
    var passwordCheck = 0;
    if (password == '') {
        message = 'password input error';
    } else if (relostpassword == '') {
        message = 'repassword input error';
    } else if (password != '' && relostpassword != '') {
        if (password != relostpassword) {
            message = 'password  error';
        } else{
            passwordCheck = 1;
        }
    }
    if (email != '' && password != '' && relostpassword != '' && passwordCheck == 1) {
        $('#setpasswordform').submit();
    } else {
        $('#lostpassword_state').html(message);
    }
}
function lostPasswordEmail() {
    var message = $('#lostpassword_state').html();
    if (message != '') {
        $('#lostpassword_state').html('');
    }
}

