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
# Функция определения нового ID договора ( koddoc)
# для таблицы этапов 'dognet_docbase'
# ----- ----- -----
function nextKoddoc() {
	$query = mysqlQuery("SELECT MAX(koddoc) as lastKod FROM dognet_docbase ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function updateFields_docbase($db, $action_docbase, $id, $values) {
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "НОВЫЙ ДОГОВОР"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_docbase == 'CRT') {
		#
		#
		// Формируем новый идентификатор договора (koddoc)
		$__nextKoddoc = nextKoddoc();
		#
		#
		$_QRY = $db->sql("SELECT koddoc, kodshab, docnumber, usedoczayv, kodblankwork, daynachdoc, monthnachdoc, yearnachdoc, kodobject, kodzakaz, kodagent FROM dognet_docbase WHERE id=" . $id)->fetchAll();  // CorrectionID#20240318-01
		#
		# >>>>> CorrectionID#20230520-01
		# Правка от 20.05.2023 
		# 1. Добавляем сохранение названий объектов (nameobjectshort, nameobjectfull) для реализации полнотекстового поиска
		# 2. Добавляем сохранение названий объектов (namecontrshort, namecontrfull) для реализации полнотекстового поиска
		# >>>>> CorrectionID#20240318-01
		# Правка от 18.03.2024 
		# 1. Добавляем сохранение названий агентов (namecontrshort, namecontrfull) для реализации полнотекстового поиска
		$_QRY_OBJ = $db->sql("SELECT nameobjectshot, nameobjectlong FROM sp_objects WHERE kodobject=" . $_QRY[0]['kodobject'])->fetchAll();
		$_QRY_ZAK = $db->sql("SELECT nameshort, namefull FROM sp_contragents WHERE kodcontragent=" . $_QRY[0]['kodzakaz'])->fetchAll();
		if (!empty($_QRY[0]['kodagent'])) {
			$_QRY_AGN = $db->sql("SELECT nameshort, namefull FROM sp_contragents WHERE kodcontragent=" . $_QRY[0]['kodagent'])->fetchAll();
			$db->update('dognet_docbase', array(
				'nameagentshort'	=>	$_QRY_AGN[0]['nameshort'],
				'nameagentfull'		=>	$_QRY_AGN[0]['namefull'],
			), array('id' => $id));
		}
		$db->update('dognet_docbase', array(
			'koddoc'			=>	$__nextKoddoc,
			'docnumberSTR'		=>	$_QRY[0]['docnumber'],
			'nameobjectshort'	=>	$_QRY_OBJ[0]['nameobjectshot'], // CorrectionID#20230520-01
			'nameobjectfull'	=>	$_QRY_OBJ[0]['nameobjectlong'], // CorrectionID#20230520-01
			'namezakshort'		=>	$_QRY_ZAK[0]['nameshort'], // CorrectionID#20230520-01
			'namezakfull'		=>	$_QRY_ZAK[0]['namefull'], // CorrectionID#20230520-01
		), array('id' => $id));
		# <<<<< CorrectionID#20230520-01
		# <<<<< CorrectionID#20240318-01
		#
		if ($_QRY[0]['kodshab'] == 1 || $_QRY[0]['kodshab'] == 3) {
			DOCKALPLAN_PR_CREATE_DEFPLAN($db, "docbase", $id, $action_docbase);
		}
		if ($_QRY[0]['usedoczayv'] == 1) {
			$_QRY1 = $db->sql("SELECT * FROM dognet_docblankwork WHERE kodblankwork=" . $_QRY[0]['kodblankwork'])->fetchAll();

			// *Убрал "подтягивание суммы из бланка заявки на договор
			/*
			$csummadocopl = "";
			if ($_QRY1[0]['kodtipblank'] == "POS") {
				$_QRY2 = $db->sql( "SELECT csummadocopl FROM dognet_blankdocpost WHERE kodblankwork=".$_QRY[0]['kodblankwork']." AND kodtipblank='DO'" )->fetchAll();
				$csummadocopl = $_QRY2[0]['csummadocopl'];
			}
			if ($_QRY1[0]['kodtipblank'] == "PNR") {
				$_QRY2 = $db->sql( "SELECT csummadocopl FROM dognet_blankdocpnr WHERE kodblankwork=".$_QRY[0]['kodblankwork']." AND kodtipblank='DO'" )->fetchAll();
				$csummadocopl = $_QRY2[0]['csummadocopl'];
			}
			if ($_QRY1[0]['kodtipblank'] == "SUB") {
				$_QRY2 = $db->sql( "SELECT csummadocopl FROM dognet_blankdocsub WHERE kodblankwork=".$_QRY[0]['kodblankwork']." AND kodtipblank='DO'" )->fetchAll();
				$csummadocopl = $_QRY2[0]['csummadocopl'];
			}

			$docsumma = ($csummadocopl!="Рамочно" && $csummadocopl!="") ? str_replace(",", ".", $csummadocopl) : "0.00";
*/

			$db->update('dognet_docbase', array(
				'kodzakaz'			=>	$_QRY1[0]['kodzakaz'],
				'kodispol'			=>	$_QRY1[0]['kodispol'],
				'kodispolruk'		=>	$_QRY1[0]['kodispolruk'],
				'docnamefullm'		=>	$_QRY1[0]['nameblankwork']
				// *Убрал "подтягивание суммы из бланка заявки на договор
				// 				'docsumma'			=>	$docsumma
			), array('id' => $id));

			/* 
ПРИВЯЗЫВАЕМ БЛАНК К СОЗДАВАЕМОМУ ДОГОВОРУ
	Обновляем в таблице dognet_docblankwork
	- dateblankdoc формируем из dognet_docbase.daynachdoc, dognet_docbase.monthnachdoc, dognet_docbase.yearnachdoc
	- numberdoccr формируем из dognet_docbase.docnumber
*/
			$koddoc = $__nextKoddoc;
			$kodblankwork = $_QRY[0]['kodblankwork'];

			$yearnachdoc = $_QRY[0]['yearnachdoc'];
			$day0 = $_QRY[0]['daynachdoc'];
			$daynachdoc = str_pad($day0, 2, "0", STR_PAD_LEFT);
			$month0 = $_QRY[0]['monthnachdoc'];
			$monthnachdoc = str_pad($month0, 2, "0", STR_PAD_LEFT);

			$_date = $yearnachdoc . "-" . $monthnachdoc . "-" . $daynachdoc;
			$_date1 = date("Y-m-d", strtotime($_date));
			$_date2 = new DateTime($_date1);
			$dateblancdoc = $_date2->format('Y-m-d');

			$numberdoccr = $_QRY[0]['docnumber'];

			$QRY_UPDATE_BLANK = $db->sql("UPDATE dognet_docblankwork SET dateblankdoc = '$_date1', numberdoccr = '$numberdoccr', koddoc = '$koddoc', kodstatusblank = 'DO', statusblankwork = 'ДОГОВОР' WHERE (kodblankwork = '$kodblankwork' AND kodstatusblank = 'RD' AND kodblankdone = '1') ");
		}
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99941000', '0000001', $id, $__nextKoddoc, null, $_SERVER['PHP_SELF']);
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
	if ($action_docbase == 'UPD') {
		#
		#
		$_QRY = $db->sql("SELECT kodshab, docnumber, usedoczayv, kodblankwork, kodobject, kodzakaz, kodagent FROM dognet_docbase WHERE id=" . $id)->fetchAll();
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99941000', '0000002', $id, null, null, $_SERVER['PHP_SELF']);
		#
		#
		# >>>>> CorrectionID#20230520-01
		# Правка от 20.05.2023 
		# 1. Добавляем сохранение названий объектов (nameobjectshort, nameobjectfull) для реализации полнотекстового поиска
		# 2. Добавляем сохранение названий объектов (namecontrshort, namecontrfull) для реализации полнотекстового поиска
		$_QRY_OBJ = $db->sql("SELECT nameobjectshot, nameobjectlong FROM sp_objects WHERE kodobject=" . $_QRY[0]['kodobject'])->fetchAll();
		$_QRY_ZAK = $db->sql("SELECT nameshort, namefull FROM sp_contragents WHERE kodcontragent=" . $_QRY[0]['kodzakaz'])->fetchAll();
		if (!empty($_QRY[0]['kodagent'])) {
			$_QRY_AGN = $db->sql("SELECT nameshort, namefull FROM sp_contragents WHERE kodcontragent=" . $_QRY[0]['kodagent'])->fetchAll();
			$db->update('dognet_docbase', array(
				'nameagentshort'	=>	$_QRY_AGN[0]['nameshort'],
				'nameagentfull'		=>	$_QRY_AGN[0]['namefull'],
			), array('id' => $id));
		}
		$db->update('dognet_docbase', array(
			'nameobjectshort'	=>	$_QRY_OBJ[0]['nameobjectshot'],
			'nameobjectfull'	=>	$_QRY_OBJ[0]['nameobjectlong'],
			'namezakshort'		=>	$_QRY_ZAK[0]['nameshort'],
			'namezakfull'		=>	$_QRY_ZAK[0]['namefull'],
		), array('id' => $id));
		# <<<<< CorrectionID#20230520-01

	}
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "УДАЛИТЬ"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_docbase == 'DEL') {
		#
		#
		$_QRY = $db->sql("SELECT kodshab, docnumber, usedoczayv, kodblankwork FROM dognet_docbase WHERE id=" . $id)->fetchAll();
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99941000', '0000003', $id, null, null, $_SERVER['PHP_SELF']);

		DOCBASE_PR_FULLREMOVE_DOC($db, $id);
		#
		#
	}
	#
	#
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function doc_block_for_edit($db, $action_docbase, $id, $values) {
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "ИЗМЕНИТЬ"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_docbase == 'UPD') {
		#
		#
		DOCBASE_PR_DOC_BLOCK_FOR_EDIT($db, "docbase", $id, $action_docbase);
		#
		#
	}
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
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
Editor::inst($db, 'dognet_docbase')
	->fields(
		Field::inst('dognet_docbase.koddel'),
		Field::inst('dognet_docbase.docnumber')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Номер')
			)),
		Field::inst('dognet_docbase.docnameshot')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Введите краткое название договора')
			)),
		Field::inst('dognet_docbase.docnumberSTR'),
		Field::inst('dognet_docbase.docpartnernumberSTR'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docbase.kodblankwork')
			->options(
				Options::inst()
					->table('dognet_docblankwork')
					->value('kodblankwork')
					->label(array('yearblankwork', 'numberblankwork', 'nameorgblankwork', 'kodstatusblank', 'nameblankwork', 'kodblankdone'))
					->render(function ($row) {
						if ($row['kodstatusblank'] == "RD") {
							return (strlen($row['nameblankwork']) > 50) ? " *** " . $row['yearblankwork'] . " / " . $row['numberblankwork'] . " / " . $row['nameorgblankwork'] . " / " . mb_substr($row['nameblankwork'], 0, 50, 'utf8') . " ..." : " *** " . $row['yearblankwork'] . " / " . $row['numberblankwork'] . " / " . $row['nameorgblankwork'] . " / " . $row['nameblankwork'];
						} else {
							return (strlen($row['nameblankwork']) > 50) ? $row['yearblankwork'] . " / " . $row['numberblankwork'] . " / " . $row['nameorgblankwork'] . " / " . mb_substr($row['nameblankwork'], 0, 50, 'utf8') . " ..." : $row['yearblankwork'] . " / " . $row['numberblankwork'] . " / " . $row['nameorgblankwork'] . " / " . $row['nameblankwork'];
						}
					})
					->where(function ($q1) {
						$q1->where('kodblankdone', '1', '=');
					})
					->where(function ($q2) {
						$q2->where('kodstatusblank', 'DO', '=');
						$q2->or_where('kodstatusblank', 'RD', '=');
					})
					->order('yearblankwork desc, numberblankwork desc')
					->limit(20)
			),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docbase.koddoc'),
		Field::inst('dognet_docbase.daynachdoc'),
		Field::inst('dognet_docbase.monthnachdoc'),
		Field::inst('dognet_docbase.yearnachdoc'),
		Field::inst('dognet_docbase.dayenddoc'),
		Field::inst('dognet_docbase.monthenddoc'),
		Field::inst('dognet_docbase.yearenddoc'),
		Field::inst('dognet_docbase.docsumma')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Введите сумму')
			)),
		Field::inst('dognet_docbase.docnamefullm'),
		Field::inst('dognet_docbase.usedoczayv'),
		Field::inst('dognet_docbase.usedocruk'),
		Field::inst('dognet_docbase.kodshab')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Выберите шаблон')
			)),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('sp_contragents.nameshort'),
		Field::inst('sp_contragents.namefull'),
		Field::inst('dognet_docbase.kodzakaz')
			->options(
				Options::inst()
					->table('sp_contragents')
					->value('kodcontragent')
					->label(array('kodcontragent', 'nameshort', 'namefull'))
					->render(function ($row) {
						return $row['nameshort'];
					})
					->where(function ($q) {
						$q->where('koddel', '99', '!=');
						$q->where('useindog', '1', '=');
					})
			)
			->setFormatter(Format::ifEmpty("")),

		Field::inst('sp_contragents_agent.nameshort'),
		Field::inst('sp_contragents_agent.namefull'),
		Field::inst('dognet_docbase.kodagent')
			->options(
				Options::inst()
					->table('sp_contragents')
					->value('kodcontragent')
					->label(array('kodcontragent', 'nameshort', 'namefull'))
					->render(function ($row) {
						return $row['nameshort'];
					})
					->where(function ($q) {
						$q->where('koddel', '99', '!=');
						$q->where('useindog', '1', '=');
					})
			)
			->setFormatter(Format::ifEmpty("")),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('sp_objects.nameobjectshot'),
		Field::inst('sp_objects.nameobjectlong'),
		Field::inst('dognet_docbase.kodobject')
			->options(
				Options::inst()
					->table('sp_objects')
					->value('kodobject')
					->label(array('kodobject', 'nameobjectshot', 'nameobjectlong'))
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
			->setFormatter(Format::ifEmpty("")),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_sptipdog.nametip'),
		Field::inst('dognet_docbase.kodtip')
			->options(
				Options::inst()
					->table('dognet_sptipdog')
					->value('kodtip')
					->label(array('kodtip', 'nametip'))
					->render(function ($row) {
						return $row['nametip'];
					})
					->where(function ($q) {
						$q->where('nametip', '', '!=');
					})
			)
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Выберите тип')
			)),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spstatus.statusnameshot'),
		Field::inst('dognet_spstatus.statusnamefull'),
		Field::inst('dognet_docbase.kodstatus')
			->options(
				Options::inst()
					->table('dognet_spstatus')
					->value('kodstatus')
					->label(array('kodstatus', 'statusnameshot', 'statusnamefull'))
					->render(function ($row) {
						return $row['statusnameshot'];
					})
			)
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Выберите статус')
			)),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spispol.ispolnameshot'),
		Field::inst('dognet_spispol.ispolnamefull'),
		Field::inst('dognet_docbase.kodispol')
			->options(
				Options::inst()
					->table('dognet_spispol')
					->value('kodispol')
					->label(array('kodispol', 'ispolnameshot', 'ispolnamefull'))
					->render(function ($row) {
						return $row['ispolnameshot'];
					})
					->where(function ($q) {
						$q->where('koddel', '99', '!=');
					})
			)
			->setFormatter(Format::ifEmpty("")),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spispolruk.ispolrukname'),
		Field::inst('dognet_docbase.kodispolruk')
			->options(
				Options::inst()
					->table('dognet_spispolruk')
					->value('kodispolruk')
					->label(array('kodispolruk', 'ispolrukname'))
					->render(function ($row) {
						return $row['ispolrukname'];
					})
			)
			->setFormatter(Format::ifEmpty("")),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spdened.namedenedfull'),
		Field::inst('dognet_docbase.koddened')
			->options(
				Options::inst()
					->table('dognet_spdened')
					->value('koddened')
					->label(array('koddened', 'namedenedshot', 'namedenedfull'))
					->render(function ($row) {
						return $row['namedenedfull'];
					})
					->where(function ($q) {
						$q->where('namedenedfull', '', '!=');
					})
			)
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Выберите валюту')
			)),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docbase.usendssumma'),
		Field::inst('dognet_docbase.dateplanav1'),
		Field::inst('dognet_docbase.dateplanav2'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docbase.kodstatuszdl'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docbase.usemisopl'),
		Field::inst('dognet_docbase.docsummamis'),
		Field::inst('dognet_docbase.comments'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docbase.usecreatekcp'),
		Field::inst('dognet_docbase.warranty_period'), // Добавлено 2023-08-28
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		/*
		Field::inst( 'dognet_docblankwork.numberblankwork' ),
		Field::inst( 'dognet_docblankwork.nameblankwork' ),
*/
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spdened.koddened'),
		Field::inst('dognet_spdened.html_code'),
		Field::inst('dognet_spdened.short_code')
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		#
		#
	)
	#
	#
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('preGet', function ($editor_docbase, $id) {
		$editor_docbase->where(function ($q) {
			$q->where('dognet_docbase.koddel', '99', '!=');
			$q->where('dognet_docbase.kodshab', '0', '!=');
		});
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('postCreate', function ($editor_docbase, $id, $values, $row) {
		updateFields_docbase($editor_docbase->db(), 'CRT', $id, $values);
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('postEdit', function ($editor_docbase, $id, $values, $row) {
		updateFields_docbase($editor_docbase->db(), 'UPD', $id, $values);
	})
	/*
	->on( 'preEdit', function ( $editor_docbase, $id, $values ) {
		doc_block_for_edit( $editor_docbase->db(), 'UPD', $id, $values );
	} )
*/
	->on('preRemove', function ($editor_docbase, $id, $values) {
		updateFields_docbase($editor_docbase->db(), 'DEL', $id, $values);
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	/* 	->leftJoin( 'dognet_docblankwork', 'dognet_docblankwork.kodblankwork', '=', 'dognet_docbase.kodblankwork' ) */
	->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
	->leftJoin('dognet_spstatus', 'dognet_spstatus.kodstatus', '=', 'dognet_docbase.kodstatus')
	->leftJoin('dognet_sptipdog', 'dognet_sptipdog.kodtip', '=', 'dognet_docbase.kodtip')
	->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_docbase.kodobject')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docbase.kodzakaz')
	->leftJoin('sp_contragents as sp_contragents_agent', 'sp_contragents_agent.kodcontragent', '=', 'dognet_docbase.kodagent')
	->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_docbase.kodispol')
	->leftJoin('dognet_spispolruk', 'dognet_spispolruk.kodispolruk', '=', 'dognet_docbase.kodispolruk')
	->process($_POST)
	->json();
