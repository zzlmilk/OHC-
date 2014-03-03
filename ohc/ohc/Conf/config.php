<?php

return array(
    'APP_GROUP_LIST' => 'Home,User,Medical,Crontab,Weixin,forum,Bank,Test,Ooptest,View',
    'DEFAULT_GROUP' => 'Home',
    'LOG_RECORD' => true,
    'LOG_EXCEPTION_RECORD' => true,
    'LOG_LEVEL' => 'EMERG,ALERT,CRIT,ERR,WARN,NOTIC,INFO,DEBUG,SQL',
    'DB_FIELDS_CACHE' => false,
    'APP_FILE_CASE' => false,
    'TMPL_CACHE_ON' => true,
    'TMPL_STRIP_SPACE' => false,
    'SHOW_ERROR_MSG' => true,
    'SHOW_PAGE_TRACE' => false,
    'LANG_SWITCH_ON' => true,
    'DEFAULT_LANG' => 'zh-cn', // 默认语言
    'LANG_LIST' => 'zh-cn,en-us', // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE' => 'l', // 默认语言切换变量
   'SMTP_SERVER' => 'smtp.126.com', //邮件服务器
   'SMTP_PORT' => 25, //邮件服务器端口
   'SMTP_USER_EMAIL' => 'jinglingchang@126.com', //SMTP服务器的用户邮箱(一般发件人也得用这个邮箱)
   'SMTP_USER' => 'jinglingchang@126.com', //SMTP服务器账户名
   'SMTP_PWD' => 'zxp19891118', //SMTP服务器账户密码
    
    
    //  'SMTP_SERVER' => 'smtpout.secureserver.net', //邮件服务器
    // 'SMTP_PORT' => 80, //邮件服务器端口
    // 'SMTP_USER_EMAIL' => 'admin@transparentmedicalcare.com', //SMTP服务器的用户邮箱(一般发件人也得用这个邮箱)
    // 'SMTP_USER' => 'admin@transparentmedicalcare.com', //SMTP服务器账户名
    // 'SMTP_PWD' => '1qaz2wsx', //SMTP服务器账户密码
    
    'SMTP_MAIL_TYPE' => 'HTML', //发送邮件类型:HTML,TXT(注意都是大写)
    'SMTP_TIME_OUT' => 30, //超时时间
    'SMTP_AUTH' => true,
    //'adminUrl'=>'http://transparentmedicalcare.com/admin',
   'adminUrl'=>'http://localhost/OHC-/ohc/ohc//admin'
);
?>