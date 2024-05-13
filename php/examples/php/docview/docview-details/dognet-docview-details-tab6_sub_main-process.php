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
$_UNIQUEID = $_SESSION['uniqueID'];
// $_UNIQUEID = $_GET['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ВАЖНО!!!
# Определяем создан ли договор по шаблону с календарным планом (kodshab=1)
# или без плана (kodshab=2)
# Это определяет будет ли идти привязка в таблицах счетов, оплат и авансов привязка по
# коду этапа (kodkalplan) или по коду договора (koddoc) соответственно
#
$_QRY_KODSHAB = mysqlQuery("SELECT kodshab FROM dognet_docbase WHERE koddoc=" . $_UNIQUEID);
$_ROW_KODSHAB = mysqli_fetch_assoc($_QRY_KODSHAB);
$_KODSHAB = $_ROW_KODSHAB['kodshab'];
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция формирования нового ID счета-фактуры (kodchfact)
# для таблицы этапов 'dognet_kalplanchf'
# ----- ----- -----
function nextKoddocsubpodr() {
	$query = mysqlQuery("SELECT MAX(koddocsubpodr) as lastKod FROM dognet_docsubpodr ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#	ОПИСАНИЕ : Сумма всех авансов зачтенных в счет-фактуру $kodchfsubpodr
#
#
function SUMMA_AVANSCHF_SUBPODR($kodchfsubpodr) {
	$_QRY = mysqlQuery("SELECT SUM(sumavsubpodr) as SummaAvansChf FROM dognet_docavsubpodr WHERE kodchfsubpodr=" . $kodchfsubpodr);
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ($_QRY) {
		$__SummaAvansChf = $_ROW['SummaAvansChf'];
	} else {
		$__SummaAvansChf = "";
	}
	return $__SummaAvansChf;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ОПИСАНИЕ : Сумма всех оплат счета-фактуры $kodchfsubpodr
#
#
function SUMMA_OPLATCHF_SUBPODR($kodchfsubpodr) {
	$_QRY = mysqlQuery("SELECT SUM(sumoplchfsubpodr) as SummaOplatChf FROM dognet_docoplchfsubpodr WHERE kodchfsubpodr=" . $kodchfsubpodr);
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ($_QRY) {
		$__SummaOplatChf = $_ROW['SummaOplatChf'];
	} else {
		$__SummaOplatChf = "";
	}
	return $__SummaOplatChf;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- -----
function updateFields_docsubpodr($db, $action, $id, $values) {
	$__nextKoddocsubpodr = nextKoddocsubpodr();
	if ($action == 'CRT') {
		$db->update('dognet_docsubpodr', array(
			'koddocsubpodr'			=>	$__nextKoddocsubpodr
		), array('id' => $id));
	}
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Вытаскиваем идентификатор календарного плана
$query1 = mysqlQuery("SELECT koddened FROM dognet_docbase WHERE koddoc=" . $_UNIQUEID);
$row1 = mysqli_fetch_assoc($query1);
$__koddened = $row1['koddened'];
$query2 = mysqlQuery("SELECT html_code FROM dognet_spdened WHERE koddened=" . $__koddened);
$row2 = mysqli_fetch_assoc($query2);
$__dened = $row2['html_code'];
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
#
#
if ($_KODSHAB == "1" or $_KODSHAB == "3") {
	#
	#
	// Build our Editor instance and process the data coming from _POST
	Editor::inst($db, 'dognet_docsubpodr')
		->fields(
			Field::inst('dognet_dockalplan.koddoc'),
			Field::inst('dognet_dockalplan.numberstage'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_docsubpodr.koddoc')
				->options(
					Options::inst()
						->table('dognet_dockalplan')
						->value('kodkalplan')
						->label(array('kodkalplan', 'numberstage', 'nameshotstage'))
						->render(function ($row) {
							return "Этап " . $row['numberstage'] . " : " . $row['nameshotstage'];
						})
						->where(function ($q) use ($_UNIQUEID) {
							$q->where('koddoc', $_UNIQUEID, '=');
							$q->and_where('koddel', '99', '!=');
						})
				)
				->validator(Validate::notEmpty(
					ValidateOptions::inst()
						->message('Выберите этап договора')
				)),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('sp_contragents.nameshort'),
			Field::inst('dognet_docsubpodr.kodsubpodr')
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
							$q->where('useinsub', '1');
							$q->where('nameshort', '', '<>');
						})
				)
				->validator(Validate::notEmpty(
					ValidateOptions::inst()
						->message('Выберите организацию')
				)),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_docsubpodr.koddocsubpodr'),
			Field::inst('dognet_docsubpodr.namedocsubpodr'),
			Field::inst('dognet_docsubpodr.numberdocsubpodr'),
			Field::inst('dognet_docsubpodr.sumdocsubpodr'),
			Field::inst('dognet_docsubpodr.sumzadolsubpodr'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_docsubpodr.datedocsubpodr')
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
			Field::inst('dognet_docbase.koddened'),
			Field::inst('dognet_docbase.kodshab'),
			Field::inst('dognet_docbase.docnumber'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_spdened.koddened'),
			Field::inst('dognet_spdened.html_code'),
			Field::inst('dognet_spdened.short_code')
		)
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->on('postCreate', function ($editor, $id, $values, $row) {
			updateFields_docsubpodr($editor->db(), 'CRT', $id, $values);
		})
		->on('preGet', function ($editor, $id) use ($_UNIQUEID) {
			$editor->where(function ($q) use ($_UNIQUEID) {
				$q->where('dognet_docsubpodr.koddel', '99', '!=');
			});
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->leftJoin('dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_docsubpodr.koddoc')
		->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docsubpodr.kodsubpodr')
		->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
		->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
		->join(
			Mjoin::inst('dognet_docchfsubpodr')
				->link('dognet_docchfsubpodr.koddocsubpodr', 'dognet_docsubpodr.koddocsubpodr')
				->field(
					Field::inst('koddocsubpodr')
				)
		)
		->where('dognet_dockalplan.koddoc', $_UNIQUEID)
		->process($_POST)
		->json();
	#
	#
}
#
#
if ($_KODSHAB == "2" or $_KODSHAB == "4") {
	#
	#
	// Build our Editor instance and process the data coming from _POST
	Editor::inst($db, 'dognet_docsubpodr')
		->fields(
			Field::inst('dognet_docsubpodr.koddoc')
				->options(
					Options::inst()
						->table('dognet_docbase')
						->value('koddoc')
						->label(array('koddoc'))
						->render(function ($row) {
							return "Без календарного плана";
						})
						->where(function ($q) use ($_UNIQUEID) {
							$q->where('koddoc', $_UNIQUEID, '=');
						})
				)
				->validator(Validate::notEmpty(
					ValidateOptions::inst()
						->message('Объект обязателен')
				)),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('sp_contragents.nameshort'),
			Field::inst('dognet_docsubpodr.kodsubpodr')
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
							$q->where('useinsub', '1');
							$q->where('nameshort', '', '<>');
						})
				)
				->validator(Validate::notEmpty(
					ValidateOptions::inst()
						->message('Выберите организацию')
				)),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_docsubpodr.koddocsubpodr'),
			Field::inst('dognet_docsubpodr.namedocsubpodr'),
			Field::inst('dognet_docsubpodr.numberdocsubpodr'),
			Field::inst('dognet_docsubpodr.sumdocsubpodr'),
			Field::inst('dognet_docsubpodr.sumzadolsubpodr'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_docsubpodr.datedocsubpodr')
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
			Field::inst('dognet_docbase.koddened'),
			Field::inst('dognet_docbase.kodshab'),
			Field::inst('dognet_docbase.docnumber'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_spdened.koddened'),
			Field::inst('dognet_spdened.html_code'),
			Field::inst('dognet_spdened.short_code')
		)
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->on('postCreate', function ($editor, $id, $values, $row) {
			updateFields_docsubpodr($editor->db(), 'CRT', $id, $values);
		})
		->on('preGet', function ($editor, $id) use ($_UNIQUEID) {
			$editor->where(function ($q) use ($_UNIQUEID) {
				$q->where('dognet_docsubpodr.koddel', '99', '!=');
			});
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docsubpodr.kodsubpodr')
		->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_docsubpodr.koddoc')
		->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
		->join(
			Mjoin::inst('dognet_docchfsubpodr')
				->link('dognet_docchfsubpodr.koddocsubpodr', 'dognet_docsubpodr.koddocsubpodr')
				->field(
					Field::inst('koddocsubpodr')
				)
		)
		->where('dognet_docbase.koddoc', $_UNIQUEID)
		->process($_POST)
		->json();
	#
	#
}