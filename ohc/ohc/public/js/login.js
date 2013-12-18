n = 0
function isRepeatClick() {
    if (n == 0)
    {
        n++;
        $('#hiddenSign').trigger('click')
    }
    else {
        return false;
    }
}

function LoginPage(path, PublicUrl) {
    var url = getUrl(path, PublicUrl);
    $.get(url, {
        }, function(res) {
            n = 0;
            /**
         * 判断前面已有登录框  存在则不执行后续代码
         */
            var className = $("#login").attr('class');
        
            if(className != 'loginBoxShdow '){
                $('body').append(res);
                $('.main_mask').css('z-index','9999999');
            } 
        });
}
function UserLogin(path, PublicUrl) {
    var LogUrl = getUrl(path, PublicUrl);  //获取登录页面AJAX调用网址
    var email = $('#user_email').val();
    var password = $('#user_password').val();
    $.get(LogUrl, {
        email: email,
        password: password
    }, function(res) {
        var result = res.split(":"); //字符分割     
        if (result[0] == 0) {
            window.location.href = url;
        } else {
            $('#loginStatus').html(result[1]);
        }
    });
}
function userlogout() {
    var visiturl = getUrl('Home/Ajax/userlogout', url);  //获取登录页面AJAX调用网址
    $.get(visiturl, {
        status: 1
    }, function(res) {
        window.location.href = url;
    });
}
