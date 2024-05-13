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
$__uniqueID = $_SESSION['uniqueID'];
// $__uniqueID = $_GET['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ВАЖНО!!!
# Определяем создан ли договор по шаблону с календарным планом (kodshab=1)
# или без плана (kodshab=2)
# Это определяет будет ли идти привязка в таблицах счетов, оплат и авансов привязка по
# коду этапа (kodkalplan) или по коду договора (koddoc) соответственно
#
$_QRY_KODSHAB = mysqlQuery("SELECT kodshab FROM dognet_docbase WHERE koddoc=" . $__uniqueID);
$_ROW_KODSHAB = mysqli_fetch_assoc($_QRY_KODSHAB);
$_KODSHAB = $_ROW_KODSHAB['kodshab'];
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция формирования нового ID аванса (kodavsubpodr)
# для таблицы авансов субподряда 'dognet_docavsubpodr'
# ----- ----- -----
function nextKodavsubpodr() {
	$query = mysqlQuery("SELECT MAX(kodavsubpodr) as lastKod FROM dognet_docavsubpodr ORDER BY id DESC");
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
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления нового ID аванса (kodavsubpodr)
# для таблицы авансов субподряда 'dognet_docavsubpodr'
# ----- ----- -----
function updateFields_avsubpodr($db, $action, $id, $values) {

	// ID счета фактуры
	$_QRY_1 = $db->sql("SELECT kodchfsubpodr FROM dognet_docavsubpodr WHERE id=" . $id)->fetchAll();
	if ($_QRY_1) {
		$__kodchfsubpodr = $_QRY_1[0]['kodchfsubpodr'];
	}
	#
	#
	if ($action == 'CRT') {
		$__nextKodavsubpodr = nextKodavsubpodr();
		$db->update('dognet_docavsubpodr', array(
			'kodavsubpodr'			=>	$__nextKodavsubpodr
		), array('id' => $id));
		//
		DOCSUB_PR_ZADOLG_DOC($db, "docavsubpodr", $id, $action);
		//
	}
	#
	#
	if ($action == 'UPD') {
		//
		DOCSUB_PR_ZADOLG_DOC($db, "docavsubpodr", $id, $action);
		//
	}
	#
	#
	if ($action == 'DEL') {
		//
		DOCSUB_PR_ZADOLG_DOC($db, "docavsubpodr", $id, $action);
		//
	}
	#
	#
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция пересчета задолженности по счету-фактуре (kodchfsubpodr)
# для таблицы счетов-фактур 'dognet_docchfsubpodr'
# ----- ----- -----
function update_chfZadol($db, $id, $kodchfsubpodr) {

	$_QRY_1 = $db->sql("SELECT sumchfsubpodr FROM dognet_docchfsubpodr WHERE kodchfsubpodr=" . $kodchfsubpodr)->fetchAll();
	if ($_QRY_1) {
		$__sumchfsubpodr = $_QRY_1[0]['sumchfsubpodr'];
	}
	// -----
	$_QRY_2 = $db->sql("SELECT SUM(sumavsubpodr) as sumavans FROM dognet_docavsubpodr WHERE kodchfsubpodr=" . $kodchfsubpodr)->fetchAll();
	if ($_QRY_2) {
		$__sumavans = $_QRY_2[0]['sumavans'];
	}
	// -----
	// Пересчитываем сумму задолженности по счету-фактуре
	$_NEW_sumzadolchfsubpodr = $__sumchfsubpodr - (SUMMA_OPLATCHF_SUBPODR($kodchfsubpodr) + $__sumavans);
	// -----
	$db->update('dognet_docchfsubpodr', array(
		'sumzadolchfsubpodr'		=>	$_NEW_sumzadolchfsubpodr
	), array('kodchfsubpodr' => $kodchfsubpodr));
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция пересчета задолженности по счетам-фактурам (NOT kodchfsubpodr)
# отличным от выбранного для таблицы счетов-фактур 'dognet_docchfsubpodr'
# ----- ----- -----
function update_otherChfZadol($db, $id, $koddocsubpodr, $kodchfsubpodr) {
	$_QRY = mysqlQuery("SELECT kodchfsubpodr FROM dognet_docchfsubpodr WHERE koddocsubpodr=" . $koddocsubpodr);
	while ($_ROW = mysqli_fetch_assoc($_QRY)) {

		$kod = $_ROW['kodchfsubpodr'];
		// -----
		$_QRY_1 = $db->sql("SELECT sumchfsubpodr FROM dognet_docchfsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
		if ($_QRY_1) {
			$__sumchfsubpodr = $_QRY_1[0]['sumchfsubpodr'];
		}
		// -----
		$_QRY_2 = $db->sql("SELECT SUM(sumavsubpodr) as sumavans FROM dognet_docavsubpodr WHERE kodchfsubpodr=" . $kod)->fetchAll();
		if ($_QRY_2) {
			$__sumavans = $_QRY_2[0]['sumavans'];
		}
		// -----
		$_NEW_sumzadolchfsubpodr = $__sumchfsubpodr - (SUMMA_OPLATCHF_SUBPODR($kod) + $__sumavans);
		// -----
		if ($kod != $kodchfsubpodr) {
			$db->update('dognet_docchfsubpodr', array(
				'sumzadolchfsubpodr'		=>	$_NEW_sumzadolchfsubpodr
			), array('kodchfsubpodr' => $kod));
		}
	}
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Вытаскиваем идентификатор календарного плана
$query1 = mysqlQuery("SELECT koddened FROM dognet_docbase WHERE koddoc=" . $__uniqueID);
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
	if (!isset($_POST['koddocsubpodr2']) || !is_numeric($_POST['koddocsubpodr2'])) {
		echo json_encode(["data" => []]);
	} else {
		if (!isset($_POST['kodchfsubpodr_avchf']) || !is_numeric($_POST['kodchfsubpodr_avchf'])) {

			$__koddocsubpodr = $_POST['koddocsubpodr2'];
			// Build our Editor instance and process the data coming from _POST
			Editor::inst($db, 'dognet_docavsubpodr')
				->fields(
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.kodchfsubpodr')
						->options(
							Options::inst()
								->table('dognet_docchfsubpodr')
								->value('kodchfsubpodr')
								->label(array('koddocsubpodr', 'kodchfsubpodr', 'numberchfsubpodr', 'datechfsubpodr'))
								->render(function ($row) use ($__koddocsubpodr) {
									return ("Счет-фактура : " . $row['numberchfsubpodr']);
								})
								->where(function ($q) use ($__koddocsubpodr) {
									$q->where('koddocsubpodr', $__koddocsubpodr, '=');
								})
						),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.koddocsubpodr')
						->options(
							Options::inst()
								->table('dognet_docsubpodr')
								->value('koddocsubpodr')
								->label(array('koddocsubpodr', 'numberdocsubpodr', 'kodsubpodr'))
								->render(function ($row) use ($__koddocsubpodr) {
									return ("Договор : " . $row['numberdocsubpodr']);
								})
								->where(function ($q) use ($__koddocsubpodr) {
									$q->where('koddocsubpodr', $__koddocsubpodr, '=');
								})
						)
						->validator(Validate::notEmpty(
							ValidateOptions::inst()
								->message('Объект обязателен')
						)),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.kodavsubpodr'),
					Field::inst('dognet_docavsubpodr.dateavsubpodr')
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
					Field::inst('dognet_docavsubpodr.sumavsubpodr'),
					Field::inst('dognet_docchfsubpodr.koddocsubpodr'),
					Field::inst('dognet_docchfsubpodr.kodchfsubpodr'),
					Field::inst('dognet_dockalplan.kodkalplan'),
					Field::inst('dognet_docbase.koddoc'),
					Field::inst('dognet_docbase.koddened'),
					Field::inst('dognet_spdened.html_code'),
					Field::inst('dognet_spdened.short_code')
				)
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				->on('postCreate', function ($editor, $id, $values, $row) {
					updateFields_avsubpodr($editor->db(), 'CRT', $id, $values);
				})
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				->leftJoin('dognet_docavchfsubpodr', 'dognet_docavchfsubpodr.kodchfsubpodr', '=', 'dognet_docavsubpodr.kodchfsubpodr')

				->leftJoin('dognet_docchfsubpodr', 'dognet_docchfsubpodr.kodchfsubpodr', '=', 'dognet_docavsubpodr.kodchfsubpodr')
				->leftJoin('dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docavsubpodr.koddocsubpodr')
				->leftJoin('dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_docsubpodr.koddoc')
				->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
				->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
				->where('dognet_docavsubpodr.koddocsubpodr', $__koddocsubpodr)
				//   ->where( 'dognet_docavsubpodr.kodchfsubpodr', $__kodchfsubpodr )
				->process($_POST)
				->json();
		} else {
			$__koddocsubpodr = $_POST['koddocsubpodr2'];
			$__kodchfsubpodr = $_POST['kodchfsubpodr_avchf'];
			$_SESSION['tmp_SelectedKodchfsubpodr'] = $_POST['kodchfsubpodr_avchf'];
			// Build our Editor instance and process the data coming from _POST
			Editor::inst($db, 'dognet_docavsubpodr')
				->fields(
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.kodchfsubpodr')
						->options(
							Options::inst()
								->table('dognet_docchfsubpodr')
								->value('kodchfsubpodr')
								->label(array('koddocsubpodr', 'kodchfsubpodr', 'numberchfsubpodr', 'datechfsubpodr'))
								->render(function ($row) use ($__kodchfsubpodr) {
									return ("Счет-фактура : " . $row['numberchfsubpodr']);
								})
								->where(function ($q) use ($__kodchfsubpodr) {
									$q->where('kodchfsubpodr', $__kodchfsubpodr, '=');
								})
						),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.koddocsubpodr')
						->options(
							Options::inst()
								->table('dognet_docsubpodr')
								->value('koddocsubpodr')
								->label(array('koddocsubpodr', 'numberdocsubpodr', 'kodsubpodr'))
								->render(function ($row) use ($__koddocsubpodr) {
									return ("Договор : " . $row['numberdocsubpodr']);
								})
								->where(function ($q) use ($__koddocsubpodr) {
									$q->where('koddocsubpodr', $__koddocsubpodr, '=');
								})
						)
						->validator(Validate::notEmpty(
							ValidateOptions::inst()
								->message('Выберите договор')
						)),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.kodavsubpodr'),
					Field::inst('dognet_docavsubpodr.dateavsubpodr')
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
					Field::inst('dognet_docavsubpodr.sumavsubpodr'),
					Field::inst('dognet_docchfsubpodr.koddocsubpodr'),
					Field::inst('dognet_docchfsubpodr.kodchfsubpodr'),
					Field::inst('dognet_dockalplan.kodkalplan'),
					Field::inst('dognet_docbase.koddoc'),
					Field::inst('dognet_docbase.koddened'),
					Field::inst('dognet_spdened.html_code'),
					Field::inst('dognet_spdened.short_code')
				)
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				->on('preEdit', function ($editor, $id, $values) {
					update_chfZadol($editor->db(), $id, $_POST['kodchfsubpodr_avchf']);
				})
				->on('postCreate', function ($editor, $id, $values, $row) {
					updateFields_avsubpodr($editor->db(), 'CRT', $id, $values);
					update_chfZadol($editor->db(), $id, $_POST['kodchfsubpodr_avchf']);
				})
				->on('postEdit', function ($editor, $id, $values, $row) {
					updateFields_avsubpodr($editor->db(), 'UPD', $id, $values);
					update_chfZadol($editor->db(), $id, $_POST['kodchfsubpodr_avchf']);
					update_otherChfZadol($editor->db(), $id, $_POST['koddocsubpodr2'], $_POST['kodchfsubpodr_avchf']);
				})
				->on('preRemove', function ($editor, $id, $values) {
					updateFields_avsubpodr($editor->db(), 'DEL', $id, $values);
				})
				->on('postRemove', function ($editor, $id, $values) {
					update_chfZadol($editor->db(), $id, $_POST['kodchfsubpodr_avchf']);
					update_otherChfZadol($editor->db(), $id, $_POST['koddocsubpodr2'], $_POST['kodchfsubpodr_avchf']);
				})
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				->leftJoin('dognet_docavchfsubpodr', 'dognet_docavchfsubpodr.kodchfsubpodr', '=', 'dognet_docavsubpodr.kodchfsubpodr')

				->leftJoin('dognet_docchfsubpodr', 'dognet_docchfsubpodr.kodchfsubpodr', '=', 'dognet_docavsubpodr.kodchfsubpodr')
				->leftJoin('dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docavsubpodr.koddocsubpodr')
				->leftJoin('dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_docsubpodr.koddoc')
				->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
				->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
				->where('dognet_docavsubpodr.koddocsubpodr', $__koddocsubpodr)
				//   ->where( 'dognet_docavsubpodr.kodchfsubpodr', $__kodchfsubpodr )
				->process($_POST)
				->json();
		}
	}
	#
	#
}
#
#
if ($_KODSHAB == "2" or $_KODSHAB == "4") {
	#
	#
	if (!isset($_POST['koddocsubpodr2']) || !is_numeric($_POST['koddocsubpodr2'])) {
		echo json_encode(["data" => []]);
	} else {
		if (!isset($_POST['kodchfsubpodr_avchf']) || !is_numeric($_POST['kodchfsubpodr_avchf'])) {

			$__koddocsubpodr = $_POST['koddocsubpodr2'];
			// Build our Editor instance and process the data coming from _POST
			Editor::inst($db, 'dognet_docavsubpodr')
				->fields(
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.kodchfsubpodr')
						->options(
							Options::inst()
								->table('dognet_docchfsubpodr')
								->value('kodchfsubpodr')
								->label(array('koddocsubpodr', 'kodchfsubpodr', 'numberchfsubpodr', 'datechfsubpodr'))
								->render(function ($row) use ($__koddocsubpodr) {
									return ("Счет-фактура : " . $row['numberchfsubpodr']);
								})
								->where(function ($q) use ($__koddocsubpodr) {
									$q->where('koddocsubpodr', $__koddocsubpodr, '=');
								})
						),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.koddocsubpodr')
						->options(
							Options::inst()
								->table('dognet_docsubpodr')
								->value('koddocsubpodr')
								->label(array('koddocsubpodr', 'numberdocsubpodr', 'kodsubpodr'))
								->render(function ($row) use ($__koddocsubpodr) {
									return ("Договор : " . $row['numberdocsubpodr']);
								})
								->where(function ($q) use ($__koddocsubpodr) {
									$q->where('koddocsubpodr', $__koddocsubpodr, '=');
								})
						)
						->validator(Validate::notEmpty(
							ValidateOptions::inst()
								->message('Объект обязателен')
						)),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.kodavsubpodr'),
					Field::inst('dognet_docavsubpodr.dateavsubpodr')
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
					Field::inst('dognet_docavsubpodr.sumavsubpodr'),
					Field::inst('dognet_docchfsubpodr.koddocsubpodr'),
					Field::inst('dognet_docchfsubpodr.kodchfsubpodr'),
					Field::inst('dognet_docbase.koddoc'),
					Field::inst('dognet_docbase.koddened'),
					Field::inst('dognet_spdened.html_code'),
					Field::inst('dognet_spdened.short_code')
				)
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				->on('postCreate', function ($editor, $id, $values, $row) {
					updateFields_avsubpodr($editor->db(), 'CRT', $id, $values);
				})
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				->leftJoin('dognet_docchfsubpodr', 'dognet_docchfsubpodr.kodchfsubpodr', '=', 'dognet_docavsubpodr.kodchfsubpodr')
				->leftJoin('dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docavsubpodr.koddocsubpodr')
				->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_docsubpodr.koddoc')
				->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
				->where('dognet_docavsubpodr.koddocsubpodr', $__koddocsubpodr)
				//   ->where( 'dognet_docavsubpodr.kodchfsubpodr', $__kodchfsubpodr )
				->process($_POST)
				->json();
		} else {
			$__koddocsubpodr = $_POST['koddocsubpodr2'];
			$__kodchfsubpodr = $_POST['kodchfsubpodr_avchf'];
			$_SESSION['tmp_SelectedKodchfsubpodr'] = $_POST['kodchfsubpodr_avchf'];
			// Build our Editor instance and process the data coming from _POST
			Editor::inst($db, 'dognet_docavsubpodr')
				->fields(
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.kodchfsubpodr')
						->options(
							Options::inst()
								->table('dognet_docchfsubpodr')
								->value('kodchfsubpodr')
								->label(array('koddocsubpodr', 'kodchfsubpodr', 'numberchfsubpodr', 'datechfsubpodr'))
								->render(function ($row) use ($__kodchfsubpodr) {
									return ("Счет-фактура : " . $row['numberchfsubpodr']);
								})
								->where(function ($q) use ($__kodchfsubpodr) {
									$q->where('kodchfsubpodr', $__kodchfsubpodr, '=');
								})
						),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.koddocsubpodr')
						->options(
							Options::inst()
								->table('dognet_docsubpodr')
								->value('koddocsubpodr')
								->label(array('koddocsubpodr', 'numberdocsubpodr', 'kodsubpodr'))
								->render(function ($row) use ($__koddocsubpodr) {
									return ("Договор : " . $row['numberdocsubpodr']);
								})
								->where(function ($q) use ($__koddocsubpodr) {
									$q->where('koddocsubpodr', $__koddocsubpodr, '=');
								})
						)
						->validator(Validate::notEmpty(
							ValidateOptions::inst()
								->message('Выберите договор')
						)),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.kodavsubpodr'),
					Field::inst('dognet_docavsubpodr.dateavsubpodr')
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
					Field::inst('dognet_docavsubpodr.sumavsubpodr'),
					Field::inst('dognet_docchfsubpodr.koddocsubpodr'),
					Field::inst('dognet_docchfsubpodr.kodchfsubpodr'),
					Field::inst('dognet_docbase.koddoc'),
					Field::inst('dognet_docbase.koddened'),
					Field::inst('dognet_spdened.html_code'),
					Field::inst('dognet_spdened.short_code')
				)
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				->on('preEdit', function ($editor, $id, $values) {
					update_chfZadol($editor->db(), $id, $_POST['kodchfsubpodr_avchf']);
				})
				->on('postCreate', function ($editor, $id, $values, $row) {
					updateFields_avsubpodr($editor->db(), 'CRT', $id, $values);
					update_chfZadol($editor->db(), $id, $_POST['kodchfsubpodr_avchf']);
				})
				->on('postEdit', function ($editor, $id, $values, $row) {
					updateFields_avsubpodr($editor->db(), 'UPD', $id, $values);
					update_chfZadol($editor->db(), $id, $_POST['kodchfsubpodr_avchf']);
					update_otherChfZadol($editor->db(), $id, $_POST['koddocsubpodr2'], $_POST['kodchfsubpodr_avchf']);
				})
				->on('preRemove', function ($editor, $id, $values) {
					updateFields_avsubpodr($editor->db(), 'DEL', $id, $values);
				})
				->on('postRemove', function ($editor, $id, $values) {
					update_chfZadol($editor->db(), $id, $_POST['kodchfsubpodr_avchf']);
					update_otherChfZadol($editor->db(), $id, $_POST['koddocsubpodr2'], $_POST['kodchfsubpodr_avchf']);
				})
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				->leftJoin('dognet_docchfsubpodr', 'dognet_docchfsubpodr.kodchfsubpodr', '=', 'dognet_docavsubpodr.kodchfsubpodr')
				->leftJoin('dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docavsubpodr.koddocsubpodr')
				->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_docsubpodr.koddoc')
				->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
				->where('dognet_docavsubpodr.koddocsubpodr', $__koddocsubpodr)
				//   ->where( 'dognet_docavsubpodr.kodchfsubpodr', $__kodchfsubpodr )
				->process($_POST)
				->json();
		}
	}
	#
	#
}