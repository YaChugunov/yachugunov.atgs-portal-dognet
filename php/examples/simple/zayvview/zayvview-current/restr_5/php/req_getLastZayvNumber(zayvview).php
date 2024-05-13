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
require($_SERVER['DOCUMENT_ROOT']."/ism/_assets/functions/funcISM.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
	$_TMPSL1 = $_POST['tmpslave1']!="" ? $_POST['tmpslave1'] : "";
	$_TMPSL2 = $_POST['tmpslave2']!="" ? $_POST['tmpslave2'] : "";
	$_TMPSL3 = $_POST['tmpslave3']!="" ? $_POST['tmpslave3'] : "";
	$_TMPUSER = $_POST['tmpuser']!="" ? $_POST['tmpuser'] : "";
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
/*
 * Example PHP implementation used for the index.html example
*/
// DataTables PHP library
require( $_SERVER['DOCUMENT_ROOT']."/ism/_assets/drivers/Datatables/dt_php/DataTables.php" );
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
#
#
#
#
// Build our Editor instance and process the data coming from _POST
	Editor::inst( $db, 'ism_docpaper' )
	->fields(
		Field::inst( 'ism_docpaper.linktouser' ) 
				->options( Options::inst()
					->table( 'ism_spstaff' )
					->value( 'id' )
					->label( array('lastname', 'firstname', 'middlename', 'boss') )
					->render( function ( $row ) {
						switch ($row['boss']) {
							case "0":
								return $row['lastname']." ".$row['firstname']." ".$row['middlename'];
								break;
							case "1":
								return $row['lastname']." ".$row['firstname']." ".$row['middlename']." *";
								break;
							case "2":
								return $row['lastname']." ".$row['firstname']." ".$row['middlename']." **";
								break;
							case "3":
								return $row['lastname']." ".$row['firstname']." ".$row['middlename']." ***";
								break;
							case "4":
								return $row['lastname']." ".$row['firstname']." ".$row['middlename']." ****";
								break;
							default:
								return $row['lastname']." ".$row['firstname']." ".$row['middlename'];
						}
					})
			        ->where( function ($q) use ($_TMPSL1, $_TMPSL2, $_TMPSL3, $_TMPUSER) {
			            $q->where( 'status', '1', '=' );
				        $q->where( function ($q0) use ($_TMPSL1, $_TMPSL2, $_TMPSL3, $_TMPUSER) {
							$q0->where( 'kodslave1', '('.$_TMPSL1.')', 'IN', false );
								if ($_TMPSL2!=="") {
							        $q0->and_where( 'kodslave2', '('.$_TMPSL2.')', 'IN', false );
									if ($_TMPSL3!=="") {
								        $q0->and_where( 'kodslave3', '('.$_TMPSL3.')', 'IN', false );
										if ($_TMPUSER!=="") {
									        $q0->and_where( function ($q1) use ($_TMPUSER) {
										        $q1->where( 'kodslave41', '('.$_TMPUSER.')', 'IN', false );
										        $q1->or_where( 'kodslave42', '('.$_TMPUSER.')', 'IN', false );
											});
										}
									}
								}
						});
/*
				        $q->where( function ($q0) use ($_TMPSL1, $_TMPSL2, $_TMPSL3, $_TMPUSER) {
					        $q0->where( 'kodslave4', '('.$_TMPUSER.')', 'IN', false );
						});
*/
					})
/*
			        ->where( function ($q) use ($_TMPSL1, $_TMPSL2, $_TMPSL3, $_TMPUSER) {
			            $q->where( 'status', '1', '=' );
				        $q->and_where( function ($q0) use ($_TMPSL1, $_TMPSL2, $_TMPSL3, $_TMPUSER) {
				            $q0->where( 'kodmaster', '('.$_TMPUSER.')', 'IN', false );
				            $q0->or_where( 'kodslave3', '('.$_TMPSL1.')', 'IN', false );
				            $q0->or_where( 'kodslave2', '('.$_TMPSL2.')', 'IN', false );
				            $q0->or_where( 'kodslave1', '('.$_TMPSL3.')', 'IN', false );
				        });
			        })
*/
				)
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	)
	->on( 'preGet', function ( $editor_docpaper, $id ) {

	} )
	->on( 'postCreate', function ( $editor_docpaper, $id, $values, $row ) {

	} )
	->on( 'postEdit', function ( $editor_docpaper, $id, $values, $row ) {

	} )
	->on( 'preRemove', function ( $editor_docpaper, $id, $values ) {

	} )
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	->process( $_POST )
	->json();
