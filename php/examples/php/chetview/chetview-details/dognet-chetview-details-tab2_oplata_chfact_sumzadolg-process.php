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
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
$__uniqueID = $_SESSION['uniqueID'];
// $__uniqueID = "245847329098834";

# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# 
// Вытаскиваем идентификатор календарного плана 
// 	$query = mysqlQuery("SELECT inbox_docID FROM mailbox_incoming WHERE id=".$currID);
// 	$row = mysqli_fetch_assoc($query);
// 	$currDocID = $row['inbox_docID'];
// 	$_SESSION['editedInboxDocID'] = $currDocID;
#
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
if ( ! isset($_POST['kodkalplan']) || ! is_numeric($_POST['kodkalplan']) ) {
    echo json_encode( [ "data" => [] ] );
}
else {
    Editor::inst( $db, 'dognet_kalplanchf' )
        ->field(
            Field::inst( 'dognet_kalplanchf.kodkalplan' ),
            Field::inst( 'dognet_kalplanchf.kodchfact' ),
            Field::inst( 'dognet_kalplanchf.chetfdate' ),
            Field::inst( 'dognet_kalplanchf.chetfnumber' ),
            Field::inst( 'dognet_kalplanchf.chetfsumma' ), 
            Field::inst( 'dognet_dockalplan.kodkalplan' ), 
            Field::inst( 'dognet_docbase.koddoc' ), 
			      Field::inst( 'dognet_docbase.koddened' ), 
			      Field::inst( 'dognet_spdened.html_code' ), 
			      Field::inst( 'dognet_spdened.short_code' ) 
        )
				->leftJoin( 'dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_kalplanchf.kodkalplan' )
				->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc' )
				->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
        ->where( 'dognet_kalplanchf.kodchfact', $_POST['kodkalplan'] )
        ->process($_POST)
        ->json();
}
?>