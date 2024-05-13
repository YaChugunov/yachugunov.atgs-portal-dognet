<?php
date_default_timezone_set('Europe/Moscow');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$__title = 'Договор';
$__subtitle = "Отчетные формы";
$__subsubtitle = "Перечень договоров";

// Делаем запись в системный лог
// Все параметры в таблице portal_log_messages
PORTAL_SYSLOG('99942100', '0000000', null, $_GET['reportview'], $__subsubtitle, null);

?>

<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<div class="container">
	<div class="row" style="margin-top:20px">
		<?php include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/dognet-topblock.php") ?>
	</div>


	<script type="text/javascript" language="javascript" class="init">
		var table_reportview_filterdocs; // use a global for the submit and return data rendering in the examples

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

		$(document).ready(function() {

			table_reportview_filterdocs = $('#reportview-filterdocs').DataTable({
				dom: "<'row'<'col-sm-5'><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
				// 		dom: "<'space50'r>tip",
				language: {
					url: "russian.json"
				},
				ajax: {
					url: "php/examples/php/report/report-details/reports/dognet-report-reportview-other-missions-process.php",
					type: "POST"
				},
				serverSide: true,
				columns: [{
						class: "details-control",
						searchable: false,
						orderable: false,
						data: null,
						defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
					},
					{
						data: "dognet_docbase.docnumber",
						className: "text-left"
					},
					{
						data: "dognet_dockalplan.numberstage",
						className: "text-left"
					},
					{
						data: "dognet_dockalplan.nameshotstage",
						className: "text-left"
					},
					{
						data: "sp_objects.nameobjectshot",
						className: "text-left"
					},
					{
						data: "sp_contragents.nameshort",
						className: "text-left"
					}
				],
				select: {
					style: 'os',
					selector: 'td:not(:last-child)' // no row selection on last column
				},
				columnDefs: [{
						orderable: false,
						searchable: false,
						targets: 0
					},
					{
						orderable: true,
						searchable: true,
						render: function(data, type, row, meta) {
							return '';
						},
						targets: 1
					},
					{
						orderable: true,
						searchable: true,
						render: function(data, type, row, meta) {
							if (data) {
								return "Этап " + data;
							} else {
								return "-";
							}
						},
						targets: 2
					},
					{
						orderable: false,
						searchable: true,
						targets: 3
					},
					{
						orderable: false,
						searchable: true,
						targets: 4
					},
					{
						orderable: false,
						searchable: true,
						targets: 5
					}
				],
				order: [
					[1, "desc"]
				],
				select: false,
				processing: true,
				paging: true,
				searching: true,
				pageLength: 15,
				lengthChange: false,
				lengthMenu: [
					[15, 30, 50, -1],
					[15, 30, 50, "Все"]
				],
				buttons: [{
					text: '<span class="glyphicon glyphicon-refresh"></span>',
					action: function(e, dt, node, config) {
						table_reportview_filterdocs.columns().search('');
						table_reportview_filterdocs.order([1, "desc"]).draw();
					}
				}],
				drawCallback: function(settings) {
					var api = this.api();
					var rows = api.rows({
						page: 'current'
					}).nodes();
					var last = null;
					api.column(1, {
						page: 'current'
					}).data().each(function(group, i) {
						if (last !== group) {
							$(rows).eq(i).before(
								'<tr class="group"><td style="text-align:left; white-space:nowrap">3-4/' + group + '</td><td colspan="2" style="text-align:left">' + api.row(i).data().dognet_docbase.yearnachdoc + '</td><td colspan="3" style="text-align:left">' + api.row(i).data().dognet_docbase.docnameshot + '</td></tr>'
							);
							last = group;
						}
					});
				}
			});
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			// Array to track the ids of the details displayed rows
			var detailRows = [];

			$('#reportview-filterdocs tbody').on('click', 'tr td.details-control', function() {
				var tr = $(this).closest('tr');
				var row = table_reportview_filterdocs.row(tr);
				var idx = $.inArray(tr.attr('id'), detailRows);

				if (row.child.isShown()) {
					tr.removeClass('details');
					row.child.hide();

					// Remove from the 'open' array
					detailRows.splice(idx, 1);
				} else {
					tr.addClass('details');
					rowData = table_reportview_filterdocs.row(row);
					d = row.data();
					rowData.child(<?php include('templates/report-details_tab7_missions.tpl'); ?>).show();

					// Add to the 'open' array
					if (idx === -1) {
						detailRows.push(tr.attr('id'));
					}
				}
			});
			// On each draw, loop over the `detailRows` array and show any child rows
			table_reportview_filterdocs.on('draw', function() {
				$.each(detailRows, function(i, id) {
					$('#' + id + ' td.details-control').trigger('click');
				});
			});

			// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			$('#columnSearch_btnApply').click(function(e) {

				table_reportview_filterdocs
					.columns(1)
					.search($("#docNumberSearch_text").val())
					.draw();
				table_reportview_filterdocs
					.columns(3)
					.search($("#docNameSearch_text").val())
					.draw();
				table_reportview_filterdocs
					.columns(4)
					.search($("#docObjectSearch_text").val())
					.draw();
				table_reportview_filterdocs
					.columns(5)
					.search($("#docZakazSearch_text").val())
					.draw();

			});
			$('#columnSearch_btnClear').click(function(e) {
				$('#docNumberSearch_text').val('');
				$('#docNameSearch_text').val('');
				$('#docObjectSearch_text').val('');
				$('#docZakazSearch_text').val('');
				table_reportview_filterdocs.columns().search('').draw();
				$('#columnSearch_btnClear').val('');
			});
			//
			//
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			editor_doctypes = new $.fn.dataTable.Editor({
				display: "bootstrap",
				ajax: "php/examples/php/report/report-details/reports/dognet-report-reportview-other-missions_doctypes-process.php",
				table: "#sp-doctypes-table",
				fields: [{
					label: "Статус",
					name: "nametip"
				}, {
					label: "Разрешить",
					name: "enbl_report_missions"
				}]
			});
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			table_doctypes = $('#sp-doctypes-table').DataTable({
				// 		dom: "<'row'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'lftip>>",
				dom: "<'space50'>t",
				language: {
					url: "russian.json"
				},
				ajax: {
					url: "php/examples/php/report/report-details/reports/dognet-report-reportview-other-missions_doctypes-process.php",
					type: "POST"
				},
				serverSide: true,
				columns: [{
						data: "ID",
						className: "text-center"
					},
					{
						data: "nametip"
					},
					{
						data: "enbl_report_missions",
						className: "text-center",
						render: function(data, type, row) {
							if (type === 'display') {
								return '<input type="checkbox" class="editor-types-enbl_report_missions">';
							}
							return data;
						}
					}
				],
				select: {
					style: 'os',
					selector: 'td:not(:last-child)' // no row selection on last column
				},
				columnDefs: [{
						orderable: false,
						targets: 0
					},
					{
						orderable: false,
						targets: 1
					},
					{
						orderable: false,
						targets: 2
					}
				],
				scrollY: '122px',
				/* 		scrollY: '20vh', */
				scrollCollapse: true,
				select: false,
				processing: true,
				paging: false,
				searching: false,
				rowCallback: function(row, data) {
					// Set the checked state of the checkbox in the table
					$('input.editor-types-enbl_report_missions', row).prop('checked', data.enbl_report_missions == 1);
					table_reportview_filterdocs.draw();
				}
			});
			//
			//
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			$('#sp-doctypes-table').on('change', 'input.editor-types-enbl_report_missions', function() {
				editor_doctypes
					.edit($(this).closest('tr'), false)
					.set('enbl_report_missions', $(this).prop('checked') ? 1 : 0)
					.submit();
			});
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			//
			//
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			editor_docstatus = new $.fn.dataTable.Editor({
				display: "bootstrap",
				ajax: "php/examples/php/report/report-details/reports/dognet-report-reportview-other-missions_docstatus-process.php",
				table: "#sp-docstatus-table",
				fields: [{
					label: "Название",
					name: "statusnameshot"
				}, {
					label: "Статус",
					name: "enbl_report_missions"
				}]
			});
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			table_docstatus = $('#sp-docstatus-table').DataTable({
				// 		dom: "<'row'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'>r>t<'row'<'col-md-12 col-sm-12 footer'lftip>>",
				dom: "<'space50'>t",
				language: {
					url: "russian.json"
				},
				ajax: {
					url: "php/examples/php/report/report-details/reports/dognet-report-reportview-other-missions_docstatus-process.php",
					type: "POST"
				},
				serverSide: true,
				columns: [{
						data: "ID",
						className: "text-center"
					},
					{
						data: "statusnameshot"
					},
					{
						data: "enbl_report_missions",
						className: "text-center",
						render: function(data, type, row) {
							if (type === 'display') {
								return '<input type="checkbox" class="editor-status-enbl_report_missions">';
							}
							return data;
						}
					}
				],
				select: {
					style: 'os',
					selector: 'td:not(:last-child)' // no row selection on last column
				},
				columnDefs: [{
						orderable: false,
						targets: 0
					},
					{
						orderable: false,
						targets: 1
					},
					{
						orderable: false,
						targets: 2
					}
				],
				scrollY: '122px',
				/* 		scrollY: '20vh', */
				scrollCollapse: true,
				select: false,
				processing: true,
				paging: false,
				searching: false,
				rowCallback: function(row, data) {
					// Set the checked state of the checkbox in the table
					$('input.editor-status-enbl_report_missions', row).prop('checked', data.enbl_report_missions == 1);
					table_reportview_filterdocs.draw();
				}
			});
			//
			//
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			$('#sp-docstatus-table').on('change', 'input.editor-status-enbl_report_missions', function() {
				editor_docstatus
					.edit($(this).closest('tr'), false)
					.set('enbl_report_missions', $(this).prop('checked') ? 1 : 0)
					.submit();
			});
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			//
			//
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
		#reportview-filterdocs>thead {
			background-color: #326a86;
			font-family: 'Oswald', sans-serif;
			border-bottom: none;
			border-top: none
		}

		#reportview-filterdocs>thead>tr>th {
			color: #fff;
			border-bottom: none;
			font-weight: 500;
			font-size: 1.2em;
			text-transform: uppercase
		}

		#reportview-filterdocs .sorting:after,
		#reportview-filterdocs .sorting_asc:after,
		#reportview-filterdocs .sorting_desc:after {
			display: none
		}

		#reportview-filterdocs>thead>tr>th.sorting_asc {
			padding-right: 8px
		}

		#reportview-filterdocs>thead>tr>th.sorting_desc {
			padding-right: 8px
		}

		/*
/*
/* Тело таблицы */
		#reportview-filterdocs {}

		#reportview-filterdocs>tbody {
			font-family: 'Ubuntu', sans-serif;
			font-size: 0.9em;
			color: #666;
			border-bottom: none;
			border-top: none
		}

		#reportview-filterdocs>tbody>tr>td {}

		#reportview-filterdocs>tbody>tr>td {
			padding: 5px 8px;
			line-height: 1.42857143;
			vertical-align: middle;
		}

		#reportview-filterdocs>thead>tr>th {
			border-bottom: none
		}

		#reportview-filterdocs>tbody>tr>td {}

		#reportview-filterdocs>tbody>tr>td:last-child {
			text-align: right
		}

		#reportview-filterdocs>tfoot>tr>td {
			padding: 5px 4px
		}

		#reportview-filterdocs>tfoot {
			background-color: #999;
		}

		/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
		#reportview-filterdocs>thead>tr>th:first-child,
		#reportview-filterdocs>tbody>tr>td:first-child {
			width: 8%;
			text-align: left
		}

		#reportview-filterdocs>thead>tr>th:nth-child(2),
		#reportview-filterdocs>tbody>tr>td:nth-child(2) {
			width: 7%;
			text-align: left;
			border-left: 1px #fff solid
		}

		#reportview-filterdocs>thead>tr>th:nth-child(3),
		#reportview-filterdocs>tbody>tr>td:nth-child(3) {
			width: 7%;
			text-align: left;
			border-left: 1px #fff solid
		}

		#reportview-filterdocs>thead>tr>th:nth-child(4),
		#reportview-filterdocs>tbody>tr>td:nth-child(4) {
			width: 65%;
			text-align: left;
			border-left: 1px #fff solid
		}

		#reportview-filterdocs>thead>tr>th:nth-child(5),
		#reportview-filterdocs>tbody>tr>td:nth-child(5) {
			width: min-intrinsic;
			white-space: nowrap;
			text-align: left;
			border-left: 1px #fff solid
		}

		#reportview-filterdocs>thead>tr>th:nth-child(6),
		#reportview-filterdocs>tbody>tr>td:nth-child(6) {
			width: min-intrinsic;
			text-align: left;
			white-space: nowrap;
			border-left: 1px #fff solid
		}

		#reportview-filterdocs .details-control:hover {
			cursor: pointer
		}

		/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
		#reportview-filterdocs-row-details .sorting_asc:after {
			display: none
		}

		#reportview-filterdocs-row-details>thead>tr>th.sorting_asc {
			padding-right: 8px
		}

		#reportview-filterdocs .group {
			font-family: 'Oswald', sans-serif;
			font-size: 1.3em;
			font-weight: 400;
			color: #000;
			background-color: #f1f1f1
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
		#docsearch-filters-block .panel-title,
		#missions-settings-block .panel-title {
			font-family: 'HeliosCond', sans-serif;
			font-size: 1.5em;
			font-weight: 500;
			padding-top: 5px;
			text-transform: none;
		}

		#docsearch-filters-block .panel,
		#missions-settings-block .panel {
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

		#missions-settings-block .panel {
			border: none;
			box-shadow: none;
			-webkit-box-shadow: none
		}

		#sp-docstatus-table_wrapper>div.space50 {
			display: none
		}

		#sp-doctypes-table_wrapper>div.space50 {
			display: none
		}

		#missions-settings-body {
			padding: 15px;
			background-color: #f1f1f1
		}

		#sp-docstatus-table>thead,
		#sp-doctypes-table>thead {
			background-color: #111;
			color: #fff;
			text-transform: uppercase
		}

		#sp-docstatus-table,
		#sp-doctypes-table {
			text-transform: inherit;
			font-family: 'Oswald', sans-serif;
			font-size: 0.85em
		}

		#sp-docstatus-table>thead>tr>th,
		#sp-docstatus-table>tbody>tr>td,
		#sp-doctypes-table>thead>tr>th,
		#sp-doctypes-table>tbody>tr>td {
			padding: 3px 5px
		}

		#sp-docstatus-table .sorting:after,
		#sp-docstatus-table .sorting_asc:after,
		#sp-docstatus-table .sorting_desc:after {
			display: none
		}

		#sp-doctypes-table .sorting:after,
		#sp-doctypes-table .sorting_asc:after,
		#sp-doctypes-table .sorting_desc:after {
			display: none
		}

		#sp-docstatus-table>thead>tr>th:first-child,
		#sp-docstatus-table>tbody>tr>td:first-child,
		#sp-doctypes-table>thead>tr>th:first-child,
		#sp-doctypes-table>tbody>tr>td:first-child {
			width: 5%;
			text-align: center
		}

		#sp-docstatus-table>thead>tr>th:nth-child(2),
		#sp-docstatus-table>tbody>tr>td:nth-child(2),
		#sp-doctypes-table>thead>tr>th:nth-child(2),
		#sp-doctypes-table>tbody>tr>td:nth-child(2) {
			width: 85%;
			text-align: left
		}

		#sp-docstatus-table>thead>tr>th:nth-child(3),
		#sp-docstatus-table>tbody>tr>td:nth-child(3),
		#sp-doctypes-table>thead>tr>th:nth-child(3),
		#sp-doctypes-table>tbody>tr>td:nth-child(3) {
			width: 10%;
			text-align: center
		}


		#sp-docstatus-table_wrapper>div.dataTables_scroll>div.dataTables_scrollHead>div>table>thead,
		#sp-doctypes-table_wrapper>div.dataTables_scroll>div.dataTables_scrollHead>div>table>thead {
			display: none
		}

		#sp-docstatus-table_wrapper>div.dataTables_scroll>div.dataTables_scrollBody,
		#sp-doctypes-table_wrapper>div.dataTables_scroll>div.dataTables_scrollBody {
			border: 2px #951301 solid;
			border-radius: 5px
		}

		#missions-settings-body h3 {
			font-family: 'Play', sans-serif;
			font-size: 1.35em;
			font-weight: 200;
			color: #951301;
			letter-spacing: 0.1em
		}
	</style>

	<section>
		<div class="space30"></div>


		<div id="missions-settings-block" class="panel-group">
			<div class="panel panel-default" style="border:1px #f1f1f1 solid; box-shadow:none">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" href="#missions-settings">Настройка реестра командировок</a>
					</h4>
				</div>
				<div id="missions-settings" class="panel-collapse collapse">
					<div id="missions-settings-body" class="panel-body">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<h3 class="space10">Какие статусы договоров отображать</h3>
							<table id="sp-docstatus-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th width="2%" class="text-center">#</th>
										<th width="90%">Статус</th>
										<th width="8%">Показывать</th>
									</tr>
								</thead>
							</table>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<h3 class="space10">Какие типы договоров отображать</h3>
							<table id="sp-doctypes-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th width="2%" class="text-center">#</th>
										<th width="90%">Тип</th>
										<th width="8%">Показывать</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>



		<div id="docsearch-filters-block" class="panel-group">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" href="#docsearch-filters">Фильтры для поиска договора</a>
					</h4>
				</div>
				<div id="docsearch-filters" class="panel-collapse collapse">

					<div id="dognet-missions-filters" class="panel-body space30">
						<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
							<div class="form-group space10" style="width:100%">
								<label for="docNumberSearch_text"><b>Номер договора:</b></label>
								<input type="text" id="docNumberSearch_text" class="form-control" placeholder="По номеру" name="docNumberSearch_text">
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
							<div class="form-group space10" style="width:100%">
								<label for="docNameSearch_text"><b>Название договора/этапа:</b></label>
								<input type="text" id="docNameSearch_text" class="form-control" placeholder="По названию" name="docNameSearch_text">
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
							<div class="form-group space10" style="width:100%">
								<label for="docObjectSearch_text"><b>Объект/заказчик:</b></label>
								<input type="text" id="docObjectSearch_text" class="form-control" placeholder="По объекту или заказчику" name="docObjectSearch_text">
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
							<div class="form-group space10" style="width:100%">
								<label for="docZakazSearch_text"><b>Плательщик:</b></label>
								<input type="text" id="docZakazSearch_text" class="form-control" placeholder="По плательщику" name="docZakazSearch_text">
							</div>
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
		<table id="reportview-filterdocs" class="table table-responsive display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th width="7%" class="text-left">Год</th>
					<th width="7%" class="text-left">Этап</th>
					<th width="64%" class="text-left">Название договора&nbsp;/&nbsp;этапа</th>
					<th width="12%" class="text-left">Объект</th>
					<th width="12%">Плательщик</th>
				</tr>
			</thead>
		</table>
	</section>

</div>


<script type="text/javascript">
	subtitle = '<?php echo $__subtitle; ?>';
	subsubtitle = '<?php echo $__subsubtitle; ?>';
	document.getElementById("subtitle").innerHTML = subtitle;
	document.getElementById("dognet-subsubtitle").innerHTML = subsubtitle;
	$("#dognet-subsubtitle").attr("class", "text-default");
</script>