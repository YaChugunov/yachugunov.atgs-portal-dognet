<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/date-de.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/_assets/js/my/moment-with-locales.js"></script>

<!-- Custom Table style -->
<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/css/docview-table-current-tab2-custom.css">
<!-- Custom Form Editor style -->
<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/docview/css/docview-customForm-current-tab2-Editor.css">

<script type="text/javascript" language="javascript" class="init">
	var table_tab7_report_missions; // use a global for the submit and return data rendering in the examples

	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	$(document).ready(function() {

		table_tab7_report_missions = $('#report-missions').DataTable({
			dom: "<'row'<'col-sm-5'><'col-sm-4'<'#toolbar_msg'>><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			// 		dom: "<'space50'r>tip",
			language: {
				url: "russian.json"
			},
			ajax: {
				url: "php/examples/php/report/report-details/dognet-report-details(restr_4)-tab7_missions-process.php",
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
					table_tab7_report_missions.columns().search('');
					table_tab7_report_missions.order([1, "desc"]).draw();
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

		$('#report-missions tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_tab7_report_missions.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows);

			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();

				// Remove from the 'open' array
				detailRows.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_tab7_report_missions.row(row);
				d = row.data();
				rowData.child(<?php include('templates/report-details_tab7_missions.tpl'); ?>).show();

				// Add to the 'open' array
				if (idx === -1) {
					detailRows.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows` array and show any child rows
		table_tab7_report_missions.on('draw', function() {
			$.each(detailRows, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

		$('#columnSearch_btnApply').click(function(e) {

			table_tab7_report_missions
				.columns(1)
				.search($("#docNumberSearch_text").val())
				.draw();
			table_tab7_report_missions
				.columns(3)
				.search($("#docNameSearch_text").val())
				.draw();
			table_tab7_report_missions
				.columns(4)
				.search($("#docObjectSearch_text").val())
				.draw();
			table_tab7_report_missions
				.columns(5)
				.search($("#docZakazSearch_text").val())
				.draw();

		});
		$('#columnSearch_btnClear').click(function(e) {
			$('#docNumberSearch_text').val('');
			$('#docNameSearch_text').val('');
			$('#docObjectSearch_text').val('');
			$('#docZakazSearch_text').val('');
			table_tab7_report_missions.columns().search('').draw();
			$('#columnSearch_btnClear').val('');
		});
	});
</script>
<?php
// ----- ----- ----- ----- -----
// Подключаем форму редактирования, форму поиска и выводим таблицу договора
// :::
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/base/missions/restr_1/includes/forms/base-missions-filters.php");
// ----- ----- ----- ----- -----
?>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/base/missions/restr_1/includes/css/base-missions-main.css">
<section>
	<div class="demo-html"></div>
	<table id="report-missions" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
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