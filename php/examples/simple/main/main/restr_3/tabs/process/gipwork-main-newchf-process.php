<?php
date_default_timezone_set('Europe/Moscow');
# Подключаем конфигурационный файл
// require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
// require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require($_SERVER['DOCUMENT_ROOT']."/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса
require($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ID ПОЛЬЗОВАТЕЛЯ
if ($_SESSION['id']=="1011"||checkIsItSuperadmin($_SESSION['id'])==1) {
#	$__USERID = '1052'; // Щукин
#	$__USERID = '1105'; // Лавров
	$__USERID = '1043'; // Тимофеев
#	$__USERID = '1037'; // Зельдин
}
else {
	$__USERID = $_SESSION['id'];
}

# ИНТЕРВАЛ ДЕДЛАЙНА
	$__DATEDIFF = 180;

# ТЕКУЩАЯ ДАТА
	$__DATENOW = date("Y-m-d H:i:s");

// ОПРЕДЕЛЯЕМ KODISPOL ГИПА ПО ЕГО ID
	$_QRY_KODISPOL = mysqlQuery("SELECT * FROM dognet_users_kods WHERE id='".$__USERID."'");
	$_ROW_KODISPOL = mysqli_fetch_assoc($_QRY_KODISPOL);
	$__KODISPOL = $_ROW_KODISPOL['kodispol'];
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
/*
 * Example PHP implementation used for the index.html example
*/
// DataTables PHP library
require( $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_datatables-php-api-editor/DataTables.php" );
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
Editor::inst( $db, 'dognet_kalplanchf' )
	->fields(
		Field::inst( 'dognet_kalplanchf.kodchfact' ),
		Field::inst( 'dognet_kalplanchf.kodkalplan' ),
		Field::inst( 'dognet_kalplanchf.chetfnumber' ),
		Field::inst( 'dognet_kalplanchf.chetfdate' )
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
		Field::inst( 'dognet_kalplanchf.chetfsumma' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_dockalplan.koddoc' ),
		Field::inst( 'dognet_dockalplan.srokstage' ),
		Field::inst( 'dognet_dockalplan.srokstage_date' )
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
		Field::inst( 'dognet_dockalplan.kodkalplan' ),
		Field::inst( 'dognet_dockalplan.numberstage' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_docbase.koddened' ),
    Field::inst( 'dognet_docbase.docnumber' ),
    Field::inst( 'dognet_docbase.kodstatus' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_spdened.koddened' ),
    Field::inst( 'dognet_spdened.html_code' ),
    Field::inst( 'dognet_spdened.short_code' )
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	)
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
	->on( 'preGet', function ( $editor, $id ) use ($__KODISPOL) {
		$editor->where( function ( $q ) use ($__KODISPOL) {
			$q->where( function ( $r3 ) {
				$r3->where( 'dognet_kalplanchf.chetfdate', 'DATE_ADD( NOW(), INTERVAL -20 DAY )', '>=', false );
			} );
			$q->where( 'dognet_docbase.kodispol', $__KODISPOL);
			$q->where( 'dognet_docbase.koddel', '99', '!=' );
			$q->limit(5);
		} );
	} )
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
	->leftJoin( 'dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_kalplanchf.kodkalplan' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
	->process( $_POST )
	->json();

