<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

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
Editor::inst($db, 'dognet_docchfsubpodr')
	->fields(
		Field::inst('dognet_docchfsubpodr.koddel'),
		Field::inst('dognet_docchfsubpodr.koddocsubpodr'),
		Field::inst('dognet_docchfsubpodr.kodchfsubpodr'),
		Field::inst('dognet_docchfsubpodr.numberchfsubpodr'),
		Field::inst('dognet_docchfsubpodr.datechfsubpodr')
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
		Field::inst('dognet_docchfsubpodr.sumchfsubpodr'),
		Field::inst('dognet_docchfsubpodr.sumzadolchfsubpodr'),
		// --- --- --- --- --- 
		/*
		Field::inst( 'dognet_docavsubpodr.kodavsubpodr' ), 
		Field::inst( 'dognet_docavsubpodr.sumavsubpodr' ), 
    Field::inst( 'dognet_docavsubpodr.dateavsubpodr' ) 
        ->validator( Validate::dateFormat(
            'd.m.Y',
            ValidateOptions::inst()
                ->allowEmpty( false ) ) )
        ->getFormatter( Format::datetime(
            'Y-m-d',
            'd.m.Y'
        ) )
        ->setFormatter( Format::datetime(
            'd.m.Y',
            'Y-m-d'
		) ),
*/
		// --- --- --- --- --- 
		/*
		Field::inst( 'dognet_docoplchfsubpodr.kodoplchfsubpodr' ), 
		Field::inst( 'dognet_docoplchfsubpodr.sumoplchfsubpodr' ), 
    Field::inst( 'dognet_docoplchfsubpodr.dateoplchfsubpodr' ) 
        ->validator( Validate::dateFormat(
            'd.m.Y',
            ValidateOptions::inst()
                ->allowEmpty( false ) ) )
        ->getFormatter( Format::datetime(
            'Y-m-d',
            'd.m.Y'
        ) )
        ->setFormatter( Format::datetime(
            'd.m.Y',
            'Y-m-d'
		) ),
*/
		// --- --- --- --- --- 
		Field::inst('dognet_reports_zadolsub_chfincoming.kodchfsubpodr'),
		Field::inst('dognet_reports_zadolsub_chfincoming.type_incoming'),
		Field::inst('dognet_reports_zadolsub_chfincoming.kod_incoming'),
		Field::inst('dognet_reports_zadolsub_chfincoming.sum_incoming'),
		Field::inst('dognet_reports_zadolsub_chfincoming.flag_1'),
		Field::inst('dognet_reports_zadolsub_chfincoming.date_incoming')
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
		// --- --- --- --- --- 
		Field::inst('dognet_docbase.koddoc'),
		Field::inst('dognet_docbase.docnumber'),
		Field::inst('dognet_docbase.docnameshot'),
		Field::inst('dognet_docbase.kodzakaz'),
		Field::inst('dognet_docbase.kodobject'),
		Field::inst('dognet_docbase.koddened'),
		Field::inst('dognet_docbase.kodstatuszdl'),
		Field::inst('dognet_docbase.numberchet'),
		// --- --- --- --- --- 
		Field::inst('dognet_dockalplan.koddoc'),
		Field::inst('dognet_dockalplan.kodkalplan'),
		Field::inst('dognet_dockalplan.numberstage'),
		Field::inst('dognet_dockalplan.nameshotstage'),
		// --- --- --- --- --- 
		Field::inst('dognet_docsubpodr.koddoc'),
		Field::inst('dognet_docsubpodr.koddocsubpodr'),
		Field::inst('dognet_docsubpodr.numberdocsubpodr'),
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
		Field::inst('dognet_docsubpodr.sumdocsubpodr'),
		Field::inst('dognet_docsubpodr.kodsubpodr'),
		// --- --- --- --- ---  
		Field::inst('sp_contragents.kodcontragent'),
		Field::inst('sp_contragents.namefull'),
		Field::inst('sp_contragents.nameshort'),
		// --- --- --- --- ---  
		Field::inst('dognet_spsubpodr.kodsubpodr'),
		Field::inst('dognet_spsubpodr.namesubpodrlong'),
		Field::inst('dognet_spsubpodr.namesubpodrshot'),
		// --- --- --- --- ---  
		Field::inst('sp_objects.kodobject'),
		Field::inst('sp_objects.nameobjectlong'),
		Field::inst('sp_objects.nameobjectshot'),
		// --- --- --- --- ---  
		Field::inst('dognet_spdened.koddened'),
		Field::inst('dognet_spdened.html_code'),
		Field::inst('dognet_spdened.short_code')
		// 
		// 
	)
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->on('preGet', function ($editor, $id) {
		$editor->where(function ($q) {
			$q->where('dognet_docchfsubpodr.koddel', '99', '!=');
			$q->and_where('dognet_docchfsubpodr.sumzadolchfsubpodr', 0.00, '!=');
		});
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	//
	->leftJoin('dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docchfsubpodr.koddocsubpodr')
	// 	->leftJoin( 'dognet_docavsubpodr', 'dognet_docavsubpodr.koddocsubpodr', '=', 'dognet_docsubpodr.koddocsubpodr' )
	// 	->leftJoin( 'dognet_docoplchfsubpodr', 'dognet_docoplchfsubpodr.kodchfsubpodr', '=', 'dognet_docchfsubpodr.kodchfsubpodr' )
	->leftJoin('dognet_reports_zadolsub_chfincoming', 'dognet_reports_zadolsub_chfincoming.kodchfsubpodr', '=', 'dognet_docchfsubpodr.kodchfsubpodr')
	->leftJoin('dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_docsubpodr.koddoc')
	->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docbase.kodzakaz')
	->leftJoin('dognet_spsubpodr', 'dognet_spsubpodr.kodsubpodr', '=', 'dognet_docsubpodr.kodsubpodr')
	->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_docbase.kodobject')
	->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
	->process($_POST)
	->json();
