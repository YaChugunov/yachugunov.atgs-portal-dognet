<?php
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
	DataTables\Editor\Mjoin;
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_oplatachf' )
	->fields(
		Field::inst( 'dognet_oplatachf.kodoplata' ),
		Field::inst( 'dognet_oplatachf.kodchfact' ),
		Field::inst( 'dognet_oplatachf.kodkalplan' ),
		Field::inst( 'dognet_oplatachf.dateopl' )
	        ->getFormatter( Format::datetime(
	            'Y-m-d',
	            'd.m.Y'
	        ) )
	        ->setFormatter( Format::datetime(
	            'd.m.Y',
	            'Y-m-d'
			) ),
		Field::inst( 'dognet_oplatachf.summaopl' ),
//
		Field::inst( 'dognet_kalplanchf.kodkalplan' ),
		Field::inst( 'dognet_kalplanchf.chetfnumber' ),
//
		Field::inst( 'dognet_dockalplan.koddoc' ),
		Field::inst( 'dognet_dockalplan.kodkalplan' ),
		Field::inst( 'dognet_dockalplan.numberstage' ),
//
	    Field::inst( 'dognet_docbase.koddoc' ),
	    Field::inst( 'dognet_docbase.koddened' ),
	    Field::inst( 'dognet_docbase.docnumber' ),
	    Field::inst( 'dognet_docbase.kodshab' ),

	    Field::inst( 'tmp1.koddoc' ),
	    Field::inst( 'tmp1.koddened' ),
	    Field::inst( 'tmp1.docnumber' ),
	    Field::inst( 'tmp1.kodshab' ),

	    Field::inst( 'tmp2.koddoc' ),
	    Field::inst( 'tmp2.koddened' ),
	    Field::inst( 'tmp2.docnumber' ),
	    Field::inst( 'tmp2.kodshab' ),
//
	    Field::inst( 'dognet_spdened.koddened' ),
	    Field::inst( 'dognet_spdened.html_code' ),
	    Field::inst( 'dognet_spdened.short_code' ),

	    Field::inst( 'tmp3.koddened' ),
	    Field::inst( 'tmp3.html_code' ),
	    Field::inst( 'tmp3.short_code' )
	)
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
	->on( 'preGet', function ( $editor, $id ) {
		$editor->where( function ( $q ) {
			$q->where( 'dognet_oplatachf.dateopl', 'DATE_ADD( NOW(), INTERVAL -20 DAY )', '>=', false );
			$q->order( 'dognet_oplatachf.dateopl desc, dognet_oplatachf.kodoplata desc' );
			$q->limit( 5 );
		} );
	} )
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
	->leftJoin( 'dognet_kalplanchf', 'dognet_kalplanchf.kodchfact', '=', 'dognet_oplatachf.kodchfact' )
	->leftJoin( 'dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_kalplanchf.kodkalplan' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_oplatachf.kodkalplan' )
	->leftJoin( 'dognet_docbase as tmp1', 'tmp1.koddoc', '=', 'dognet_dockalplan.koddoc' )
	->leftJoin( 'dognet_docbase as tmp2', 'tmp2.koddoc', '=', 'dognet_oplatachf.kodkalplan' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
	->leftJoin( 'dognet_spdened as tmp3', 'tmp3.koddened', '=', 'tmp1.koddened' )
	->where( 'dognet_oplatachf.dateopl', 'DATE_ADD( NOW(), INTERVAL -20 DAY )', '>=', false )
	->process( $_POST )
	->json();

