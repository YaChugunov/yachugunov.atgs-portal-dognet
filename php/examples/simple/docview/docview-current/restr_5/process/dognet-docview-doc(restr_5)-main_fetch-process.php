<?php
#
date_default_timezone_set('Europe/Moscow');
#
# Подключаем конфигурационный файл
# require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
# require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require($_SERVER['DOCUMENT_ROOT'] . "/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса Почта
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$_UNIQUEID = $_SESSION['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// You can access the values posted by jQuery.ajax
// through the global variable $_POST, like this:
$kodblankwork = isset($_POST['kodblankwork']) ? $_POST['kodblankwork'] : null;
// print_r ($_POST);

if (empty($kodblankwork)) {
	echo 'blank no selected';
} else {
	$_QRY = mysqlQuery("SELECT kodzakaz, kodispol, kodispolruk, nameblankwork, kodtipblank, blank_rowID FROM dognet_docblankwork WHERE kodblankwork = {$kodblankwork}");
	if (mysqli_num_rows($_QRY) < 1) {
		echo 'no items';
	} else {
		$_ROW = mysqli_fetch_assoc($_QRY);
		$blankrowid = $_ROW['blank_rowID'];
		$qry_zakaz = mysqlQuery("SELECT nameshort FROM sp_contragents WHERE kodcontragent=" . $_ROW['kodzakaz'] . " AND koddel<>'99'");
		$row_zakaz = mysqli_fetch_assoc($qry_zakaz);

		if ($blankrowid != "") {
			switch ($_ROW['kodtipblank']) {
				case "PNR":
					$qry_contacts = mysqlQuery("SELECT nameendcontact, namefistcontact, namesecondcontact, numbertelrab, numbertelmob, numbertelfax, nameemail, namedoljcontact FROM dognet_blankdocpnr WHERE id = {$blankrowid}");
					$row_contacts = mysqli_fetch_assoc($qry_contacts);
					break;
				case "POS":
					$qry_contacts = mysqlQuery("SELECT nameendcontact, namefistcontact, namesecondcontact, numbertelrab, numbertelmob, numbertelfax, nameemail, namedoljcontact FROM dognet_blankdocpost WHERE id = {$blankrowid}");
					$row_contacts = mysqli_fetch_assoc($qry_contacts);
					break;
				case "SUB":
					$qry_contacts = mysqlQuery("SELECT nameendcontact, namefistcontact, namesecondcontact, numbertelrab, numbertelmob, numbertelfax, nameemail, namedoljcontact FROM dognet_blankdocsub WHERE id = {$blankrowid}");
					$row_contacts = mysqli_fetch_assoc($qry_contacts);
					break;
				default:
					$_lastname = "";
					$_firstname = "";
					$_midname = "";
					$_telrab = "";
					$_telmob = "";
					$_telfax = "";
					$_email = "";
					$_dolj = "";
					break;
			}
		}
		if ($qry_contacts) {
			$_lastname = $row_contacts['nameendcontact'];
			$_firstname = $row_contacts['namefistcontact'];
			$_midname = $row_contacts['namesecondcontact'];
			$_telrab = $row_contacts['numbertelrab'];
			$_telmob = $row_contacts['numbertelmob'];
			$_telfax = $row_contacts['numbertelfax'];
			$_email = $row_contacts['nameemail'];
			$_dolj = $row_contacts['namedoljcontact'];
		} else {
			$_lastname = "";
			$_firstname = "";
			$_midname = "";
			$_telrab = "";
			$_telmob = "";
			$_telfax = "";
			$_email = "";
			$_dolj = "";
		}

		echo $_ROW['kodzakaz'] . ":" . $_ROW['kodispol'] . ":" . $_ROW['kodispolruk'] . ":" . $_ROW['nameblankwork'] . ":" . $_lastname . ":" . $_firstname . ":" . $_midname . ":" . $_telrab . ":" . $_telmob . ":" . $_telfax . ":" . $_email . ":" . $_dolj;
	}
}
#
#
#
#
#
#