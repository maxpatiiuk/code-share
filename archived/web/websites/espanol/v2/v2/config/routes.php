<?php

return [//REGEX  RESULT  TITLE  DESCRIPTION  KEYWORDS  OTHERS  CONTAINER  EXTRA
        //main_page
        'mainPage'                                             => ['index/main', '', '', '', FALSE, TRUE, FALSE], '(class|category|theme|author|unverified|page)\/?(.*)' => ['index/main/$1/$2', '', '', '', FALSE, TRUE, FALSE],

        //profiles_front_end
        'login\/?(success)?'                                   => ['users/login/$1', 'Acceder', 'Acceder', 'Acceder', FALSE, TRUE, FALSE],//Entrada
        'register\/?(class\/?(-1|[5-9]|1?[01]?))?\/?(silent)?' => ['users/register/$2/$3', 'Regístrate', 'Regístrate', 'Regístrate', FALSE, TRUE, FALSE], 'profile\/edit\/?(\d*)' => ['users/advancedProfileEdit/$1', 'Perfil', 'Perfil', 'Perfil', FALSE, TRUE, FALSE], 'profile\/delete\/?(\d*)' => ['users/delete/$1', 'Perfil', 'Perfil', 'Perfil', FALSE, TRUE, FALSE], 'profile\/ban\/(\d+)' => ['users/ban/$1', 'Perfil', 'Perfil', 'Perfil', FALSE, TRUE, FALSE], 'profile\/logout' => ['users/logout', 'Perfil', 'Perfil', 'Perfil', FALSE, TRUE, FALSE], 'profile\/?(\d*|@?[\w\.\-]{3,60})' => ['users/profile/$1', 'Perfil', 'Perfil', 'Perfil', FALSE, TRUE, FALSE], 'confirm\/email\/user\/(\d+)\/key\/([a-z\d]{10})' => ['users/confirmEmail/$1/$2', 'Perfil', 'Perfil', 'Perfil', FALSE, TRUE, FALSE], 'reset\/email\/user\/(\d+)\/key\/([a-z\d]{10})' => ['users/resetEmail/$1/$2', 'Perfil', 'Perfil', 'Perfil', FALSE, TRUE, FALSE], 'reset\/password\/user\/(\d+)\/key\/([a-z\d]{10})' => ['users/resetPassword/$1/$2', 'Perfil', 'Perfil', 'Perfil', FALSE, TRUE, FALSE], 'change\/password' => ['users/changePassword', 'Perfil', 'Perfil', 'Perfil', FALSE, TRUE, FALSE],

        //profiles_back_end
        'validate\/login'                                      => ['users/validateLogin', NULL], 'validate\/register\/?(silent)?' => ['users/validateRegister/$1', NULL], 'validate\/captcha' => ['users/needLoginCaptcha', NULL], 'validate\/r_captcha' => ['users/needRegisterCaptcha', NULL], 'edit\/profile\/advanced\/?(\d*)' => ['users/advancedEditProfile/$1', NULL], 'edit\/profile\/?(\d*)' => ['users/editProfile/$1', NULL], 'delete\/profile\/(\d+)' => ['users/deleteValidate/$1', NULL], 'ban\/profile\/(\d+)' => ['users/banValidate/$1', NULL], 'validate\/confirm\/email\/user\/(\d+)\/key\/([a-z\d]{10})' => ['users/validateConfirmEmail/$1/$2', NULL], 'validate\/reset\/email\/user\/(\d+)\/key\/([a-z\d]{10})' => ['users/validateResetEmail/$1/$2', NULL], 'validate\/reset\/password\/user\/(\d+)\/key\/([a-z\d]{10})' => ['users/validateResetPassword/$1/$2', NULL], 'validate\/change\/password' => ['users/validateChangePassword', NULL],

        //posts_back_end
        'post\/add\/validate'                                  => ['posts/validateAdd/', NULL], 'post\/edit\/validate\/(\d+)' => ['posts/validateEdit/$1', NULL], 'post\/get\/categories\/(\-?\d+)' => ['posts/getCategories/$1', NULL], 'post\/accept\/(\d+)' => ['posts/accept/$1', NULL], 'post\/deleted\/(\d+)' => ['posts/deleted/$1', NULL], 'post\/?(\d*)\/comment\/add' => ['posts/commentAdd/$1', NULL], 'post\/?(\d*)\/comment\/delete' => ['posts/commentDelete/$1', NULL], 'post\/?(\d*)\/comment\/restore' => ['posts/commentRestore/$1', NULL], 'post\/tinymce\/token' => ['posts/tinymceToken', NULL],

        //posts_front_end
        'post\/view\/?(\d*)'                                   => ['posts/view/$1', 'Post', 'Post', 'Post', FALSE, TRUE, FALSE], 'post\/add' => ['posts/add/', 'Post', 'Post', 'Post', FALSE, TRUE, FALSE], 'post\/edit\/?(\d*)' => ['posts/edit/$1', 'Post', 'Post', 'Post', FALSE, TRUE, FALSE], 'post\/review\/?(\d+)' => ['posts/review/$1', 'Post', 'Post', 'Post', FALSE, TRUE, FALSE], 'post\/delete\/(\d*)' => ['posts/delete/$1', 'Post', 'Post', 'Post', FALSE, TRUE, FALSE],

        //others
        'error\/mail'                                          => ['errors/adminNotify', NULL], 'contacts\/send' => ['index/contactsValidate', NULL], 'browserconfig.xml' => ['index/browserConfig', NULL], 'manifest.json' => ['index/manifestJson', NULL], 'favicon.ico' => ['index/favicon', NULL], 'robots.txt' => ['index/robotsTxt', NULL], 'sw.js' => ['index/serviceWorker', NULL], 'cron' => ['index/cron', NULL], 'contacts(\/?(sent))?' => ['index/contacts/$2', 'Contactos', 'Contactos', 'Contactos', FALSE, TRUE, FALSE], '[a-z]*\/?w.*?\.php' => ['index/blank', NULL], 'google([\w]{16})\.html' => ['index/googleVerification/$1', NULL],

        //admin front end
        'admin\/users(\/class\/?(\-1|[05-9]|1[01]))?'          => ['admin/users/$2', 'Ajustes', 'Ajustes', 'Ajustes', FALSE, TRUE, FALSE],

];