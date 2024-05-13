<?php
date_default_timezone_set('Europe/Moscow');
# Подключаем конфигурационный файл
// require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
// require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require($_SERVER['DOCUMENT_ROOT'] . "/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса Почта
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
/*
	$_QRY = mysqlQuery( "SELECT * FROM dognet_users_kods WHERE id=".$_SESSION['id'] );
	$_ROW = mysqli_fetch_assoc($_QRY);
	$KODISPOL = $_ROW['kodispol'];
*/
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- -----
function getNumberblank($kodblankwork) {
	$query = mysqlQuery("SELECT numberblankwork FROM dognet_docblankwork WHERE kodblankwork=" . $kodblankwork . " AND (kodstatusblank='CR' OR kodstatusblank='RD')");
	$row = mysqli_fetch_assoc($query);
	if ($query) {
		$numberblankwork = $row['numberblankwork'];
		return $numberblankwork;
	} else {
		return null;
	}
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- -----
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
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- -----
function nextKodblankpir() {
	$query = mysqlQuery("SELECT MAX(kodblankpir) as lastKod FROM dognet_blankdocpir ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- -----
function nextNubmerblank($year) {
	$query = mysqlQuery("SELECT MAX(numberblankwork) as lastnumber FROM dognet_docblankwork WHERE yearblankwork=" . $year . " ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastNumber = $row['lastnumber'];
	$nextNumber = $lastNumber + 1;
	return $nextNumber;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function updateFields_blankdocpir_preRemove($db, $id, $values) {

	// Выбираем данные по ID записи (id) из таблицы бланков
	$_QRY_1 = $db->sql("SELECT * FROM dognet_blankdocpir WHERE id=" . $id)->fetchAll();
	if ($_QRY_1) {
		$__kodblankwork = $_QRY_1[0]['kodblankwork'];
		$_QRY_DEL1 = $db->sql("DELETE FROM dognet_blankpril WHERE kodblankwork=" . $__kodblankwork);
		$_QRY_DEL1 = $db->sql("DELETE FROM dognet_blankpril_files WHERE kodblankwork=" . $__kodblankwork);
		$_QRY_DEL2 = $db->sql("DELETE FROM dognet_docblankwork WHERE kodblankwork=" . $__kodblankwork);
		$_QRY_DEL3 = $db->sql("DELETE FROM dognet_docblankwork_files WHERE kodblankwork=" . $__kodblankwork);
	}
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function updateFields_blankdocpir_preEdit($db, $id, $values) {
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function updateFields_blankdocpir($db, $action_blankdocpir, $id, $values) {
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "НОВЫЙ СЧЕТ"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_blankdocpir == 'CRT') {
		#
		#
		$_QRY = $db->sql("SELECT * FROM dognet_blankdocpir WHERE id=" . $id)->fetchAll();
		$_QRY_PARENTID = $db->sql("SELECT userid_blankcreator, userdept_blankcreator FROM dognet_blankdocpir WHERE id=" . $_POST['parentid_tab5'])->fetchAll();
		if ($_QRY[0]['kodblankinprocess'] != '1') {
			// Формируем новый идентификатор бланка (kodblankwork)
			$__nextKodblankpir = nextKodblankpir();
			$__nextKodblankwork = nextKodblankwork();
			$db->update('dognet_blankdocpir', array(
				'kodblankpir' => $__nextKodblankpir,
				'kodblankwork' => $__nextKodblankwork,
				'kodtipblank' => "CR"
			), array('id' => $id));
		}

		if ($_QRY[0]['kodblankinprocess'] == '1') {
			$__nextKodblankpir = nextKodblankpir();
			$__nextKodblankwork = $_POST['kodblankwork_tab5'];
			$db->update('dognet_blankdocpir', array(
				'kodblankpir' => $__nextKodblankpir,
				'kodblankwork' => $__nextKodblankwork,
				'kodtipblank' => "RD",
				'userid_blankcreator' => $_QRY_PARENTID[0]['userid_blankcreator'],
				'userdept_blankcreator' => $_QRY_PARENTID[0]['userdept_blankcreator']
			), array('id' => $id));
			$db->update('dognet_blankdocpir', array(
				'kodblankinprocess' => "1",
				'kodblankdone' => "1"
			), array('id' => $_POST['parentid_tab5']));
		}

		if ($_QRY[0]['kodblankdone'] == '1') {
			$__nextKodblankpir = nextKodblankpir();
			$__nextKodblankwork = $_POST['kodblankwork_tab5'];
			$db->update('dognet_blankdocpir', array(
				'kodblankpir' => $__nextKodblankpir,
				'kodblankwork' => $__nextKodblankwork,
				'kodtipblank' => "DO",
				'kodblankinprocess' => "1",
				'userid_blankcreator' => $_QRY_PARENTID[0]['userid_blankcreator'],
				'userdept_blankcreator' => $_QRY_PARENTID[0]['userdept_blankcreator']
			), array('id' => $id));
			$db->update('dognet_blankdocpir', array(
				'kodblankdone' => "1"
			), array('id' => $_POST['parentid_tab5']));
		}

		$_QRY = $db->sql("SELECT * FROM dognet_blankdocpir WHERE id=" . $id)->fetchAll();

		// Заказчик
		$_kodzakaz = $_QRY[0]['kodzakaz'];
		// Навзание организации
		if ($_QRY[0]['koduseneworg'] == '0') {
			if (!empty($_kodzakaz)) {
				$_QRY_ZAKAZ = $db->sql("SELECT nameshort FROM sp_contragents WHERE kodcontragent='" . $_kodzakaz . "'")->fetchAll();
				$_nameorgblankwork = $_QRY_ZAKAZ[0]['nameshort'];
			} else {
				$_nameorgblankwork = "";
			}
		} else {
			// Добавляем новую организацию
			$_nameorgblankwork = $_QRY[0]['nameneworg'];
			$_kodzakaz = createNewZakaz($_nameorgblankwork, "(создан из бланка)");
			if ($_kodzakaz != "") {
				$db->update('dognet_blankdocpir', array(
					'kodzakaz'			=>	$_kodzakaz,
					'koduseneworg'		=>	0,
					'kodusespzakaz'		=>	1
				), array('id' => $id));
			}
		}

		// Проверяем, передан ли сформированный бланк на оформление
		if (($_QRY[0]['kodblankcreate'] == '1') && ($_QRY[0]['kodblankinprocess'] != '1') && ($_QRY[0]['kodblankdone'] != '1')) {
			# Если бланк передан на оформление, то делаем запись в таблице dognet_docblankwork
			# Созданной записи о бланке присваиваем статус бланка 'CR'
			// Год создания бланка
			$_year = date('Y');
			// Номер бланка
			$_nextNumberblank = nextNubmerblank($_year);
			// Предмет договора
			$_nameblankwork = $_QRY[0]['namedocblank'];
			// Статус бланка
			$_status = "CR";
			$_QRY_STATUS = $db->sql("SELECT * FROM dognet_sysdefs_blankstatus WHERE status_kod='" . $_status . "'")->fetchAll();
			$_statusblankwork = $_QRY_STATUS[0]['status_name'];
			// Тип бланка
			$_nametipblankwork = "ПИР";
			$_kodtipblank = "PIR";
			// Исполнители
			$_kodispol = $_QRY[0]['kodispol'];
			$_kodispolruk = $_QRY[0]['kodispolruk'];
			// ID строки бланка
			$_blankrowid = $id;
			// 
			// 
			// Добавлено 18.08.2021
			// --- --- --- --- ---
			// Добавлен новый идентификатор "Договор на основе выигранного тендера" - kodusetender
			$_kodusetender = $_QRY[0]['kodusetender'];
			// --- --- --- --- ---
			//
			// 
			//
			$db->insert('dognet_docblankwork', array(
				'kodblankwork' => $__nextKodblankwork,
				'numberblankwork' => $_nextNumberblank,
				'yearblankwork' => $_year,
				'dateblankwork' => NULL,
				'dateblankorder' => date('Y-m-d'),
				'dateblankdoc' => NULL,
				'nameblankwork' => $_nameblankwork,
				'nameorgblankwork' => $_nameorgblankwork,
				'statusblankwork' => $_statusblankwork,
				'kodstatusblank' => $_status,
				'nametipblankwork' => $_nametipblankwork,
				'kodtipblank' => $_kodtipblank,
				'numberdoccr' => "",
				'kodispol' => $_kodispol,
				'kodispolruk' => $_kodispolruk,
				'kodzakaz' => $_kodzakaz,
				'kodsubpodr' => "",
				'koddoc' => "",
				'kodusetender' => $_kodusetender,
				'numberdocmain' => "",
				'numberstagedoc' => "",
				'kodblankdone' => 0,
				'blank_rowID' => $_blankrowid,
				'userid_blankcreator' => $_QRY[0]['userid_blankcreator'],
				'userdept_blankcreator' => $_QRY[0]['userdept_blankcreator']
			));
		}
		if ($_QRY[0]['kodblankdone'] == '1') {
			# Если бланк передан на оформление, то делаем запись в таблице dognet_docblankwork
			# Созданной записи о бланке присваиваем статус бланка 'CR'
			// Год создания бланка
			$_year = date('Y');
			// Номер бланка
			$_nextNumberblank = getNumberblank($_POST['kodblankwork_tab5']);
			// Предмет договора
			$_nameblankwork = $_QRY[0]['namedocblank'];
			// Заказчик
			$_kodzakaz = $_QRY[0]['kodzakaz'];
			// Назdание организации
			if ($_QRY[0]['koduseneworg'] == '0') {
				$_QRY_ZAKAZ = $db->sql("SELECT namefull, nameshort FROM sp_contragents WHERE kodcontragent='" . $_kodzakaz . "'")->fetchAll();
				$_nameorgblankwork = $_QRY_ZAKAZ[0]['nameshort'];
			} else {
				$_nameorgblankwork = $_QRY[0]['nameneworg'];
			}
			// Статус бланка
			$_status = "RD";
			$_QRY_STATUS = $db->sql("SELECT * FROM dognet_sysdefs_blankstatus WHERE status_kod='" . $_status . "'")->fetchAll();
			$_statusblankwork = $_QRY_STATUS[0]['status_name'];
			// Тип бланка
			$_nametipblankwork = "ПИР";
			$_kodtipblank = "PIR";
			// Исполнители
			$_kodispol = $_QRY[0]['kodispol'];
			$_kodispolruk = $_QRY[0]['kodispolruk'];
			//
			$_QRY_DateOrder = $db->sql("SELECT dateblankorder FROM dognet_docblankwork WHERE kodblankwork=" . $__nextKodblankwork . " AND kodstatusblank='CR'")->fetchAll();
			if ($_QRY_DateOrder) {
				$_dateblankorder = $_QRY_DateOrder[0]['dateblankorder'];
			} else {
				$_dateblankorder = date('Y-m-d');
			}
			// ID строки бланка
			$_blankrowid = $id;
			//
			$db->update('dognet_docblankwork', array(
				'kodblankdone' => 1
			), array('kodblankwork' => $__nextKodblankwork, 'kodstatusblank' => 'CR'));
			// 
			// 
			// Добавлено 18.08.2021
			// --- --- --- --- ---
			// Добавлен новый идентификатор "Договор на основе выигранного тендера" - kodusetender
			$_kodusetender = $_QRY[0]['kodusetender'];
			// --- --- --- --- ---
			//
			// 
			//
			$db->insert('dognet_docblankwork', array(
				'kodblankwork' => $__nextKodblankwork,
				'numberblankwork' => $_nextNumberblank,
				'yearblankwork' => $_year,
				'dateblankwork' => date('Y-m-d'),
				'dateblankorder' => $_dateblankorder,
				'dateblankdoc' => NULL,
				'nameblankwork' => $_nameblankwork,
				'nameorgblankwork' => $_nameorgblankwork,
				'statusblankwork' => $_statusblankwork,
				'kodstatusblank' => $_status,
				'nametipblankwork' => $_nametipblankwork,
				'kodtipblank' => $_kodtipblank,
				'numberdoccr' => "",
				'kodispol' => $_kodispol,
				'kodispolruk' => $_kodispolruk,
				'kodzakaz' => $_kodzakaz,
				'kodsubpodr' => "",
				'koddoc' => "",
				'kodusetender' => $_kodusetender,
				'numberdocmain' => "",
				'numberstagedoc' => "",
				'kodblankdone' => 1,
				'blank_rowID' => $_blankrowid,
				'userid_blankcreator' => $_QRY[0]['userid_blankcreator'],
				'userdept_blankcreator' => $_QRY[0]['userdept_blankcreator']
			));
		}
		#
		#
	}
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "ИЗМЕНИТЬ"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_blankdocpir == 'UPD') {
		#
		#


		#
		#
	}
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "УДАЛИТЬ"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_blankdocpir == 'DEL') {
		#
		#

		#
		#
	}
	#
	#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
/*
 * Example PHP implementation used for the index.html example
*/
// DataTables PHP library
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/_datatables-php-api-editor/DataTables.php");
// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;
// Build our Editor instance and process the data coming from _POST
Editor::inst($db, 'dognet_blankdocpir')
	->fields(
		Field::inst('dognet_blankdocpir.kodblankwork'),
		Field::inst('dognet_blankdocpir.kodblankpir'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.kodispol')
			->options(
				Options::inst()
					->table('dognet_spispol')
					->value('kodispol')
					->label(array('kodispol', 'ispolnameshot', 'kodusegip'))
					->where(function ($q) {
						$q->where('kodusegip', '1', '=');
					})
					->render(function ($row) {
						return $row['ispolnameshot'];
					})
			)
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('ГИП обязателен')
			)),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.kodispolruk')
			->options(
				Options::inst()
					->table('dognet_spispolruk')
					->value('kodispolruk')
					->label(array('kodispolruk', 'ispolrukname'))
					->render(function ($row) {
						return $row['ispolrukname'];
					})
			)
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('ГИП обязателен')
			)),
		Field::inst('dognet_blankdocpir.kodtipblank'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.kodorgzakaz'),
		Field::inst('dognet_blankdocpir.kodorgispol'),
		Field::inst('dognet_blankdocpir.kodusespzakaz'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.koduseneworg'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.nameneworg'),
		Field::inst('dognet_blankdocpir.namedocblank')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Введите предварительное название договора')
			)),
		Field::inst('dognet_blankdocpir.csummadocopl'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.kodusendsopl'),
		Field::inst('dognet_blankdocpir.kodusespechopl'),
		Field::inst('dognet_blankdocpir.koduseopl1usl'),
		Field::inst('dognet_blankdocpir.koduseopl2usl'),
		Field::inst('dognet_blankdocpir.koduseopl3usl'),
		Field::inst('dognet_blankdocpir.koduseopl4usl'),
		Field::inst('dognet_blankdocpir.csummaopl1usl'),
		Field::inst('dognet_blankdocpir.csummaopl2usl'),
		Field::inst('dognet_blankdocpir.cnumberoplday2usl'),
		Field::inst('dognet_blankdocpir.cnumberoplday3usl'),
		Field::inst('dognet_blankdocpir.ctextoplotherusl'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.kodusepril1'),
		Field::inst('dognet_blankdocpir.kodusepril2'),
		Field::inst('dognet_blankdocpir.kodusepril3'),
		Field::inst('dognet_blankdocpir.kodusepril4'),
		Field::inst('dognet_blankdocpir.kodusepril5'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.defuslgiptext'),
		Field::inst('dognet_blankdocpir.kodusetender'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.koduseispoldoc1'),
		Field::inst('dognet_blankdocpir.koduseispoldoc3'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.cdateispoldoc1'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.kodusekomrasx1'),
		Field::inst('dognet_blankdocpir.kodusekomrasx2'),
		Field::inst('dognet_blankdocpir.kodusekomrasx3'),
		Field::inst('dognet_blankdocpir.kodusekomrasx4'),
		Field::inst('dognet_blankdocpir.summalimitmis'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.komrasxprim'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.kodusetrans1'),
		Field::inst('dognet_blankdocpir.kodusetrans2'),
		Field::inst('dognet_blankdocpir.kodusetrans3'),
		Field::inst('dognet_blankdocpir.transprim'),
		Field::inst('dognet_blankdocpir.transplaceobor'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.numberdocmain'),
		Field::inst('dognet_blankdocpir.climitdays'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.koduserisk1'),
		Field::inst('dognet_blankdocpir.koduserisk2'),
		Field::inst('dognet_blankdocpir.koduserisk3'),
		Field::inst('dognet_blankdocpir.koduserisk4'),
		Field::inst('dognet_blankdocpir.koduserisk5'),
		Field::inst('dognet_blankdocpir.koduserisk6'),
		Field::inst('dognet_blankdocpir.riskprim'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.kodblankcreate'),
		Field::inst('dognet_blankdocpir.nameendcontact'),
		Field::inst('dognet_blankdocpir.namefistcontact'),
		Field::inst('dognet_blankdocpir.namesecondcontact'),
		Field::inst('dognet_blankdocpir.dopcontact1'),
		Field::inst('dognet_blankdocpir.dopcontact2'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.numbertelrab'),
		Field::inst('dognet_blankdocpir.numbertelmob'),
		Field::inst('dognet_blankdocpir.numbertelfax'),
		Field::inst('dognet_blankdocpir.nameemail'),
		Field::inst('dognet_blankdocpir.namedoljcontact'),
		Field::inst('dognet_blankdocpir.kodpaperstr'),
		Field::inst('dognet_blankdocpir.kodblankinprocess'),
		Field::inst('dognet_blankdocpir.kodblankdone'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpir.kodzakaz')
			->options(
				Options::inst()
					->table('sp_contragents')
					->value('kodcontragent')
					->label(array('kodcontragent', 'nameshort', 'namefull'))
					->order('nameshort asc')
					->render(function ($row) {
						return $row['nameshort'];
					})
					->where(function ($q) {
						$q->where('koddel', '99', '<>');
						$q->where('useindog', '1');
						$q->where('nameshort', '', '<>');
					})
			),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docblankwork.kodblankwork'),
		Field::inst('dognet_docblankwork.numberblankwork'),
		Field::inst('dognet_docblankwork.yearblankwork'),
		Field::inst('dognet_docblankwork.dateblankwork')
			->validator(Validate::dateFormat(
				'd.m.Y',
				ValidateOptions::inst()
					->allowEmpty(false)
			))
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
		Field::inst('dognet_docblankwork.dateblankorder')
			->validator(Validate::dateFormat(
				'd.m.Y',
				ValidateOptions::inst()
					->allowEmpty(false)
			))
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
		Field::inst('dognet_docblankwork.dateblankdoc')
			->validator(Validate::dateFormat(
				'd.m.Y',
				ValidateOptions::inst()
					->allowEmpty(false)
			))
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docblankwork.nametipblankwork'),
		Field::inst('dognet_docblankwork.nameblankwork'),
		Field::inst('dognet_docblankwork.nameorgblankwork'),
		Field::inst('dognet_docblankwork.kodstatusblank'),
		Field::inst('dognet_docblankwork.statusblankwork'),
		Field::inst('dognet_docblankwork.numberdoccr'),
		Field::inst('dognet_docblankwork.koddoc'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docblankwork.kodispol'),
		Field::inst('dognet_docblankwork.kodispolruk'),
		Field::inst('dognet_docblankwork.kodtipblank'),
		Field::inst('dognet_docblankwork.kodblankdone'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_sysdefs_blankstatus.id'),
		Field::inst('dognet_sysdefs_blankstatus.status_description'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('sp_contragents.kodcontragent'),
		Field::inst('sp_contragents.nameshort'),
		Field::inst('sp_contragents.namefull'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spispol.kodispol'),
		Field::inst('dognet_spispol.ispolnameshot'),
		Field::inst('dognet_spispol.ispolnamefull'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spispolruk.kodispolruk'),
		Field::inst('dognet_spispolruk.ispolrukname'),
		Field::inst('dognet_spispolruk.ispolruknamefull')
	)
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	#
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('preGet', function ($editor, $id) {
		$editor->where(function ($q) {
			$q->where('dognet_blankdocpir.koddel', '99', '!=');
			$q->and_where('dognet_blankdocpir.kodtipblank', 'DO', '!=');
			$q->and_where('dognet_blankdocpir.kodblankcreate', '1', '=');
			$q->and_where('dognet_blankdocpir.kodblankdone', '1', '!=');
		});
	})
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('postCreate', function ($editor, $id, $values, $row) {
		updateFields_blankdocpir($editor->db(), 'CRT', $id, $values);
	})
	->on('postEdit', function ($editor, $id, $values, $row) {
		updateFields_blankdocpir($editor->db(), 'UPD', $id, $values);
	})
	->on('postRemove', function ($editor, $id, $values) {
		updateFields_blankdocpir($editor->db(), 'DEL', $id, $values);
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	#
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin('dognet_docblankwork', 'dognet_docblankwork.kodblankwork', '=', 'dognet_blankdocpir.kodblankwork')
	->leftJoin('dognet_sysdefs_blankstatus', 'dognet_sysdefs_blankstatus.status_kod', '=', 'dognet_blankdocpir.kodtipblank')
	->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_blankdocpir.kodispol')
	->leftJoin('dognet_spispolruk', 'dognet_spispolruk.kodispolruk', '=', 'dognet_blankdocpir.kodispolruk')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_blankdocpir.kodzakaz')
	// 	->where( 'dognet_blankdocpir.kodispol', $KODISPOL )
	// 	->where( 'dognet_docblankwork.kodstatusblank', 'dognet_blankdocpir.kodtipblank' )
	->where('dognet_docblankwork.yearblankwork', date('Y') - 1, ">=")
	->process($_POST)
	->json();
