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
	$query = mysqlQuery("SELECT numberblankwork FROM dognet_docblankwork WHERE kodblankwork=" . $kodblankwork . " AND (kodstatusblank='CR' OR kodstatusblank='RD' OR kodstatusblank='DO')");
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
	$row1 = mysqli_fetch_assoc($query1);
	$row2 = mysqli_fetch_assoc($query2);
	$row3 = mysqli_fetch_assoc($query3);
	$row4 = mysqli_fetch_assoc($query4);
	$lastKod_doc = $row1['lastKod_doc'];
	$lastKod_pos = $row2['lastKod_pos'];
	$lastKod_pnr = $row3['lastKod_pnr'];
	$lastKod_sub = $row4['lastKod_sub'];
	$maxkod = max($lastKod_doc, $lastKod_pos, $lastKod_pnr, $lastKod_sub);
	$nextKod = $maxkod + rand(3, 11);
	return $nextKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- -----
function nextkodblanksub() {
	$query = mysqlQuery("SELECT MAX(kodblanksub) as lastKod FROM dognet_blankdocsub ORDER BY id DESC");
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
function updateFields_blankdocsub_preRemove($db, $id, $values) {

	// Выбираем данные по ID записи (id) из таблицы бланков
	$_QRY_1 = $db->sql("SELECT * FROM dognet_blankdocsub WHERE id=" . $id)->fetchAll();
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
function updateFields_blankdocsub_preEdit($db, $id, $values) {
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function updateFields_blankdocsub($db, $action_blankdocsub, $id, $values) {
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "НОВЫЙ СЧЕТ"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_blankdocsub == 'CRT') {
		#
		#
		$_QRY = $db->sql("SELECT * FROM dognet_blankdocsub WHERE id=" . $id)->fetchAll();
		$_QRY_PARENTID = $db->sql("SELECT userid_blankcreator, userdept_blankcreator FROM dognet_blankdocpnr WHERE id=" . $_POST['parentid_tab4'])->fetchAll();
		if ($_QRY[0]['kodblankinprocess'] != '1') {
			// Формируем новый идентификатор бланка (kodblankwork)
			$__nextkodblanksub = nextkodblanksub();
			$__nextKodblankwork = nextKodblankwork();
			$db->update('dognet_blankdocsub', array(
				'kodblanksub' => $__nextkodblanksub,
				'kodblankwork' => $__nextKodblankwork,
				'kodtipblank' => "CR"
			), array('id' => $id));
		}

		if ($_QRY[0]['kodblankinprocess'] == '1') {
			$__nextkodblanksub = nextkodblanksub();
			$__nextKodblankwork = $_POST['kodblankwork_tab4'];
			$db->update('dognet_blankdocsub', array(
				'kodblanksub' => $__nextkodblanksub,
				'kodblankwork' => $__nextKodblankwork,
				'kodtipblank' => "RD",
				'userid_blankcreator' => $_QRY_PARENTID[0]['userid_blankcreator'],
				'userdept_blankcreator' => $_QRY_PARENTID[0]['userdept_blankcreator']
			), array('id' => $id));
			$db->update('dognet_blankdocsub', array(
				'kodblankinprocess' => "1",
				'kodblankdone' => "1"
			), array('id' => $_POST['parentid_tab4']));
		}

		if ($_QRY[0]['kodblankdone'] == '1') {
			$__nextkodblanksub = nextkodblanksub();
			$__nextKodblankwork = $_POST['kodblankwork_tab4'];
			$db->update('dognet_blankdocsub', array(
				'kodblanksub' => $__nextkodblanksub,
				'kodblankwork' => $__nextKodblankwork,
				'kodtipblank' => "DO",
				'kodblankinprocess' => "1",
				'userid_blankcreator' => $_QRY_PARENTID[0]['userid_blankcreator'],
				'userdept_blankcreator' => $_QRY_PARENTID[0]['userdept_blankcreator']
			), array('id' => $id));
			$db->update('dognet_blankdocsub', array(
				'kodblankdone' => "1"
			), array('id' => $_POST['parentid_tab4']));
		}

		$_QRY = $db->sql("SELECT * FROM dognet_blankdocsub WHERE id=" . $id)->fetchAll();

		// Заказчик
		$_kodsubpodr = $_QRY[0]['kodzakaz'];
		// Навзание организации
		if ($_QRY[0]['koduseneworg'] == '0') {
			if (!empty($_kodsubpodr)) {
				$_QRY_ZAKAZ = $db->sql("SELECT nameshort FROM sp_contragents WHERE kodcontragent='" . $_kodsubpodr . "'")->fetchAll();
				$_nameorgblankwork = $_QRY_ZAKAZ[0]['namesubpodrshot'];
			} else {
				$_nameorgblankwork = "";
			}
		} else {
			// Добавляем новую организацию
			$_nameorgblankwork = $_QRY[0]['nameneworg'];
			$_kodsubpodr = createNewSubpodr($_nameorgblankwork, "(создан из бланка)");
			if ($_kodsubpodr != "") {
				$db->update('dognet_blankdocsub', array(
					'kodzakaz'			=>	$_kodsubpodr,
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
			$_nametipblankwork = "СУБПОДРЯД";
			$_kodtipblank = "SUB";
			// Исполнители
			$_kodispol = $_QRY[0]['kodispol'];
			$_kodispolruk = $_QRY[0]['kodispolruk'];
			// ID строки бланка
			$_blankrowid = $id;
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
				'kodzakaz' => "",
				'kodsubpodr' => $_kodsubpodr,
				'koddoc' => "",
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
			$_Numberblank = getNumberblank($_POST['kodblankwork_tab4']);
			// Предмет договора
			$_nameblankwork = $_QRY[0]['namedocblank'];
			// Заказчик
			$_kodsubpodr = $_QRY[0]['kodzakaz'];
			// Назdание организации
			if ($_QRY[0]['koduseneworg'] == '0') {
				$_QRY_ZAKAZ = $db->sql("SELECT namefull, nameshort FROM sp_contragents WHERE kodcontragent='" . $_kodsubpodr . "'")->fetchAll();
				$_nameorgblankwork = $_QRY_ZAKAZ[0]['namesubpodrshot'];
			} else {
				$_nameorgblankwork = $_QRY[0]['nameneworg'];
			}
			// Статус бланка
			$_status = "RD";
			$_QRY_STATUS = $db->sql("SELECT * FROM dognet_sysdefs_blankstatus WHERE status_kod='" . $_status . "'")->fetchAll();
			$_statusblankwork = $_QRY_STATUS[0]['status_name'];
			// Тип бланка
			$_nametipblankwork = "СУБПОДРЯД";
			$_kodtipblank = "SUB";
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
			$db->insert('dognet_docblankwork', array(
				'kodblankwork' => $__nextKodblankwork,
				'numberblankwork' => $_Numberblank,
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
				'kodzakaz' => "",
				'kodsubpodr' => $_kodsubpodr,
				'koddoc' => "",
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
	if ($action_blankdocsub == 'UPD') {
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
	if ($action_blankdocsub == 'DEL') {
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
Editor::inst($db, 'dognet_blankdocsub')
	->fields(
		Field::inst('dognet_blankdocsub.kodblankwork'),
		Field::inst('dognet_blankdocsub.kodblanksub'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.kodispol')
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
		Field::inst('dognet_blankdocsub.kodispolruk')
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
		Field::inst('dognet_blankdocsub.kodtipblank'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.kodorgzakaz'),
		Field::inst('dognet_blankdocsub.kodorgispol'),
		Field::inst('dognet_blankdocsub.kodusespzakaz'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.koduseneworg'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.nameneworg'),
		Field::inst('dognet_blankdocsub.namedocblank')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Введите предварительное название договора')
			)),
		Field::inst('dognet_blankdocsub.csummadocopl'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.kodusendsopl'),
		Field::inst('dognet_blankdocsub.kodusespechopl'),
		Field::inst('dognet_blankdocsub.koduseopl1usl'),
		Field::inst('dognet_blankdocsub.koduseopl2usl'),
		Field::inst('dognet_blankdocsub.koduseopl3usl'),
		Field::inst('dognet_blankdocsub.koduseopl4usl'),
		Field::inst('dognet_blankdocsub.csummaopl1usl'),
		Field::inst('dognet_blankdocsub.csummaopl2usl'),
		Field::inst('dognet_blankdocsub.cnumberoplday2usl'),
		Field::inst('dognet_blankdocsub.cnumberoplday3usl'),
		Field::inst('dognet_blankdocsub.ctextoplotherusl'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.kodusepril1'),
		Field::inst('dognet_blankdocsub.kodusepril2'),
		Field::inst('dognet_blankdocsub.kodusepril3'),
		Field::inst('dognet_blankdocsub.kodusepril4'),
		Field::inst('dognet_blankdocsub.kodusepril5'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.defuslgiptext'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.koduseispoldoc1'),
		Field::inst('dognet_blankdocsub.koduseispoldoc2'),
		Field::inst('dognet_blankdocsub.koduseispoldoc3'),
		Field::inst('dognet_blankdocsub.koduseispoldoc4'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.cdateispoldoc1'),
		Field::inst('dognet_blankdocsub.cdaysispoldoc2'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.kodusekomrasx1'),
		Field::inst('dognet_blankdocsub.kodusekomrasx2'),
		Field::inst('dognet_blankdocsub.kodusekomrasx3'),
		Field::inst('dognet_blankdocsub.kodusekomrasx4'),
		Field::inst('dognet_blankdocsub.summalimitmis'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.komrasxprim'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.kodusetrans1'),
		Field::inst('dognet_blankdocsub.kodusetrans2'),
		Field::inst('dognet_blankdocsub.kodusetrans3'),
		Field::inst('dognet_blankdocsub.transprim'),
		Field::inst('dognet_blankdocsub.transplaceobor'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.numberdocmain'),
		Field::inst('dognet_blankdocsub.climitdays'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.koduserisk1'),
		Field::inst('dognet_blankdocsub.koduserisk2'),
		Field::inst('dognet_blankdocsub.koduserisk3'),
		Field::inst('dognet_blankdocsub.koduserisk4'),
		Field::inst('dognet_blankdocsub.koduserisk5'),
		Field::inst('dognet_blankdocsub.riskprim'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.kodblankcreate'),
		Field::inst('dognet_blankdocsub.nameendcontact'),
		Field::inst('dognet_blankdocsub.namefistcontact'),
		Field::inst('dognet_blankdocsub.namesecondcontact'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.numbertelrab'),
		Field::inst('dognet_blankdocsub.numbertelmob'),
		Field::inst('dognet_blankdocsub.numbertelfax'),
		Field::inst('dognet_blankdocsub.nameemail'),
		Field::inst('dognet_blankdocsub.namedoljcontact'),
		Field::inst('dognet_blankdocsub.kodpaperstr'),
		Field::inst('dognet_blankdocsub.kodblankinprocess'),
		Field::inst('dognet_blankdocsub.kodblankdone'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocsub.kodzakaz')
			->options(
				Options::inst()
					->table('sp_contragents')
					->value('kodcontragent')
					->label(array('kodcontragent', 'nameshort', 'namefull'))
					->render(function ($row) {
						return $row['nameshort'];
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
			$q->where('dognet_blankdocsub.koddel', '99', '!=');
			$q->and_where('dognet_blankdocsub.kodtipblank', 'DO', '!=');
			$q->and_where('dognet_blankdocsub.kodblankcreate', '1', '=');
			$q->and_where('dognet_blankdocsub.kodblankdone', '1', '!=');
		});
	})
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('postCreate', function ($editor, $id, $values, $row) {
		updateFields_blankdocsub($editor->db(), 'CRT', $id, $values);
	})
	->on('postEdit', function ($editor, $id, $values, $row) {
		updateFields_blankdocsub($editor->db(), 'UPD', $id, $values);
	})
	->on('postRemove', function ($editor, $id, $values) {
		updateFields_blankdocsub($editor->db(), 'DEL', $id, $values);
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	#
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin('dognet_docblankwork', 'dognet_docblankwork.kodblankwork', '=', 'dognet_blankdocsub.kodblankwork')
	->leftJoin('dognet_sysdefs_blankstatus', 'dognet_sysdefs_blankstatus.status_kod', '=', 'dognet_blankdocsub.kodtipblank')
	->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_blankdocsub.kodispol')
	->leftJoin('dognet_spispolruk', 'dognet_spispolruk.kodispolruk', '=', 'dognet_blankdocsub.kodispolruk')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_blankdocsub.kodzakaz')
	// 	->where( 'dognet_blankdocsub.kodispol', $KODISPOL )
	// 	->where( 'dognet_docblankwork.kodstatusblank', 'dognet_blankdocsub.kodtipblank' )
	->where('dognet_docblankwork.yearblankwork', date('Y'))
	->process($_POST)
	->json();
