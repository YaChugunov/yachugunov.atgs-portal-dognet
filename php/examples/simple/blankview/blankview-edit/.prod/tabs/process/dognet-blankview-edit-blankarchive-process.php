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
$_QRY = mysqlQuery("SELECT * FROM dognet_users_kods WHERE id=" . $_SESSION['id']);
$_ROW = mysqli_fetch_assoc($_QRY);
$KODISPOL = $_ROW['kodispol'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function updateFields_docblankwork($db, $action_docblankwork, $id, $values) {
	# :::
	# ::: Если была нажата кнопка "ИЗМЕНИТЬ"
	# :::
	if ($action_docblankwork == 'UPD') {
		// Если договор приявязан, то определяем номер договора и меняем статус бланка
		$_QRY = $db->sql("SELECT kodzakaz, koddoc, dateblankdoc FROM dognet_docblankwork WHERE id=" . $id)->fetchAll();
		if ($_QRY[0]['koddoc'] != '') {
			$_QRY_DocNumber = $db->sql("SELECT docnumber FROM dognet_docbase WHERE koddoc=" . $_QRY[0]['koddoc'])->fetchAll();
			// Номер договора
			$_numberdoccr = $_QRY_DocNumber[0]['docnumber'];
			// Определяем статус бланка
			$_kodstatusblank = 'DO';
			$_QRY_StatusBlank = $db->sql("SELECT status_name FROM dognet_sysdefs_blankstatus WHERE status_kod='" . $_kodstatusblank . "'")->fetchAll();
			$_statusblankwork = $_QRY_StatusBlank[0]['status_name'];
			// Дата привязки к договору
			$_dateblankdoc = $_QRY[0]['dateblankdoc'];
			if ($_QRY[0]['dateblankdoc'] == '' or $_QRY[0]['dateblankdoc'] == NULL) {
				$_dateblankdoc = date('Y-m-d');
			}
			// Обновляем заказчика
			$_kodzakaz = $_QRY[0]['kodzakaz'];
			$_QRY_ZakazName = $db->sql("SELECT nameshort, namefull FROM sp_contragents WHERE kodcontragent='" . $_kodzakaz . "'")->fetchAll();
			$_zakazName = $_QRY_ZakazName[0]['nameshort'];
			$db->update('dognet_docblankwork', array(
				'numberdoccr' => $_numberdoccr,
				'nameorgblankwork' => $_zakazName,
				'kodstatusblank' => $_kodstatusblank,
				'statusblankwork' => $_statusblankwork,
				'dateblankdoc' => $_dateblankdoc
			), array('id' => $id));
		} else {
			$_kodstatusblank = 'RD';
			$_QRY_StatusBlank = $db->sql("SELECT status_name FROM dognet_sysdefs_blankstatus WHERE status_kod='" . $_kodstatusblank . "'")->fetchAll();
			$_statusblankwork = $_QRY_StatusBlank[0]['status_name'];
			// Обновляем заказчика
			$_kodzakaz = $_QRY[0]['kodzakaz'];
			$_QRY_ZakazName = $db->sql("SELECT nameshort, namefull FROM sp_contragents WHERE kodcontragent='" . $_kodzakaz . "'")->fetchAll();
			$_zakazName = $_QRY_ZakazName[0]['nameshort'];
			$db->update('dognet_docblankwork', array(
				'numberdoccr' => "",
				'nameorgblankwork' => $_zakazName,
				'kodstatusblank' => $_kodstatusblank,
				'statusblankwork' => $_statusblankwork,
				'dateblankdoc' => NULL
			), array('id' => $id));
		}
	}
	#
	#
}
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
Editor::inst($db, 'dognet_docblankwork')
	->fields(
		Field::inst('dognet_docblankwork.kodblankwork'),
		Field::inst('dognet_docblankwork.numberblankwork'),
		Field::inst('dognet_docblankwork.yearblankwork'),
		Field::inst('dognet_docblankwork.dateblankwork')
			->validator(Validate::dateFormat(
				'd.m.Y',
				ValidateOptions::inst()
					->allowEmpty(true)
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
					->allowEmpty(true)
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
					->allowEmpty(true)
			))
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
		Field::inst('dognet_docblankwork.nametipblankwork'),
		Field::inst('dognet_docblankwork.nameblankwork'),
		Field::inst('dognet_docblankwork.nameorgblankwork'),
		Field::inst('dognet_docblankwork.kodstatusblank'),
		Field::inst('dognet_docblankwork.statusblankwork'),
		Field::inst('dognet_docblankwork.koddoc')
			->options(
				Options::inst()
					->table('dognet_docbase')
					->value('koddoc')
					->label(array('koddoc', 'docnumber', 'docnameshot'))
					->where(function ($q) {
						$q->where('yearnachdoc', date('Y'), '=');
						$q->and_where('numberchet', '', '=');
					})
					->render(function ($row) {
						return "№ " . $row['docnumber'] . " : " . $row['docnameshot'];
					})
			),
		Field::inst('dognet_docblankwork.numberdoccr'),
		Field::inst('dognet_docblankwork.kodzakaz')
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
			)
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Объект обязателен')
			)),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docblankwork.kodispol'),
		Field::inst('dognet_docblankwork.kodispolruk'),
		Field::inst('dognet_docblankwork.kodtipblank'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_sysdefs_blankstatus.id'),
		Field::inst('dognet_sysdefs_blankstatus.status_description'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_sysdefs_blanktype.id'),
		Field::inst('dognet_sysdefs_blanktype.type_description'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('sp_contragents.kodcontragent'),
		Field::inst('sp_contragents.nameshort'),
		Field::inst('sp_contragents.namefull'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('sp_objects.kodobject'),
		Field::inst('sp_objects.nameobjectshot'),
		Field::inst('sp_objects.nameobjectlong'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spispol.kodispol'),
		Field::inst('dognet_spispol.ispolnameshot'),
		Field::inst('dognet_spispol.ispolnamefull'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spispolruk.kodispolruk'),
		Field::inst('dognet_spispolruk.ispolrukname'),
		Field::inst('dognet_spispolruk.ispolruknamefull'),
		//
		// ::: Включаем в запрос данные из таблицы бланков на поставку (dognet_blankdocpost)
		//
		Field::inst('dognet_blankdocpost.ID'),
		Field::inst('dognet_blankdocpost.kodblankwork'),
		Field::inst('dognet_blankdocpost.kodblankpost'),
		Field::inst('dognet_blankdocpost.kodispol'),
		Field::inst('dognet_blankdocpost.kodispolruk'),
		Field::inst('dognet_blankdocpost.kodtipblank'),
		Field::inst('dognet_blankdocpost.kodorgzakaz'),
		Field::inst('dognet_blankdocpost.kodorgispol'),
		Field::inst('dognet_blankdocpost.kodusespzakaz'),
		Field::inst('dognet_blankdocpost.koduseneworg'),
		Field::inst('dognet_blankdocpost.nameneworg'),
		Field::inst('dognet_blankdocpost.namedocblank'),
		Field::inst('dognet_blankdocpost.csummadocopl'),
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
		Field::inst('dognet_blankdocpost.kodusepril1'),
		Field::inst('dognet_blankdocpost.kodusepril2'),
		Field::inst('dognet_blankdocpost.kodusepril3'),
		Field::inst('dognet_blankdocpost.kodusepril4'),
		Field::inst('dognet_blankdocpost.kodusepril5'),
		Field::inst('dognet_blankdocpost.defuslgiptext'),
		Field::inst('dognet_blankdocpost.koduseispoldoc1'),
		Field::inst('dognet_blankdocpost.koduseispoldoc2'),
		Field::inst('dognet_blankdocpost.koduseispoldoc3'),
		Field::inst('dognet_blankdocpost.koduseispoldoc4'),
		Field::inst('dognet_blankdocpost.cdateispoldoc1'),
		Field::inst('dognet_blankdocpost.cdaysispoldoc2'),
		Field::inst('dognet_blankdocpost.namecontact1full'),
		Field::inst('dognet_blankdocpost.namecontact1dolj'),
		Field::inst('dognet_blankdocpost.contact1tel'),
		Field::inst('dognet_blankdocpost.contact1email'),
		Field::inst('dognet_blankdocpost.namecontact2full'),
		Field::inst('dognet_blankdocpost.namecontact2dolj'),
		Field::inst('dognet_blankdocpost.contact2tel'),
		Field::inst('dognet_blankdocpost.contact2email'),
		Field::inst('dognet_blankdocpost.kodusekomrasx1'),
		Field::inst('dognet_blankdocpost.kodusekomrasx2'),
		Field::inst('dognet_blankdocpost.kodusekomrasx3'),
		Field::inst('dognet_blankdocpost.komrasxprim'),
		Field::inst('dognet_blankdocpost.kodusetrans1'),
		Field::inst('dognet_blankdocpost.kodusetrans2'),
		Field::inst('dognet_blankdocpost.kodusetrans3'),
		Field::inst('dognet_blankdocpost.transprim'),
		Field::inst('dognet_blankdocpost.transplaceobor'),
		Field::inst('dognet_blankdocpost.numberdocmain'),
		Field::inst('dognet_blankdocpost.climitdays'),
		Field::inst('dognet_blankdocpost.koduserisk1'),
		Field::inst('dognet_blankdocpost.koduserisk2'),
		Field::inst('dognet_blankdocpost.koduserisk3'),
		Field::inst('dognet_blankdocpost.koduserisk4'),
		Field::inst('dognet_blankdocpost.riskprim'),
		Field::inst('dognet_blankdocpost.kodblankcreate'),
		Field::inst('dognet_blankdocpost.nameendcontact'),
		Field::inst('dognet_blankdocpost.namefistcontact'),
		Field::inst('dognet_blankdocpost.namesecondcontact'),
		Field::inst('dognet_blankdocpost.numbertelrab'),
		Field::inst('dognet_blankdocpost.numbertelmob'),
		Field::inst('dognet_blankdocpost.numbertelfax'),
		Field::inst('dognet_blankdocpost.nameemail'),
		Field::inst('dognet_blankdocpost.namedoljcontact'),
		Field::inst('dognet_blankdocpost.kodpaperstr'),
		//
		// ::: Включаем в запрос данные из таблицы бланков на ПНР (dognet_blankdocpnr)
		//
		Field::inst('dognet_blankdocpnr.ID'),
		Field::inst('dognet_blankdocpnr.kodblankwork'),
		Field::inst('dognet_blankdocpnr.kodblankpnr'),
		Field::inst('dognet_blankdocpnr.kodispol'),
		Field::inst('dognet_blankdocpnr.kodispolruk'),
		Field::inst('dognet_blankdocpnr.kodtipblank'),
		Field::inst('dognet_blankdocpnr.kodorgzakaz'),
		Field::inst('dognet_blankdocpnr.kodorgispol'),
		Field::inst('dognet_blankdocpnr.kodusespzakaz'),
		Field::inst('dognet_blankdocpnr.koduseneworg'),
		Field::inst('dognet_blankdocpnr.nameneworg'),
		Field::inst('dognet_blankdocpnr.namedocblank'),
		Field::inst('dognet_blankdocpnr.csummadocopl'),
		Field::inst('dognet_blankdocpnr.kodusendsopl'),
		Field::inst('dognet_blankdocpnr.kodusespechopl'),
		Field::inst('dognet_blankdocpnr.koduseopl1usl'),
		Field::inst('dognet_blankdocpnr.koduseopl2usl'),
		Field::inst('dognet_blankdocpnr.koduseopl3usl'),
		Field::inst('dognet_blankdocpnr.koduseopl4usl'),
		Field::inst('dognet_blankdocpnr.csummaopl1usl'),
		Field::inst('dognet_blankdocpnr.csummaopl2usl'),
		Field::inst('dognet_blankdocpnr.cnumberoplday2usl'),
		Field::inst('dognet_blankdocpnr.cnumberoplday3usl'),
		Field::inst('dognet_blankdocpnr.ctextoplotherusl'),
		Field::inst('dognet_blankdocpnr.kodusepril1'),
		Field::inst('dognet_blankdocpnr.kodusepril2'),
		Field::inst('dognet_blankdocpnr.kodusepril3'),
		Field::inst('dognet_blankdocpnr.kodusepril4'),
		Field::inst('dognet_blankdocpnr.kodusepril5'),
		Field::inst('dognet_blankdocpnr.defuslgiptext'),
		Field::inst('dognet_blankdocpnr.koduseispoldoc1'),
		Field::inst('dognet_blankdocpnr.koduseispoldoc2'),
		Field::inst('dognet_blankdocpnr.koduseispoldoc3'),
		Field::inst('dognet_blankdocpnr.koduseispoldoc4'),
		Field::inst('dognet_blankdocpnr.cdateispoldoc1'),
		Field::inst('dognet_blankdocpnr.cdaysispoldoc2'),
		Field::inst('dognet_blankdocpnr.kodusekomrasx1'),
		Field::inst('dognet_blankdocpnr.kodusekomrasx2'),
		Field::inst('dognet_blankdocpnr.kodusekomrasx3'),
		Field::inst('dognet_blankdocpnr.kodusekomrasx4'),
		Field::inst('dognet_blankdocpnr.summalimitmis'),
		Field::inst('dognet_blankdocpnr.komrasxprim'),
		Field::inst('dognet_blankdocpnr.kodusetrans1'),
		Field::inst('dognet_blankdocpnr.kodusetrans2'),
		Field::inst('dognet_blankdocpnr.kodusetrans3'),
		Field::inst('dognet_blankdocpnr.transprim'),
		Field::inst('dognet_blankdocpnr.transplaceobor'),
		Field::inst('dognet_blankdocpnr.numberdocmain'),
		Field::inst('dognet_blankdocpnr.climitdays'),
		Field::inst('dognet_blankdocpnr.koduserisk1'),
		Field::inst('dognet_blankdocpnr.koduserisk2'),
		Field::inst('dognet_blankdocpnr.koduserisk3'),
		Field::inst('dognet_blankdocpnr.koduserisk4'),
		Field::inst('dognet_blankdocpnr.koduserisk5'),
		Field::inst('dognet_blankdocpnr.riskprim'),
		Field::inst('dognet_blankdocpnr.kodblankcreate'),
		Field::inst('dognet_blankdocpnr.nameendcontact'),
		Field::inst('dognet_blankdocpnr.namefistcontact'),
		Field::inst('dognet_blankdocpnr.namesecondcontact'),
		Field::inst('dognet_blankdocpnr.numbertelrab'),
		Field::inst('dognet_blankdocpnr.numbertelmob'),
		Field::inst('dognet_blankdocpnr.numbertelfax'),
		Field::inst('dognet_blankdocpnr.nameemail'),
		Field::inst('dognet_blankdocpnr.namedoljcontact'),
		Field::inst('dognet_blankdocpnr.kodpaperstr'),
		Field::inst('dognet_blankdocpnr.kodobject'),
		//
		// ::: Включаем в запрос данные из таблицы бланков на ПНР (dognet_blankdocpnr)
		//
		Field::inst('dognet_blankdocsub.ID'),
		Field::inst('dognet_blankdocsub.kodblankwork'),
		Field::inst('dognet_blankdocsub.kodblanksub'),
		Field::inst('dognet_blankdocsub.kodispol'),
		Field::inst('dognet_blankdocsub.kodispolruk'),
		Field::inst('dognet_blankdocsub.kodtipblank'),
		Field::inst('dognet_blankdocsub.kodorgzakaz'),
		Field::inst('dognet_blankdocsub.kodorgispol'),
		Field::inst('dognet_blankdocsub.kodusespzakaz'),
		Field::inst('dognet_blankdocsub.koduseneworg'),
		Field::inst('dognet_blankdocsub.nameneworg'),
		Field::inst('dognet_blankdocsub.namedocblank'),
		Field::inst('dognet_blankdocsub.csummadocopl'),
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
		Field::inst('dognet_blankdocsub.kodusepril1'),
		Field::inst('dognet_blankdocsub.kodusepril2'),
		Field::inst('dognet_blankdocsub.kodusepril3'),
		Field::inst('dognet_blankdocsub.kodusepril4'),
		Field::inst('dognet_blankdocsub.kodusepril5'),
		Field::inst('dognet_blankdocsub.defuslgiptext'),
		Field::inst('dognet_blankdocsub.koduseispoldoc1'),
		Field::inst('dognet_blankdocsub.koduseispoldoc2'),
		Field::inst('dognet_blankdocsub.koduseispoldoc3'),
		Field::inst('dognet_blankdocsub.koduseispoldoc4'),
		Field::inst('dognet_blankdocsub.cdateispoldoc1'),
		Field::inst('dognet_blankdocsub.cdaysispoldoc2'),
		Field::inst('dognet_blankdocsub.kodusekomrasx1'),
		Field::inst('dognet_blankdocsub.kodusekomrasx2'),
		Field::inst('dognet_blankdocsub.kodusekomrasx3'),
		Field::inst('dognet_blankdocsub.kodusekomrasx4'),
		Field::inst('dognet_blankdocsub.summalimitmis'),
		Field::inst('dognet_blankdocsub.komrasxprim'),
		Field::inst('dognet_blankdocsub.kodusetrans1'),
		Field::inst('dognet_blankdocsub.kodusetrans2'),
		Field::inst('dognet_blankdocsub.kodusetrans3'),
		Field::inst('dognet_blankdocsub.transprim'),
		Field::inst('dognet_blankdocsub.transplaceobor'),
		Field::inst('dognet_blankdocsub.numberdocmain'),
		Field::inst('dognet_blankdocsub.climitdays'),
		Field::inst('dognet_blankdocsub.koduserisk1'),
		Field::inst('dognet_blankdocsub.koduserisk2'),
		Field::inst('dognet_blankdocsub.koduserisk3'),
		Field::inst('dognet_blankdocsub.koduserisk4'),
		Field::inst('dognet_blankdocsub.koduserisk5'),
		Field::inst('dognet_blankdocsub.riskprim'),
		Field::inst('dognet_blankdocsub.kodblankcreate'),
		Field::inst('dognet_blankdocsub.nameendcontact'),
		Field::inst('dognet_blankdocsub.namefistcontact'),
		Field::inst('dognet_blankdocsub.namesecondcontact'),
		Field::inst('dognet_blankdocsub.numbertelrab'),
		Field::inst('dognet_blankdocsub.numbertelmob'),
		Field::inst('dognet_blankdocsub.numbertelfax'),
		Field::inst('dognet_blankdocsub.nameemail'),
		Field::inst('dognet_blankdocsub.namedoljcontact'),
		Field::inst('dognet_blankdocsub.kodpaperstr')
	)
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	#
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('preGet', function ($editor, $id) {
		$editor->where(function ($q) {
			$q->where('dognet_docblankwork.koddel', '99', '!=');
			$q->and_where('dognet_docblankwork.kodstatusblank', 'DO');
			$q->and_where('dognet_docblankwork.kodblankdone', '1', '=');
		});
	})
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	#
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin('dognet_sysdefs_blankstatus', 'dognet_sysdefs_blankstatus.status_kod', '=', 'dognet_docblankwork.kodstatusblank')
	->leftJoin('dognet_sysdefs_blanktype', 'dognet_sysdefs_blanktype.type_kod', '=', 'dognet_docblankwork.kodtipblank')
	->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_docblankwork.kodispol')
	->leftJoin('dognet_spispolruk', 'dognet_spispolruk.kodispolruk', '=', 'dognet_docblankwork.kodispolruk')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docblankwork.kodzakaz')
	->leftJoin('dognet_blankdocpost', 'dognet_blankdocpost.id', '=', 'dognet_docblankwork.blank_rowID')
	->leftJoin('dognet_blankdocpnr', 'dognet_blankdocpnr.id', '=', 'dognet_docblankwork.blank_rowID')
	->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_blankdocpnr.kodobject')
	->leftJoin('dognet_blankdocsub', 'dognet_blankdocsub.id', '=', 'dognet_docblankwork.blank_rowID')
	// 	->where( 'dognet_docblankwork.kodispol', $KODISPOL )
	->where('dognet_docblankwork.yearblankwork', date('Y'), "!=")
	->where('dognet_docblankwork.kodblankdone', "1")
	->process($_POST)
	->json();
