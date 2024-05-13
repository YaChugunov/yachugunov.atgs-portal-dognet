<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Отчетные формы";
$__subsubtitle = "Задолженность по счетам-фактурам";


#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция обновления полей основной таблицы (dognet_kalplanchf) 
# 
#
$_QRY0 = mysqlQuery("TRUNCATE TABLE dognet_reports_zadolchf");
$_QRY = mysqlQuery("SELECT * FROM dognet_kalplanchf WHERE koddel <> '99'");
$chf_koddoc = '';
$_ENBL = FALSE;
while ($_ROW = mysqli_fetch_assoc($_QRY)) {

	$chf_sumAvChf = SUMMA_AVANSCHF($_ROW['kodchfact']);
	$chf_sumOpChf = SUMMA_OPLATCHF($_ROW['kodchfact']);
	$chf_summazadol = $_ROW['chetfsumma'] - ($chf_sumOpChf + $chf_sumAvChf);
	if (round($chf_summazadol) > 0 or round($chf_summazadol) < 0) {

		// Определяем ID договора (koddoc) для договора с календарным планом
		$_QRY_koddoc1 = mysqlQuery("SELECT koddoc FROM dognet_dockalplan WHERE kodkalplan=" . $_ROW['kodkalplan'] . " AND koddel <> '99'");
		$_NUM1 = mysqli_num_rows($_QRY_koddoc1);
		$_ROW_koddoc1 = mysqli_fetch_assoc($_QRY_koddoc1);
		if ($_NUM1 > 0) {
			$chf_koddoc = $_ROW_koddoc1['koddoc'];
		}
		// Определяем ID договора (koddoc) для договора без календарного плана
		else {
			$_QRY_koddoc2 = mysqlQuery("SELECT koddoc FROM dognet_docbase WHERE koddoc=" . $_ROW['kodkalplan']);
			$_ROW_koddoc2 = mysqli_fetch_assoc($_QRY_koddoc2);
			$chf_koddoc = $_ROW_koddoc2['koddoc'];
		}
		// ----- ----- ----- ----- ----- 
		$chf_kodkalplan = $_ROW['kodkalplan'];
		$chf_kodchfact = $_ROW['kodchfact'];
		$chf_kodusechf = $_ROW['kodusechf'];
		$chf_koddel = $_ROW['koddel'];
		$chf_chetfnumber = $_ROW['chetfnumber'];
		$chf_chetfdate = $_ROW['chetfdate'];
		$chf_chetfsumma = $_ROW['chetfsumma'];
		$chf_summazadol = $chf_chetfsumma - ($chf_sumAvChf + $chf_sumOpChf);
		$chf_comment = "";
		// ----- ----- ----- ----- ----- 
		// 			$_QRY_INSERT = mysqlQuery( " INSERT INTO dognet_reports_zadolchf (koddoc, kodkalplan, kodchfact, chetfnumber, chetfdate, chetfsumma, summaoplav, summaopl, summazadol, comment) VALUES ($chf_koddoc, $chf_kodkalplan, $chf_kodchfact, $chf_chetfnumber, $chf_chetfdate, $chf_chetfsumma, $chf_sumAvChf, $chf_sumOpChf, $chf_summazadol, $chf_comment) " );
		$_QRY_INSERT = mysqlQuery(" INSERT INTO dognet_reports_zadolchf (koddoc, kodkalplan, kodchfact, kodusechf, koddel, chetfnumber, chetfdate, chetfsumma, summaoplav, summaopl, summazadol, comment) VALUES ('$chf_koddoc', '$chf_kodkalplan', '$chf_kodchfact', '$chf_kodusechf', '$chf_koddel', '$chf_chetfnumber', '$chf_chetfdate', '$chf_chetfsumma', '$chf_sumAvChf', '$chf_sumOpChf', '$chf_summazadol', '$chf_comment') ");
	}
}


?>

<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<div class="container">
	<div class="row" style="margin-top:20px">
		<?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/dognet-topblock.php") ?>
	</div>


	<script type="text/javascript" language="javascript" class="init">
		var table_reports_spravka_zadolchf; // use a global for the submit and return data rendering in the examples

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

		$(document).ready(function() {

			table_reports_spravka_zadolchf = $('#reports-spravka-zadolchf-table').DataTable({
				dom: "<'row'<'col-sm-5'B><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
				// 		dom: "<'space50'r>tip",
				language: {
					url: "russian.json"
				},
				ajax: {
					url: "php/examples/php/report/report-details/reports/dognet-report-reportview(restr_4)-spravka-zadolchf-process.php",
					type: "POST"
				},
				serverSide: true,
				columns: [{
						searchable: false,
						orderable: false,
						data: null
					},
					{
						searchable: false,
						orderable: false,
						data: null
					},
					{
						searchable: false,
						orderable: false,
						data: null
					},
					{
						data: "sp_contragents.nameshort",
						className: "text-left"
					},
					{
						data: "dognet_docbase.docnameshot",
						className: "text-left"
					},
					{
						data: "dognet_dockalplan.numberstage",
						className: "text-left"
					},
					{
						orderable: false,
						data: "dognet_reports_zadolchf.chetfnumber",
						className: "text-left"
					},
					{
						orderable: false,
						data: "dognet_reports_zadolchf.chetfdate",
						className: "text-left"
					},
					{
						orderable: false,
						data: "dognet_reports_zadolchf.chetfsumma",
						className: "text-left"
					},
					{
						orderable: false,
						data: "dognet_reports_zadolchf.summaoplav",
						className: "text-left"
					},
					{
						orderable: false,
						data: "dognet_reports_zadolchf.summaopl",
						className: "text-left"
					},
					{
						orderable: false,
						data: "dognet_reports_zadolchf.summazadol",
						className: "text-left"
					},
					{
						data: "dognet_spdened.short_code"
					},
					{
						data: "dognet_docbase.kodstatuszdl"
					},
					{
						data: "dognet_docbase.docnumber"
					},
					{
						data: "dognet_docbase.numberchet"
					},
					{
						data: "sp_objects.nameobjectshot"
					}
				],
				select: {
					style: 'os',
					selector: 'td:not(:last-child)' // no row selection on last column
				},
				columnDefs: [{
						searchable: false,
						targets: 0,
						render: function(data) {
							return '';
						}
					},
					{
						searchable: false,
						targets: 1,
						render: function(data) {
							return '';
						}
					},
					{
						searchable: false,
						targets: 2,
						render: function(data) {
							return '';
						}
					},
					{
						searchable: true,
						visible: false,
						targets: 3
					},
					{
						searchable: true,
						visible: false,
						targets: 4
					},
					{
						searchable: true,
						render: function(data) {
							if (data) {
								return 'Этап ' + data;
							} else {
								return 'Без этапа';
							}
						},
						targets: 5
					},
					{
						searchable: true,
						targets: 6
					},
					{
						searchable: true,
						targets: 7
					},
					{
						searchable: false,
						render: function(data, type, row, meta) {
							if (data != null) {
								return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened.short_code;
							} else {
								return "0.00" + row.dognet_spdened.short_code;
							}
						},
						targets: 8
					},
					{
						searchable: false,
						render: function(data, type, row, meta) {
							if (data != null) {
								return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened.short_code;
							} else {
								return "0.00" + row.dognet_spdened.short_code;
							}
						},
						targets: 9
					},
					{
						searchable: false,
						render: function(data, type, row, meta) {
							if (data != null) {
								return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened.short_code;
							} else {
								return "0.00" + row.dognet_spdened.short_code;
							}
						},
						targets: 10
					},
					{
						searchable: false,
						render: function(data, type, row, meta) {
							if (data != null) {
								return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened.short_code;
							} else {
								return "0.00" + row.dognet_spdened.short_code;
							}
						},
						targets: 11
					},
					{
						visible: false,
						targets: 12
					},
					{
						visible: false,
						targets: 13
					},
					{
						searchable: true,
						visible: false,
						targets: 14
					},
					{
						searchable: true,
						visible: false,
						targets: 15
					},
					{
						searchable: true,
						visible: false,
						targets: 16
					}
				],

				order: [
					[3, "asc"],
					[4, "asc"],
					[5, "asc"],
					[6, "asc"]
				],
				rowGroup: {
					startRender: function(rows, group, level) {

						if (level == 0) {
							return '<span style="text-align:left; white-space:nowrap; padding-right:20px">' + group + '</span>';
						}
						var docnumber = rows.data().pluck("dognet_docbase").pluck("docnumber")[0];
						if (level == 1) {
							return '<span style="text-align:left; white-space:nowrap; padding-right:20px">Договор 3-4/' + docnumber + '&nbsp;-&nbsp;' + group + '</span>';
						}

					},
					endRender: function(rows, group, level) {

						var kodened = rows.data().pluck("dognet_spdened").pluck("short_code")[0];
						var docnumber = rows.data().pluck("dognet_docbase").pluck("docnumber")[0];
						var avg = rows
							.data()
							.pluck("dognet_reports_zadolchf")
							.pluck("summazadol")
							.reduce(function(a, b) {
								return a + b * 1;
							}, 0);
						var dataSrcArray = table_reports_spravka_zadolchf.rowGroup().dataSrc();

						if (level == 0) {
							return '<span style=""><span style="text-align:left; padding-right:20px">Итого по заказчику&nbsp;:</span><span style="float:right">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(avg) + '' + kodened + '</span></span>';
						}
						if (level == 1) {
							return '<span style=""><span style="text-align:left; padding-right:20px">Итого по договору&nbsp;:</span><span style="float:right">' + $.fn.dataTable.render.number(' ', ',', 2, '').display(avg) + '' + kodened + '</span></span>';
						}
					},
					dataSrc: ["sp_contragents.nameshort", "dognet_docbase.docnameshot"]
				},

				select: false,
				ordering: true,
				processing: true,
				paging: true,
				pageLength: 15,
				lengthChange: false,
				lengthMenu: [
					[15, 30, 50, -1],
					[15, 30, 50, "Все"]
				],
				buttons: [{
					text: '<span class="glyphicon glyphicon-refresh"></span>',
					action: function(e, dt, node, config) {
						table_reports_spravka_zadolchf.columns().search('');
						table_reports_spravka_zadolchf.order([3, "asc"], [4, "asc"], [6, "asc"]).draw();
					}
				}],

			});


			// 
			// 
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
			// 
			// 

			$('#columnSearch_btnApply').click(function(e) {

				switch ($('#reportDocTypeSearch_text').val()) {
					case '0':
						table_reports_spravka_zadolchf
							.column(15)
							.search("")
							.draw();
						break;
					case '1':

						table_reports_spravka_zadolchf
							.column(15)
							.search("080043")
							.draw();
						break;
					case '2':
						// Escape the expression so we can perform a regex match    
						var val = $.fn.dataTable.util.escapeRegex($('#reportObjectSearch_text').val());
						console.log(val);
						table_reports_spravka_zadolchf
							.columns()
							.search(val ? '^' + val + '$' : '', true, false)
							.draw();
						break;
				}

			});
			$('#columnSearch_btnClear').click(function(e) {
				$('#reportDocTypeSearch_text').val('');
				$('#reportObjectSearch_text').val('');
				table_reports_spravka_zadolchf
					.columns()
					.search('')
					.draw();
			});





		});
	</script>

	<style>
		/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  

ОСНОВНАЯ ТАБЛИЦА

----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
		/* 
/* Общее для таблицы */
		#docview-details-tab3 {}

		#docview-details-tab3 .details-control:hover {
			cursor: hand
		}

		/* 
/* 
/* Заголовок таблицы */
		#reports-spravka-zadolchf-table>thead {
			background-color: #326a86;
			font-family: 'Oswald', sans-serif;
			border-bottom: none;
			border-top: none
		}

		#reports-spravka-zadolchf-table>thead>tr>th {
			color: #fff;
			border-bottom: none;
			font-weight: 500;
			font-size: 1.2em;
			text-transform: uppercase
		}

		#reports-spravka-zadolchf-table .sorting:after,
		#reports-spravka-zadolchf-table .sorting_asc:after,
		#reports-spravka-zadolchf-table .sorting_desc:after {
			display: none
		}

		#reports-spravka-zadolchf-table>thead>tr>th.sorting_asc {
			padding-right: 8px
		}

		#reports-spravka-zadolchf-table>thead>tr>th.sorting_desc {
			padding-right: 8px
		}

		/* 
/* 
/* Тело таблицы */
		#reports-spravka-zadolchf-table {}

		#reports-spravka-zadolchf-table>tbody {
			font-family: 'Ubuntu', sans-serif;
			font-size: 0.9em;
			color: #666;
			border-bottom: none;
			border-top: none
		}

		#reports-spravka-zadolchf-table>tbody>tr>td {}

		#reports-spravka-zadolchf-table>tbody>tr>td {
			padding: 5px 8px;
			line-height: 1.42857143;
			vertical-align: middle;
		}

		#reports-spravka-zadolchf-table>thead>tr>th {
			border-bottom: none
		}

		#reports-spravka-zadolchf-table>tbody>tr>td {}

		#reports-spravka-zadolchf-table>tbody>tr>td:last-child {
			text-align: right
		}

		#reports-spravka-zadolchf-table>tfoot>tr>td {
			padding: 5px 4px
		}

		#reports-spravka-zadolchf-table>tfoot {
			background-color: #999;
		}

		/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
		#reports-spravka-zadolchf-table>thead>tr>th:first-child,
		#reports-spravka-zadolchf-table>tbody>tr>td:first-child {
			width: 1%
		}

		#reports-spravka-zadolchf-table>thead>tr>th:nth-child(2),
		#reports-spravka-zadolchf-table>tbody>tr>td:nth-child(2) {
			width: 1%
		}

		#reports-spravka-zadolchf-table>thead>tr>th:nth-child(2),
		#reports-spravka-zadolchf-table>tbody>tr>td:nth-child(3) {
			width: 1%
		}

		#reports-spravka-zadolchf-table>thead>tr>th:nth-child(4),
		#reports-spravka-zadolchf-table>tbody>tr>td:nth-child(4) {
			width: 7%;
			text-align: left
		}

		#reports-spravka-zadolchf-table>thead>tr>th:nth-child(5),
		#reports-spravka-zadolchf-table>tbody>tr>td:nth-child(5) {
			width: 15%;
			text-align: left
		}

		#reports-spravka-zadolchf-table>thead>tr>th:nth-child(6),
		#reports-spravka-zadolchf-table>tbody>tr>td:nth-child(6) {
			width: 15%;
			text-align: right;
			white-space: nowrap
		}

		#reports-spravka-zadolchf-table>thead>tr>th:nth-child(7),
		#reports-spravka-zadolchf-table>tbody>tr>td:nth-child(7) {
			width: 15%;
			text-align: right;
			white-space: nowrap
		}

		#reports-spravka-zadolchf-table>thead>tr>th:nth-child(8),
		#reports-spravka-zadolchf-table>tbody>tr>td:nth-child(8) {
			width: 15%;
			text-align: right;
			white-space: nowrap
		}

		#reports-spravka-zadolchf-table>thead>tr>th:nth-child(9),
		#reports-spravka-zadolchf-table>tbody>tr>td:nth-child(9) {
			width: 15%;
			text-align: right;
			white-space: nowrap
		}


		#reports-spravka-zadolchf-table .details-control:hover {
			cursor: pointer
		}

		/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
		#reports-spravka-zadolchf-table-row-details .sorting_asc:after {
			display: none
		}

		#reports-spravka-zadolchf-table-row-details>thead>tr>th.sorting_asc {
			padding-right: 8px
		}

		#reports-spravka-zadolchf-table .group {
			font-family: 'Oswald', sans-serif;
			font-size: 1.3em;
			font-weight: 400;
			color: #000
		}

		#reports-spravka-zadolchf-table .group1 {
			font-family: 'Play', sans-serif;
			font-size: 1.15em;
			font-weight: 600;
			color: #000
		}

		#reports-spravka-zadolchf-table .group2 {
			font-family: 'Play', sans-serif;
			font-size: 1.0em;
			font-weight: 600;
			color: #000
		}


		#reports-spravka-zadolchf-table>tbody>tr.dtrg-start.dtrg-level-0>td {
			font-family: 'Oswald', sans-serif;
			font-size: 1.35em;
			font-weight: 500;
			color: #000;
			text-align: left
		}

		#reports-spravka-zadolchf-table>tbody>tr.dtrg-start.dtrg-level-1>td {
			font-family: 'Play', sans-serif;
			font-size: 1.15em;
			font-weight: 500;
			color: #000;
			text-align: left
		}

		#reports-spravka-zadolchf-table>tbody>tr.dtrg-end.dtrg-level-1>td {
			font-family: 'Play', sans-serif;
			font-size: 1.0em;
			font-weight: 500;
			color: #000;
			background-color: #fff
		}

		#reports-spravka-zadolchf-table>tbody>tr.dtrg-end.dtrg-level-0>td {
			font-family: 'Play', sans-serif;
			font-size: 1.15em;
			font-weight: 700;
			color: #000;
			background-color: #fff
		}



		/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/

		#column1_search_current,
		#column2_search_current,
		#column3_search_current,
		#column4_search_current {
			width: 100%;
			padding: 5px 5px;
			font-weight: 400;
			font-size: 0.9em;
			color: #333;
			max-height: 31px;
		}

		#column1_search_current {
			text-align: center
		}

		#column2_search_current {
			text-align: center
		}

		#column3_search_current {
			text-align: left
		}

		#column4_search_current {
			text-align: left
		}

		#filters_clear_current,
		#filters_apply_current {
			padding: 6px;
			font-weight: 400;
			font-size: 0.9em
		}

		/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
		#reports-spravka-zadolchf-filters-block .panel-title {
			font-family: 'HeliosCond', sans-serif;
			font-size: 1.5em;
			font-weight: 500;
			padding-top: 5px;
			text-transform: none;
		}

		#reports-spravka-zadolchf-filters-block .panel {
			border: transparent
		}

		#dognet-missions-filters {
			padding: 15px 0;
			background-color: #f1f1f1
		}

		#columnSearch_btnApply .focus,
		#columnSearch_btnApply .active:focus,
		#columnSearch_btnApply:active.focus,
		#columnSearch_btnApply:active:focus,
		#columnSearch_btnApply:focus {
			outline: none;
			border-color: #ccc
		}

		#columnSearch_btnClear .focus,
		#columnSearch_btnClear .active:focus,
		#columnSearch_btnClear:active.focus,
		#columnSearch_btnClear:active:focus,
		#columnSearch_btnClear:focus {
			outline: none;
			border-color: #ccc
		}
		}

		/* 
----- ----- ----- ----- ----- ----- ----- ----- ----- -----  
*/
		#reports-spravka-zadolchf-filters-block .panel-title {
			font-family: 'HeliosCond', sans-serif;
			font-size: 1.5em;
			font-weight: 500;
			padding-top: 5px;
			text-transform: none;
		}

		#reports-spravka-zadolchf-filters-block .panel {
			border: transparent
		}
	</style>

	<section>

		<div class="space30"></div>

		<div id="reports-spravka-zadolchf-filters-block" class="panel-group">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" href="#docsearch-filters">Фильтры для поиска</a>
					</h4>
				</div>
				<div id="docsearch-filters" class="panel-collapse collapse">

					<div id="reports-spravka-zadolchf-filters" class="panel-body space30">
						<?php // ----- ----- ----- ----- ----- 
						?>
						<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
							<div class="input-group space10" style="width:100%">
								<label for="reportZadolTypeSearch_text"><b>Задолженность :</b></label>
								<select name="reportZadolTypeSearch_text" id="reportZadolTypeSearch_text" class="form-control">
									<option value="">Все</option>
									<option value="1">Текущая</option>
									<option value="2">Судебная</option>
									<option value="3">Невозвратная</option>
								</select>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
							<div class="input-group space10" style="width:100%">
								<label for="reportDocTypeSearch_text"><b>Тип :</b></label>
								<select name="reportDocTypeSearch_text" id="reportDocTypeSearch_text" class="form-control">
									<option value="0">Все</option>
									<option value="1">Договор</option>
									<option value="2">Счет</option>
								</select>
								<!-- 							<input type="text" id="reportDocTypeSearch_text" class="form-control" placeholder="Счет" name="reportDocTypeSearch_text"> -->
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-1 col-lg-1">
							<div class="form-group space10" style="width:100%">
								<label for="docNumberSearch_text"><b>№ :</b></label>
								<input type="text" id="docNumberSearch_text" class="form-control" placeholder="Номер" name="docNumberSearch_text">
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
							<div class="input-group space10" style="width:100%">
								<label for="reportObjectSearch_text"><b>Заказчик/объект :</b></label>
								<input type="text" id="reportObjectSearch_text" class="form-control" placeholder="Все объекты" name="reportObjectSearch_text">
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-7 col-lg-5">
							<div class="input-group space10" style="width:100%">
								<label for="docNameSearch_text"><b>Текст из названия договора :</b></label>
								<input type="text" id="docNameSearch_text" class="form-control" placeholder="Введите текст для поиска в названии" name="docNameSearch_text">
							</div>
						</div>
						<?php // ----- ----- ----- ----- ----- 
						?>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-6">

						</div>
						<?php // ----- ----- ----- ----- ----- 
						?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
							<div class="input-group-btn">
								<button id="columnSearch_btnApply" class="btn btn-default" type="button">Применить фильтры</button>
								<button id="columnSearch_btnClear" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
							</div>
						</div>
						<?php // ----- ----- ----- ----- ----- 
						?>
					</div>

				</div>
			</div>
		</div>




		<div class="space30"></div>
		<div class="demo-html"></div>
		<table id="reports-spravka-zadolchf-table" class="table table-responsive display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th width=""></th>
					<th width=""></th>
					<th width=""></th>
					<th width=""></th>
					<th width=""></th>
					<th width=""></th>
					<th width="">Счет</th>
					<th width="">Дата</th>
					<th width="">Сумма</th>
					<th width="">Авансы</th>
					<th width="">Оплаты</th>
					<th width="">Задолженность</th>
					<th width=""></th>
					<th width=""></th>
					<th width=""></th>
					<th width=""></th>
				</tr>
			</thead>
		</table>

	</section>


	<script type="text/javascript">
		subtitle = '<?php echo $__subtitle; ?>';
		subsubtitle = '<?php echo $__subsubtitle; ?>';
		document.getElementById("subtitle").innerHTML = subtitle;
		document.getElementById("dognet-subsubtitle").innerHTML = subsubtitle;
		$("#dognet-subsubtitle").attr("class", "text-default");
	</script>