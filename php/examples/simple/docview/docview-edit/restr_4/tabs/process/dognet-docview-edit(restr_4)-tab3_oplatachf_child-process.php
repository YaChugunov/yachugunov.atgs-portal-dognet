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
# ВАЖНО!!!
# Определяем создан ли договор по шаблону с календарным планом (kodshab=1)
# или без плана (kodshab=2)
# Это определяет будет ли идти привязка в таблицах счетов, оплат и авансов привязка по
# коду этапа (kodkalplan) или по коду договора (koddoc) соответственно
#
$_QRY_KODSHAB = mysqlQuery("SELECT kodshab FROM dognet_docbase WHERE koddoc=" . $_UNIQUEID);
$_ROW_KODSHAB = mysqli_fetch_assoc($_QRY_KODSHAB);
$_KODSHAB = !empty($_ROW_KODSHAB['kodshab']) ? $_ROW_KODSHAB['kodshab'] : "";
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция формирования нового ID счета-фактуры (kodchfact)
# для таблицы этапов 'dognet_kalplanchf'
# ----- ----- -----
function nextKodoplata() {
	$query = mysqlQuery("SELECT MAX(kodoplata) as lastKod FROM dognet_oplatachf ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
#
function updateFields_oplatachf($db, $action_oplatachf, $id, $values, $row, $__kodkalplan, $__kodchfact, $__kodshab, $__uniqueID) {
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "НОВАЯ ОПЛАТА"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	$_QRY = $db->sql("SELECT * FROM dognet_oplatachf WHERE id=" . $id)->fetchAll();
	/*
	if ( $_QRY ) {
		$__kodchfact = $_QRY[0]['kodchfact'];
	}
*/
	#
	#
	if ($action_oplatachf == 'CRT') {
		$__nextKodoplata = nextKodoplata();
		$db->update('dognet_oplatachf', array(
			'kodoplata'			=>	$__nextKodoplata
		), array('id' => $id));
		#
		#
		$_QRY_CHF = $db->sql("SELECT kodkalplan, chetfnumber FROM dognet_kalplanchf WHERE kodchfact=" . $__kodchfact)->fetchAll();
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940001', '0000001', $id, $__nextKodoplata, $__kodchfact, $_QRY_CHF[0]['kodkalplan']);
		#
		#
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		# ПЕРСЧИТЫВАЕМ СУММУ ЗАЧТЕННЫХ ОПЛАТ ПО ЭТАПУ
		# ДЛЯ ТАБЛИЦЫ ПРОГРЕССА ЭТАПОВ - dockalplan_progress
		# ----- ----- -----
		# Считываем ID счета-фактуры (kodchfact)
		$_QRY1 = $db->sql("SELECT kodchfact FROM dognet_oplatachf WHERE id=" . $id)->fetchAll();
		# Считываем ID этапа (koddoc) по ID аванса (kodavans)
		$_QRY2 = $db->sql("SELECT kodkalplan FROM dognet_kalplanchf WHERE kodchfact=" . $_QRY1[0]['kodchfact'])->fetchAll();
		# -----
		# Суммируем все авансы по этапу ($_QRY2[0]['koddoc'])
		$_QRY_SUMAV = $db->sql("SELECT SUM(summaavans) as sum1 FROM dognet_docavans WHERE koddoc='" . $_QRY2[0]['kodkalplan'] . "' AND koddel<>'99'")->fetchAll();
		# -----
		# Суммируем все счета-фактуры по этапу ($_QRY2[0]['koddoc'])
		$_QRY_SUMCHF = $db->sql("SELECT SUM(chetfsumma) as sum1 FROM dognet_kalplanchf WHERE kodkalplan='" . $_QRY2[0]['kodkalplan'] . "' AND koddel<>'99'")->fetchAll();
		# -----
		# Суммируем все оплаты счетов-фактур по этапу ($_QRY2[0]['koddoc'])
		$_QRY_SUMOPLCHF = $db->sql("SELECT SUM(summaopl) as sum1 FROM dognet_oplatachf WHERE kodchfact IN (SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $_QRY2[0]['kodkalplan'] . " AND koddel<>'99') AND koddel<>'99'")->fetchAll();
		# -----
		# Суммируем все зачеты аванса по всем счетам-фактурам этапа ($_QRY2[0]['koddoc'])
		$_QRY_SUMOPLAV = $db->sql("SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodchfact IN (SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $_QRY2[0]['kodkalplan'] . " AND koddel<>'99') AND koddel<>'99'")->fetchAll();
		$db->update('dognet_dockalplan_progress', array(
			'sumoplchfstage'	=>	$_QRY_SUMOPLCHF[0]['sum1'],
			'zadolsum_av' 	=>	$_QRY_SUMAV[0]['sum1'] - $_QRY_SUMOPLAV[0]['sum1'],
			'zadolsum_chf'	=>	$_QRY_SUMCHF[0]['sum1'] - ($_QRY_SUMOPLCHF[0]['sum1'] + $_QRY_SUMOPLAV[0]['sum1'])
		), array('kodkalplan' => $_QRY2[0]['kodkalplan']));
		#
		$db->update('dognet_oplatachf', array(
			'kodkalplan' => $_QRY2[0]['kodkalplan']
		), array('id' => $id));
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		#
		#
		KALPLANCHF_PR_ZADOLG_CHF($db, "oplatachf", $id, $action_oplatachf, $__kodchfact);
		#
		#
		DOCBASE_PR_ZADOLG_DOC($db, "oplatachf", $id, $action_oplatachf, $__uniqueID, $__kodshab);
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
	if ($action_oplatachf == 'UPD') {
		#
		#
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		# ПЕРСЧИТЫВАЕМ СУММУ ЗАЧТЕННЫХ ОПЛАТ ПО ЭТАПУ
		# ДЛЯ ТАБЛИЦЫ ПРОГРЕССА ЭТАПОВ - dockalplan_progress
		# ----- ----- -----
		# Считываем ID счета-фактуры (kodchfact)
		$_QRY1 = $db->sql("SELECT kodoplata, kodchfact FROM dognet_oplatachf WHERE id=" . $id)->fetchAll();
		# Считываем ID этапа (koddoc) по ID аванса (kodavans)
		$_QRY2 = $db->sql("SELECT kodkalplan FROM dognet_kalplanchf WHERE kodchfact=" . $_QRY1[0]['kodchfact'])->fetchAll();
		# -----
		# Суммируем все авансы по этапу ($_QRY2[0]['koddoc'])
		$_QRY_SUMAV = $db->sql("SELECT SUM(summaavans) as sum1 FROM dognet_docavans WHERE koddoc='" . $_QRY2[0]['kodkalplan'] . "' AND koddel<>'99'")->fetchAll();
		# -----
		# Суммируем все счета-фактуры по этапу ($_QRY2[0]['koddoc'])
		$_QRY_SUMCHF = $db->sql("SELECT SUM(chetfsumma) as sum1 FROM dognet_kalplanchf WHERE kodkalplan='" . $_QRY2[0]['kodkalplan'] . "' AND koddel<>'99'")->fetchAll();
		# -----
		# Суммируем все оплаты счетов-фактур по этапу ($_QRY2[0]['koddoc'])
		$_QRY_SUMOPLCHF = $db->sql("SELECT SUM(summaopl) as sum1 FROM dognet_oplatachf WHERE kodchfact IN (SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $_QRY2[0]['kodkalplan'] . " AND koddel<>'99') AND koddel<>'99'")->fetchAll();
		# -----
		# Суммируем все зачеты аванса по всем счетам-фактурам этапа ($_QRY2[0]['koddoc'])
		$_QRY_SUMOPLAV = $db->sql("SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodchfact IN (SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $_QRY2[0]['kodkalplan'] . " AND koddel<>'99') AND koddel<>'99'")->fetchAll();
		$db->update('dognet_dockalplan_progress', array(
			'sumoplchfstage'	=>	$_QRY_SUMOPLCHF[0]['sum1'],
			'zadolsum_av' 	=>	$_QRY_SUMAV[0]['sum1'] - $_QRY_SUMOPLAV[0]['sum1'],
			'zadolsum_chf'	=>	$_QRY_SUMCHF[0]['sum1'] - ($_QRY_SUMOPLCHF[0]['sum1'] + $_QRY_SUMOPLAV[0]['sum1'])
		), array('kodkalplan' => $_QRY2[0]['kodkalplan']));
		#
		$db->update('dognet_oplatachf', array(
			'kodkalplan' => $_QRY2[0]['kodkalplan']
		), array('id' => $id));
		#
		#
		$_QRY_CHF = $db->sql("SELECT kodchfact, chetfnumber FROM dognet_kalplanchf WHERE kodchfact=" . $__kodchfact)->fetchAll();
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940001', '0000002', $id, $_QRY1[0]['kodoplata'], $__kodchfact, $_QRY[0]['kodkalplan']);
		#
		#
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		#
		#
		KALPLANCHF_PR_ZADOLG_CHF($db, "oplatachf", $id, $action_oplatachf, $__kodchfact);
		#
		#
		DOCBASE_PR_ZADOLG_DOC($db, "oplatachf", $id, $action_oplatachf, $__uniqueID, $__kodshab);
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
	if ($action_oplatachf == 'DEL') {
		#
		#
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		# ПЕРСЧИТЫВАЕМ СУММУ ЗАЧТЕННЫХ ОПЛАТ ПО ЭТАПУ
		# ДЛЯ ТАБЛИЦЫ ПРОГРЕССА ЭТАПОВ - dockalplan_progress
		# ----- ----- -----
		# Считываем ID счета-фактуры (kodchfact)
		$_QRY1 = $db->sql("SELECT * FROM dognet_oplatachf WHERE id=" . $id)->fetchAll();
		# Считываем ID этапа (koddoc) по ID аванса (kodavans)
		$_QRY2 = $db->sql("SELECT kodkalplan FROM dognet_kalplanchf WHERE kodchfact=" . $_QRY1[0]['kodchfact'])->fetchAll();
		# -----
		# Суммируем все авансы по этапу ($_QRY2[0]['koddoc'])
		$_QRY_SUMAV = $db->sql("SELECT SUM(summaavans) as sum1 FROM dognet_docavans WHERE koddoc='" . $_QRY2[0]['kodkalplan'] . "' AND koddel<>'99'")->fetchAll();
		# -----
		# Суммируем все счета-фактуры по этапу ($_QRY2[0]['koddoc'])
		$_QRY_SUMCHF = $db->sql("SELECT SUM(chetfsumma) as sum1 FROM dognet_kalplanchf WHERE kodkalplan='" . $_QRY2[0]['kodkalplan'] . "' AND koddel<>'99'")->fetchAll();
		# -----
		# Суммируем все оплаты счетов-фактур по этапу ($_QRY2[0]['koddoc'])
		$_QRY_SUMOPLCHF = $db->sql("SELECT SUM(summaopl) as sum1 FROM dognet_oplatachf WHERE kodchfact IN (SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $_QRY2[0]['kodkalplan'] . " AND koddel<>'99') AND koddel<>'99'")->fetchAll();
		# -----
		# Суммируем все зачеты аванса по всем счетам-фактурам этапа ($_QRY2[0]['koddoc'])
		$_QRY_SUMOPLAV = $db->sql("SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodchfact IN (SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $_QRY2[0]['kodkalplan'] . " AND koddel<>'99') AND koddel<>'99'")->fetchAll();
		$db->update('dognet_dockalplan_progress', array(
			'sumoplchfstage'	=>	$_QRY_SUMOPLCHF[0]['sum1'] - $_QRY1[0]['summaopl'],
			'zadolsum_av' 	=>	$_QRY_SUMAV[0]['sum1'] - $_QRY_SUMOPLAV[0]['sum1'],
			'zadolsum_chf'	=>	$_QRY_SUMCHF[0]['sum1'] - ($_QRY_SUMOPLCHF[0]['sum1'] + $_QRY_SUMOPLAV[0]['sum1'] - $_QRY1[0]['summaopl'])
		), array('kodkalplan' => $_QRY2[0]['kodkalplan']));
		#
		#
		$_QRY_CHF = $db->sql("SELECT chetfnumber FROM dognet_kalplanchf WHERE kodchfact=" . $__kodchfact)->fetchAll();
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940001', '0000003', $id, $_QRY1[0]['kodoplata'], $__kodchfact, $_QRY[0]['kodkalplan']);
		#
		#
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		#
		#
		KALPLANCHF_PR_ZADOLG_CHF($db, "oplatachf", $id, $action_oplatachf, $__kodchfact);
		#
		#
		DOCBASE_PR_ZADOLG_DOC($db, "oplatachf", $id, $action_oplatachf, $__uniqueID, $__kodshab);
		#
		#
	}
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Вытаскиваем идентификатор валюты договора
#
$query1 = mysqlQuery("SELECT koddened FROM dognet_docbase WHERE koddoc=" . $_UNIQUEID);
$row1 = mysqli_fetch_assoc($query1);
$__koddened = $row1['koddened'];
$query2 = mysqlQuery("SELECT html_code FROM dognet_spdened WHERE koddened=" . $__koddened);
$row2 = mysqli_fetch_assoc($query2);
$__dened = $row2['html_code'];
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Example PHP implementation used for the index.html example
#
# DataTables PHP library
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/_datatables-php-api-editor/DataTables.php");
# Alias Editor classes so they are easy to use
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
if (!isset($_POST['kodchfact']) || !is_numeric($_POST['kodchfact'])) {
	echo json_encode(["data" => []]);
} else {
	$kodchfact = $_POST['kodchfact'];
	$kodkalplan = $_POST['kodkalplan'];
	#
	#
	if ($_KODSHAB == "1" || $_KODSHAB == "3") {
		#
		#
		// Build our Editor instance and process the data coming from _POST
		Editor::inst($db, 'dognet_oplatachf')
			->fields(
				Field::inst('dognet_oplatachf.id'),
				Field::inst('dognet_oplatachf.comment'),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_oplatachf.kodchfact')
					->options(
						Options::inst()
							->table('dognet_kalplanchf')
							->value('kodchfact')
							->label(array('kodkalplan', 'kodchfact', 'chetfnumber', 'chetfdate'))
							->render(function ($row) use ($kodkalplan) {
								return ("Счет-фактура : " . $row['chetfnumber']);
							})
							->where(function ($q) use ($kodkalplan) {
								$q->where('kodkalplan', $kodkalplan, '=');
							})
					),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_oplatachf.kodoplata'),
				Field::inst('dognet_oplatachf.dateopl')
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
				Field::inst('dognet_oplatachf.summaopl'),
				Field::inst('dognet_kalplanchf.kodkalplan'),
				Field::inst('dognet_dockalplan.kodkalplan'),
				Field::inst('dognet_docbase.koddoc'),
				Field::inst('dognet_docbase.koddened'),
				Field::inst('dognet_spdened.html_code'),
				Field::inst('dognet_spdened.short_code')
			)
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			->on('postCreate', function ($editor_oplatachf, $id, $values, $row) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
				updateFields_oplatachf($editor_oplatachf->db(), 'CRT', $id, $values, $row, $kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID);
			})
			->on('postEdit', function ($editor_oplatachf, $id, $values, $row) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
				updateFields_oplatachf($editor_oplatachf->db(), 'UPD', $id, $values, $row, $kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID);
			})
			->on('preRemove', function ($editor_oplatachf, $id, $values) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
				updateFields_oplatachf($editor_oplatachf->db(), 'DEL', $id, $values, null, $kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID);
			})
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			->leftJoin('dognet_kalplanchf', 'dognet_kalplanchf.kodchfact', '=', 'dognet_oplatachf.kodchfact')
			->leftJoin('dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_kalplanchf.kodkalplan')
			->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
			->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
			->where('dognet_kalplanchf.kodchfact', $kodchfact)
			->process($_POST)
			->json();
		#
		#
	}
	#
	#
	if ($_KODSHAB == "2" || $_KODSHAB == "4") {
		#
		#
		// Build our Editor instance and process the data coming from _POST
		Editor::inst($db, 'dognet_oplatachf')
			->fields(
				Field::inst('dognet_oplatachf.id'),
				Field::inst('dognet_oplatachf.comment'),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_oplatachf.kodchfact')
					->options(
						Options::inst()
							->table('dognet_kalplanchf')
							->value('kodchfact')
							->label(array('kodkalplan', 'kodchfact', 'chetfnumber', 'chetfdate'))
							->render(function ($row) use ($kodkalplan) {
								return ("Счет-фактура : " . $row['chetfnumber']);
							})
							->where(function ($q) use ($kodkalplan) {
								$q->where('kodkalplan', $kodkalplan, '=');
							})
					),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_oplatachf.kodoplata'),
				Field::inst('dognet_oplatachf.dateopl')
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
				Field::inst('dognet_oplatachf.summaopl'),
				Field::inst('dognet_kalplanchf.kodkalplan'),
				Field::inst('dognet_docbase.koddoc'),
				Field::inst('dognet_docbase.koddened'),
				Field::inst('dognet_spdened.html_code'),
				Field::inst('dognet_spdened.short_code')
			)
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			->on('postCreate', function ($editor_oplatachf, $id, $values, $row) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
				updateFields_oplatachf($editor_oplatachf->db(), 'CRT', $id, $values, $row, $kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID);
			})
			->on('postEdit', function ($editor_oplatachf, $id, $values, $row) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
				updateFields_oplatachf($editor_oplatachf->db(), 'UPD', $id, $values, $row, $kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID);
			})
			->on('preRemove', function ($editor_oplatachf, $id, $values) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
				updateFields_oplatachf($editor_oplatachf->db(), 'DEL', $id, $values, null, $kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID);
			})
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			->leftJoin('dognet_kalplanchf', 'dognet_kalplanchf.kodchfact', '=', 'dognet_oplatachf.kodchfact')
			->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_kalplanchf.kodkalplan')
			->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
			->where('dognet_kalplanchf.kodchfact', $kodchfact)
			->process($_POST)
			->json();
		#
		#
	}
	#
	#
}
