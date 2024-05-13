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
# для таблицы этапов 'dognet_agreebase'
# ----- ----- -----
function nextKoddoc() {
	$query = mysqlQuery("SELECT MAX(koddoc) as lastKod FROM dognet_agreebase ORDER BY id DESC");
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

		$db->update('dognet_agreebase', array(
			'koddoc'			=>	$__nextKoddoc
		), array('id' => $id));
		#
		#
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		// PORTAL_SYSLOG('99941000', '0000001', $id, $__nextKoddoc, null, $_SERVER['PHP_SELF']);
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
		$_QRY = $db->sql("SELECT koddoc, kodstatus, kodshab, docnumber, usedoczayv, kodblankwork FROM dognet_agreebase WHERE id=" . $id)->fetchAll();

		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		// PORTAL_SYSLOG('99941000', '0000002', $id, null, null, $_SERVER['PHP_SELF']);
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
	if ($action_docbase == 'DEL') {
		#
		#
		$_QRY = $db->sql("SELECT kodshab, docnumber, usedoczayv, kodblankwork FROM dognet_agreebase WHERE id=" . $id)->fetchAll();
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		// PORTAL_SYSLOG('99941000', '0000003', $id, null, null, $_SERVER['PHP_SELF']);

		// DOCBASE_PR_FULLREMOVE_DOC( $db, $id );
		#
		#
	}
	#
	#
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
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
Editor::inst($db, 'dognet_agreebase')
	->fields(
		Field::inst('dognet_agreebase.koddel'),
		Field::inst('dognet_agreebase.docnumber')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Номер')
			)),
		Field::inst('dognet_agreebase.docnameshot')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Введите краткое название договора')
			)),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_agreebase.kodblankwork')
			->options(
				Options::inst()
					->table('dognet_docblankwork')
					->value('kodblankwork')
					->label(array('yearblankwork', 'numberblankwork', 'kodstatusblank', 'nametipblankwork', 'nameorgblankwork', 'kodblankdone'))
					->render(function ($row) {
						if ($row['kodstatusblank'] == "RD") {
							return (strlen($row['nameorgblankwork']) > 40) ? " *** " . $row['yearblankwork'] . " / " . $row['numberblankwork'] . " / " . mb_substr($row['nametipblankwork'], 0, 3, 'utf8') . " / " . mb_substr($row['nameorgblankwork'], 0, 40, 'utf8') : " *** " . $row['yearblankwork'] . " / " . $row['numberblankwork'] . " / " . mb_substr($row['nametipblankwork'], 0, 3, 'utf8') . " / " . $row['nameorgblankwork'];
						} else {
							return (strlen($row['nameorgblankwork']) > 40) ? $row['yearblankwork'] . " / " . $row['numberblankwork'] . " / " . mb_substr($row['nametipblankwork'], 0, 3, 'utf8') . " / " . mb_substr($row['nameorgblankwork'], 0, 40, 'utf8') : $row['yearblankwork'] . " / " . $row['numberblankwork'] . " / " . mb_substr($row['nametipblankwork'], 0, 3, 'utf8') . " / " . $row['nameorgblankwork'];
						}
					})
					->where(function ($q) {
						$q->where('kodblankdone', '1', '=');
						$q->where('kodstatusblank', 'RD', '=');
						// 					$q->or_where('kodstatusblank', 'DO', '=');
					})
					->order('yearblankwork desc, numberblankwork desc')
					->limit(20)
			),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_agreebase.koddoc'),
		Field::inst('dognet_agreebase.daynachdoc'),
		Field::inst('dognet_agreebase.monthnachdoc'),
		Field::inst('dognet_agreebase.yearnachdoc'),
		Field::inst('dognet_agreebase.dayenddoc'),
		Field::inst('dognet_agreebase.monthenddoc'),
		Field::inst('dognet_agreebase.yearenddoc'),
		Field::inst('dognet_agreebase.docsumma')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Введите сумму')
			)),
		Field::inst('dognet_agreebase.docnamefullm'),
		Field::inst('dognet_agreebase.usedoczayv'),
		Field::inst('dognet_agreebase.usedocruk'),
		Field::inst('dognet_agreebase.kodshab')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Выберите шаблон')
			)),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('sp_contragents.nameshort'),
		Field::inst('sp_contragents.namefull'),
		Field::inst('dognet_agreebase.kodzakaz')
			->options(
				Options::inst()
					->table('sp_contragents')
					->value('kodcontragent')
					->label(array('kodcontragent', 'nameshort', 'namefull'))
					->render(function ($row) {
						return $row['nameshort'];
					})
			)
			->setFormatter(Format::ifEmpty("")),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('sp_objects.nameobjectshot'),
		Field::inst('sp_objects.nameobjectlong'),
		Field::inst('dognet_agreebase.kodobject')
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
		Field::inst('dognet_agreebase.kodtip')
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
			),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spstatus.statusnameshot'),
		Field::inst('dognet_spstatus.statusnamefull'),
		Field::inst('dognet_agreebase.kodstatus')
			->options(
				Options::inst()
					->table('dognet_spstatus')
					->value('kodstatus')
					->label(array('kodstatus', 'statusnameshot', 'statusnamefull'))
					->render(function ($row) {
						return $row['statusnameshot'];
					})
			),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spispol.ispolnameshot'),
		Field::inst('dognet_spispol.ispolnamefull'),
		Field::inst('dognet_agreebase.kodispol')
			->options(
				Options::inst()
					->table('dognet_spispol')
					->value('kodispol')
					->label(array('kodispol', 'ispolnameshot', 'ispolnamefull'))
					->render(function ($row) {
						return $row['ispolnameshot'];
					})
			)
			->setFormatter(Format::ifEmpty("")),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spispolruk.ispolrukname'),
		Field::inst('dognet_agreebase.kodispolruk')
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
		Field::inst('dognet_agreebase.koddened')
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
		Field::inst('dognet_agreebase.usendssumma'),
		Field::inst('dognet_agreebase.dateplanav1'),
		Field::inst('dognet_agreebase.dateplanav2'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_agreebase.kodstatuszdl'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_agreebase.usemisopl'),
		Field::inst('dognet_agreebase.docsummamis'),
		Field::inst('dognet_agreebase.comments'),
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
	->on('preGet', function ($editor_agreebase, $id) {
		$editor_agreebase->where(function ($q) {
			$q->where('dognet_agreebase.koddel', '99', '!=');
			$q->where('dognet_agreebase.kodshab', '0', '!=');
		});
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('postCreate', function ($editor_agreebase, $id, $values, $row) {
		updateFields_docbase($editor_agreebase->db(), 'CRT', $id, $values);
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('postEdit', function ($editor_agreebase, $id, $values, $row) {
		updateFields_docbase($editor_agreebase->db(), 'UPD', $id, $values);
	})
	/*
	->on( 'preEdit', function ( $editor_agreebase, $id, $values ) {
		doc_block_for_edit( $editor_agreebase->db(), 'UPD', $id, $values );
	} )
*/
	->on('preRemove', function ($editor_agreebase, $id, $values) {
		updateFields_docbase($editor_agreebase->db(), 'DEL', $id, $values);
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	/* 	->leftJoin( 'dognet_docblankwork', 'dognet_docblankwork.kodblankwork', '=', 'dognet_agreebase.kodblankwork' ) */
	->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_agreebase.koddened')
	->leftJoin('dognet_spstatus', 'dognet_spstatus.kodstatus', '=', 'dognet_agreebase.kodstatus')
	->leftJoin('dognet_sptipdog', 'dognet_sptipdog.kodtip', '=', 'dognet_agreebase.kodtip')
	->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_agreebase.kodobject')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_agreebase.kodzakaz')
	->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_agreebase.kodispol')
	->leftJoin('dognet_spispolruk', 'dognet_spispolruk.kodispolruk', '=', 'dognet_agreebase.kodispolruk')
	->process($_POST)
	->json();
