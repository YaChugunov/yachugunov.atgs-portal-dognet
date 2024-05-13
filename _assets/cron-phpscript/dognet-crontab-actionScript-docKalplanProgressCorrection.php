<?php
# http://192.168.1.89/dognet/_assets/cron-phpscript/dognet-crontab-actionScript-docKalplanProgressCorrection.php
#
$_IS_CRONTAB        = TRUE;
#
$path_parts = pathinfo($_SERVER['SCRIPT_FILENAME']); // определяем директорию скрипта
chdir($path_parts['dirname']); // задаем директорию выполнение скрипта
#
date_default_timezone_set('Europe/Moscow');
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем конфигурационный файл
require_once("/var/www/html/atgs-portal.local/www/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
require_once("/var/www/html/atgs-portal.local/www/dognet/config.dognet.inc.php");
#
# Подключаемся к базе
require_once("/var/www/html/atgs-portal.local/www/dognet/_assets/dbconn/db_connection.php");
require_once("/var/www/html/atgs-portal.local/www/dognet/_assets/dbconn/db_controller.php");
$db_handle = new DBController();
#
# Подключаем общие функции безопасности
require("/var/www/html/atgs-portal.local/www/dognet/_assets/functions/func.secure.inc.php");
# Подключаем собственные функции сервиса Почта
require("/var/www/html/atgs-portal.local/www/dognet/_assets/functions/func.dognet.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
/** 
 * !!! Отправка письма о переносе срока по договору поставки
 * 
 * ? > Рассылка тестового сообщения на email разработчика
 * ? > Last edition 21.11.2023
 */
#

$sql = "SELECT * FROM dognet_dockalplan tb1 WHERE kodkalplan NOT IN (SELECT kodkalplan FROM dognet_dockalplan_progress tb2 WHERE tb2.koddoc=tb1.koddoc) AND koddel<>'99'";
$i = 1;
$result = FALSE;
$_QRY_LOOP = mysqlQuery($sql);
while ($_ROW_LOOP = mysqli_fetch_assoc($_QRY_LOOP)) {

    # Суммируем все счета-фактуры по этапу ($_QRY2[0]['koddoc'])
    $_QRY_SUMCHF = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(chetfsumma) as sum1 FROM dognet_kalplanchf WHERE kodkalplan='" . $_QRY[0]['kodkalplan'] . "' AND koddel<>'99'"));
    # -----
    $expiry_date = NULL;
    if ($_ROW_LOOP['idsrokstage'] == 1) {
        $srokstage = $_ROW_LOOP['srokstage_date'];
        $expiry_date = $_ROW_LOOP['srokstage_date'];
    } elseif ($_ROW_LOOP['idsrokstage'] == 0 && $_ROW_LOOP['srokstage'] != "") {
        $srokstage = $_ROW_LOOP['srokstage'];
        $_QRY_AV = mysqli_fetch_assoc(mysqlQuery("SELECT MIN(dateavans) as firstavans FROM dognet_docavans WHERE koddoc='" . $_ROW_LOOP['kodkalplan'] . "' LIMIT 1"));
        if ($_QRY_AV['firstavans'] != "") {
            $dateavans = new DateTime($_QRY_AV['firstavans']);
            $firstavans = $dateavans->format('Y-m-d');
            if (is_string($srokstage)) {
                $srokdays = (int)$srokstage;
            }
            $expiry_date = $dateavans->add(new DateInterval('P' . $srokdays . 'D'))->format('Y-m-d');
        } else {
            $expiry_date = NULL;
        }
    }

    $koddoc             = $_ROW_LOOP['koddoc'];
    $kodkalplan         = $_ROW_LOOP['kodkalplan'];
    $stagecreated       = date("Y-m-d");
    $idsrokstage        = $_ROW_LOOP['idsrokstage'];
    $srokstage_date     = $expiry_date;
    $idsrokopl          = $_ROW_LOOP['idsrokopl'];
    $srokopl            = $_ROW_LOOP['srokopl'];
    $dateplan           = $_ROW_LOOP['dateplan'];
    $numberdayoplstage  = $_ROW_LOOP['numberdayoplstage'];
    $dateoplall         = $_ROW_LOOP['dateoplall'];
    $summastage         = $_ROW_LOOP['summastage'];
    $sumchfstage        = '';
    $sumavstage         = '';
    $sumoplchfstage     = '';
    $sumoplavstage      = '';
    $zadolsum_stage     = $_ROW_LOOP['summastage'] - $_QRY_SUMCHF[0]['sum1'];
    $zadolsum_chf       = '';
    $zadolsum_av        = '';


    $sqlInsert = "INSERT INTO dognet_dockalplan_progress (koddoc, kodkalplan, stagecreated, idsrokstage, srokstage, srokstage_date, idsrokopl, srokopl, dateplan, numberdayoplstage, dateoplall, summastage, sumchfstage, sumavstage, sumoplchfstage, sumoplavstage, zadolsum_stage, zadolsum_chf, zadolsum_av) VALUES ('$koddoc','$kodkalplan','$stagecreated','$idsrokstage','$srokstage','$srokstage_date','$idsrokopl','$srokopl','$dateplan','$numberdayoplstage','$dateoplall','$summastage','$sumchfstage','$sumavstage','$sumoplchfstage','$sumoplavstage','$zadolsum_stage','$zadolsum_chf','$zadolsum_av')";

    $_QRY_INS = mysqli_fetch_assoc(mysqlQuery($sqlInsert));
    $result = $_QRY_INS ? '<span style="color:green"> Ok</span>' : '<span style="color:red"> False</span>';
    echo $i . ". " . $sqlInsert;
    echo "<br><br>";
    $i++;
}

unset($_IS_CRONTAB);