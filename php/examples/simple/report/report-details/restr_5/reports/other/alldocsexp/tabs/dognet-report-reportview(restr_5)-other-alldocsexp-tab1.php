<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Какой то блок...
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
?>
<script type="text/javascript" language="javascript" class="init">
	// ----- ----- -----
	var table_report_view_main;
	$(document).ready(function() {

		$(function() {
			$('#on_date').datetimepicker({
				locale: 'ru',
				defaultDate: moment(),
				format: 'YYYY'
			});
		});


		table_report_view_main = $('#report-view-main-table').DataTable({
			dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			language: {
				url: "russian.json"
			},
			ajax: {
				url: "php/examples/simple/report/report-details/restr_5/reports/other/alldocsexp/process/dognet-report-reportview(restr_5)-other-alldocsexp-ondate-process.php",
				type: "POST",
				data: function(d) {
					var t1 = $("#on_date").find("input").val();
					d.on_date = t1;
				}
			},
			serverSide: true,
			createdRow: function(row, data, index) {
				datenow = moment();
				srokstage = moment(data.dognet_dockalplan_progress.srokstage_date, 'YYYY-MM-DD').format('YYYY-MM-DD');
				chetfdate = moment(data.dognet_kalplanchf.chetfdate, 'YYYY-MM-DD').format('YYYY-MM-DD');
				diff = moment(chetfdate).diff(srokstage, 'days');
				exp_weeks = Math.round(diff / 7);
				if (exp_weeks > 0) {
					$(row).css('background-color', 'rgb(255, 240, 240)');
				}
			},
			columns: [{
					class: "details-control",
					searchable: false,
					orderable: false,
					data: null,
					defaultContent: "<span class='glyphicon glyphicon-option-vertical'></span>"
				},
				{
					data: "dognet_docbase.docnumber"
				},
				{
					data: "dognet_dockalplan.numberstage"
				},
				{
					data: "dognet_dockalplan.nameshotstage"
				},
				{
					data: "sp_contragents.nameshort"
				},
				{
					data: "sp_objects.nameobjectshot"
				},
				{
					data: "dognet_dockalplan_progress.srokstage_date"
				},
				{
					data: "dognet_kalplanchf.chetfnumber"
				},
				{
					data: "dognet_kalplanchf.chetfdate"
				},
				{
					data: "dognet_dockalplan_progress.idsrokstage"
				}
			],
			select: {
				style: 'os',
				selector: 'td:first-child'
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
						return '<a href="/dognet/dognet-docview.php?docview_type=details&uniqueID=' + row.dognet_dockalplan.koddoc + '" class="docview-details-link" title="Перейти к карточке договора">' + data + '</a>';
					},
					targets: 1
				},
				{
					orderable: false,
					searchable: false,
					targets: 2
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						if (data !== null) {
							return (data.length > 65) ? data.substr(0, 65) + " ..." : data;
						}
					},
					targets: 3
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						if (data !== null) {
							return (data.length > 20) ? data.substr(0, 20) + " ..." : data;
						}
					},
					targets: 4
				},
				{
					orderable: false,
					searchable: true,
					render: function(data, type, row, meta) {
						if (data !== null) {
							return (data.length > 20) ? data.substr(0, 20) + " ..." : data;
						}
					},
					targets: 5
				},
				{
					orderable: false,
					searchable: false,
					render: function(data, type, row, meta) {
						return moment(data, 'YYYY-MM-DD').format('DD.MM.YYYY');
					},
					targets: 6
				},
				{
					orderable: false,
					searchable: false,
					targets: 7
				},
				{
					orderable: false,
					searchable: false,
					render: function(data, type, row, meta) {
						return moment(data, 'YYYY-MM-DD').format('DD.MM.YYYY');
					},
					targets: 8
				},
				{
					orderable: false,
					searchable: false,
					render: function(data, type, row, meta) {
						datenow = moment();
						ondate = moment($('#input_on_date').val(), 'YYYY').format('YYYY');
						srokstage = moment(row.dognet_dockalplan_progress.srokstage_date, 'YYYY-MM-DD').format('YYYY-MM-DD');
						chetfdate = moment(row.dognet_kalplanchf.chetfdate, 'YYYY-MM-DD').format('YYYY-MM-DD');
						diff = moment(chetfdate).diff(srokstage, 'days');
						exp_weeks = Math.round(diff / 7);
						return exp_weeks;
					},
					targets: 9
				}
			],
			select: false,
			processing: true,
			paging: true,
			searching: true,
			lengthChange: false,
			pageLength: 15,
			lengthMenu: [
				[15, 30, 50, -1],
				[15, 30, 50, "Все"]
			],
			order: [
				[1, "desc"]
			],
			buttons: [],
			initComplete: function() {

			},
			drawCallback: function() {

			},
			footerCallback: function(row, data, start, end, display) {

			}
		});
		// Array to track the ids of the details displayed rows
		var detailRows_view_main = [];
		$('#report-view-main-table tbody').on('click', 'tr td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table_report_view_main.row(tr);
			var idx = $.inArray(tr.attr('id'), detailRows_view_main);
			if (row.child.isShown()) {
				tr.removeClass('details');
				row.child.hide();
				// Remove from the 'open' array
				detailRows_view_main.splice(idx, 1);
			} else {
				tr.addClass('details');
				rowData = table_report_view_main.row(row);
				d = row.data();

				rowData.child(<?php include('templates/report-view-main.tpl'); ?>).show();
				// Add to the 'open' array
				if (idx === -1) {
					detailRows_view_main.push(tr.attr('id'));
				}
			}
		});
		// On each draw, loop over the `detailRows_view_main` array and show any child rows
		table_report_view_main.on('draw', function() {
			$.each(detailRows_view_main, function(i, id) {
				$('#' + id + ' td.details-control').trigger('click');
			});
		});
		// ----- ----- -----
		$('#columnSearch_btnApply').click(function() {
			var tmp1 = $('#input_on_date').val();
			if (tmp1 != '') {
				table_report_view_main.columns(1).search($("#docNumberSearch_text").val());
				table_report_view_main.columns(3).search($("#docNameSearch_text").val());
				table_report_view_main.columns(4).search($("#docZakazSearch_text").val());
				table_report_view_main.columns(5).search($("#docObjectSearch_text").val());
				table_report_view_main.columns(6).search($("#docStatusSearch_text").val());
				table_report_view_main.ajax.reload();
			} else {
				alert("Необходимо ввести обе даты диапазона");
			}
		});

		$('#columnSearch_btnClear').click(function(e) {
			$('#docNumberSearch_text').val('');
			$('#docYearSearch_text').val('');
			$('#docNameSearch_text').val('');
			$('#docObjectSearch_text').val('');
			$('#docZakazSearch_text').val('');
			$('#docStatusSearch_text').val('');
			table_report_view_main
				.columns()
				.search('')
				.draw();


		});

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

		$("#docNumberSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});
		$("#docYearSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});
		$("#docNameSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});
		$("#docObjectSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});
		$("#docZakazSearch_text").on("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				document.getElementById("columnSearch_btnApply").click();
			}
		});


	});
</script>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/report/report-details/restr_5/reports/other/alldocsexp/tabs/css/report-view-main.css">
<section>
	<div id="report-view-main" class="">

		<div class="space20"></div>
		<div class="row">
			<div class='col-sm-12'>
				<form class="form-inline text-center">
					<div class="form-group">
						<div class='input-group date' id='on_date'>
							<input type='text' name="on_date" id='input_on_date' class="form-control" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
						<div class="input-group">
							<button id="columnSearch_btnApply" class="btn btn-default" type="button"><i class="glyphicon glyphicon-refresh"></i></button>
							<button id="columnSearch_btnClear" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="space10"></div>
		<?php
		// ----- ----- ----- ----- -----
		// Подключаем форму поиска и выводим таблицу счетов-фактур
		// :::
		// include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/report/report-details/restr_5/reports/other/alldocsexp/tabs/forms/report-view-main-filters.php");
		// ----- ----- ----- ----- -----
		?>
		<div class="demo-html"></div>
		<table id="report-view-main-table" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th>Дог</th>
					<th>Э</th>
					<th>Название этапа</th>
					<th>Заказчик</th>
					<th>Объект</th>
					<th>Срок</th>
					<th>№ СФ</th>
					<th>Дата СФ</th>
					<th><span class="glyphicon glyphicon-stats"></span></th>
				</tr>
			</thead>
			<!--
        <tfoot>
            <tr>
	            <th style="border-right:none"></th>
                <th colspan="7" style="text-align:right">Всего за выбранный период:</th>
                <th colspan="2" style="text-align:center"></th>
            </tr>
        </tfoot>
-->
		</table>
	</div>
</section>