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


if ((!isset($_POST['usekodavans']) || !is_numeric($_POST['usekodavans'])) && ($_POST['useavans'] == 0)) {
	$_USEKODAVANS = "";
	$_USEAVANS = 0;
} else {
	$_USEKODAVANS = $_POST['usekodavans'];
	$_USEAVANS = 1;
}
if ($_POST['useavans'] == 0) {
	$_USEAVANS = 0;
} else {
	$_USEAVANS = 1;
}


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
function nextKodchfavans() {
	$query = mysqlQuery("SELECT MAX(kodchfavans) as lastKod FROM dognet_chfavans ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 9);
	return $nextKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция формирования нового ID счета-фактуры (kodchfact)
# для таблицы этапов 'dognet_kalplanchf'
#
function nextKodchfact() {
	$query = mysqlQuery("SELECT MAX(kodchfact) as lastKod FROM dognet_kalplanchf ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function updateFields_kalplanchf($db, $action_kalplanchf, $id, $values, $__kodshab, $__uniqueID, $__usekodavans, $__useavans) {
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "НОВЫЙ СЧЕТ"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_kalplanchf == 'CRT') {
		#
		#
		// Формируем новый идентификатор счета-фактуры (kodchfact)
		$__nextKodchfact = nextKodchfact();
		$db->update('dognet_kalplanchf', array(
			'kodchfact'			=>	$__nextKodchfact,
			'kodusechf'			=>	0,
			'koddel'			=>	""
		), array('id' => $id));
		#
		#
		$_QRY = $db->sql("SELECT chetfnumber, chetfdate, kodkalplan FROM dognet_kalplanchf WHERE id=" . $id)->fetchAll();
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940010', '0000001', $id, $__nextKodchfact, $_QRY[0]['chetfnumber'], $_QRY[0]['kodkalplan']);
		#
		#
		// Правка от 27.04.21
		// Датой зачета аванса (dateoplav) теперь фиксируется не текущая дата (NOW), а дата СФ (chetfdate)

		$__sumzachet = 0.0;
		if (!empty($__usekodavans) && $__usekodavans != "nozachet" && $__usekodavans != "zachetall" && $__useavans) {
			$__nextKodchfavans = nextKodchfavans();
			$__sumzachet = $values['usesumzachet'];
			$__kodkalplan = $_QRY[0]['kodkalplan'];
			$__chefdate = date("Y-m-d", strtotime($_QRY[0]['chetfdate'])); // правка от 27.04.21
			$_QRY_INSERT = mysqlQuery("INSERT INTO dognet_chfavans (kodchfavans, kodkalplan, kodchfact, kodavans, koddel, dateoplav, summaoplav) VALUES ({$__nextKodchfavans}, {$__kodkalplan}, {$__nextKodchfact}, {$__usekodavans}, '', '{$__chefdate}', {$__sumzachet})");
		} elseif (!empty($__usekodavans) && $__usekodavans == "zachetall" && $__useavans) {
			$__kodkalplan = $_QRY[0]['kodkalplan'];
			$__chefdate = date("Y-m-d", strtotime($_QRY[0]['chetfdate'])); // правка от 27.04.21
			$_QRY_ostAllAv = mysqlQuery("SELECT kodavans, ostatokavans FROM dognet_docavans WHERE koddoc = {$__kodkalplan} AND ostatokavans > '0'");
			while ($_ROW_ostAllAv = mysqli_fetch_array($_QRY_ostAllAv)) {
				$__nextKodchfavans = nextKodchfavans();
				$__kodavans = $_ROW_ostAllAv['kodavans'];
				$__sumzachet = $_ROW_ostAllAv['ostatokavans'];
				$_QRY_INSERT = mysqlQuery("INSERT INTO dognet_chfavans (kodchfavans, kodkalplan, kodchfact, kodavans, koddel, dateoplav, summaoplav) VALUES ({$__nextKodchfavans}, {$__kodkalplan}, {$__nextKodchfact}, {$__kodavans}, '', '{$__chefdate}', {$__sumzachet})");
			}
		}
		if ($__kodshab == '1' || $__kodshab == '3') {
			#
			#
			# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			# ПЕРСЧИТЫВАЕМ СУММУ СЧЕТОВ-ФАКТУР ПО ЭТАПУ
			# ДЛЯ ТАБЛИЦЫ ПРОГРЕССА ЭТАПОВ - dockalplan_progress
			# ----- ----- -----
			# Считываем ID счета-фактуры (kodchfact)
			$_QRY2 = $db->sql("SELECT kodkalplan FROM dognet_kalplanchf WHERE id=" . $id)->fetchAll();
			$_QRY_SUMSTAGE = $db->sql("SELECT summastage FROM dognet_dockalplan WHERE kodkalplan=" . $_QRY2[0]['kodkalplan'])->fetchAll();
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
				'sumchfstage'	=>	$_QRY_SUMCHF[0]['sum1'],
				'sumoplchfstage'	=>	$_QRY_SUMOPLCHF[0]['sum1'],
				'sumoplavstage'	=>	$_QRY_SUMOPLAV[0]['sum1'],
				'zadolsum_stage' 	=>	$_QRY_SUMSTAGE[0]['summastage'] - $_QRY_SUMCHF[0]['sum1'],
				'zadolsum_chf'	=>	$_QRY_SUMCHF[0]['sum1'] - ($_QRY_SUMOPLCHF[0]['sum1'] + $_QRY_SUMOPLAV[0]['sum1']),
				'zadolsum_av' 	=>	$_QRY_SUMAV[0]['sum1'] - $_QRY_SUMOPLAV[0]['sum1']
			), array('kodkalplan' => $_QRY2[0]['kodkalplan']));
		}
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		#
		#
		KALPLANCHF_PR_ZADOLG_CHF($db, "kalplanchf", $id, $action_kalplanchf, NULL);
		DOCBASE_PR_ZADOLG_DOC($db, "kalplanchf", $id, $action_kalplanchf, $__uniqueID, $__kodshab);
		#
		#
		if (!empty($__usekodavans) && $__usekodavans != "nozachet" && $__useavans) {
			$_QRY_CHFAV = $db->sql("SELECT id FROM dognet_chfavans WHERE kodchfavans=" . $__nextKodchfavans)->fetchAll();
			DOCAVANS_PR_OSTATOK_DOC($db, "chfavans", $_QRY_CHFAV[0]['id'], $action_kalplanchf);
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
	if ($action_kalplanchf == 'UPD') {
		#
		#
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		# ПЕРСЧИТЫВАЕМ СУММУ СЧЕТОВ-ФАКТУР ПО ЭТАПУ
		# ДЛЯ ТАБЛИЦЫ ПРОГРЕССА ЭТАПОВ - dockalplan_progress
		# ----- ----- -----
		# Считываем ID счета-фактуры (kodchfact)
		$_QRY2 = $db->sql("SELECT kodchfact, kodkalplan, chetfnumber FROM dognet_kalplanchf WHERE id=" . $id)->fetchAll();
		$_QRY_SUMSTAGE = $db->sql("SELECT summastage FROM dognet_dockalplan WHERE kodkalplan=" . $_QRY2[0]['kodkalplan'])->fetchAll();
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
			'sumchfstage'	=>	$_QRY_SUMCHF[0]['sum1'],
			'sumoplchfstage'	=>	$_QRY_SUMOPLCHF[0]['sum1'],
			'sumoplavstage'	=>	$_QRY_SUMOPLAV[0]['sum1'],
			'zadolsum_stage' 	=>	$_QRY_SUMSTAGE[0]['summastage'] - $_QRY_SUMCHF[0]['sum1'],
			'zadolsum_chf'	=>	$_QRY_SUMCHF[0]['sum1'] - ($_QRY_SUMOPLCHF[0]['sum1'] + $_QRY_SUMOPLAV[0]['sum1']),
			'zadolsum_av' 	=>	$_QRY_SUMAV[0]['sum1'] - $_QRY_SUMOPLAV[0]['sum1']
		), array('kodkalplan' => $_QRY2[0]['kodkalplan']));
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		#
		#
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940010', '0000002', $id, $_QRY2[0]['kodchfact'], $_QRY2[0]['chetfnumber'], $_QRY2[0]['kodkalplan']);
		#
		#
		KALPLANCHF_PR_ZADOLG_CHF($db, "kalplanchf", $id, $action_kalplanchf, NULL);
		DOCBASE_PR_ZADOLG_DOC($db, "kalplanchf", $id, $action_kalplanchf, $__uniqueID, $__kodshab);
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
	if ($action_kalplanchf == 'DEL') {
		#
		#
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940010', '0000003', $id, null, null, null);
		#
		#
		// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
		$_QRY_1 = $db->sql("SELECT * FROM dognet_kalplanchf WHERE id=" . $id)->fetchAll();
		if ($_QRY_1) {
			$__kodchfact = $_QRY_1[0]['kodchfact'];
			$_QRY_DEL1 = $db->sql("DELETE FROM dognet_kalplanchf_zadol WHERE kodchfact=" . $__kodchfact);
			$_QRY_DEL2 = $db->sql("DELETE FROM dognet_oplatachf WHERE kodchfact=" . $__kodchfact);
			#
			#
			# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			# ПЕРСЧИТЫВАЕМ СУММУ СЧЕТОВ-ФАКТУР ПО ЭТАПУ
			# ДЛЯ ТАБЛИЦЫ ПРОГРЕССА ЭТАПОВ - dockalplan_progress
			# ----- ----- -----
			# Считываем ID счета-фактуры (kodchfact)
			$_QRY2 = $db->sql("SELECT * FROM dognet_kalplanchf WHERE id=" . $id)->fetchAll();
			$_QRY_SUMSTAGE = $db->sql("SELECT summastage FROM dognet_dockalplan WHERE kodkalplan=" . $_QRY2[0]['kodkalplan'])->fetchAll();
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
			#
			#
			DOCAVANS_PR_OSTATOK_DOC($db, "kalplanchf_test", $id, $action_kalplanchf);
			$_QRY_DEL3 = $db->sql("DELETE FROM dognet_chfavans WHERE kodchfact=" . $__kodchfact);
			#
			#
			# -----
			# Суммируем все зачеты аванса по всем счетам-фактурам этапа ($_QRY2[0]['koddoc'])
			$_QRY_SUMOPLAV = $db->sql("SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodchfact IN (SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=" . $_QRY2[0]['kodkalplan'] . " AND koddel<>'99') AND koddel<>'99'")->fetchAll();
			$db->update('dognet_dockalplan_progress', array(
				'sumchfstage'		=>	$_QRY_SUMCHF[0]['sum1'] - $_QRY2[0]['chetfsumma'],
				'sumoplchfstage'	=>	$_QRY_SUMOPLCHF[0]['sum1'],
				'sumoplavstage'		=>	$_QRY_SUMOPLAV[0]['sum1'],
				'zadolsum_stage' 	=>	$_QRY_SUMSTAGE[0]['summastage'] - $_QRY_SUMCHF[0]['sum1'] + $_QRY2[0]['chetfsumma'],
				'zadolsum_chf'	=>	$_QRY_SUMCHF[0]['sum1'] - ($_QRY_SUMOPLCHF[0]['sum1'] + $_QRY_SUMOPLAV[0]['sum1']) - $_QRY2[0]['chetfsumma'],
				'zadolsum_av' 	=>	$_QRY_SUMAV[0]['sum1'] - $_QRY_SUMOPLAV[0]['sum1']
			), array('kodkalplan' => $_QRY2[0]['kodkalplan']));
			# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			#
			#
			KALPLANCHF_PR_ZADOLG_CHF($db, "kalplanchf", $id, $action_kalplanchf, NULL);
			DOCBASE_PR_ZADOLG_DOC($db, "kalplanchf", $id, $action_kalplanchf, $__uniqueID, $__kodshab);
			#
			#
		}
	}
	#
	#
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Вытаскиваем идентификатор валюты договора
#
$query1 = mysqlQuery("SELECT koddened FROM dognet_docbase WHERE koddoc=" . $_UNIQUEID);
$row1 = mysqli_fetch_assoc($query1);
$__koddened = !empty($row1['koddened']) ? $row1['koddened'] : "";
$query2 = mysqlQuery("SELECT html_code FROM dognet_spdened WHERE koddened=" . $__koddened);
$row2 = mysqli_fetch_assoc($query2);
$__dened = $row2['html_code'];
#
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
if ($_KODSHAB == "1" or $_KODSHAB == "3") {
	#
	#
	# Build our Editor instance and process the data coming from _POST
	Editor::inst($db, 'dognet_kalplanchf')
		->fields(
			Field::inst('dognet_kalplanchf.kodchfact'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_kalplanchf.kodkalplan')
				->options(
					Options::inst()
						->table('dognet_dockalplan')
						->value('kodkalplan')
						->label(array('kodkalplan', 'numberstage', 'nameshotstage', 'summastage'))
						->render(function ($row) {
							return "Этап " . $row['numberstage'] . " : " . $row['nameshotstage'] . " : " . number_format((float)($row['summastage']), 2, '.', ' ') . " руб.";
						})
						->where(function ($q) use ($_UNIQUEID) {
							$q->where('koddoc', $_UNIQUEID, '=');
							$q->and_where('koddel', '99', '!=');
						})
				)
				->validator(Validate::notEmpty(
					ValidateOptions::inst()
						->message('Объект обязателен')
				)),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_kalplanchf.chetfnumber'),
			Field::inst('dognet_kalplanchf.chetfdate')
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
			Field::inst('dognet_kalplanchf.chetfsumma'),
			Field::inst('dognet_kalplanchf.comment'),
			Field::inst('dognet_kalplanchf_zadol.chetfsumzadol'),
			Field::inst('dognet_dockalplan.koddoc'),
			Field::inst('dognet_dockalplan.kodkalplan'),
			Field::inst('dognet_dockalplan.nameshotstage'),
			Field::inst('dognet_dockalplan.numberstage'),
			Field::inst('dognet_dockalplan.summastage'),
			Field::inst('dognet_dockalplan.srokstage'),
			Field::inst('dognet_dockalplan.dateplan'),
			Field::inst('dognet_docbase.koddened'),
			Field::inst('dognet_docbase.kodshab'),
			Field::inst('dognet_docbase.docnumber'),
			Field::inst('dognet_spdened.koddened'),
			Field::inst('dognet_spdened.html_code'),
			Field::inst('dognet_spdened.short_code')
		)
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->on('preGet', function ($editor_kalplanchf, $id) use ($_UNIQUEID) {
			$editor_kalplanchf->where(function ($q) use ($_UNIQUEID) {
				$q->where('dognet_kalplanchf.koddel', '99', '!=');
			});
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->on('postCreate', function ($editor_kalplanchf, $id, $values, $row) use ($_KODSHAB, $_UNIQUEID, $_USEKODAVANS, $_USEAVANS) {
			updateFields_kalplanchf($editor_kalplanchf->db(), 'CRT', $id, $values, $_KODSHAB, $_UNIQUEID, $_USEKODAVANS, $_USEAVANS);
		})
		->on('postEdit', function ($editor_kalplanchf, $id, $values, $row) use ($_KODSHAB, $_UNIQUEID, $_USEKODAVANS, $_USEAVANS) {
			updateFields_kalplanchf($editor_kalplanchf->db(), 'UPD', $id, $values, $_KODSHAB, $_UNIQUEID, $_USEKODAVANS, $_USEAVANS);
		})
		->on('preRemove', function ($editor_kalplanchf, $id, $values) use ($_KODSHAB, $_UNIQUEID) {
			updateFields_kalplanchf($editor_kalplanchf->db(), 'DEL', $id, $values, $_KODSHAB, $_UNIQUEID, null, null);
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->leftJoin('dognet_kalplanchf_zadol', 'dognet_kalplanchf_zadol.kodchfact', '=', 'dognet_kalplanchf.kodchfact')
		->leftJoin('dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_kalplanchf.kodkalplan')
		->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
		->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
		->join(
			Mjoin::inst('dognet_oplatachf')
				->link('dognet_oplatachf.kodchfact', 'dognet_kalplanchf.kodchfact')
				->field(
					Field::inst('kodchfact')
				)
		)
		->where('dognet_dockalplan.koddoc', $_UNIQUEID)
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->process($_POST)
		->json();
	#
	#
}
#
#
if ($_KODSHAB == "2" or $_KODSHAB == "4") {
	//
	//
	// Build our Editor instance and process the data coming from _POST
	Editor::inst($db, 'dognet_kalplanchf')
		->fields(
			Field::inst('dognet_kalplanchf.kodchfact'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_kalplanchf.kodkalplan')
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
			Field::inst('dognet_kalplanchf.chetfnumber'),
			Field::inst('dognet_kalplanchf.chetfdate')
				->set(Field::SET_EDIT)
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
			Field::inst('dognet_kalplanchf.chetfsumma'),
			Field::inst('dognet_kalplanchf.comment'),
			Field::inst('dognet_kalplanchf_zadol.chetfsumzadol'),
			Field::inst('dognet_docbase.koddened'),
			Field::inst('dognet_docbase.kodshab'),
			Field::inst('dognet_docbase.docnumber'),
			Field::inst('dognet_spdened.koddened'),
			Field::inst('dognet_spdened.html_code'),
			Field::inst('dognet_spdened.short_code')
		)
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->on('preGet', function ($editor, $id) use ($_UNIQUEID) {
			$editor->where(function ($q) use ($_UNIQUEID) {
				$q->where('dognet_kalplanchf.koddel', '99', '!=');
			});
		})
		//
		->on('postCreate', function ($editor, $id, $values, $row) use ($_KODSHAB, $_UNIQUEID, $_USEKODAVANS, $_USEAVANS) {
			updateFields_kalplanchf($editor->db(), 'CRT', $id, $values, $_KODSHAB, $_UNIQUEID, $_USEKODAVANS, $_USEAVANS);
		})
		->on('postEdit', function ($editor, $id, $values, $row) use ($_KODSHAB, $_UNIQUEID, $_USEKODAVANS, $_USEAVANS) {
			updateFields_kalplanchf($editor->db(), 'UPD', $id, $values, $_KODSHAB, $_UNIQUEID, $_USEKODAVANS, $_USEAVANS);
		})
		->on('preRemove', function ($editor, $id, $values) use ($_KODSHAB, $_UNIQUEID) {
			updateFields_kalplanchf($editor->db(), 'DEL', $id, $values, $_KODSHAB, $_UNIQUEID, null, null);
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->leftJoin('dognet_kalplanchf_zadol', 'dognet_kalplanchf_zadol.kodchfact', '=', 'dognet_kalplanchf.kodchfact')
		->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_kalplanchf.kodkalplan')
		->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
		->join(
			Mjoin::inst('dognet_oplatachf')
				->link('dognet_oplatachf.kodchfact', 'dognet_kalplanchf.kodchfact')
				->field(
					Field::inst('kodchfact')
				)
		)
		->join(
			Mjoin::inst('dognet_docavans')
				->link('dognet_docavans.koddoc', 'dognet_kalplanchf.kodkalplan')
				->field(
					Field::inst('koddoc')
				)
		)
		->where('dognet_kalplanchf.kodkalplan', $_UNIQUEID)
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->process($_POST)
		->json();
	//
	//
}
#
#