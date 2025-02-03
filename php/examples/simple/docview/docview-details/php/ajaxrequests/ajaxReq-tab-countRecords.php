<?php
date_default_timezone_set('Europe/Moscow');
#
# Подключаем конфигурационный файл
# require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once $_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_connection.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_controller.php";
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
# require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require $_SERVER['DOCUMENT_ROOT'] . "/_assets/functions/funcSecure.inc.php";
# Подключаем собственные функции сервиса Почта
require $_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/functions/funcDognet.inc.php";
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

// ID договора (koddoc) в таблице dpgnet_docbase
$uid = !empty($_POST['uid']) ? $_POST['uid'] : '';
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$error = $output = "";
$arr = $arrDoc = $data = array();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
if (isset($_SESSION['password']) && isset($_SESSION['login'])) {
    if (checkUserAuthorization($_SESSION['login'], $_SESSION['password']) == -1) {
        $output = -2;
    } else {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if (!empty($uid)) {
                $_reqDoc = mysqli_fetch_array(mysqlQuery("SELECT * FROM dognet_docbase WHERE koddoc='{$uid}' AND koddel!='99'"));
                //*
                //* Номер договора
                $docnumber = !empty($_reqDoc['docnumber']) ? $_reqDoc['docnumber'] : '';
                //*
                //* Считаем количество этапов
                $_reqCntStages = mysqli_fetch_array(mysqlQuery("SELECT COUNT(kodkalplan) as cntStages FROM dognet_dockalplan WHERE koddoc='{$uid}' AND koddel!='99'"));
                $cntStages = !empty($_reqCntStages) ? $_reqCntStages['cntStages'] : 0;
                //*
                //* Считаем количество счетов-фактур
                $_reqCntChf = mysqli_fetch_array(mysqlQuery("SELECT COUNT(kodchfact) as cntChf FROM dognet_kalplanchf WHERE kodkalplan IN (SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc='{$uid}' AND koddel!='99') AND koddel!='99'"));
                $cntChf = !empty($_reqCntChf) ? $_reqCntChf['cntChf'] : 0;
                //*
                //* Считаем количество авансов
                $_reqCntAv = mysqli_fetch_array(mysqlQuery("SELECT COUNT(kodavans) as cntAv FROM dognet_docavans WHERE koddoc IN (SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc='{$uid}' AND koddel!='99') AND koddel!='99'"));
                $cntAv = !empty($_reqCntAv) ? $_reqCntAv['cntAv'] : 0;
                //*
                //* Считаем количество субподрядных договоров
                $_reqCntSubs = mysqli_fetch_array(mysqlQuery("SELECT COUNT(koddocsubpodr) as cntSubs FROM dognet_docsubpodr WHERE (koddoc IN (SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc='{$uid}' AND koddel!='99') OR koddoc IN (SELECT koddoc FROM dognet_docbase WHERE koddoc='{$uid}' AND koddel!='99')) AND koddel!='99'"));
                $cntSubs = !empty($_reqCntSubs) ? $_reqCntSubs['cntSubs'] : 0;
                //*
                //* Считаем количество заявок
                $_reqCntZayv = mysqli_fetch_array(mysqlQuery("SELECT COUNT(kodzayv) as cntZayv FROM dognet_doczayv WHERE koddoc='{$uid}' AND koddel!='99'"));
                $cntZayv = !empty($_reqCntZayv) ? $_reqCntZayv['cntZayv'] : 0;
                //*
                //* Считаем количество прикрепленных документов к договору
                $_reqCntFiles = mysqli_fetch_array(mysqlQuery("SELECT COUNT(koddocpaper) as cntFiles FROM dognet_docpaper WHERE koddoc='{$uid}' AND koddel!='99' AND docFileID!=''"));
                $cntFiles = !empty($_reqCntFiles) ? $_reqCntFiles['cntFiles'] : 0;
                //
                $arrCounts = [
                    "cntStages" => "{$cntStages}",
                    "cntSubs" => "{$cntSubs}",
                    "cntChf" => "{$cntChf}",
                    "cntAv" => "{$cntAv}",
                    "cntZayv" => "{$cntZayv}",
                    "cntFiles" => "{$cntFiles}",
                ];
                $data['counts'][] = $arrCounts;
// ----- ----- ----- ----- -----
                $output = sizeof($data) > 0 ? json_encode($data) : 0;
            } else {
                $output = 0;
            }
        } else {
            $output = -1;
        }
    }
}
unset($_POST);
// Вывод сообщений о результате загрузки.
echo $output;