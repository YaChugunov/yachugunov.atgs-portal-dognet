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
# Подключаем собственные функции сервиса Почта
require($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/functions/funcDognet.inc.php");
#
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$__uniqueID = $_SESSION['uniqueID'];
// $__uniqueID = $_GET['uniqueID'];
// $__uniqueID = $uid;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: О Б Р А Б О Т Ч И К   З А Г Р У З К И   Ф А Й Л А
# :::
#
if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
#
	$__CURRENT_YEAR = date('Y');
	$tmpfolder = $__CURRENT_YEAR;
#
# ----- --- ----- --- ----- ---
# !!! ОЧЕНЬ ВАЖНЫЕ СТРОКИ !!!
# ----- --- ----- --- ----- ---
#
# Постоянная часть пути
// 	$Const_Part_Of_PATH = "/STORAGEDOC/ZAYVCTZ/CTZ".$__CURRENT_YEAR."/";
	$Const_Part_Of_PATH = "/STORAGEDOC/DOCZAYV/DOCZAYV".$__CURRENT_YEAR."/";
#
#
# Имя столбца в таблице файлов: file_truelocation
# Путь, где распологается оригинальный файл
	$_QRY_GetStorageFolder = mysqlQuery("SELECT storagefolder_name FROM dognet_settings_storagefolders WHERE storagefolder_use = '1'");

	$_ROW_GetStorageFolder = mysqli_fetch_assoc($_QRY_GetStorageFolder);
	if ($_QRY_GetStorageFolder) { $StorageName = $_ROW_GetStorageFolder['storagefolder_name']; }

	$d = dir($StorageName.$Const_Part_Of_PATH);
	$__DOCPATH = $d->path;
#
#
# Имя столбца в таблице файлов: file_webpath
# Формируем часть URL (без http://, имени хоста и сервиса) симлинка на оригинальный файл
// 	$__WEBPATH = "/dognet".$Const_Part_Of_PATH;
	$__WEBPATH = "".$Const_Part_Of_PATH;
#
#
# Имя столбца в таблице файлов: file_syspath
# Серверный путь (PATH) к симлинку на оригинальный файл
	$__SYSPATH = $_SERVER['DOCUMENT_ROOT']."/dognet".$Const_Part_Of_PATH;
#
# ----- --- ----- --- ----- ---
#
	$varFileArray = [
		'year' => $__CURRENT_YEAR,
		'docpath' => $__DOCPATH,
		'webpath' => $__WEBPATH,
		'syspath' => $__SYSPATH
	];
#
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
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
Editor::inst( $db, 'dognet_doczayv' )
	->fields(
		Field::inst( 'dognet_docbase.koddel' ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.kodzayv' ),
		Field::inst( 'dognet_doczayv.koddoc' ),
		Field::inst( 'dognet_doczayv.kodispol' ),
		Field::inst( 'dognet_doczayv.kodzayvtel' ),
		Field::inst( 'dognet_doczayv.kodrabzayv' ),
		Field::inst( 'dognet_doczayv.numberzayv' ),
		Field::inst( 'dognet_doczayv.datezayv' )
		        ->validator( Validate::dateFormat(
		            'd.m.Y',
		            ValidateOptions::inst()
		                ->allowEmpty( true ) ) )
		        ->getFormatter( Format::datetime(
		            'Y-m-d',
		            'd.m.Y'
		        ) )
		        ->setFormatter( Format::datetime(
		            'd.m.Y',
		            'Y-m-d'
				) ),
		Field::inst( 'dognet_doczayv.namedoc' ),
		Field::inst( 'dognet_doczayv.kodrabfile' ),
		Field::inst( 'dognet_doczayv.namerabfilespec' ),
		Field::inst( 'dognet_doczayv.rabfileexp' ),
		Field::inst( 'dognet_doczayv.tipusezayv' ),
		Field::inst( 'dognet_doczayv.kodtipzayv' ),
		Field::inst( 'dognet_doczayv.kodusecht' ),
		Field::inst( 'dognet_doczayv.rabzayvdoc' ),
		Field::inst( 'dognet_doczayv.zayvchetcom' ),
		Field::inst( 'dognet_doczayv.kodtipzayvall' ),
		Field::inst( 'dognet_doczayv.koduseobjwork' ),
		Field::inst( 'dognet_doczayv.kodusepoligon' ),
		Field::inst( 'dognet_doczayv.zayvchetcomall' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_doczayv.docFileID' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_docbase.koddoc' ),
		Field::inst( 'dognet_docbase.docnumber' ),
		Field::inst( 'dognet_docbase.docnameshot' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_spzayvtel.kodzayvtel' ),
    Field::inst( 'dognet_spzayvtel.namezayvtel' ),
    Field::inst( 'dognet_spzayvtel.namezayvtelshot' ),
    Field::inst( 'dognet_spzayvtel.doljzayvtel' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_sptipzayv.kodtipzayv' ),
    Field::inst( 'dognet_sptipzayv.namezayvshot' ),
    Field::inst( 'dognet_sptipzayv.namezayvfull' ),
    Field::inst( 'dognet_sptipzayv.shifrzayv' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_sptipzayvall.kodtipzayvall' ),
    Field::inst( 'dognet_sptipzayvall.nametipzayvshotall' ),
    Field::inst( 'dognet_sptipzayvall.nametipzayvfullall' ),
    Field::inst( 'dognet_sptipzayvall.usesimple' ),
    Field::inst( 'dognet_sptipzayvall.usespec' ),
    Field::inst( 'dognet_sptipzayvall.koddoclim' ),
    Field::inst( 'dognet_sptipzayvall.kodshab' )
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	)
#
#
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'preGet', function ( $editor_doczayv, $id ) use ($__uniqueID) {
		$editor_doczayv->where( function ( $q ) use ($__uniqueID) {
		    $q->where( 'dognet_doczayv.koddoc', $__uniqueID);
		    $q->and_where( 'dognet_doczayv.koddel', '99', '!=' );
		} );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_doczayv.koddoc' )
	->leftJoin( 'dognet_spzayvtel', 'dognet_spzayvtel.kodzayvtel', '=', 'dognet_doczayv.kodzayvtel' )
	->leftJoin( 'dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_doczayv.kodispol' )
	->leftJoin( 'dognet_sptipzayv', 'dognet_sptipzayv.kodtipzayv', '=', 'dognet_doczayv.kodtipzayv' )
	->leftJoin( 'dognet_sptipzayvall', 'dognet_sptipzayvall.kodtipzayvall', '=', 'dognet_doczayv.kodtipzayvall' )
// 	->where('dognet_doczayv.koddoc', $__uniqueID, '=')
	->process( $_POST )
	->json();

