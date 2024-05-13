<?php
# Import PHPMailer classes into the global namespace
# These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
#
# Подключаем библиотеки
require "/var/www/html/atgs-portal.local/www/dognet/_assets/_PHPMailer/src/Exception.php";
require "/var/www/html/atgs-portal.local/www/dognet/_assets/_PHPMailer/src/PHPMailer.php";
require "/var/www/html/atgs-portal.local/www/dognet/_assets/_PHPMailer/src/SMTP.php";
#
# 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
# ##### КОНСТАНТЫ
# ##### ##### ##### ##### ##### ##### ##### ##### ##### #####

if (!isset($_IS_CRONTAB)) {
}
#
# 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
# ##### КЛАССЫ
# ##### ##### ##### ##### ##### ##### ##### ##### ##### #####





# 
# 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
# ##### ФУНКЦИИ
# ##### ##### ##### ##### ##### ##### ##### ##### ##### #####