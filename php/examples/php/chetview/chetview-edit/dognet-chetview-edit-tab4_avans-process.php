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
# Функция формирования следующего ID аванса (kodavans)
# для таблицы этапов 'dognet_docavans'
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
function nextKodavans() {
	$query = mysqlQuery("SELECT MAX(kodavans) as lastKod FROM dognet_docavans ORDER BY id DESC");
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
function updateFields_docavans($db, $action_docavans, $id, $values, $__kodshab, $__uniqueID) {
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "НОВЫЙ АВАНС"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	$__nextKodavans = nextKodavans();
	#
	#
	if ($action_docavans == 'CRT') {
		$db->update('dognet_docavans', array(
			'kodavans'			=>	$__nextKodavans
		), array('id' => $id));
		#
		#
		$_QRY = $db->sql("SELECT koddoc, dateavans FROM dognet_docavans WHERE id=" . $id)->fetchAll();
		$koddoc = !empty($_QRY) ? $_QRY[0]['koddoc'] : "";
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940020', '0000001', $id, $__nextKodavans, $_QRY[0]['dateavans'], null);
		#
		#
		DOCAVANS_PR_OSTATOK_DOC($db, "docavans", $id, $action_docavans);
		#
		#
		DOCBASE_PR_ZADOLG_DOC($db, "docavans", $id, $action_docavans, $__uniqueID, $__kodshab);
		#
		#
		if (!empty($koddoc)) {
			$_QRY_AV = $db->sql("SELECT dateavans FROM dognet_docavans WHERE koddoc='$koddoc' ORDER BY dateavans ASC LIMIT 1")->fetchAll();
			$_QRY_DOC = $db->sql("SELECT dayenddoc,monthenddoc,yearenddoc,srokindays FROM dognet_docbase WHERE koddoc='$koddoc'")->fetchAll();
			$firstAvansDate	= !empty($_QRY_AV) ? $_QRY_AV[0]['dateavans'] : "";
			$srokInDays		= !empty($_QRY_DOC) ? $_QRY_DOC[0]['srokindays'] : "";
			if (!empty($firstAvansDate) && $srokInDays != "") {
				$endDate	= date("Y-m-d", strtotime($firstAvansDate . '+ ' . $srokInDays . ' days'));
				// Extract day, month, and year 
				$endDay		= date('d', strtotime($endDate));
				$endMonth	= date('m', strtotime($endDate));
				$endYear	= date('Y', strtotime($endDate));
				$db->update('dognet_docbase', array(
					'dayenddoc'		=> $endDay,
					'monthenddoc'	=> $endMonth,
					'yearenddoc'	=> $endYear
				), array(
					'koddoc' 		=> $koddoc
				));
			}
		}
	}
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "ИЗМЕНИТЬ"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_docavans == 'UPD') {
		#
		#
		$_QRY = $db->sql("SELECT koddoc, dateavans FROM dognet_docavans WHERE id=" . $id)->fetchAll();
		$koddoc = !empty($_QRY) ? $_QRY[0]['koddoc'] : "";
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940020', '0000002', $id, null, null, null);
		#
		#
		DOCAVANS_PR_OSTATOK_DOC($db, "docavans", $id, $action_docavans);
		#
		#
		DOCBASE_PR_ZADOLG_DOC($db, "docavans", $id, $action_docavans, $__uniqueID, $__kodshab);
		#
		#
		if (!empty($koddoc)) {
			$_QRY_AV = $db->sql("SELECT dateavans FROM dognet_docavans WHERE koddoc='$koddoc' ORDER BY dateavans ASC LIMIT 1")->fetchAll();
			$_QRY_DOC = $db->sql("SELECT dayenddoc,monthenddoc,yearenddoc,srokindays FROM dognet_docbase WHERE koddoc='$koddoc'")->fetchAll();
			$firstAvansDate	= !empty($_QRY_AV) ? $_QRY_AV[0]['dateavans'] : "";
			$srokInDays		= !empty($_QRY_DOC) ? $_QRY_DOC[0]['srokindays'] : "";
			if (!empty($firstAvansDate) && $srokInDays != "") {
				$endDate	= date("Y-m-d", strtotime($firstAvansDate . '+ ' . $srokInDays . ' days'));
				// Extract day, month, and year 
				$endDay		= date('d', strtotime($endDate));
				$endMonth	= date('m', strtotime($endDate));
				$endYear	= date('Y', strtotime($endDate));
				$db->update('dognet_docbase', array(
					'dayenddoc'		=> $endDay,
					'monthenddoc'	=> $endMonth,
					'yearenddoc'	=> $endYear
				), array(
					'koddoc' 		=> $koddoc
				));
			}
		}
	}
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "УДАЛИТЬ"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_docavans == 'DEL') {
		#
		#
		$_QRY = $db->sql("SELECT koddoc, dateavans FROM dognet_docavans WHERE id=" . $id)->fetchAll();
		$koddoc = !empty($_QRY) ? $_QRY[0]['koddoc'] : "";
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940020', '0000002', $id, null, null, null);
		#
		#
		DOCAVANS_PR_OSTATOK_DOC($db, "docavans", $id, $action_docavans);
		#
		#
		DOCBASE_PR_ZADOLG_DOC($db, "docavans", $id, $action_docavans, $__uniqueID, $__kodshab);
		#
		#
		if (!empty($koddoc)) {
			$_QRY_AV = $db->sql("SELECT dateavans FROM dognet_docavans WHERE koddoc='$koddoc' AND id!='$id' ORDER BY dateavans ASC LIMIT 1")->fetchAll();
			$_QRY_DOC = $db->sql("SELECT dayenddoc,monthenddoc,yearenddoc,srokindays FROM dognet_docbase WHERE koddoc='$koddoc'")->fetchAll();
			$firstAvansDate	= !empty($_QRY_AV) ? $_QRY_AV[0]['dateavans'] : "";
			$srokInDays		= !empty($_QRY_DOC) ? $_QRY_DOC[0]['srokindays'] : "";
			if (!empty($firstAvansDate) && $srokInDays != "") {
				$endDate	= date("Y-m-d", strtotime($firstAvansDate . '+ ' . $srokInDays . ' days'));
				// Extract day, month, and year 
				$endDay		= date('d', strtotime($endDate));
				$endMonth	= date('m', strtotime($endDate));
				$endYear	= date('Y', strtotime($endDate));
				$db->update('dognet_docbase', array(
					'dayenddoc'		=> $endDay,
					'monthenddoc'	=> $endMonth,
					'yearenddoc'	=> $endYear
				), array(
					'koddoc' 		=> $koddoc
				));
			} else {
				$db->update('dognet_docbase', array(
					'dayenddoc'		=> '0',
					'monthenddoc'	=> '0',
					'yearenddoc'	=> '0'
				), array(
					'koddoc' 		=> $koddoc
				));
			}
		}
	}
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
#
#
if ($_KODSHAB == "1") {
	#
	#
	# Build our Editor instance and process the data coming from _POST
	Editor::inst($db, 'dognet_docavans')
		->fields(
			Field::inst('dognet_docbase.koddel'),
			Field::inst('dognet_docbase.kodshab'),
			Field::inst('dognet_docbase.docnumber'),
			Field::inst('dognet_docbase.numberchet'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_dockalplan.koddoc'),
			Field::inst('dognet_dockalplan.kodkalplan'),
			Field::inst('dognet_dockalplan.numberstage'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_docavans.nameavans'),
			Field::inst('dognet_docavans.comment'),
			Field::inst('dognet_docavans.summaavans'),
			Field::inst('dognet_docavans.dateavans')
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
			Field::inst('dognet_docavans.kodavans'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_docavans.koddoc')
				->options(
					Options::inst()
						->table('dognet_dockalplan')
						->value('kodkalplan')
						->label(array('koddoc', 'kodkalplan', 'numberstage', 'nameshotstage'))
						->render(function ($row) use ($_UNIQUEID) {
							return ("Этап " . $row['numberstage'] . " : " . $row['nameshotstage']);
						})
						->where(function ($q) use ($_UNIQUEID) {
							$q->where('koddoc', $_UNIQUEID);
						})
				)
				->validator(Validate::notEmpty(
					ValidateOptions::inst()
						->message('Объект обязателен')
				)),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_docavans_ostatok.kodavans'),
			Field::inst('dognet_docavans_ostatok.ostatokavans'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_docbase.koddened'),
			Field::inst('dognet_spdened.koddened'),
			Field::inst('dognet_spdened.html_code'),
			Field::inst('dognet_spdened.short_code')
			# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		)
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		->on('preGet', function ($editor, $id) use ($_UNIQUEID) {
			$editor->where(function ($q) use ($_UNIQUEID) {
				$q->where('dognet_docavans.koddel', '99', '!=');
				$q->and_where('dognet_docavans.koddoc', '(SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc=' . $_UNIQUEID . ')', 'IN', false);
			});
		})
		//
		->on('postCreate', function ($editor_docavans, $id, $values, $row) use ($_KODSHAB, $_UNIQUEID) {
			updateFields_docavans($editor_docavans->db(), 'CRT', $id, $values, $_KODSHAB, $_UNIQUEID);
		})
		->on('postEdit', function ($editor_docavans, $id, $values, $row) use ($_KODSHAB, $_UNIQUEID) {
			updateFields_docavans($editor_docavans->db(), 'UPD', $id, $values, $_KODSHAB, $_UNIQUEID);
		})
		->on('preRemove', function ($editor_docavans, $id, $values) use ($_KODSHAB, $_UNIQUEID) {
			updateFields_docavans($editor_docavans->db(), 'DEL', $id, $values, $_KODSHAB, $_UNIQUEID);
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		->leftJoin('dognet_docavans_ostatok', 'dognet_docavans_ostatok.kodavans', '=', 'dognet_docavans.kodavans')
		->leftJoin('dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_docavans.koddoc')
		->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
		->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
		->process($_POST)
		->json();
	#
	#
}
#
#
if ($_KODSHAB == "2" or $_KODSHAB == "0") {
	#
	#
	# Build our Editor instance and process the data coming from _POST
	Editor::inst($db, 'dognet_docavans')
		->fields(
			Field::inst('dognet_docbase.koddel'),
			Field::inst('dognet_docbase.kodshab'),
			Field::inst('dognet_docbase.docnumber'),
			Field::inst('dognet_docbase.numberchet'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_docavans.nameavans'),
			Field::inst('dognet_docavans.comment'),
			Field::inst('dognet_docavans.summaavans'),
			Field::inst('dognet_docavans.dateavans')
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
			Field::inst('dognet_docavans.kodavans'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_docavans.koddoc')
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
			Field::inst('dognet_docavans_ostatok.kodavans'),
			Field::inst('dognet_docavans_ostatok.ostatokavans'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_docbase.koddened'),
			Field::inst('dognet_spdened.koddened'),
			Field::inst('dognet_spdened.html_code'),
			Field::inst('dognet_spdened.short_code')
			# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		)
		//
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		->on('preGet', function ($editor_docavans, $id) {
			$editor_docavans->where(function ($q) {
				$q->where('dognet_docavans.koddel', '99', '!=');
			});
		})
		//
		->on('postCreate', function ($editor_docavans, $id, $values, $row) use ($_KODSHAB, $_UNIQUEID) {
			updateFields_docavans($editor_docavans->db(), 'CRT', $id, $values, $_KODSHAB, $_UNIQUEID);
		})
		->on('postEdit', function ($editor_docavans, $id, $values, $row) use ($_KODSHAB, $_UNIQUEID) {
			updateFields_docavans($editor_docavans->db(), 'UPD', $id, $values, $_KODSHAB, $_UNIQUEID);
		})
		->on('preRemove', function ($editor_docavans, $id, $values) use ($_KODSHAB, $_UNIQUEID) {
			updateFields_docavans($editor_docavans->db(), 'DEL', $id, $values, $_KODSHAB, $_UNIQUEID);
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		//
		->leftJoin('dognet_docavans_ostatok', 'dognet_docavans_ostatok.kodavans', '=', 'dognet_docavans.kodavans')
		->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_docavans.koddoc')
		->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
		->where('dognet_docavans.koddoc', $_UNIQUEID)
		->process($_POST)
		->json();
	#
	#
}
#
#