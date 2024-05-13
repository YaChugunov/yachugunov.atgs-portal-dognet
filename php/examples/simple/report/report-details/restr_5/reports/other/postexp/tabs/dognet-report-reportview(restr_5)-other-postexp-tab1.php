<?php
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# Какой то блок...
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

/*
$_QRY_dockalplan = mysqlQuery( "SELECT * FROM dognet_dockalplan_progress WHERE idsrokstage='0' AND firstdateavans<>'' AND srokstage<>''");
while ($_ROW_dockalplan = mysqli_fetch_assoc($_QRY_dockalplan)) {

	// Нужно теперь определить срок выполнения этапа (если он был задан в днях)
	$expiry_date = "";
	if ($_ROW_dockalplan['idsrokstage']==0 && $_ROW_dockalplan['srokstage']!="") {
		$srokstage = $_ROW_dockalplan['srokstage'];
		if ($_ROW_dockalplan['firstdateavans']!="") {
			$dateavans = new DateTime($_ROW_dockalplan['firstdateavans']);
			$firstavans = $dateavans->format('Y-m-d');
			if (is_string($srokstage)) { $srokdays = (int)$srokstage; }
			$expiry_date = $dateavans->add(new DateInterval('P'.$srokdays.'D'))->format('Y-m-d');
		}
		else {
			$expiry_date = "";
		}
	}
	$_QRY_UPD = mysqlQuery( "UPDATE dognet_dockalplan_progress SET srokstage_date='".$expiry_date."' WHERE ID=".$_ROW_dockalplan['ID']);
}
*/

?>
<script type="text/javascript" language="javascript" class="init">
	// ----- ----- -----
	var table_report_view_main;
	$(document).ready(function() {

		$(function() {
			$('#on_date').datetimepicker({
				locale: 'ru',
				defaultDate: moment(),
				format: 'DD.MM.YYYY'
			});
		});


		table_report_view_main = $('#report-view-main-table').DataTable({
			dom: "<'row'<'col-sm-5'><'col-sm-4'><'col-sm-3'>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4'i><'col-sm-8'p>>",
			language: {
				url: "russian.json"
			},
			ajax: {
				url: "php/examples/simple/report/report-details/restr_5/reports/other/postexp/process/dognet-report-reportview-other-postexp-ondate-process.php",
				type: "POST",
				data: function(d) {
					var t1 = $("#on_date").find("input").val();

					var str1 = $("#docStatusSearch_text").val();
					var str2 = $("#docZakazSearch_text").val();
					d.on_date = t1;
					d.statusdog = str1;
					d.zakname = str2;
					console.log(str1 + " / " + str2);
				}
			},
			serverSide: true,
			createdRow: function(row, data, index) {

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
					data: "dognet_docbase.docnameshot"
				},
				{
					data: "sp_contragents.nameshort"
				},
				{
					data: "dognet_spstatus.statusnameshot"
				},
				{
					data: "dognet_dockalplan_progress.summastage"
				},
				{
					data: "dognet_dockalplan_progress.srokstage_date"
				},
				{
					data: "dognet_dockalplan_progress.idsrokstage"
				},
				{
					data: null,
					render: function(data, type, row, meta) {
						ondate = moment($('#input_on_date').val(), 'DD.MM.YYYY').format('YYYY-MM-DD');
						srokstage = moment(row.dognet_dockalplan_progress.srokstage_date, 'YYYY-MM-DD').format('YYYY-MM-DD');
						diff = moment(ondate).diff(srokstage, 'days');
						shtraf = $('#input_shtraf').val();
						sumshtraf = row.dognet_dockalplan_progress.summastage * diff * shtraf / 100
						return $.fn.dataTable.render.number(' ', ',', 2, '').display(sumshtraf) + row.dognet_spdened.short_code;
					}
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
							return (data.length > 17) ? data.substr(0, 17) + " ..." : data;
						}
					},
					targets: 5
				},
				{
					orderable: false,
					searchable: false,
					render: function(data, type, row, meta) {
						if (data != null) {
							return $.fn.dataTable.render.number(' ', ',', 2, '').display(data) + row.dognet_spdened.short_code;
						} else {
							return "0.00" + row.dognet_spdened.short_code;
						}
					},
					targets: 6
				},
				{
					orderable: false,
					searchable: false,
					render: function(data, type, row, meta) {
						return moment(data).format('DD.MM.YYYY');
					},
					targets: 7
				},
				{
					orderable: false,
					searchable: false,
					render: function(data, type, row, meta) {
						datenow = moment();
						ondate = moment($('#input_on_date').val(), 'DD.MM.YYYY').format('YYYY-MM-DD');
						srokstage = moment(row.dognet_dockalplan_progress.srokstage_date, 'YYYY-MM-DD').format('YYYY-MM-DD');
						diff = moment(ondate).diff(srokstage, 'days');
						return diff;
					},
					targets: 8
				},
				{
					orderable: false,
					searchable: false,
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
				var api = this.api(),
					data;

				// Remove the formatting to get integer data for summation
				var intVal = function(i) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '') * 1 :
						typeof i === 'number' ?
						i : 0;
				};

				// Total over all pages
				total = api
					.column(9, {
						page: 'all'
					})
					.data()
					.reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				// Total over this page
				pageTotal = api
					.column(9, {
						page: 'current'
					})
					.data()
					.reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				pageTotalStr = $.fn.dataTable.render.number(' ', ',', 2, '').display(pageTotal);
				totalStr = $.fn.dataTable.render.number(' ', ',', 2, '').display(total);

				// Update footer
				// $( api.column( 9 ).footer() ).html( pageTotalStr+' р.' );
				// $( api.column( 8 ).footer() ).html( '[ пока не выводится ]' );
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
				table_report_view_main.ajax.reload();
			} else {
				alert("Необходимо ввести дату");
			}
		});

		$('#columnSearch_btnClear').click(function(e) {
			$('#on_date').data("DateTimePicker").date(moment());
			$('#input_shtraf').val('0.05');
			table_report_view_main.ajax.reload();
		});
	});
</script>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dognet/php/examples/simple/report/report-details/restr_5/reports/other/postexp/tabs/css/report-view-main.css">
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
						<div class='input-group' id='shtraf'>
							<input type='text' name="shtraf" id='input_shtraf' class="form-control" style="width:80px" value="0.05" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-signal"></span>
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
		// include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/report/report-details/restr_5/reports/other/postexp/tabs/forms/report-view-main-filters.php");
		// ----- ----- ----- ----- -----
		?>
		<div class="demo-html"></div>
		<table id="report-view-main-table" class="table table-responsive table-bordered display compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><span class='glyphicon glyphicon-option-vertical'></span></th>
					<th>Дог</th>
					<th>Э</th>
					<th>Название договора</th>
					<th>Заказчик</th>
					<th>Статус</th>
					<th>Сумма</th>
					<th>Дата</th>
					<th><span class="glyphicon glyphicon-stats"></span></th>
					<th>Штраф</th>
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