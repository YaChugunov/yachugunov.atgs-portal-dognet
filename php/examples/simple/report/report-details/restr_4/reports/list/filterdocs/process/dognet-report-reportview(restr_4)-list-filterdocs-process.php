<?php
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
	DataTables\Editor\Mjoin;
// Build our Editor instance and process the data coming from _POST
Editor::inst($db, 'dognet_docbase')
	->fields(
		Field::inst('dognet_docbase.koddel'),
		Field::inst('dognet_docbase.kodshab'),
		Field::inst('dognet_docbase.koddoc'),
		Field::inst('dognet_docbase.koddened'),
		Field::inst('dognet_docbase.docnumber'),
		Field::inst('dognet_docbase.docsumma'),
		Field::inst('dognet_docbase.docnameshot'),
		Field::inst('dognet_docbase.yearnachdoc'),
		Field::inst('dognet_docbase.monthnachdoc'),
		Field::inst('dognet_docbase.daynachdoc'),
		Field::inst('dognet_docbase.yearenddoc'),
		Field::inst('dognet_docbase.monthenddoc'),
		Field::inst('dognet_docbase.dayenddoc'),
		Field::inst('dognet_docbase.docnamefullm'),
		Field::inst('dognet_docbase.kodobject'),
		Field::inst('dognet_docbase.kodispol'),
		Field::inst('dognet_docbase.kodtip'),
		Field::inst('dognet_docbase.kodstatus'),
		Field::inst('dognet_docbase.datezakr')
			->getFormatter(Format::datetime(
				'Y-m-d',
				'Y'
			))
			->setFormatter(Format::datetime(
				'Y',
				'Y-m-d'
			)),
		//
		Field::inst('dognet_spstatus.statusnameshot'),
		//
		Field::inst('dognet_sptipdog.nametip'),
		//
		Field::inst('sp_objects.nameobjectshot'),
		Field::inst('sp_objects.nameobjectlong'),
		//
		Field::inst('sp_contragents.nameshort'),
		Field::inst('sp_contragents.namefull'),
		//
		Field::inst('dognet_spispol.kodispol'),
		Field::inst('dognet_spispol.ispolnameshot'),
		Field::inst('dognet_spispol.ispolnamefull'),
		//
		//
		Field::inst('dognet_spdened.koddened'),
		Field::inst('dognet_spdened.html_code'),
		Field::inst('dognet_spdened.short_code')
	)
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	->on('preGet', function ($editor, $id) {
		$editor->where(function ($q) {
			$q->where(function ($r1) {
				// 				$r1->where( 'dognet_docbase.kodstatus', '245381842747296' ); // Статус договора "Текущий"
				// 				$r1->or_where( 'dognet_docbase.kodstatus', '245381842145343' ); // Статус договора "Проект"
				// 				$r1->or_where( 'dognet_docbase.kodstatus', '245267756667430' ); // Статус договора "Подписание"
			});
		});
	})
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
	->leftJoin('dognet_spstatus', 'dognet_spstatus.kodstatus', '=', 'dognet_docbase.kodstatus')
	->leftJoin('dognet_sptipdog', 'dognet_sptipdog.kodtip', '=', 'dognet_docbase.kodtip')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docbase.kodzakaz')
	->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_docbase.kodobject')
	->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_docbase.kodispol')
	->where('dognet_docbase.koddel', '99', '!=')
	->process($_POST)
	->json();
