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
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового ID договора ( koddoc)
# для таблицы этапов 'dognet_docbase'
# ----- ----- -----
function nextKodzayvchet() {
	$query = mysqlQuery("SELECT MAX(koddoc) as lastKod FROM dognet_doczayvchet ORDER BY id DESC");
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
function updateFields ( $db, $id, $values, $row, $chf_ID, $chFrom_kod ) {

	$_QRY_CHET = $db->sql( "SELECT kodzayvchet FROM dognet_doczayvchet WHERE id=".$id )->fetchAll();
	$_QRY_CHETF = mysqlQuery( "UPDATE dognet_doczayvchetf SET kodzayvchet=".$_QRY_CHET[0]['kodzayvchet']." WHERE id=".$chf_ID );

// Считаем выполнение и задолженность по счету и обновляем значения в таблице счетов
// Для счета, на который переносится счет-фактура
			$_QRY_CHET_TO = $db->sql( "SELECT zayvchetsumma, kodzayvchet FROM dognet_doczayvchet WHERE id=".$id )->fetchAll();
			$sumch_to = $_QRY_CHET_TO[0]['zayvchetsumma'];
			$_kodzayvchet_to = $_QRY_CHET_TO[0]['kodzayvchet'];

			$_QRY_CHETF_TO = $db->sql( "SELECT SUM(zayvchetfsumma) as SummaChf FROM dognet_doczayvchetf WHERE kodzayvchet=".$_kodzayvchet_to )->fetchAll();
			$sumallchf_to = $_QRY_CHETF_TO[0]['SummaChf'];
			$perc_to = ($sumallchf_to/$sumch_to)*100;
			$zadol_to = $sumch_to - $sumallchf_to;
			$controlzadol_to = ($perc_to != 100.00) ? 1 : 0;
			//
			$db->update( 'dognet_doczayvchet', array(
				'zayvchetpr' => $perc_to,
				'zayvchetzadol' => $zadol_to,
				'controlzadol' => $controlzadol_to
			), array(
				'kodzayvchet' => $_kodzayvchet_to
			));
// Для счета, с которого переносится счет-фактура
			$_QRY_CHET_FROM = $db->sql( "SELECT zayvchetsumma FROM dognet_doczayvchet WHERE kodzayvchet=".$chFrom_kod )->fetchAll();
			$sumch_from = $_QRY_CHET_FROM[0]['zayvchetsumma'];

			$_QRY_CHETF_FROM = $db->sql( "SELECT SUM(zayvchetfsumma) as SummaChf FROM dognet_doczayvchetf WHERE kodzayvchet=".$chFrom_kod )->fetchAll();
			$sumallchf_from = $_QRY_CHETF_FROM[0]['SummaChf'];
			$perc_from = ($sumallchf_from/$sumch_from)*100;
			$zadol_from = $sumch_from - $sumallchf_from;
			$controlzadol_from = ($perc_from != 100.00) ? 1 : 0;
			//
			$db->update( 'dognet_doczayvchet', array(
				'zayvchetpr' => $perc_from,
				'zayvchetzadol' => $zadol_from,
				'controlzadol' => $controlzadol_from
			), array(
				'kodzayvchet' => $chFrom_kod
			));
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

if ( !isset($_POST['chf_ID']) || !is_numeric($_POST['chf_ID']) ) {
	echo json_encode( [ "data" => [] ] );
}
else {
$__chf_ID = $_POST['chf_ID'];
$__chFrom_kod = $_POST['chFrom_kodzayvchet'];
$__chFrom_year = $_POST['chFrom_year'];

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_doczayvchetf' )
	->fields(
		Field::inst( 'dognet_doczayvchetf.ID' ),
		Field::inst( 'dognet_doczayvchetf.kodzayvchet' )
	)
#
#
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postEdit', function ( $editor_docbase, $id, $values, $row ) use ($__chf_ID, $__chFrom_kod)  {
		updateFields( $editor_docbase->db(), $id, $values, $row, $__chf_ID, $__chFrom_kod );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// 	->leftJoin( 'dognet_doczayvchet', 'dognet_doczayvchet.kodzayvchet', '=', 'dognet_doczayvchetf.kodzayvchet' )
  ->where( 'dognet_doczayvchetf.id', $__chf_ID )
	->process( $_POST )
	->json();
}