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
Editor::inst($db, 'dognet_dockalplan')
	->fields(
		Field::inst('dognet_docbase.koddel'),
		Field::inst('dognet_dockalplan.koddoc'),
		Field::inst('dognet_dockalplan.kodkalplan'),
		Field::inst('dognet_dockalplan.numberstage'),
		Field::inst('dognet_dockalplan.nameshotstage'),
		Field::inst('dognet_dockalplan.namefullstage'),
		Field::inst('dognet_dockalplan.dateplan')
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
		Field::inst('dognet_dockalplan.dateoplall')
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
		Field::inst('dognet_dockalplan.summastage'),
		//
		Field::inst('dognet_dockalplan.srokstage'),
		Field::inst('dognet_dockalplan.srokstage_date')
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
		Field::inst('dognet_dockalplan.idsrokstage'),
		Field::inst('dognet_dockalplan.srokopl'),
		Field::inst('dognet_dockalplan.idsrokopl'),
		Field::inst('dognet_dockalplan.idobjectready'),
		Field::inst('dognet_dockalplan.numberdayoplstage'),
		//
		Field::inst('dognet_dockalplan_progress.stagecreated')
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
		//
		Field::inst('sp_objects.nameobjectshot'),
		//
		Field::inst('sp_contragents.nameshort'),
		Field::inst('sp_contragents.namefull'),
		//
		Field::inst('dognet_spispol.ispolnameshot'),
		Field::inst('dognet_spispol.ispolnamefull'),
		//
		Field::inst('dognet_docbase.koddoc'),
		Field::inst('dognet_docbase.koddened'),
		Field::inst('dognet_docbase.kodzakaz'),
		Field::inst('dognet_docbase.docnumber'),
		Field::inst('dognet_docbase.docnameshot'),
		Field::inst('dognet_docbase.docnamefullm'),
		Field::inst('dognet_docbase.kodstatus'),
		//
		Field::inst('dognet_docblankwork.numberblankwork'),
		Field::inst('dognet_docblankwork.dateblankdoc')
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
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
				$r1->where('dognet_docbase.kodstatus', '245381842747296'); // Статус договора "Текущий"
				$r1->or_where('dognet_docbase.kodstatus', '245381842145343'); // Статус договора "Проект"
				$r1->or_where('dognet_docbase.kodstatus', '245267756667430'); // Статус договора "Подписание"
			});
		});
	})
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
	->leftJoin('dognet_docblankwork', 'dognet_docblankwork.koddoc', '=', 'dognet_docbase.koddoc')
	->leftJoin('dognet_dockalplan_progress', 'dognet_dockalplan_progress.kodkalplan', '=', 'dognet_dockalplan.kodkalplan')
	->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docbase.kodzakaz')
	->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_dockalplan.kodobject')
	->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_docbase.kodispol')

	->where('dognet_docblankwork.dateblankdoc', 'DATE_ADD(NOW(), INTERVAL -30 DAY)', '>=', false)
	->where('dognet_dockalplan_progress.stagecreated', 'DATE_ADD(NOW(), INTERVAL -30 DAY)', '>=', false)
	->where('dognet_dockalplan.koddel', '99', '!=')
	->where('dognet_docbase.koddel', '99', '!=')

	->process($_POST)
	->json();
