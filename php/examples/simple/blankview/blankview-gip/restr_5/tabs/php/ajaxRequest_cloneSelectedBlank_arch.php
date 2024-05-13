<?php
#
date_default_timezone_set('Europe/Moscow');
#
# Подключаем конфигурационный файл
# require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
# require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require($_SERVER['DOCUMENT_ROOT']."/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса Почта
require($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// $_UNIQUEID = $_SESSION['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// You can access the values posted by jQuery.ajax
// through the global variable $_POST, like this:
// print_r ($_POST);
$kodblankwork = $_POST['kodblankwork'];
$kodstatusblank = $_POST['kodstatusblank'];
$kodtipblank = $_POST['kodtipblank'];
$userid = $_SESSION['id'];
$ip = $_SERVER['REMOTE_ADDR'];
$login = $_SESSION['login'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	$_QRY_ISP = mysqli_fetch_assoc(mysqlQuery( "SELECT kodispol FROM dognet_users_kods WHERE id=".$_SESSION['id'] ));
	$kodispol = $_QRY_ISP['kodispol'];
//
	$_QRY_DEPT = mysqli_fetch_assoc(mysqlQuery( "SELECT dept_num FROM users WHERE id=".$_SESSION['id'] ));
	$deptnum = $_QRY_DEPT['dept_num'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Функция определения нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
#
function nextKodblankwork() {
	$query1 = mysqlQuery("SELECT MAX(kodblankwork) as lastKod_doc FROM dognet_docblankwork ORDER BY id DESC");
	$query2 = mysqlQuery("SELECT MAX(kodblankwork) as lastKod_pos FROM dognet_blankdocpost ORDER BY id DESC");
	$query3 = mysqlQuery("SELECT MAX(kodblankwork) as lastKod_pnr FROM dognet_blankdocpnr ORDER BY id DESC");
	$query4 = mysqlQuery("SELECT MAX(kodblankwork) as lastKod_sub FROM dognet_blankdocsub ORDER BY id DESC");
	$query5 = mysqlQuery("SELECT MAX(kodblankwork) as lastKod_pir FROM dognet_blankdocpir ORDER BY id DESC");
	$row1 = mysqli_fetch_assoc($query1);
	$row2 = mysqli_fetch_assoc($query2);
	$row3 = mysqli_fetch_assoc($query3);
	$row4 = mysqli_fetch_assoc($query4);
	$row5 = mysqli_fetch_assoc($query5);
	$lastKod_doc = $row1['lastKod_doc'];
	$lastKod_pos = $row2['lastKod_pos'];
	$lastKod_pnr = $row3['lastKod_pnr'];
	$lastKod_sub = $row4['lastKod_sub'];
	$lastKod_pir = $row5['lastKod_pir'];
	$maxkod = max($lastKod_doc, $lastKod_pos, $lastKod_pnr, $lastKod_sub, $lastKod_pir);
	$nextKod = $maxkod + rand(3, 11);
	return $nextKod;
}
#
# Функция определения нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
#
function nextKodblankpnr() {
	$query = mysqlQuery("SELECT MAX(kodblankpnr) as lastKod FROM dognet_blankdocpnr ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
function nextKodblankpost() {
	$query = mysqlQuery("SELECT MAX(kodblankpost) as lastKod FROM dognet_blankdocpost ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
function nextKodblanksub() {
	$query = mysqlQuery("SELECT MAX(kodblanksub) as lastKod FROM dognet_blankdocsub ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
function nextKodblankpir() {
	$query = mysqlQuery("SELECT MAX(kodblankpir) as lastKod FROM dognet_blankdocpir ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
if (isset($_SESSION ['password']) && isset($_SESSION ['login'])) {
	if ( checkUserAuthorization($_SESSION['login'],$_SESSION['password']) == -1 ) {
		$output = '-1';
	}
	else {
		if (checkUserRestrictions($_SESSION['id'],'dognet', 3, 0)==1) {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

				if ($kodtipblank == "PNR") {
					$_QRY1 = mysqli_fetch_array(mysqlQuery(" SELECT id FROM dognet_blankdocpnr WHERE kodblankwork = '$kodblankwork' AND kodtipblank = 'DO' AND kodblankinprocess = '1' AND kodblankdone = '1' "));
					$_id1 = $_QRY1['id'];
					if ($_QRY1) {
						$output = "Тип бланка: ".$kodtipblank."/Статус бланка: ".$kodstatusblank."/ID бланка: ".$_id1;

						$__nextKodblankwork = nextKodblankwork();
						$__nextKodblankpnr = nextKodblankpnr();
						$__kodtipblank = 'CR';
						$__kodispol = $kodispol;
						$__kodblankcreate = '0';
						$__kodblankinprocess = '0';
						$__kodblankdone = '0';
						$__userid_blankcreator = $userid;
						$__userdept_blankcreator = $deptnum;

						$_QRY1_INSERT = mysqlQuery(" 
						INSERT INTO `dognet_blankdocpnr` (`ID`, `koddel`, `kodblankwork`, `kodblankpnr`, `kodtipblank`, `kodispolruk`, `kodispol`, `kodorgzakaz`, `kodorgispol`, `kodusespzakaz`, `kodzakaz`, `koduseneworg`, `nameneworg`, `namedocblank`, `csummadocopl`, `kodusendsopl`, `kodusespechopl`, `koduseopl1usl`, `koduseopl2usl`, `koduseopl3usl`, `koduseopl4usl`, `csummaopl1usl`, `csummaopl2usl`, `cnumberoplday2usl`, `cnumberoplday3usl`, `ctextoplotherusl`, `kodusepril1`, `kodusepril2`, `kodusepril3`, `kodusepril4`, `kodusepril5`, `defuslgiptext`, `kodusetender`, `koduseispoldoc1`, `koduseispoldoc2`, `koduseispoldoc3`, `koduseispoldoc4`, `cdateispoldoc1`, `cdaysispoldoc2`, `kodusekomrasx1`, `kodusekomrasx2`, `kodusekomrasx3`, `kodusekomrasx4`, `summalimitmis`, `komrasxprim`, `kodusetrans1`, `kodusetrans2`, `kodusetrans3`, `transprim`, `transplaceobor`, `numberdocmain`, `climitdays`, `koduserisk1`, `koduserisk2`, `koduserisk3`, `koduserisk4`, `koduserisk5`, `riskprim`, `kodblankcreate`, `nameendcontact`, `namefistcontact`, `namesecondcontact`, `numbertelrab`, `numbertelmob`, `numbertelfax`, `nameemail`, `namedoljcontact`, `dopcontact1`, `dopcontact2`, `kodpaperstr`, `kodobject`, `kodblankinprocess`, `kodblankdone`, `userid_blankcreator`, `userdept_blankcreator`) 
						SELECT NULL, `koddel`, '$__nextKodblankwork', '$__nextKodblankpnr', '$__kodtipblank', `kodispolruk`, '$__kodispol', `kodorgzakaz`, `kodorgispol`, `kodusespzakaz`, `kodzakaz`, `koduseneworg`, `nameneworg`, `namedocblank`, `csummadocopl`, `kodusendsopl`, `kodusespechopl`, `koduseopl1usl`, `koduseopl2usl`, `koduseopl3usl`, `koduseopl4usl`, `csummaopl1usl`, `csummaopl2usl`, `cnumberoplday2usl`, `cnumberoplday3usl`, `ctextoplotherusl`, `kodusepril1`, `kodusepril2`, `kodusepril3`, `kodusepril4`, `kodusepril5`, `defuslgiptext`, `kodusetender`, `koduseispoldoc1`, `koduseispoldoc2`, `koduseispoldoc3`, `koduseispoldoc4`, `cdateispoldoc1`, `cdaysispoldoc2`, `kodusekomrasx1`, `kodusekomrasx2`, `kodusekomrasx3`, `kodusekomrasx4`, `summalimitmis`, `komrasxprim`, `kodusetrans1`, `kodusetrans2`, `kodusetrans3`, `transprim`, `transplaceobor`, `numberdocmain`, `climitdays`, `koduserisk1`, `koduserisk2`, `koduserisk3`, `koduserisk4`, `koduserisk5`, `riskprim`, '$__kodblankcreate', `nameendcontact`, `namefistcontact`, `namesecondcontact`, `numbertelrab`, `numbertelmob`, `numbertelfax`, `nameemail`, `namedoljcontact`, `dopcontact1`, `dopcontact2`, `kodpaperstr`, `kodobject`, '$__kodblankinprocess', '$__kodblankdone', '$__userid_blankcreator', '$__userdept_blankcreator'
						FROM `dognet_blankdocpnr`
						WHERE id = '$_id1'
						");	
						$output = $_QRY1_INSERT ? "1" : "0";
					}
					else {
						$output = "0";
					}
				}
				elseif ($kodtipblank == "POS") {
					$_QRY2 = mysqli_fetch_array(mysqlQuery(" SELECT id FROM dognet_blankdocpost WHERE kodblankwork = '$kodblankwork' AND kodtipblank = 'DO' AND kodblankinprocess = '1' AND kodblankdone = '1' "));
					$_id2 = $_QRY2['id'];
					if ($_QRY2) {
						$output = "Тип бланка: ".$kodtipblank."/Статус бланка: ".$kodstatusblank."/ID бланка: ".$_id2;

						$__nextKodblankwork = nextKodblankwork();
						$__nextKodblankpost = nextKodblankpost();
						$__kodtipblank = 'CR';
						$__kodispol = $kodispol;
						$__kodblankcreate = '0';
						$__kodblankinprocess = '0';
						$__kodblankdone = '0';
						$__userid_blankcreator = $userid;
						$__userdept_blankcreator = $deptnum;

						$_QRY2_INSERT = mysqlQuery(" 
						INSERT INTO `dognet_blankdocpost` (`ID`, `koddel`, `kodblankwork`, `kodblankpost`, `kodtipblank`, `kodispolruk`, `kodispol`, `kodorgzakaz`, `kodorgispol`, `kodusespzakaz`, `kodzakaz`, `koduseneworg`, `nameneworg`, `namedocblank`, `csummadocopl`, `kodusendsopl`, `kodusespechopl`, `koduseopl1usl`, `koduseopl2usl`, `koduseopl3usl`, `koduseopl4usl`, `csummaopl1usl`, `csummaopl2usl`, `cnumberoplday2usl`, `cnumberoplday3usl`, `ctextoplotherusl`, `kodusepril1`, `kodusepril2`, `kodusepril3`, `kodusepril4`, `kodusepril5`, `defuslgiptext`, `kodusetender`, `koduseispoldoc1`, `koduseispoldoc2`, `koduseispoldoc3`, `koduseispoldoc4`, `cdateispoldoc1`, `cdaysispoldoc2`, `namecontact1full`, `namecontact1dolj`, `contact1tel`, `contact1email`, `namecontact2full`, `namecontact2dolj`, `contact2tel`, `contact2email`, `kodusekomrasx1`, `kodusekomrasx2`, `kodusekomrasx3`, `komrasxprim`, `kodusetrans1`, `kodusetrans2`, `kodusetrans3`, `transprim`, `transplaceobor`, `numberdocmain`, `climitdays`, `koduserisk1`, `koduserisk2`, `koduserisk3`, `koduserisk4`, `riskprim`, `kodblankcreate`, `nameendcontact`, `namefistcontact`, `namesecondcontact`, `numbertelrab`, `numbertelmob`, `numbertelfax`, `nameemail`, `namedoljcontact`, `kodpaperstr`, `kodblankinprocess`, `kodblankdone`, `userid_blankcreator`, `userdept_blankcreator`) 
						SELECT NULL, `koddel`, '$__nextKodblankwork', '$__nextKodblankpost', '$__kodtipblank', `kodispolruk`, '$__kodispol', `kodorgzakaz`, `kodorgispol`, `kodusespzakaz`, `kodzakaz`, `koduseneworg`, `nameneworg`, `namedocblank`, `csummadocopl`, `kodusendsopl`, `kodusespechopl`, `koduseopl1usl`, `koduseopl2usl`, `koduseopl3usl`, `koduseopl4usl`, `csummaopl1usl`, `csummaopl2usl`, `cnumberoplday2usl`, `cnumberoplday3usl`, `ctextoplotherusl`, `kodusepril1`, `kodusepril2`, `kodusepril3`, `kodusepril4`, `kodusepril5`, `defuslgiptext`, `kodusetender`, `koduseispoldoc1`, `koduseispoldoc2`, `koduseispoldoc3`, `koduseispoldoc4`, `cdateispoldoc1`, `cdaysispoldoc2`, `namecontact1full`, `namecontact1dolj`, `contact1tel`, `contact1email`, `namecontact2full`, `namecontact2dolj`, `contact2tel`, `contact2email`, `kodusekomrasx1`, `kodusekomrasx2`, `kodusekomrasx3`, `komrasxprim`, `kodusetrans1`, `kodusetrans2`, `kodusetrans3`, `transprim`, `transplaceobor`, `numberdocmain`, `climitdays`, `koduserisk1`, `koduserisk2`, `koduserisk3`, `koduserisk4`, `riskprim`, '$__kodblankcreate', `nameendcontact`, `namefistcontact`, `namesecondcontact`, `numbertelrab`, `numbertelmob`, `numbertelfax`, `nameemail`, `namedoljcontact`, `kodpaperstr`, '$__kodblankinprocess', '$__kodblankdone', '$__userid_blankcreator', '$__userdept_blankcreator'
						FROM `dognet_blankdocpost`
						WHERE id = '$_id2'
						");	
						$output = $_QRY2_INSERT ? "1" : "0";
					}
					else {
						$output = "0";
					}
				}
				elseif ($kodtipblank == "SUB") {
					$_QRY3 = mysqli_fetch_array(mysqlQuery(" SELECT id FROM dognet_blankdocsub WHERE kodblankwork = '$kodblankwork' AND kodtipblank = 'DO' AND kodblankinprocess = '1' AND kodblankdone = '1' "));
					$_id3 = $_QRY3['id'];
					if ($_QRY3) {
						$output = "Тип бланка: ".$kodtipblank."/Статус бланка: ".$kodstatusblank."/ID бланка: ".$_id3;

						$__nextKodblankwork = nextKodblankwork();
						$__nextKodblanksub = nextKodblanksub();
						$__kodtipblank = 'CR';
						$__kodispol = $kodispol;
						$__kodblankcreate = '0';
						$__kodblankinprocess = '0';
						$__kodblankdone = '0';
						$__userid_blankcreator = $userid;
						$__userdept_blankcreator = $deptnum;

						$_QRY3_INSERT = mysqlQuery(" 
						INSERT INTO `dognet_blankdocsub` (`ID`, `koddel`, `kodblankwork`, `kodblanksub`, `kodtipblank`, `kodispolruk`, `kodispol`, `kodorgzakaz`, `kodorgispol`, `kodusespzakaz`, `kodzakaz`, `koduseneworg`, `nameneworg`, `namedocblank`, `csummadocopl`, `kodusendsopl`, `kodusespechopl`, `koduseopl1usl`, `koduseopl2usl`, `koduseopl3usl`, `koduseopl4usl`, `csummaopl1usl`, `csummaopl2usl`, `cnumberoplday2usl`, `cnumberoplday3usl`, `ctextoplotherusl`, `kodusepril1`, `kodusepril2`, `kodusepril3`, `kodusepril4`, `kodusepril5`, `defuslgiptext`, `kodusetender`, `koduseispoldoc1`, `koduseispoldoc2`, `koduseispoldoc3`, `koduseispoldoc4`, `cdateispoldoc1`, `cdaysispoldoc2`, `kodusekomrasx1`, `kodusekomrasx2`, `kodusekomrasx3`, `kodusekomrasx4`, `summalimitmis`, `komrasxprim`, `kodusetrans1`, `kodusetrans2`, `kodusetrans3`, `transprim`, `transplaceobor`, `numberdocmain`, `climitdays`, `koduserisk1`, `koduserisk2`, `koduserisk3`, `koduserisk4`, `koduserisk5`, `riskprim`, `kodblankcreate`, `nameendcontact`, `namefistcontact`, `namesecondcontact`, `numbertelrab`, `numbertelmob`, `numbertelfax`, `nameemail`, `namedoljcontact`, `kodpaperstr`, `koddoc`, `kodkalplan`, `numberstagedoc`, `kodusedocnumber`, `kodusedocstage`, `numberdocisp`, `datedocisp`, `kodblankinprocess`, `kodblankdone`, `userid_blankcreator`, `userdept_blankcreator`) 
						SELECT NULL, `koddel`, '$__nextKodblankwork', '$__nextKodblanksub', '$__kodtipblank', `kodispolruk`, '$__kodispol', `kodorgzakaz`, `kodorgispol`, `kodusespzakaz`, `kodzakaz`, `koduseneworg`, `nameneworg`, `namedocblank`, `csummadocopl`, `kodusendsopl`, `kodusespechopl`, `koduseopl1usl`, `koduseopl2usl`, `koduseopl3usl`, `koduseopl4usl`, `csummaopl1usl`, `csummaopl2usl`, `cnumberoplday2usl`, `cnumberoplday3usl`, `ctextoplotherusl`, `kodusepril1`, `kodusepril2`, `kodusepril3`, `kodusepril4`, `kodusepril5`, `defuslgiptext`, `kodusetender`, `koduseispoldoc1`, `koduseispoldoc2`, `koduseispoldoc3`, `koduseispoldoc4`, `cdateispoldoc1`, `cdaysispoldoc2`, `kodusekomrasx1`, `kodusekomrasx2`, `kodusekomrasx3`, `kodusekomrasx4`, `summalimitmis`, `komrasxprim`, `kodusetrans1`, `kodusetrans2`, `kodusetrans3`, `transprim`, `transplaceobor`, `numberdocmain`, `climitdays`, `koduserisk1`, `koduserisk2`, `koduserisk3`, `koduserisk4`, `koduserisk5`, `riskprim`, '$__kodblankcreate', `nameendcontact`, `namefistcontact`, `namesecondcontact`, `numbertelrab`, `numbertelmob`, `numbertelfax`, `nameemail`, `namedoljcontact`, `kodpaperstr`, `koddoc`, `kodkalplan`, `numberstagedoc`, `kodusedocnumber`, `kodusedocstage`, `numberdocisp`, `datedocisp`, '$__kodblankinprocess', '$__kodblankdone', '$__userid_blankcreator', '$__userdept_blankcreator'
						FROM `dognet_blankdocsub`
						WHERE id = '$_id3'
						");	
						$output = $_QRY3_INSERT ? "1" : "0";
					}
					else {
						$output = "0";
					}
				}
				elseif ($kodtipblank == "PIR") {
					$_QRY4 = mysqli_fetch_array(mysqlQuery(" SELECT id FROM dognet_blankdocpir WHERE kodblankwork = '$kodblankwork' AND kodtipblank = 'DO' AND kodblankinprocess = '1' AND kodblankdone = '1' "));
					$_id4 = $_QRY4['id'];
					if ($_QRY4) {
						$output = "Тип бланка: ".$kodtipblank."/Статус бланка: ".$kodstatusblank."/ID бланка: ".$_id4;

						$__nextKodblankwork = nextKodblankwork();
						$__nextKodblankpir = nextKodblankpir();
						$__kodtipblank = 'CR';
						$__kodispol = $kodispol;
						$__kodblankcreate = '0';
						$__kodblankinprocess = '0';
						$__kodblankdone = '0';
						$__userid_blankcreator = $userid;
						$__userdept_blankcreator = $deptnum;

						$_QRY4_INSERT = mysqlQuery(" 
						INSERT INTO `dognet_blankdocpir` (`ID`, `koddel`, `kodblankwork`, `kodblankpir`, `kodtipblank`, `kodispolruk`, `kodispol`, `kodorgzakaz`, `kodorgispol`, `kodusespzakaz`, `kodzakaz`, `koduseneworg`, `nameneworg`, `namedocblank`, `csummadocopl`, `kodusendsopl`, `kodusespechopl`, `koduseopl1usl`, `koduseopl2usl`, `koduseopl3usl`, `koduseopl4usl`, `csummaopl1usl`, `csummaopl2usl`, `cnumberoplday2usl`, `cnumberoplday3usl`, `ctextoplotherusl`, `kodusepril1`, `kodusepril2`, `kodusepril3`, `kodusepril4`, `kodusepril5`, `defuslgiptext`, `kodusetender`, `koduseispoldoc1`, `koduseispoldoc3`, `cdateispoldoc1`, `kodusekomrasx1`, `kodusekomrasx2`, `kodusekomrasx3`, `kodusekomrasx4`, `summalimitmis`, `komrasxprim`, `kodusetrans1`, `kodusetrans2`, `kodusetrans3`, `transprim`, `transplaceobor`, `numberdocmain`, `climitdays`, `koduserisk1`, `koduserisk2`, `koduserisk3`, `koduserisk4`, `koduserisk5`, `koduserisk6`, `riskprim`, `kodblankcreate`, `nameendcontact`, `namefistcontact`, `namesecondcontact`, `numbertelrab`, `numbertelmob`, `numbertelfax`, `nameemail`, `namedoljcontact`, `dopcontact1`, `dopcontact2`, `kodpaperstr`, `kodblankinprocess`, `kodblankdone`, `userid_blankcreator`, `userdept_blankcreator`) 
						SELECT NULL, `koddel`, '$__nextKodblankwork', '$__nextKodblankpir', '$__kodtipblank', `kodispolruk`, '$__kodispol', `kodorgzakaz`, `kodorgispol`, `kodusespzakaz`, `kodzakaz`, `koduseneworg`, `nameneworg`, `namedocblank`, `csummadocopl`, `kodusendsopl`, `kodusespechopl`, `koduseopl1usl`, `koduseopl2usl`, `koduseopl3usl`, `koduseopl4usl`, `csummaopl1usl`, `csummaopl2usl`, `cnumberoplday2usl`, `cnumberoplday3usl`, `ctextoplotherusl`, `kodusepril1`, `kodusepril2`, `kodusepril3`, `kodusepril4`, `kodusepril5`, `defuslgiptext`, `kodusetender`, `koduseispoldoc1`, `koduseispoldoc3`, `cdateispoldoc1`, `kodusekomrasx1`, `kodusekomrasx2`, `kodusekomrasx3`, `kodusekomrasx4`, `summalimitmis`, `komrasxprim`, `kodusetrans1`, `kodusetrans2`, `kodusetrans3`, `transprim`, `transplaceobor`, `numberdocmain`, `climitdays`, `koduserisk1`, `koduserisk2`, `koduserisk3`, `koduserisk4`, `koduserisk5`, `koduserisk6`, `riskprim`, '$__kodblankcreate', `nameendcontact`, `namefistcontact`, `namesecondcontact`, `numbertelrab`, `numbertelmob`, `numbertelfax`, `nameemail`, `namedoljcontact`, `dopcontact1`, `dopcontact2`, `kodpaperstr`, '$__kodblankinprocess', '$__kodblankdone', '$__userid_blankcreator', '$__userdept_blankcreator'
						FROM `dognet_blankdocpir`
						WHERE id = '$_id4'
						");	
						$output = $_QRY4_INSERT ? "1" : "0";
					}
					else {
						$output = "0";
					}
				}
				else { $output = '-4'; }
				
			}
			else { $output = '-2'; }
		}
		else { $output = '-3'; }
	}
echo $output;
}
#
#
#
#
#
#
?>