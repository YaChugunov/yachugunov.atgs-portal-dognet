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
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция 
# 
# ----- ----- ----- 
function updateFields_docbase_single($db, $action, $id, $values) {
	if ($action == 'UPD') {
		// Формируем идентификатор счета (numberchet)
		$_QRY0 = $db->sql("SELECT docnumber, yearnachdoc FROM dognet_docbase WHERE id=" . $id)->fetchAll();
		$docnumber = $_QRY0[0]['docnumber'];
		$yearnachdoc = $_QRY0[0]['yearnachdoc'];
		$docnumber = str_pad($docnumber, 4, "0", STR_PAD_LEFT);
		$__numberChet = substr($yearnachdoc, 2, 2) . $docnumber;

		$db->update('dognet_docbase', array(
			'numberchet' => $__numberChet,
			'kodshab' => '0'
		), array('id' => $id));
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
		Field::inst('dognet_docbase.koddoc'),
		Field::inst('dognet_docbase.daynachdoc'),
		Field::inst('dognet_docbase.monthnachdoc'),
		Field::inst('dognet_docbase.yearnachdoc'),
		Field::inst('dognet_docbase.dayenddoc'),
		Field::inst('dognet_docbase.monthenddoc'),
		Field::inst('dognet_docbase.yearenddoc'),
		Field::inst('dognet_docbase.srokindays')
			->setFormatter(Format::ifEmpty(null)),
		Field::inst('dognet_docbase.comments'),
		Field::inst('dognet_docbase.docsumma')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Введите сумму')
			)),
		Field::inst('dognet_docbase.docnamefullm'),
		Field::inst('dognet_docbase.usedoczayv'),
		Field::inst('dognet_docbase.usedocruk'),
		Field::inst('dognet_docbase.kodshab'),
		// ->validator( Validate::notEmpty( ValidateOptions::inst()
		// 	->message( 'Выберите шаблон' )	
		// ) ),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
		Field::inst('sp_contragents.nameshort'),
		Field::inst('dognet_docbase.kodzakaz')
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
		Field::inst('sp_objects.nameobjectshot'),
		Field::inst('dognet_docbase.kodobject')
			->options(
				Options::inst()
					->table('sp_objects')
					->value('kodobject')
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
					->message('Тип обязателен')
			)),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
		Field::inst('dognet_spstatus.statusnameshot'),
		Field::inst('dognet_docbase.kodstatus')
			->options(
				Options::inst()
					->table('dognet_spstatus')
					->value('kodstatus')
					->label(array('kodstatus', 'statusnameshot'))
					->render(function ($row) {
						return $row['statusnameshot'];
					})
			),
		// ->validator( Validate::notEmpty( ValidateOptions::inst()
		// 	->message( 'Статус обязателен' )	
		// ) ),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
		Field::inst('dognet_spispol.ispolnameshot'),
		Field::inst('dognet_docbase.kodispol')
			->options(
				Options::inst()
					->table('dognet_spispol')
					->value('kodispol')
					->label(array('kodispol', 'ispolnameshot'))
					->render(function ($row) {
						return $row['ispolnameshot'];
					})
			),
		// ->validator( Validate::notEmpty( ValidateOptions::inst()
		// 	->message( 'Статус обязателен' )	
		// ) ),
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
			),
		// ->validator( Validate::notEmpty( ValidateOptions::inst()
		// 	->message( 'Статус обязателен' )	
		// ) ),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
		Field::inst('dognet_spdened.namedenedfull'),
		Field::inst('dognet_docbase.koddened')
			->options(
				Options::inst()
					->table('dognet_spdened')
					->value('koddened')
					->label(array('koddened', 'namedenedshot', 'namedenedfull'))
					->render(function ($row) {
						return $row['namedenedshot'];
					})
					->where(function ($q) {
						$q->where('namedenedshot', '', '!=');
					})
			)
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Статус обязателен')
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
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
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
			$q->where('dognet_docbase.koddoc', $_UNIQUEID);
			$q->and_where('dognet_docbase.koddel', '99', '!=');
		});
	})
	//
	->on('postCreate', function ($editor, $id, $values, $row) {
		updateFields_docbase_single($editor->db(), 'CRT', $id, $values);
	})
	->on('postEdit', function ($editor, $id, $values, $row) {
		updateFields_docbase_single($editor->db(), 'UPD', $id, $values);
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	//
	->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
	->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_docbase.kodobject')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docbase.kodzakaz')
	->leftJoin('dognet_sptipdog', 'dognet_sptipdog.kodtip', '=', 'dognet_docbase.kodtip')
	->leftJoin('dognet_spstatus', 'dognet_spstatus.kodstatus', '=', 'dognet_docbase.kodstatus')
	->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_docbase.kodispol')
	->leftJoin('dognet_spispolruk', 'dognet_spispolruk.kodispolruk', '=', 'dognet_docbase.kodispolruk')
	->where('dognet_docbase.koddoc', $_UNIQUEID)
	->process($_POST)
	->json();
