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
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- -----
function updateFields($db, $action, $id, $values) {
	$__koddoc = $_SESSION['uniqueID'];
	if ($action == 'CRT') {
		$__nextKodkalplan = nextKodkalplan();
		$db->update('dognet_dockalplan', array(
			'kodkalplan'			=>	$__nextKodkalplan,
			'koddoc'				=>	$__koddoc
		), array('id' => $id));

		$_QRY = $db->sql("SELECT * FROM dognet_dockalplan WHERE id=" . $id)->fetchAll();
		// Добавляем этап в таблицу прогресса
		# -----
		$expiry_date = "";
		if ($_QRY[0]['idsrokstage'] == 1) {
			$srokstage = $_QRY[0]['srokstage_date'];
			$expiry_date = $_QRY[0]['srokstage_date'];
		} elseif ($_QRY[0]['idsrokstage'] == 0 && $_QRY[0]['srokstage'] != "") {
			$srokstage = $_QRY[0]['srokstage'];
			$_QRY_AV = $db->sql("SELECT MIN(dateavans) as firstavans FROM dognet_docavans WHERE koddoc=" . $_QRY[0]['kodkalplan'] . " LIMIT 1")->fetchAll();
			if ($_QRY_AV[0]['firstavans'] != "") {
				$dateavans = new DateTime($_QRY_AV[0]['firstavans']);
				$firstavans = $dateavans->format('Y-m-d');
				if (is_string($srokstage)) {
					$srokdays = (int)$srokstage;
				}
				$expiry_date = $dateavans->add(new DateInterval('P' . $srokdays . 'D'))->format('Y-m-d');
			} else {
				$expiry_date = "";
			}
		}
		# -----
		$db->insert('dognet_dockalplan_progress', array(
			'koddoc'			=>	$_QRY[0]['koddoc'],
			'kodkalplan'		=>	$_QRY[0]['kodkalplan'],
			'stagecreated'		=>	date("Y-m-d"),
			'idsrokstage'		=>	$_QRY[0]['idsrokstage'],
			'srokstage'			=>	$srokstage,
			'srokstage_date'	=>	$expiry_date,
			'idsrokopl'			=>	$_QRY[0]['idsrokopl'],
			'srokopl'			=>	$_QRY[0]['srokopl'],
			'dateplan'			=>	$_QRY[0]['dateplan'],
			'numberdayoplstage'	=>	$_QRY[0]['numberdayoplstage'],
			'dateoplall'		=>	$_QRY[0]['dateoplall'],
			'summastage'		=>	$_QRY[0]['summastage'],
			'sumchfstage'		=>	'',
			'sumavstage'		=>	'',
			'sumoplchfstage'	=>	'',
			'sumoplavstage'		=>	''
		));

		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940200', '0000001', $id, $__nextKodkalplan, $_QRY[0]['numberstage'], null);
	}
	#
	#
	if ($action == 'UPD') {

		$_QRY = $db->sql("SELECT * FROM dognet_dockalplan WHERE id=" . $id)->fetchAll();
		if ($_QRY[0]['idsrokstage'] != 1) {
			$db->update('dognet_dockalplan', array(
				'srokstage_date' => null
			), array('id' => $id));
		}
		# -----
		# Суммируем все счета-фактуры по этапу ($_QRY2[0]['koddoc'])
		$_QRY_SUMCHF = $db->sql("SELECT SUM(chetfsumma) as sum1 FROM dognet_kalplanchf WHERE kodkalplan='" . $_QRY[0]['kodkalplan'] . "' AND koddel<>'99'")->fetchAll();
		# -----
		$expiry_date = "";
		if ($_QRY[0]['idsrokstage'] == 1) {
			$srokstage = $_QRY[0]['srokstage_date'];
			$expiry_date = $_QRY[0]['srokstage_date'];
		} elseif ($_QRY[0]['idsrokstage'] == 0 && $_QRY[0]['srokstage'] != "") {
			$srokstage = $_QRY[0]['srokstage'];
			$_QRY_AV = $db->sql("SELECT MIN(dateavans) as firstavans FROM dognet_docavans WHERE koddoc=" . $_QRY[0]['kodkalplan'] . " LIMIT 1")->fetchAll();
			if ($_QRY_AV[0]['firstavans'] != "") {
				$dateavans = new DateTime($_QRY_AV[0]['firstavans']);
				$firstavans = $dateavans->format('Y-m-d');
				if (is_string($srokstage)) {
					$srokdays = (int)$srokstage;
				}
				$expiry_date = $dateavans->add(new DateInterval('P' . $srokdays . 'D'))->format('Y-m-d');
			} else {
				$expiry_date = "";
			}
		}
		# -----
		// Обновляем этап в таблице прогресса
		$db->update('dognet_dockalplan_progress', array(
			'idsrokstage'		=>	$_QRY[0]['idsrokstage'],
			'srokstage'			=>	$srokstage,
			'srokstage_date'	=>	$expiry_date,
			'idsrokopl'			=>	$_QRY[0]['idsrokopl'],
			'srokopl'			=>	$_QRY[0]['srokopl'],
			'dateplan'			=>	$_QRY[0]['dateplan'],
			'numberdayoplstage'	=>	$_QRY[0]['numberdayoplstage'],
			'dateoplall'		=>	$_QRY[0]['dateoplall'],
			'summastage'		=>	$_QRY[0]['summastage'],
			'zadolsum_stage'	=>	$_QRY[0]['summastage'] - $_QRY_SUMCHF[0]['sum1']
		), array('kodkalplan' => $_QRY[0]['kodkalplan']));

		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940200', '0000002', $id, null, null, null);
	}
	#
	#
	if ($action == 'DEL') {
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940200', '0000003', $id, null, null, null);
	}
	#
	#
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- -----
function removeProgress($db, $id, $values) {
	$_QRY1 = $db->sql("SELECT kodkalplan FROM dognet_dockalplan WHERE id=" . $id)->fetchAll();
	$_QRY2 = $db->sql("DELETE FROM dognet_dockalplan_progress WHERE kodkalplan=" . $_QRY1[0]['kodkalplan']);
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$__uniqueID = $_SESSION['uniqueID'];
// $__uniqueID = "245847329098834";
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
Editor::inst($db, 'dognet_dockalplan')
	->fields(
		Field::inst('dognet_docbase.koddel'),
		Field::inst('dognet_dockalplan.kodkalplan'),
		Field::inst('dognet_dockalplan.numberstage'),
		Field::inst('dognet_dockalplan.nameshotstage'),
		Field::inst('dognet_dockalplan.namefullstage'),
		Field::inst('dognet_dockalplan.summastage'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_dockalplan.srokstage'),
		Field::inst('dognet_dockalplan.srokstage_date')
			->validator(Validate::dateFormat(
				'd/m/Y',
				ValidateOptions::inst()
					->allowEmpty(true)
			))
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd/m/Y'
			))
			->setFormatter(Format::datetime(
				'd/m/Y',
				'Y-m-d'
			)),
		Field::inst('dognet_dockalplan.idsrokstage'),
		Field::inst('dognet_dockalplan.srokopl'),
		Field::inst('dognet_dockalplan.idsrokopl'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_dockalplan.useav1plan'),
		Field::inst('dognet_dockalplan.pravplan1stage'),
		Field::inst('dognet_dockalplan.dateplanav1stage')
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
		Field::inst('dognet_dockalplan.useav2plan'),
		Field::inst('dognet_dockalplan.pravplan2stage'),
		Field::inst('dognet_dockalplan.dateplanav2stage')
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
		Field::inst('dognet_dockalplan.useav3plan'),
		Field::inst('dognet_dockalplan.pravplan3stage'),
		Field::inst('dognet_dockalplan.dateplanav3stage')
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
		Field::inst('dognet_dockalplan.useav4plan'),
		Field::inst('dognet_dockalplan.pravplan4stage'),
		Field::inst('dognet_dockalplan.dateplanav4stage')
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
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_dockalplan.numberdayoplstage'),
		Field::inst('dognet_dockalplan.dateplan')
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
		Field::inst('dognet_dockalplan.dateoplall')
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
		Field::inst('dognet_dockalplan.usedocsubpodr'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('sp_objects.nameobjectshot'),
		Field::inst('dognet_dockalplan.kodobject')
			->options(
				Options::inst()
					->table('sp_objects')
					->value('kodobject')
					->label(array('kodobject', 'nameobjectshot'))
					->order('nameobjectshot asc')
					->render(function ($row) {
						return $row['nameobjectshot'];
					})
					->where(function ($q) {
						$q->where('koddel', '99', '<>');
						$q->where('useindog', '1');
						$q->where('nameobjectshot', '', '<>');
					})
			)
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Объект обязателен')
			)),
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
	->on('preGet', function ($editor, $id) use ($__uniqueID) {
		$editor->where(function ($q) use ($__uniqueID) {
			$q->where('dognet_dockalplan.koddoc', $__uniqueID);
			$q->and_where('dognet_dockalplan.koddel', '99', '!=');
		});
	})
	//
	->on('postCreate', function ($editor, $id, $values, $row) {
		updateFields($editor->db(), 'CRT', $id, $values);
	})
	->on('postEdit', function ($editor, $id, $values, $row) {
		updateFields($editor->db(), 'UPD', $id, $values);
	})
	->on('preRemove', function ($editor, $id, $values) {
		removeProgress($editor->db(), $id, $values);
		updateFields($editor->db(), 'DEL', $id, $values);
	})
	->on('postRemove', function ($editor, $id, $values) {
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
	->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
	->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_dockalplan.kodobject')
	->process($_POST)
	->json();
