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
	$query = mysqlQuery("SELECT numberblankwork FROM dognet_docblankwork WHERE kodblankwork=" . $kodblankwork . " AND kodstatusblank='CR'");
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
function nextKodblankpost() {
	$query = mysqlQuery("SELECT MAX(kodblankpost) as lastKod FROM dognet_blankdocpost ORDER BY id DESC");
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
function updateFields_blankdocpost_preEdit($db, $id, $values) {
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function updateFields_blankdocpost($db, $action_blankdocpost, $id, $values) {
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "НОВЫЙ СЧЕТ"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_blankdocpost == 'CRT') {
		#
		#
		$_QRY = $db->sql("SELECT * FROM dognet_blankdocpost WHERE id=" . $id)->fetchAll();
		$_QRY_PARENTID = $db->sql("SELECT userid_blankcreator, userdept_blankcreator FROM dognet_blankdocpost WHERE id=" . $_POST['parentid_tab2'])->fetchAll();
		if ($_QRY[0]['kodblankinprocess'] != '1') {
			// Формируем новый идентификатор бланка (kodblankwork)
			$__nextKodblankpost = nextKodblankpost();
			$__nextKodblankwork = nextKodblankwork();
			$db->update('dognet_blankdocpost', array(
				'kodblankpost' => $__nextKodblankpost,
				'kodblankwork' => $__nextKodblankwork,
				'kodtipblank' => "CR"
			), array('id' => $id));
		}

		if ($_QRY[0]['kodblankinprocess'] == '1') {
			$__nextKodblankpost = nextKodblankpost();
			$__nextKodblankwork = $_POST['kodblankwork_tab2'];
			$db->update('dognet_blankdocpost', array(
				'kodblankpost' => $__nextKodblankpost,
				'kodblankwork' => $__nextKodblankwork,
				'kodtipblank' => "RD",
				'userid_blankcreator' => $_QRY_PARENTID[0]['userid_blankcreator'],
				'userdept_blankcreator' => $_QRY_PARENTID[0]['userdept_blankcreator']
			), array('id' => $id));
			$db->update('dognet_blankdocpost', array(
				'kodblankinprocess' => "1",
				'kodblankdone' => "1"
			), array('id' => $_POST['parentid_tab2']));
		}

		if ($_QRY[0]['kodblankdone'] == '1') {
			$__nextKodblankpost = nextKodblankpost();
			$__nextKodblankwork = $_POST['kodblankwork_tab2'];
			$db->update('dognet_blankdocpost', array(
				'kodblankpost' => $__nextKodblankpost,
				'kodblankwork' => $__nextKodblankwork,
				'kodtipblank' => "DO",
				'kodblankinprocess' => "1",
				'userid_blankcreator' => $_QRY_PARENTID[0]['userid_blankcreator'],
				'userdept_blankcreator' => $_QRY_PARENTID[0]['userdept_blankcreator']
			), array('id' => $id));
			$db->update('dognet_blankdocpost', array(
				'kodblankdone' => "1"
			), array('id' => $_POST['parentid_tab2']));
		}

		$_QRY = $db->sql("SELECT * FROM dognet_blankdocpost WHERE id=" . $id)->fetchAll();

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
				$db->update('dognet_blankdocpost', array(
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
			$_nametipblankwork = "ПОСТАВКА";
			$_kodtipblank = "POS";
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
				'kodzakaz' => $_kodzakaz,
				'kodsubpodr' => "",
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
			$_nextNumberblank = getNumberblank($_POST['kodblankwork_tab2']);
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
			$_nametipblankwork = "ПОСТАВКА";
			$_kodtipblank = "POS";
			// Исполнители
			$_kodispol = $_QRY[0]['kodispol'];
			$_kodispolruk = $_QRY[0]['kodispolruk'];
			//
			$_QRY_DateOrder = $db->sql("SELECT dateblankorder FROM dognet_docblankwork WHERE kodblankwork=" . $__nextKodblankwork . " AND kodstatusblank='CR'")->fetchAll();
			$_dateblankorder = $_QRY_DateOrder[0]['dateblankorder'];
			// ID строки бланка
			$_blankrowid = $id;
			//
			$db->update('dognet_docblankwork', array(
				'kodblankdone' => 1
			), array('kodblankwork' => $__nextKodblankwork, 'kodstatusblank' => 'CR'));
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
	if ($action_blankdocpost == 'UPD') {
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
	if ($action_blankdocpost == 'DEL') {
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
Editor::inst($db, 'dognet_blankdocpost')
	->fields(
		Field::inst('dognet_blankdocpost.kodblankwork'),
		Field::inst('dognet_blankdocpost.kodblankpost'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.kodispol')
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
		Field::inst('dognet_blankdocpost.kodispolruk')
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
		Field::inst('dognet_blankdocpost.kodtipblank'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.kodorgzakaz'),
		Field::inst('dognet_blankdocpost.kodorgispol'),
		Field::inst('dognet_blankdocpost.kodusespzakaz'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.koduseneworg'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.nameneworg'),
		Field::inst('dognet_blankdocpost.namedocblank')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Введите предварительное название договора')
			)),
		Field::inst('dognet_blankdocpost.csummadocopl'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.kodusendsopl'),
		Field::inst('dognet_blankdocpost.kodusespechopl'),
		Field::inst('dognet_blankdocpost.koduseopl1usl'),
		Field::inst('dognet_blankdocpost.koduseopl2usl'),
		Field::inst('dognet_blankdocpost.koduseopl3usl'),
		Field::inst('dognet_blankdocpost.koduseopl4usl'),
		Field::inst('dognet_blankdocpost.csummaopl1usl'),
		Field::inst('dognet_blankdocpost.csummaopl2usl'),
		Field::inst('dognet_blankdocpost.cnumberoplday2usl'),
		Field::inst('dognet_blankdocpost.cnumberoplday3usl'),
		Field::inst('dognet_blankdocpost.ctextoplotherusl'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.kodusepril1'),
		Field::inst('dognet_blankdocpost.kodusepril2'),
		Field::inst('dognet_blankdocpost.kodusepril3'),
		Field::inst('dognet_blankdocpost.kodusepril4'),
		Field::inst('dognet_blankdocpost.kodusepril5'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.defuslgiptext'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.koduseispoldoc1'),
		Field::inst('dognet_blankdocpost.koduseispoldoc2'),
		Field::inst('dognet_blankdocpost.koduseispoldoc3'),
		Field::inst('dognet_blankdocpost.koduseispoldoc4'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.cdateispoldoc1'),
		Field::inst('dognet_blankdocpost.cdaysispoldoc2'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.namecontact1full'),
		Field::inst('dognet_blankdocpost.namecontact1dolj'),
		Field::inst('dognet_blankdocpost.contact1tel'),
		Field::inst('dognet_blankdocpost.contact1email'),
		Field::inst('dognet_blankdocpost.namecontact2full'),
		Field::inst('dognet_blankdocpost.namecontact2dolj'),
		Field::inst('dognet_blankdocpost.contact2tel'),
		Field::inst('dognet_blankdocpost.contact2email'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.kodusekomrasx1'),
		Field::inst('dognet_blankdocpost.kodusekomrasx2'),
		Field::inst('dognet_blankdocpost.kodusekomrasx3'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.komrasxprim'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.kodusetrans1'),
		Field::inst('dognet_blankdocpost.kodusetrans2'),
		Field::inst('dognet_blankdocpost.kodusetrans3'),
		Field::inst('dognet_blankdocpost.transprim'),
		Field::inst('dognet_blankdocpost.transplaceobor'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.numberdocmain'),
		Field::inst('dognet_blankdocpost.climitdays'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.koduserisk1'),
		Field::inst('dognet_blankdocpost.koduserisk2'),
		Field::inst('dognet_blankdocpost.koduserisk3'),
		Field::inst('dognet_blankdocpost.koduserisk4'),
		Field::inst('dognet_blankdocpost.riskprim'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.kodblankcreate'),
		Field::inst('dognet_blankdocpost.nameendcontact'),
		Field::inst('dognet_blankdocpost.namefistcontact'),
		Field::inst('dognet_blankdocpost.namesecondcontact'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.numbertelrab'),
		Field::inst('dognet_blankdocpost.numbertelmob'),
		Field::inst('dognet_blankdocpost.numbertelfax'),
		Field::inst('dognet_blankdocpost.nameemail'),
		Field::inst('dognet_blankdocpost.namedoljcontact'),
		Field::inst('dognet_blankdocpost.kodpaperstr'),
		Field::inst('dognet_blankdocpost.kodblankinprocess'),
		Field::inst('dognet_blankdocpost.kodblankdone'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_blankdocpost.kodzakaz')
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
			$q->where('dognet_blankdocpost.koddel', '99', '!=');
			$q->and_where('dognet_blankdocpost.kodtipblank', 'DO', '!=');
			$q->and_where('dognet_blankdocpost.kodblankcreate', '1', '=');
			$q->and_where('dognet_blankdocpost.kodblankdone', '1', '!=');
		});
	})
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('postCreate', function ($editor, $id, $values, $row) {
		updateFields_blankdocpost($editor->db(), 'CRT', $id, $values);
	})
	->on('postEdit', function ($editor, $id, $values, $row) {
		updateFields_blankdocpost($editor->db(), 'UPD', $id, $values);
	})
	/*
	->on( 'preRemove', function ( $editor, $id, $values ) {
		updateFields_blankdocpost_preRemove ( $editor->db(), 'DEL', $id, $values );
	} )
*/
	->on('postRemove', function ($editor, $id, $values) {
		updateFields_blankdocpost($editor->db(), 'DEL', $id, $values);
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	#
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin('dognet_docblankwork', 'dognet_docblankwork.kodblankwork', '=', 'dognet_blankdocpost.kodblankwork')
	->leftJoin('dognet_sysdefs_blankstatus', 'dognet_sysdefs_blankstatus.status_kod', '=', 'dognet_blankdocpost.kodtipblank')
	->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_blankdocpost.kodispol')
	->leftJoin('dognet_spispolruk', 'dognet_spispolruk.kodispolruk', '=', 'dognet_blankdocpost.kodispolruk')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_blankdocpost.kodzakaz')
	// 	->where( 'dognet_blankdocpost.kodispol', $KODISPOL )
	// 	->where( 'dognet_docblankwork.kodstatusblank', 'dognet_blankdocpost.kodtipblank' )
	->where('dognet_docblankwork.yearblankwork', date('Y'))
	->process($_POST)
	->json();
