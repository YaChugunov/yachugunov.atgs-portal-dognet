<?php
if (!isset($_IS_CRONTAB)) {
    # Включаем режим сессии
    session_start();
    #
    $mysqli = new mysqli(__DEFAULT_DBCONN_HOST, __DEFAULT_DBCONN_USER, __DEFAULT_DBCONN_PASS, __DEFAULT_DBCONN_NAME, __DEFAULT_DBCONN_PORT);
    $result = $mysqli->query("SELECT dognetnew_testmode FROM users_restrictions WHERE id='{$_SESSION['id']}'");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $_SESSION['userInDognetTestmode'] = $row['dognetnew_testmode'];
    /* Close the connection as soon as it becomes unnecessary */
    $mysqli->close();
}
#
#
##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
##### 
##### ОСНОВНАЯ КОНФИГУРАЦИЯ СЕРВИСА ПОЧТА (MAIL)
##### 
##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
#
# РЕЖИМ РАБОТЫ СЕРВИСА : __DOGNET_TESTMODE_ON
# >>> TRUE или 1	- отладочный/тестовый режим
# >>> FALSE	или 0	- рабочий режим

define('__DOGNET_TESTMODE_ON', TRUE);

# ТИП ОТЛАДОЧНОГО РЕЖИМА : __DOGNET_TESTMODE_TYPE
# >>> 0	- рабочая БД, рабочее хранилище, отладочные папки restr_N.test для users.testmode = 1
# >>> 1	- рабочая БД (дублирующие тестовые таблицы), тестовое хранилище, отладочные папки restr_N.test для users.testmode = 1
# >>> 2	- тестовая БД, тестовое хранилище, отладочные папки restr_N.test для users.testmode = 1
# >>> 3	- тестовая БД, тестовое хранилище, рабочие папки restr_N для users.testmode = 1

define('__DOGNET_TESTMODE_TYPE', 0);

##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
if (!isset($_IS_CRONTAB)) {

    if ((__DOGNET_TESTMODE_ON == TRUE || __DOGNET_TESTMODE_ON == 1) && $_SESSION['userInDognetTestmode'] >= 1) {
        #
        if (__DOGNET_TESTMODE_TYPE == 0) {
            #
            define('__DOGNET_DBCONN_HOST', '192.168.1.89');
            define('__DOGNET_DBCONN_USER', 'root');
            define('__DOGNET_DBCONN_PASS', 'Atgs_1992');
            define('__DOGNET_DBCONN_NAME', 'yachu_devs_db');
            define('__DOGNET_DBCONN_PORT', '3306');
            #
        } elseif (__DOGNET_TESTMODE_TYPE == 1) {
            #
            define('__DOGNET_DBCONN_HOST', '192.168.1.89');
            define('__DOGNET_DBCONN_USER', 'root');
            define('__DOGNET_DBCONN_PASS', 'Atgs_1992');
            define('__DOGNET_DBCONN_NAME', 'yachu_devs_db');
            define('__DOGNET_DBCONN_PORT', '3306');
            #
        } elseif (__DOGNET_TESTMODE_TYPE == 2) {
            #
            define('__DOGNET_DBCONN_HOST', '192.168.1.89');
            define('__DOGNET_DBCONN_USER', 'root');
            define('__DOGNET_DBCONN_PASS', 'Atgs_1992');
            define('__DOGNET_DBCONN_NAME', 'yachu_devs_db_test');
            define('__DOGNET_DBCONN_PORT', '3306');
            #
        }
        #
        define('__DOGNET_HEADER', '/___header.test.php');
        define('__DOGNET_FOOTER', '/___footer.test.php');
        define('__DOGNET_HEADER_PROFILE', '/___header_profile.test.php');
        define('__DOGNET_FOOTER_PROFILE', '/___footer_profile.test.php');
        #
    } else {
        define('__DOGNET_DBCONN_HOST', '192.168.1.89');
        define('__DOGNET_DBCONN_USER', 'root');
        define('__DOGNET_DBCONN_PASS', 'Atgs_1992');
        define('__DOGNET_DBCONN_NAME', 'yachu_devs_db');
        define('__DOGNET_DBCONN_PORT', '3306');
        #
        define('__DOGNET_HEADER', '/___header.php');
        define('__DOGNET_FOOTER', '/___footer.php');
        define('__DOGNET_HEADER_PROFILE', '/___header_profile.php');
        define('__DOGNET_FOOTER_PROFILE', '/___footer_profile.php');
        #
    }
} else {
    if ((__DOGNET_TESTMODE_ON == TRUE || __DOGNET_TESTMODE_ON == 1)) {
        #
        if (__DOGNET_TESTMODE_TYPE == 0) {
            #
            define('__DOGNET_DBCONN_HOST', '192.168.1.89');
            define('__DOGNET_DBCONN_USER', 'root');
            define('__DOGNET_DBCONN_PASS', 'Atgs_1992');
            define('__DOGNET_DBCONN_NAME', 'yachu_devs_db');
            define('__DOGNET_DBCONN_PORT', '3306');
            #
        } elseif (__DOGNET_TESTMODE_TYPE == 1) {
            #
            define('__DOGNET_DBCONN_HOST', '192.168.1.89');
            define('__DOGNET_DBCONN_USER', 'root');
            define('__DOGNET_DBCONN_PASS', 'Atgs_1992');
            define('__DOGNET_DBCONN_NAME', 'yachu_devs_db');
            define('__DOGNET_DBCONN_PORT', '3306');
            #
        } elseif (__DOGNET_TESTMODE_TYPE == 2) {
            #
            define('__DOGNET_DBCONN_HOST', '192.168.1.89');
            define('__DOGNET_DBCONN_USER', 'root');
            define('__DOGNET_DBCONN_PASS', 'Atgs_1992');
            define('__DOGNET_DBCONN_NAME', 'yachu_devs_db_test');
            define('__DOGNET_DBCONN_PORT', '3306');
            #
        }
    } else {
        define('__DOGNET_DBCONN_HOST', '192.168.1.89');
        define('__DOGNET_DBCONN_USER', 'root');
        define('__DOGNET_DBCONN_PASS', 'Atgs_1992');
        define('__DOGNET_DBCONN_NAME', 'yachu_devs_db');
        define('__DOGNET_DBCONN_PORT', '3306');
        #
    }
}
#
##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
# Абсолютный путь к сервису
define('__DOGNET_ABSPATH', '/var/www/html/atgs-portal.local/www/dognet');
#
# Главная страница
define('__DOGNET_WORKPATH', '/php/examples/simple');
define('__DOGNET_MAIN_WORKPATH', '/php/examples/simple/main');
#
#
# 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
# ##### КЛАССЫ
# ##### ##### ##### ##### ##### ##### ##### ##### ##### #####


#
##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 